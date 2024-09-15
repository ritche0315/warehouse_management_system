<?php
namespace App\Models;
use System\BaseModel;

class Product extends BaseModel{

    public function getProducts(){
        return $this->db->select('* FROM products');
    }

    public function insert($data)
    {
        $this->db->insert('products', $data);
    }

    public function update($data, $where)
    {
        $this->db->update('products', $data, $where);
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