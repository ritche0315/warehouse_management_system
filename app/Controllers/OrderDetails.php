<?php

namespace App\Controllers;
use System\BaseController;
use App\Helpers\Session;
use App\Helpers\Url;
use App\Models\OrderDetail;
use App\Models\Inventory;
use App\Models\Order;


class OrderDetails extends BaseController{

    protected $orderDetail;
    protected $inventory;
    protected $order;
    
    public function __construct(){
        parent::__construct();

        if (!Session::get('logged_in')) {
            Url::redirect('/admin/login');
        }

        // only authorized user can access this route(admin & superadmin)
        // if(Session::get('user_username') != "admin" 
        // || Session::get('user_username') != "superadmin"){ 
        //     Url::redirect('/orders/add');
        //     return;
        // }

        $this->orderDetail = new OrderDetail();
        $this->inventory = new Inventory();
        $this->order = new Order();
    }

    //view function
    // public function index(){
    //     $orders = $this->order->get_orders();
    //     $title = 'Order';
    //     $this->view->render('orders/index', compact('orders','title'));
    // }


    public function fetch_orderdetails($id){
        //CHECK customer ID IF VALID
        if (! is_numeric($id)) {
            Url::redirect('/inventory');
        }

        //GET customer THROUGH ID
        $orderDetails = $this->orderDetail->get_orderdetails($id);


        //THROW 404 IF NOT FOUND
        if ($orderDetails == null) {
            Url::redirect('/404');
        }

            

        echo json_encode(["orderdetails"=>$orderDetails]);
            
        
    }

    public function remove_orderdetail(){

        $orderDetail_ID = (isset($_POST['orderItemId'])? $_POST['orderItemId']: null);
        $orderId = (isset($_POST['orderId'])? $_POST['orderId']: null);

        $fetchedOrderItems = $this->orderDetail->get_orderdetails($orderId);


        // if(count($fetchedOrderItems) <= 1){
            
        //     $this->order->update(['Status'=>'Cancelled', 'Remarks'=>'Cancelled Order'], ['OrderID'=>$orderId]);
        // }
        
        $fetchedOrderDetail = $this->orderDetail->get_orderdetail($orderDetail_ID);

        //THROW 404 IF NOT FOUND
        if ($fetchedOrderDetail == null) {
            Url::redirect('/404');
        }

        //delete orderdetail
        $where = ['OrderDetail_ID'=> $orderDetail_ID];
        $this->orderDetail->delete($where);


        //return to inventory
        // $productId = $fetchedOrderDetail->ProductID;
        // $where = ['ProductID'=> $productId];

        // $currentQty = $this->invetory->get_current_qty($productId);
        // $itemQty =  $fetchedOrderDetail->Quantity;
        // $newQty = (int)$currentQty + (int)$itemQty;

        // $this->inventory->insert(['Quantity'=>$newQty], $where);
        
        echo json_encode(['message'=> 'item removed']);
    }

    
}