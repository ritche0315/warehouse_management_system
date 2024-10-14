<?php
namespace App\Models;
use System\BaseModel;

class OrderItem extends BaseModel{

    public function get_orders(){
        return $this->db->select("");
    }

    public function insert($data)
    {
        $this->db->insert('orderitem', $data);
    }

    public function update($data, $where)
    {
        $this->db->update('orderitem', $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete('orderitem', $where);
    }

    public function get_orderitem($id){
        $data = $this->db->select("products.Name, orderitem.OrderID, orderitem.UnitPrice, 
        orderitem.Quantity, orderitem.TotalPrice from orderitem INNER JOIN products ON 
        orderitem.ProductID = products.ProductID 
        where orderitem.OrderID = :id", [":id" => $id]);
        return (isset($data[0]) ? $data[0] : null);
    }
}
?>