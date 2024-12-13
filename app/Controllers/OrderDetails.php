<?php

namespace App\Controllers;
use System\BaseController;
use App\Helpers\Session;
use App\Helpers\Url;
use App\Models\OrderDetail;


class OrderDetails extends BaseController{

    protected $orderDetail;
    
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


    
}