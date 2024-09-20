<?php
namespace App\Models;
use System\BaseModel;

class LastIssuedNo extends BaseModel{

    public function get_orders(){
        return $this->db->select("");
    }

    public function getOrderNo($year){
        $data = $this->db->select("* FROM lastissuedno WHERE YearIssued = :year_param", [":year_param" => $year]);
        return isset($data[0]) ? $data[0] : null;
    }

    public function insert($data)
    {
        $this->db->insert('lastissuedno', $data);
    }

    public function update($data, $where)
    {
        $this->db->update('lastissuedno', $data, $where);

    }

    public function delete($where)
    {
        $this->db->delete('products', $where);
    }

    public function get_product($id){
        $data = $this->db->select("* from products where ProductID = :id", [":id" => $id]);
        return (isset($data[0]) ? $data[0] : null);
    }
}
?>