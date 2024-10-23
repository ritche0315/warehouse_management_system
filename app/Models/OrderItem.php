<?php
namespace App\Models;
use System\BaseModel;

class OrderItem extends BaseModel{

    public function get_orderitems(){
        return $this->db->select("orderitem.OrderID, orderitem.ProductID, products.Name, orderitem.UnitPrice, orderitem.Quantity, orderitem.TotalPrice FROM orderitem INNER JOIN products ON products.ProductID = orderitem.ProductID INNER JOIN orders ON orderitem.OrderID = orders.OrderID");
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

    public function get_totalqty_orderitems(){
        return $this->db->select('products.Name, SUM(orderitem.Quantity) AS TotalQuantity FROM orderitem INNER JOIN products ON orderitem.ProductID = products.ProductID GROUP BY orderitem.ProductID');
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