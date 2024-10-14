<?php

namespace App\Controllers;
use System\BaseController;
use App\Helpers\Session;
use App\Helpers\Url;
use App\Models\OrderItem as OrderItemModel;


class OrderItem extends BaseController{

    protected $orderitem;
    
    public function __construct(){
        parent::__construct();

        // if (! Session::get('logged_in')) {
        //     Url::redirect('/admin/login');
        // }

        $this->orderitem = new OrderItemModel();
    }

    //view function
    // public function index(){
    //     $orders = $this->order->get_orders();
    //     $title = 'Order';
    //     $this->view->render('orders/index', compact('orders','title'));
    // }


    public function view_orderitem($id){
        //CHECK customer ID IF VALID
        if (! is_numeric($id)) {
            Url::redirect('/inventory');
        }

        //GET customer THROUGH ID
        $orderitem = $this->orderitem->get_orderitem($id);


        //THROW 404 IF NOT FOUND
        if ($orderitem == null) {
            Url::redirect('/404');
        }

            

        echo json_encode($orderitem);
            
        
    }


    
}