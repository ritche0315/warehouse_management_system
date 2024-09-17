<?php
namespace App\Models;
use System\BaseModel;

class Customer extends BaseModel{

    public function getCustomers(){
        return $this->db->select('* FROM customers');
    }

    public function insert($data)
    {
        $this->db->insert('customers', $data);
    }

    public function update($data, $where)
    {
        $this->db->update('customers', $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete('customers', $where);
    }

    public function get_customer($id){
        $data = $this->db->select("* from customers where CustomerID = :id", [":id" => $id]);
        return (isset($data[0]) ? $data[0] : null);
    }
}
?>