<?php
namespace App\Models;
use System\BaseModel;

class Inventory extends BaseModel{

    public function getInventories(){
        return $this->db->select("inventory.InventoryID, products.ProductID, products.Barcode, products.Name, products.Description, products.UnitPrice, inventory.Quantity, warehouse.WarehouseID, warehouse.Name as \"WarehouseName\", warehouse.Location as \"WarehouseLocation\" FROM inventory INNER JOIN products ON inventory.ProductID = products.ProductID INNER JOIN warehouse ON inventory.WarehouseID = warehouse.WarehouseID");
    }

    public function insert($data)
    {
        $this->db->insert('inventory', $data);
    }

    public function update($data, $where)
    {
        $this->db->update('inventory', $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete('inventory', $where);
    }
    
    public function get_current_qty($id){
        $data = $this->db->select("Quantity FROM inventory WHERE ProductID=:id", [":id"=>$id]);
        return (isset($data[0]) ? $data[0] : null);
    }
    public function get_inventory_by_barcode($barcode){
        $data = $this->db->select("* from inventory INNER JOIN products ON inventory.ProductID = products.ProductID where products.barcode = :barcode", [":barcode" => $barcode]);
        return (isset($data[0]) ? $data[0] : null);
    }
    public function get_inventory($id){
        $data = $this->db->select("* from inventory where InventoryID = :id", [":id" => $id]);
        return (isset($data[0]) ? $data[0] : null);
    }

    
}
?>