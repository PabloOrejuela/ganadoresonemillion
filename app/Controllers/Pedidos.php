<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Pedidos extends BaseController {

    private $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];

    private $metodosPago = [
        1 => 'Efectivo / transferencia / Depósito (Red bancaria)',
        2 => 'Saldo de mi billetera digital'
    ];

    private $mes;
    private $anio;

    public function acl() {
        $data['idrol'] = $this->session->idrol;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        $data['miembro_desde'] = $this->session->created_at;
        return $data;
    }

    /**
     * Formulario para registro de un pedido
     *
     * @param 
     * @return void
     * @throws conditon
     **/
    public function registraNuevoPedido() {
        
        $data['session'] = $this->session;
        $data['sistema'] = $this->sistemaModel->findAll();

        $data['provincias'] = $this->provinciaModel->findAll();
        $data['ciudades'] = $this->ciudadModel->findAll();
        $data['paquetes'] = $this->paqueteModel->findAll();
        $data['datosSocio'] = $this->socioModel
            ->select('nombre,codigo_socio,patrocinador,nodopadre,idusuario,idrango,socios.id as idsocio')
            ->where('idusuario', $this->session->id)->join('usuarios', 'usuarios.id=socios.idusuario')
            ->join('rangos', 'rangos.id=socios.idrango')->findAll();
        
        $data['tiene_recompra'] = $this->pedidoModel->_verificaRecompra($data['datosSocio'][0]->idsocio);

        $data['mes_actual'] = $this->meses[date('n')];
        $data['metodosPago'] = $this->metodosPago;

        //echo '<pre>'.var_export($data['paquetes'][0]->pvp, true).'</pre>';exit;

        $data['title'] = 'REGISTRO DE PAGO DE MEMBRESÍA';
        $data['subtitle']='Pago de membresía mes de '.$this->meses[date('n')];
        $data['main_content'] = 'pedidos/form_new_order';
        return view('dashboard/index', $data);
        
    }

    public function getPaquete(){
        $idpaquete = $this->request->getPostGet('idpaquete');
        $res['infoPaquete'] = $this->paqueteModel->find($idpaquete);

        echo json_encode($res);
    }

    public function getSaldoBilletera(){
        $data['billetera'] = $this->billeteraDigitalModel->where('idsocio', $this->session->id)->findAll();
        $total = 0;

        foreach ($data['billetera'] as $key => $mov) {
            $total += $mov->cantidad;
        }
            
        $res['saldo'] = $total;

        echo json_encode($res);
    }

    public function insertNuevoPedido(){

        $data = $this->acl();

        if ($data['logged'] == 1) {

            $pedido = [
                'nombre' => strtoupper($this->request->getPostGet('nombre')),
                'codigo_socio' => strtoupper($this->request->getPostGet('codigo_socio')),
                'cantidad' => strtoupper($this->request->getPostGet('cantidad')),
                'total' => strtoupper($this->request->getPostGet('total')),
                'idpaquete' => strtoupper($this->request->getPostGet('idpaquete')),
                'descripcion' => strtoupper($this->request->getPostGet('descripcion')),
                'idsocio' => $this->session->id,
                'observacion_pedido' => strtoupper($this->request->getPostGet('observacion_pedido')),
                'fecha_compra' => date('Y-m-d h:m:s'),
                'metodo_pago' => $this->request->getPostGet('metodoPago'),
                'saldo_billetera_digital' => $this->request->getPostGet('saldoBilletera'),
                'estado' => 0
            ];

            $this->validation->setRuleGroup('insertPedido');
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 

                
                //Inserto el nuevo pedido
                $res = $this->pedidoModel->insert($pedido);


                if ($res) {
                    //Se actualiza los puntos, cartera, 
                    
                }else{

                }
                //echo $this->db->getLastQuery();
                return redirect()->to('lista-pedidos');
            }
        }else{

            return redirect()->to('logout');
        }
    }

    /**
     * Grid historial de pedidos, muestra todos los pedidos sin filtro de fechas
     *
     * @param 
     * @return void
     * @throws conditon
     **/
    public function historialPedidos() {

        $data = $this->acl();
        
        if ($data['logged'] == 1 && $this->session->miembros == 1) {

            $data['session'] = $this->session;
            $data['sistema'] = $this->sistemaModel->findAll();

            $data['pedidos'] = $this->pedidoModel->where('idsocio', $this->session->id)
                                                    ->join('paquetes', 'paquetes.id=pedidos.idpaquete')
                                                    ->findAll();

            $data['title'] = 'Historial de recompras';
            $data['main_content'] = 'pedidos/historial_recompras';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
        
    }
}
