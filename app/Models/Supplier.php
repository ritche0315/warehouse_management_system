<?php
namespace App\Models;
use System\BaseModel;

class Supplier extends BaseModel{

    public function getSuppliers(){
        return $this->db->select('* FROM supplier');
    }

    public function insert($data)
    {
        $this->db->insert('supplier', $data);
    }

    public function update($data, $where)
    {
        $this->db->update('supplier', $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete('supplier', $where);
    }

    public function get_supplier($id){
        $data = $this->db->select("* from supplier where SupplierID = :id", [":id" => $id]);
        return (isset($data[0]) ? $data[0] : null);
    }
}
?>