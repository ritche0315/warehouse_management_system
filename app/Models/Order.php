<?php
namespace App\Models;
use System\BaseModel;

class Order extends BaseModel{

    public function get_orders(){
        return $this->db->select("orders.OrderID, orders.OrderDate, warehouse.Name as 'Warehouse', customers.FirstName, customers.LastName, orders.TotalAmount FROM orders 
        INNER JOIN warehouse ON orders.WarehouseID = warehouse.WarehouseID 
        INNER JOIN customers ON orders.CustomerID = customers.CustomerID");
    }

    public function insert($data)
    {
        $this->db->insert('orders', $data);
    }

    public function update($data, $where)
    {
        $this->db->update('orders', $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete('orders', $where);
    }

    public function get_order($id){
        $data = $this->db->select("* from orders where OrderID = :id", [":id" => $id]);
        return (isset($data[0]) ? $data[0] : null);
    }

    public function get_last_inserted_id(){
        $data = $this->db->select('LAST_INSERT_ID()');
        return (isset($data[0]) ? $data[0] : null);
    }
}
?>