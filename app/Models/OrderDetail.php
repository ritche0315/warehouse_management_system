<?php
namespace App\Models;
use System\BaseModel;

class OrderDetail extends BaseModel{

    public function get_orderdetails($id){
        return $this->db->select("* FROM orderdetails
            INNER JOIN products ON orderdetails.ProductID = products.ProductID 
            WHERE orderdetails.OrderID=:OrderID
        ", [":OrderID"=> $id]);
    }

    public function get_orderdetail($id){
        $data = $this->db->select("* FROM orderdetails WHERE OrderDetail_ID=:id", [":id"=>$id]);
        return (isset($data[0]) ? $data[0] : null);
    }
    

    public function insert($data)
    {
        $this->db->insert('orderdetails', $data);
    }

    public function update($data, $where)
    {
        $this->db->update('orderdetails', $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete('orderdetails', $where);
    }


}
?>