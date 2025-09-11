<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model {

    protected $table            = 'pedidos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'fecha_compra','cantidad','total','observacion_pedido','idsocio',
        'idpaquete','estado','descripcion','abono','saldo'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    function _verificaRecompra($idsocio){
        $fechaCadena = date('Y-m');
        $month = date('m');
        $year = date('Y');
        
        $num_dias = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $result = NULL;
        $builder = $this->db->table('pedidos');
        $builder->where('fecha_compra BETWEEN "'. date('Y-m-d', strtotime($fechaCadena.'-01')). '" and "'. date('Y-m-d', strtotime($fechaCadena.'-'.$num_dias)).'"');
        $builder->where('idsocio', $idsocio);
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;                               
    }

    function _getRecompraMes($fechaInicio, $fechaFinal){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->where($this->table.'.estado', 1);
        $builder->where($this->table.'.idsocio', 1);
        $builder->where( "fecha_compra BETWEEN '$fechaInicio' AND '$fechaFinal'", NULL, FALSE );
        $builder->orderBy('fecha_compra', 'desc');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getColorSemana($semana){
        $colores = [
            1 => '#dbac77',
            2 => '#7bb6d2',
            3 => '#e0d998',
            4 => '#bcd48e',
            5 => '#dbac77',
        ];

        return $colores[$semana];
    }
}
