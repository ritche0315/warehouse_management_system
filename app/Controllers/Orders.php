<?php

namespace App\Controllers;
use System\BaseController;
use App\Helpers\Session;
use App\Helpers\Url;
use App\Models\Customer;
use App\Models\Warehouse;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Inventory;
use App\Controllers\LastIssuedNo;


class Orders extends BaseController{

    protected $order;
    protected $customer;
    protected $warehouse;
    protected $lastIssuedNo;
    protected $inventory;
    
    public function __construct(){
        parent::__construct();

        if (! Session::get('logged_in')) {
            Url::redirect('/admin/login');
        }

        $this->order = new Order();
        $this->orderitem = new OrderItem();
        $this->customer = new Customer();
        $this->warehouse = new Warehouse();
        $this->lastIssuedNo = new LastIssuedNo();
        $this->inventory = new Inventory();
    }

    //view function
    public function index(){
        $orders = $this->order->get_orders();
        $title = 'Order';
        $this->view->render('orders/index', compact('orders','title'));
    }


    //add function
    public function add(){
        $errors = [];
        if(isset($_POST['submit'])){
            //payload
        
            $customer = (isset($_POST['selectCustomer']) ? $_POST['selectCustomer'] : null);
            $product = (isset($_POST['selectProduct']) ? $_POST['selectProduct'] : null);
            $quantity = (isset($_POST['quantity']) ? $_POST['quantity'] : null);
            $totalAmount = (isset($_POST['totalAmount']) ? $_POST['totalAmount']: null);
            $warehouseID = (isset($_POST['warehouseID']) ? $_POST['warehouseID']: null);
            $unitPrice = (isset($_POST['unitPrice']) ? $_POST['unitPrice']: null);
            $orderDate = (isset($_POST['orderdate']) ? $_POST['orderdate']: null);

            //input validation
            if($product == 0) $errors[] = "Please select a product";

            if($customer == 0) $errors[] = "Please select a customer";
        
            //check errors
            if(count($errors) == 0){
                // no errors exec.

                $data = [
                    'CustomerID'=>$customer,
                    'OrderDate'=>$orderDate,
                    'WarehouseID'=>$warehouseID,
                    'TotalAmount'=>$totalAmount
                ];
                
                $this->order->insert($data);

                $orderId = $this->order->get_last_inserted_id();
                

                //get product id from inventory
                $inventoryId = $product;
                $inventoryResult = $this->inventory->get_inventory($inventoryId);
                 
                $productId = $inventoryResult->ProductID;
            
                
                $orderitemdata = [
                    'OrderID'=> $orderId->{'LAST_INSERT_ID()'},
                    'ProductID'=> $productId, //
                    'UnitPrice'=> $unitPrice,
                    'Quantity'=> $quantity,
                    'TotalPrice'=> $totalAmount,
                ];
                
                $this->orderitem->insert($orderitemdata);


                //update inventory
                $where = ['InventoryID' => $inventoryId];


                $currentQuantity = $inventoryResult->Quantity;
                $newQuantity = (int)$currentQuantity - (int)$quantity;

                $this->inventory->update(["quantity"=>$newQuantity], $where);

                Session::set('success', 'Order added');
                Url::redirect('/orders');
            }
           
        }


        $title = 'Add Order';

        $products = $this->inventory->getInventories();
        $customers = $this->customer->getCustomers();
        $warehouses = $this->warehouse->getWarehouses(); 

        //render view
        $this->view->render('orders/add', compact('errors', 'products','customers', 'warehouses',  'title'));
    }

    // edit function''
    public function edit($id){

        //CHECK customer ID IF VALID
        if (! is_numeric($id)) {
            Url::redirect('/order');
        }

        //GET customer THROUGH ID
        $order = $this->order->get_order($id);


        //THROW 404 IF NOT FOUND
        if ($order == null) {
            Url::redirect('/404');
        }

        $errors = [];

        if (isset($_POST['submit'])) {

            //payload
        
            $customer = (isset($_POST['selectCustomer']) ? $_POST['selectCustomer'] : null);
            $product = (isset($_POST['selectProduct']) ? $_POST['selectProduct'] : null);
            $quantity = (isset($_POST['quantity']) ? $_POST['quantity'] : null);
            $totalAmount = (isset($_POST['totalAmount']) ? $_POST['totalAmount']: null);
            $warehouseID = (isset($_POST['warehouseID']) ? $_POST['warehouseID']: null);
            $unitPrice = (isset($_POST['unitPrice']) ? $_POST['unitPrice']: null);
            $orderDate = (isset($_POST['orderdate']) ? $_POST['orderdate']: null);

            //input validation
            if($product == 0) $errors[] = "Please select a product";

            if($customer == 0) $errors[] = "Please select a customer";
        
            //check errors
            if(count($errors) == 0){
                // no errors exec.

                $data = [
                    'CustomerID'=>$customer,
                    'OrderDate'=>$orderDate,
                    'WarehouseID'=>$warehouseID,
                    'TotalAmount'=>$totalAmount
                ];

                $where = ['OrderID' => $id];
                
                $this->order->update($data, $where);


                //get product id from inventory
                $inventoryId = $product;
                $inventoryResult = $this->inventory->get_inventory($inventoryId);
                 
                $productId = $inventoryResult->ProductID;
            
                
                $orderitemdata = [
                    'ProductID'=> $productId, //
                    'UnitPrice'=> $unitPrice,
                    'Quantity'=> $quantity,
                    'TotalPrice'=> $totalAmount,
                ];
                

                $this->orderitem->update($orderitemdata, $where);


                //update inventory
                $where = ['InventoryID' => $inventoryId];


                $currentQuantity = $inventoryResult->Quantity;
                $newQuantity = (int)$currentQuantity - (int)$quantity;

                $this->inventory->update(["quantity"=>$newQuantity], $where);

                Session::set('success', 'Order Updated');
                Url::redirect('/orders');
            }
        }

        $title = 'Edit Order';
        //populate warehouse and product
        $warehouses = $this->warehouse->getWarehouses();
        $customers = $this->customer->getCustomers();
        $orderitem = $this->orderitem->get_orderitem($order->OrderID);
        $products = $this->inventory->getInventories();

        $this->view->render('orders/edit', compact('warehouses', 'products','orderitem','customers','order','errors', 'title'));
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
        

        $where = ['OrderID' => $id];
        $this->orderitem->delete($where);
        $this->order->delete($where);

        Session::set('success', 'Order deleted');

        Url::redirect('/orders');
    }
}