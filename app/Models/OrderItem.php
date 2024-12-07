<?php
namespace App\Models;
use System\BaseModel;

class OrderItem extends BaseModel{

    public function get_orderitems(){
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


}
?>