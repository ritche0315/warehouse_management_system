<?php
namespace App\Models;
use System\BaseModel;

class Warehouse extends BaseModel{

    public function getWarehouses(){
        return $this->db->select('* FROM warehouse');
    }

    public function insert($data)
    {
        $this->db->insert('warehouse', $data);
    }

    public function update($data, $where)
    {
        $this->db->update('warehouse', $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete('warehouse', $where);
    }

    public function get_warehouse($id){
        $data = $this->db->select("* from warehouse where WarehouseID = :id", [":id" => $id]);
        return (isset($data[0]) ? $data[0] : null);
    }
}
?>