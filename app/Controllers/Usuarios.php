<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Usuarios extends BaseController {

    public function acl() {
        $data['idrol'] = $this->session->idrol;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        $data['miembro_desde'] = $this->session->created_at;
        return $data;
    }

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function listaBinaria(){
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->miembros == 1) {

            $data['session'] = $this->session;
            $data['sistema'] = $this->sistemaModel->findAll();
            $data['micodigo'] = $this->socioModel->find($this->session->id);
            $data['mi_equipo'] = $this->socioModel->select('socios.id as id,codigo_socio,patrocinador,fecha_inscripcion,idusuario,idrango,socios.estado as estado_socio,nombre,
                    user,usuarios.cedula as cedula,posicion,telefono,email,idrol,rango,nodopadre,socios.id as idsocio')
                    ->where('patrocinador', $data['micodigo']->id)
                    ->join('usuarios', 'usuarios.id=socios.idusuario','left')
                    ->join('rangos', 'rangos.id=socios.idrango','left')
                    ->findAll();
            //echo $this->db->getLastQuery();

            //echo '<pre>'.var_export($data['mi_equipo'], true).'</pre>';exit;

            $data['title'] = 'Lista Binaria';
            $data['subtitle'] = 'Lista de socios en la organización con sus datos y ubicaciones en el binario';
            $data['main_content'] = 'usuarios/lista_binaria';

            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function arbolBinario(){
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->miembros == 1) {

            $data['session'] = $this->session;
            $data['sistema'] = $this->sistemaModel->findAll();
            $data['micodigo'] = $this->socioModel
                            ->select('nombre as name,rango,codigo_socio,patrocinador,nodopadre,posicion,socios.id as id,socios.estado as estado')
                            ->join('usuarios', 'usuarios.id=socios.idusuario','left')
                            ->join('rangos', 'rangos.id=socios.idrango','left')
                            ->find($this->session->id);

            //Traigo todos los socios
            $data['todosLosSocios'] = $this->socioModel
                ->select('nombre as name,rango,codigo_socio,patrocinador,nodopadre,posicion,socios.id as id,socios.estado as estado')
                ->join('usuarios', 'usuarios.id=socios.idusuario','left')
                ->join('rangos', 'rangos.id=socios.idrango','left')
                ->findAll();

            // Nodo raíz del árbol
            $data['treeData'] = [
                "id" => $data['micodigo']->id,
                "name" => $data['micodigo']->name,
                "rango" => $data['micodigo']->rango,
                "estado" => $data['micodigo']->estado,
                "codigo_socio" => $data['micodigo']->codigo_socio,
                "patrocinador" => $data['micodigo']->patrocinador,
                "nodopadre" => $data['micodigo']->nodopadre,
                "children" => []
            ];

        //echo '<pre>'.var_export($data['todosLosSocios'], true).'</pre>';exit;

            $data['title'] = 'Mi Arbol Binario';
            $data['subtitle'] = 'Mi árbol binario';
            $data['main_content'] = 'usuarios/arbol_binario';

            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    private function obtenerHijos($idPadre) {
        $hijos = $this->socioModel
            ->select('socios.id as id,codigo_socio,patrocinador,nodopadre,socios.estado as estado,nombre,rango,posicion')
            ->where('nodopadre', $idPadre)
            ->join('usuarios', 'usuarios.id=socios.idusuario','left')
            ->join('rangos', 'rangos.id=socios.idrango', 'left')
            ->findAll();

        $resultado = [];
        foreach ($hijos as $hijo) {
            $resultado[] = [
                "name" => $hijo->nombre,
                "rango" => $hijo->rango,
                "codigo_socio" => $hijo->codigo_socio,
                "patrocinador" => $hijo->patrocinador,
                "nodopadre" => $hijo->nodopadre,
                "children" => $this->obtenerHijos($hijo->id) // Aplico recursividad
            ];
        }
        return $resultado;
    }

    /**
     * Formulario para registro de un nuevo miembro
     *
     * @param 
     * @return void
     * @throws conditon
     **/
    public function registrarNuevoMiembro() {

        $data['session'] = $this->session;
        $data['sistema'] = $this->sistemaModel->findAll();

        $data['provincias'] = $this->provinciaModel->findAll();
        $data['ciudades'] = $this->ciudadModel->findAll();

        $data['title'] = 'Socios';
        $data['subtitle']='Registro un nuevo Socio';
        $data['main_content'] = 'usuarios/form_reg_new_member';
        return view('dashboard/index', $data);
        
    }

    public function insertNuevoMiembro(){

        $data = $this->acl();

        if ($data['logged'] == 1) {

            $origen = $this->request->getPostGet('origen');

            // recogemos datos enviados desde el formulario de registro
            $user = filter_var(strtoupper($this->request->getPostGet('user')), FILTER_SANITIZE_STRING);
            $pass = filter_var($this->request->getPostGet('password'), FILTER_SANITIZE_STRING);

            // generamos el hash a partir de la contraseña enviada desde el formulario
            $pass_hashed = password_hash($pass, PASSWORD_BCRYPT);

            $usuario = [
                'nombre' => strtoupper($this->request->getPostGet('nombre')),
                'user' => strtoupper($user),
                'password' => $pass_hashed,
                'cedula' => strtoupper($this->request->getPostGet('cedula')),
                'telefono' => trim($this->request->getPostGet('telefono')),
                'telefono_2' => trim($this->request->getPostGet('telefono_2')),
                'email' => $this->request->getPostGet('email'),
                'pais' => strtoupper($this->request->getPostGet('pais')),
                'idpais' => strtoupper($this->request->getPostGet('idpais')),
                'idciudad' => $this->request->getPostGet('idciudad'),
                'idprovincia' => $this->request->getPostGet('idprovincia'),
                'direccion' => strtoupper($this->request->getPostGet('direccion')),
                'suscripción' => $this->request->getPostGet('suscripción'),
                'acuerdo_terminos' => $this->request->getPostGet('chkTerminos'),
                'estado' => 1,
                'idrol' => 2
            ];

            $this->validation->setRuleGroup('insertNewMember');
        
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 

                //Traigo los datos del socio
                $data['mis_datos'] = $this->socioModel->where('idusuario', $this->session->id)->first();

                //Traigo el precio del paquete
                $paquete = $this->paqueteModel->select('pvp')->findAll();

                //verifico si no existe el usuario
                $userExist = $this->usuarioModel->select('cedula')->where('cedula', $usuario['cedula'])->findAll();

                if (!$userExist) {

                    if ($usuario['idpais'] != "47") {
                        $usuario['idciudad'] = 225;
                        $usuario['idprovincia'] = 26;
                    }

                    //echo '<pre>'.var_export($usuario, true).'</pre>';exit;
                    //Inserto el nuevo usuario
                    $user = $this->usuarioModel->insert($usuario);

                    if ($user) {
                        //Género un codigo de socio
                        $lastId = $this->socioModel->orderBy('id',"desc")->limit(1)->findAll();

                        $socio = [
                            'codigo_socio' => 'GTK-170000'.(int)($lastId[0]->id + 1),
                            'patrocinador' => $this->session->id,
                            'fecha_inscripcion' => date('Y-m-d h:m:s'),
                            'idusuario' => $user,
                            'idrango' => 1,
                            'estado' => 0
                        ];
                        
                        $socio =$this->socioModel->insert($socio);

                    } else {
                        //Salgo del sistema
                        return redirect()->to('logout');
                    }
                
                    if ($socio) {
                        //Se genera un BIR
                        $bir = [
                            'idsocio' => $this->session->id,
                            'socio_nuevo' => $socio,
                            //Le aplico la penalización en caso de que la tenga
                            'cantidad' => $data['mis_datos']->penalizacion == 0 ? 50 : 25,
                            'concepto' => "BIR POR INSCRIPCION DE NUEVO SOCIO",
                            'fecha' => date('Y-m-d h:m:s'),
                            'estado' => 0,
                        ];
                        $idbir = $this->birModel->insert($bir);

                        $pedido_inicial = [
                                
                            'fecha_compra' => date('Y-m-d'),
                            'cantidad' => 1,
                            'total' => $paquete[0]->pvp,
                            'observacion_pedido' => "COMPRA INICIAL POR INSCRIPCION",
                            'idsocio' => $socio,
                            'idpaquete' => 1,
                            'estado' => 0,
                        ];

                        $res = $this->pedidoModel->insert($pedido_inicial);
                    }

                    //Si viene desde la web 
                    if ($origen == 'web') {
                        return redirect()->to('exito-inscripcion');
                    }else if($origen == 'form_interno'){
                        return redirect()->to('lista-miembros');
                    }

                }else{
                    return redirect()->to('error-inscripcion');
                }
                
            }
        }else{

            return redirect()->to('logout');
        }
    }

    function verificaEstadoSocio($idsocio){
        return 1;
    }

    function exitoInscripcion(){
        $data[] = null;
        return view('usuarios/exito_inscripcion', $data);
    }

    function errorInscripcion(){
        $data[] = null;
        return view('usuarios/error_inscripcion', $data);
    }

    /**
     * Formulario de edición de datos del socio
     *
     * @param 
     * @return void
     * @throws conditon
     **/
    public function perfil($id, $mensaje = '') {

        $data = $this->acl();
        
        if ($data['logged'] == 1 && $this->session->miembros == 1) {

            $data['session'] = $this->session;
            $data['sistema'] = $this->sistemaModel->findAll();
            $data['provincias'] = $this->provinciaModel->findAll();
            $data['ciudades'] = $this->ciudadModel->findAll();
            $data['paises'] = $this->paisModel->findAll();

            $data['perfil'] = $this->usuarioModel->find($id);
            $data['ciudad'] = $this->ciudadModel->where('id', $data['perfil']->idciudad)->first();

            $data['title'] = 'Mis datos';
            $data['subtitle']='Editar datos del usuario';
            $data['mensaje'] = $mensaje;

            if ($data['perfil']) {
                $data['main_content'] = 'usuarios/form_edit_perfil';
            } else {
                $data['main_content'] = 'usuarios/form_error';
            }

            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
        
    }

    /**
     * Recibe la información editada del perfil de un usuario
    */
    public function editProfile($mensaje = ''){

        $data = $this->acl();

        if ($data['logged'] == 1) {

            $id = $this->session->id;
            $pass = filter_var($this->request->getPostGet('password'), FILTER_SANITIZE_STRING);

            // generamos el hash a partir de la contraseña enviada desde el formulario
            $pass_hashed = password_hash($pass, PASSWORD_BCRYPT);

            $usuario = [
                'nombre' => strtoupper($this->request->getPostGet('nombre')),
                'user' => strtoupper($this->request->getPostGet('user')),
                //'password' => $pass_hashed,
                'telefono' => strtoupper($this->request->getPostGet('telefono')),
                'telefono_2' => strtoupper($this->request->getPostGet('telefono_2')),
                'cedula' => strtoupper($this->request->getPostGet('cedula')),
                'direccion' => strtoupper($this->request->getPostGet('direccion')),
                'email' => $this->request->getPostGet('email'),
                'idpais' => strtoupper($this->request->getPostGet('idpais')),
                'idprovincia' => strtoupper($this->request->getPostGet('idprovincia')),
                'idciudad' => strtoupper($this->request->getPostGet('idciudad')),
                'acuerdo_terminos' => strtoupper($this->request->getPostGet('acuerdo_terminos')),
            ];
            
            $this->validation->setRuleGroup('insertNewMember');
        
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 
                
                //Inserto el nuevo usuario
                $res = $this->usuarioModel->update($id, $usuario);

                if ($res) {
                    $this->session->setFlashdata('mensaje', "success");
                }else{
                    $this->session->setFlashdata('mensaje', "error");
                }
                
                return redirect()->to('perfil/'.$id);
            }
        }else{

            return redirect()->to('logout');
        }
    }

    /**
     * Grid de socios registrados
     *
     * @param 
     * @return void
     * @throws conditon
     **/
    public function listaMiembros() {

        $data = $this->acl();
        
        if ($data['logged'] == 1 && $this->session->miembros == 1) {

            $data['session'] = $this->session;
            $data['sistema'] = $this->sistemaModel->findAll();
            $data['micodigo'] = $this->socioModel->find($this->session->id);

            $data['mi_equipo'] = $this->socioModel->select('socios.id as id,codigo_socio,patrocinador,fecha_inscripcion,idusuario,idrango,socios.estado as estado_socio,
                                nombre, usuarios.cedula as cedula,telefono,email,idrol,rango,socios.id as idsocio')
                ->where('patrocinador', $data['micodigo']->id)
                ->join('usuarios', 'usuarios.id=socios.idusuario')
                ->join('rangos', 'rangos.id=socios.idrango')
                ->findAll();//echo $this->db->getLastQuery();

            $data['title'] = 'Mi Equipo';
            $data['main_content'] = 'usuarios/lista_miembros';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        } 
    }

    /**
     * Tanque de reserva socios registrados aún no ubicados
     *
     * @param 
     * @return void
     * @throws conditon
     **/
    public function tanqueReserva() {

        $data = $this->acl();
        
        if ($data['logged'] == 1 && $this->session->miembros == 1) {

            $data['session'] = $this->session;
            $data['sistema'] = $this->sistemaModel->findAll();

            //Traigo a mi equipo, es decir a todos los socios que patrocina mas todos los que se encuentran abajo de el
            // $data['miEquipo'] = $this->socioModel->select('socios.id as id,codigo_socio,patrocinador,nodopadre,posicion,fecha_inscripcion,idusuario,nombre')
            //     ->join('usuarios','usuarios.id=socios.idusuario')
            //     ->where('patrocinador', $this->session->id)->findAll();

            $sql = "WITH RECURSIVE descendientes AS (
                SELECT 
                    socios.id as id,
                    socios.codigo_socio,
                    socios.patrocinador,
                    socios.nodopadre,
                    socios.posicion,
                    socios.fecha_inscripcion,
                    socios.idusuario,
                    usuarios.nombre,
                    usuarios.email,
                    usuarios.cedula
                FROM socios
                LEFT JOIN usuarios ON socios.idusuario = usuarios.id
                WHERE socios.id = ?
                UNION ALL
                SELECT 
                    s.id,
                    s.codigo_socio,
                    s.patrocinador,
                    s.nodopadre,
                    s.posicion,
                    s.fecha_inscripcion,
                    s.idusuario,
                    u.nombre,
                    u.email,
                    u.cedula
                FROM socios s
                LEFT JOIN usuarios u ON s.idusuario = u.id
                INNER JOIN descendientes d ON s.nodopadre = d.id
            )
            SELECT * FROM descendientes WHERE id != ?";

            $query = $this->db->query($sql, [$this->session->id, $this->session->id]);
            $data['miEquipo'] = $query->getResult();
            
            //Traigo los datos del patrocinador
            $patrocinador = $this->socioModel
                ->select('socios.id as id, nombre, codigo_socio, patrocinador')
                ->join('usuarios', 'socios.idusuario=usuarios.id', 'left')
                ->find($this->session->id);

            // Lo agrego al inicio del arreglo
            array_unshift($data['miEquipo'], $patrocinador);

            $data['idpatrocinador'] = $this->session->id;
            $data['patrocinador'] = $this->session->nombre;

            //Traigo a los socios debajo del patrocinador que no tienen posición
            $data['sociosReserva'] = $this->socioModel->select('socios.id as id,codigo_socio,patrocinador,idusuario,nombre,cedula,email,fecha_inscripcion,socios.estado as estado')
                ->join('usuarios', 'socios.idusuario=usuarios.id', 'left')
                ->where('posicion','I')
                ->where('patrocinador', $this->session->id)
                ->orderBy('nombre', 'asc')
                ->findall();

            $data['title'] = 'Mi Equipo';
            $data['subtitle'] = 'Tanque de retención';
            $data['main_content'] = 'usuarios/tanque-reserva';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        } 
    }

    /**
     * Devuelve los socios del equipo que estén en una pierna de la organización
     * Usada por: tanque-reserva.js
     *
     * @param 
     * @return void
     * @throws conditon
     **/
    // public function getSocios() {

    //     $pierna = $this->request->getPostGet('pierna');
    //     $equipo = $this->socioModel->select('socios.id as id,nombre,codigo_socio,patrocinador')
    //             ->where('patrocinador', $this->session->id)
    //             ->join('usuarios', 'socios.idusuario=usuarios.id', 'left')
    //             ->findAll();

    //     // Para cada socio, verifico si tiene hijos
    //     foreach ($equipo as &$socio) {
    //         $hijos = $this->socioModel->where('nodopadre', $socio->id)->countAllResults();
    //         $socio->tiene_hijos = $hijos > 0 ? true : false;
    //     }

    //     echo '<pre>'.var_export($equipo, true).'</pre>';exit;

    //     echo json_encode($equipo);
    // }

    public function getSocios() {
        $pierna = $this->request->getPostGet('pierna'); // 'I' o 'D'

        $socios_libres = [];

        // 1. Verifica si el patrocinador (usuario actual) tiene libre la pierna
        $patrocinador = $this->socioModel
            ->select('socios.id as id, nombre, codigo_socio, patrocinador')
            ->join('usuarios', 'socios.idusuario=usuarios.id', 'left')
            ->find($this->session->id);

        $hijo_patrocinador = $this->socioModel
            ->where('nodopadre', $patrocinador->id)
            ->where('posicion', $pierna)
            ->first();

        if (!$hijo_patrocinador) {
            $socios_libres[] = $patrocinador;
        }

        // 2. Busca en el equipo los socios que tengan libre esa pierna
        $equipo = $this->socioModel
            ->select('socios.id as id, nombre, codigo_socio, patrocinador')
            ->where('patrocinador', $this->session->id)
            ->join('usuarios', 'socios.idusuario=usuarios.id', 'left')
            ->findAll();

        foreach ($equipo as $socio) {
            $hijo = $this->socioModel
                ->where('nodopadre', $socio->id)
                ->where('posicion', $pierna)
                ->first();

            if (!$hijo) {
                $socios_libres[] = $socio;
            }
        }
        //echo '<pre>'.var_export($socios_libres, true).'</pre>';exit;
        echo json_encode($socios_libres);
    }

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function tablerolideres(){
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->miembros == 1) {

            $data['session'] = $this->session;
            $data['sistema'] = $this->sistemaModel->findAll();
            $data['micodigo'] = $this->socioModel->find($this->session->id);

            $data['lideres'] = $this->socioModel->select('socios.id as id,codigo_socio,rango,nombre')
                ->join('usuarios', 'usuarios.id=socios.idusuario')
                ->join('rangos', 'rangos.id=socios.idrango')
                ->findAll();

            if ($data['lideres']) {
                foreach ($data['lideres'] as $lider) {
                    $dataLider = $this->liderModel->where('idsocio', $lider->id)->first();
                    $cant_socios = $this->socioModel->where('patrocinador', $lider->id)->countAllResults();
                    $lider->cant_socios = $cant_socios;

                    // actualizo la tabla de líderes
                    $liderInsert = [
                        'idsocio' => $lider->id,
                        'cant_socios' => $cant_socios
                    ];

                    if ($dataLider) {
                        
                        $this->liderModel->update($dataLider->id, $liderInsert);
                    } else {
                        $this->liderModel->insert($liderInsert);
                    }
                }
            }

            $data['tabla_lideres'] = $this->liderModel->select('lideres.id as id, socios.id as idsocio, codigo_socio, nombre,cant_socios')
                ->join('socios', 'socios.id=lideres.idsocio')
                ->join('usuarios', 'usuarios.id=socios.idusuario')
                ->orderBy('cant_socios', 'desc')
                ->findAll();
            

            //echo '<pre>'.var_export($data['tabla_lideres'], true).'</pre>';exit;
            $data['title'] = 'Tablero de Líderes';
            $data['subtitle'] = 'Lista de socios en la organización que mas socios nuevos han captado para su equipo';
            $data['main_content'] = 'usuarios/tablero_lideres';

            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }


    function setPosition(){
        $id = $this->request->getPostGet('id');
        //$patrocinador = $this->request->getPostGet('patrocinador');

        $info['nodopadre'] = $this->request->getPostGet('posicion');
        $info['posicion'] = $this->request->getPostGet('piernas');

        $data = [
            'nodopadre'=> $info['nodopadre'],
            'posicion'=> $info['posicion']
        ];

        $info['res'] = $this->socioModel->update($id,  $data);

        echo json_encode($info);
        exit;
    }
}
