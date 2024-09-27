<?php

namespace App\Controllers;
use System\BaseController;
use App\Helpers\Session;
use App\Helpers\Url;
use App\Models\Customer;
use App\Models\Warehouse;
use App\Models\Order;
use App\Models\Product;
use App\Controllers\LastIssuedNo;


class Orders extends BaseController{

    protected $order;
    protected $customer;
    protected $warehouse;
    protected $lastIssuedNo;
    protected $product;

    public function __construct(){
        parent::__construct();

        // if (! Session::get('logged_in')) {
        //     Url::redirect('/admin/login');
        // }

        $this->order = new Order();
        $this->customer = new Customer();
        $this->warehouse = new Warehouse();
        $this->lastIssuedNo = new LastIssuedNo();
        $this->product = new Product();
    }

    //view function
    public function index(){
        $orders = $this->order->get_orders();

        $title = 'Order';
        $this->view->render('orders/index', compact('orders','title'));
    }

    public function love(){
        $title = 'Love';
        $this->view->render('orders/love', compact('title'));
    }

    //add function
    public function add(){
        $errors = [];

        if(isset($_POST['submit'])){
            
            //payload
            $product = (isset($_POST['product']) ? $_POST['product'] : null);
            $warehouse = (isset($_POST['warehouse']) ? $_POST['warehouse'] : null);
            $quantity = (isset($_POST['quantity']) ? $_POST['quantity']: null);
            

            //input validation
            if($product == 0) $errors[] = "Please select a product";

            if($warehouse == 0) $errors[] = "Please select a warehouse";
        
            //check errors
            if(count($errors) == 0){
                // no errors exec.
                $data = [
                    'WarehouseID'=> $warehouse,
                    'ProductID'=>$product,
                    'quantity'=>$quantity,
                ];
                
                $this->inventory->insert($data);
                Session::set('success', 'Inventory added');
                Url::redirect('/inventory');
            }
        }


        $title = 'Add Order';
        //populate warehouse and product
        // $this->lastIssuedNo->generateOrderNumber();
        $issuedNo = $this->lastIssuedNo->generateOrderNumber();
        $products = $this->product->getProducts();
        $customers = $this->customer->getCustomers();
        //render view
        $this->view->render('orders/add', compact('errors', 'products','customers', 'issuedNo',  'title'));
    }
    // edit function''
    public function edit($id){

        //CHECK customer ID IF VALID
        if (! is_numeric($id)) {
            Url::redirect('/inventory');
        }

        //GET customer THROUGH ID
        $inventory = $this->inventory->get_inventory($id);


        //THROW 404 IF NOT FOUND
        if ($inventory == null) {
            Url::redirect('/404');
        }

        $errors = [];

        if (isset($_POST['submit'])) {

            $product = (isset($_POST['product']) ? $_POST['product'] : null);
            $warehouse = (isset($_POST['warehouse']) ? $_POST['warehouse'] : null);
            $quantity = (isset($_POST['quantity']) ? $_POST['quantity']: null);

            //input validation
            if($product == 0) $errors[] = "Please select a product";

            if($warehouse == 0) $errors[] = "Please select a warehouse";
            
            if (count($errors) == 0) {

                $data = [
                    'WarehouseID'=> $warehouse,
                    'ProductID'=>$product,
                    'quantity'=>$quantity,
                ];

                $where = ['InventoryID' => $id];

                $this->inventory->update($data, $where);

                Session::set('success', 'Inventory updated');

                Url::redirect('/inventory');

            }

        }

        $title = 'Edit Inventory';
        //populate warehouse and product
        $warehouses = $this->warehouse->getWarehouses();
        $products = $this->product->getProducts();

        $this->view->render('inventory/edit', compact('warehouses','products', 'inventory','errors', 'title'));
    }
    public function delete($id){
        if (! is_numeric($id)) {
            Url::redirect('/inventory');
        }

        // if (Session::get('user_id') == $id) {
        //     die('You cannot delete yourself.');
        // }

        // $user = $this->user->get_user($id);

        // if ($user == null) {
        //     Url::redirect('/404');
        // }

        $where = ['InventoryID' => $id];

        $this->inventory->delete($where);

        Session::set('success', 'Inventory deleted');

        Url::redirect('/inventory');
    }
}