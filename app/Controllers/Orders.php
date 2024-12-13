<?php

namespace App\Controllers;
use System\BaseController;
use App\Helpers\Session;
use App\Helpers\Url;
use App\Models\Inventory;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;

class Orders extends BaseController{

    protected $customer;
    protected $order;
    protected $orderDetail;
    protected $product;
    protected $inventory;
    
    public function __construct(){
        parent::__construct();

        if (! Session::get('logged_in')) {
            Url::redirect('/admin/login');
        }

        $this->customer = new Customer();
        $this->order = new Order();
        $this->orderDetail = new OrderDetail();
        $this->product = new Product();
        $this->inventory = new Inventory();
    }

    //view function
    public function index(){
        $title = "Order";

        $customers = $this->customer->getCustomers();
        $orders = $this->order->get_orders();
        $this->view->render('orders/index', compact('title','orders', 'customers'));
    }

    

    //add function
    public function add(){
        $errors = [];
        if(isset($_POST['submit'])){
            
        
            //check errors
            if(count($errors) == 0){
                
                
            }
           
        }


        $title = 'Add Order';
        $customers = $this->customer->getCustomers();
        //render view
        $this->view->render('orders/add', compact('errors','title','customers'));
    }
    
    public function add_order(){
        if(isset($_POST['data'])){

            
            $decodedjson = json_decode($_POST['data']);
            

            $totalAmount = $decodedjson->order->totalAmount;
            $totalItems = $decodedjson->order->totalItems;
            $orderDate = $decodedjson->order->orderDate;
            $userid = Session::get('user_id');
            $customerid = $decodedjson->order->customerId;
            
            $data = [
                "CustomerID"=> $customerid,
                "UserID"=> $userid,
                "OrderDate"=> $orderDate,
                "TotalQuantity"=> $totalItems,
                "TotalAmount"=> $totalAmount,
				"Status"=> "Pending",
				"Remarks" => "", 
            ];

            $test = [];

            foreach($decodedjson->orderdetails as $orderdetail){
                $test[] = $orderdetail->barcode;
            }
            
            $this->order->insert($data);

            //order details insertion
            $lastInsertedId = $this->order->get_last_inserted_id();
            $orderId = $lastInsertedId->{'LAST_INSERT_ID()'};
            
            foreach($decodedjson->orderdetails as $orderdetail){

                $barcode = $orderdetail->barcode;
                $quantity = $orderdetail->quantity;
                $subtotal = $orderdetail->subtotal;
                
                $fetchedProduct = $this->product->get_product_by_barcode($barcode);//get product
                $productId = $fetchedProduct->ProductID;
                $priceSold = $fetchedProduct->UnitPrice;
    
                $orderDetailsData = [
                    "OrderID" => $orderId,
                    "ProductID" => $productId,
                    "PriceSold" => $priceSold,
                    "Quantity" => $quantity,
                    "SubTotal"=> $subtotal
                ];
            
                $this->orderDetail->insert($orderDetailsData);


                // //get available stock and update stock qty (inventory)
                // $inventoryStock = $this->inventory->get_inventory_by_barcode($barcode);

                // $newStockValue = $inventoryStock->Quantity - $quantity;

                // $where = [
                //     "ProductID" => $inventoryStock->ProductID
                // ];
                
                // $inventoryData = ["Quantity" => $newStockValue];

                // $this->inventory->update($inventoryData, $where);
            }

            echo json_encode(["message"=>"Orded Added"]);

        }
    }

    public function fetch_order($id){
        if (! is_numeric($id)) {
            Url::redirect('/orders');
        }

        $order = $this->order->get_order($id);

        echo json_encode(["order"=>$order]);
        
    }

    public function cancel_order(){
        $orderId = isset($_POST['orderId']) ? $_POST['orderId'] : null;
        $remarks = isset($_POST['remarks']) ? $_POST['remarks'] : null;
        $status = isset($_POST['status']) ? $_POST['status'] : null;
        
        $where = ["OrderID"=> $orderId];
        $data = [
            "Status"=>$status,
            "Remarks" => $remarks
        ];

        $this->order->update($data, $where);

        echo json_encode(["message"=>"Order Cancelled Successsfully!"]);        
    }

    public function update_order(){
        if(isset($_POST['data'])){
            $decodedjson = json_decode($_POST['data']);
            
            $updateOrderItems = $decodedjson->updateOrderItems;
            $totalAmount = $decodedjson->order->totalAmount;
            $totalItems = $decodedjson->order->totalItems;
            $customer = $decodedjson->order->customer;
            $orderId = $decodedjson->order->orderId;
            $orderDate = $decodedjson->order->orderDate;
            // echo json_encode(["order"=>[$orderId, $totalAmount, $totalItems, $customer], "updateOrderItems"=>$updateOrderItems]);
            // return;


            foreach($updateOrderItems as $orderitem){
                $quantity = $orderitem->quantity;
                $subtotal = $orderitem->subtotal;
                $orderDetailId = $orderitem->orderItemId;
                
                //getproductId in orderdetails
                $fetchedOrderDetail = $this->orderDetail->get_orderdetail($orderDetailId);
                $productId = $fetchedOrderDetail->ProductID;
                $prevQuantity = $fetchedOrderDetail->Quantity;

                //get current qty and add the prevquantity
                $fetchedCurrentQty = $this->inventory->get_current_qty($productId);
                $currentQty = $fetchedCurrentQty->Quantity;
                $totQty = (int)$currentQty + (int)$prevQuantity;

                // $inventoryData = ["Quantity"=>$totQty];
                // $where = ["ProductID"=> $productId];

                //return orderitems to inventory
                // $this->inventory->update($inventoryData, $where);


                //orderdetails
                $where = ["OrderDetail_ID"=> $orderDetailId];


                $data = [
                    "Quantity"=> $quantity,
                    "Subtotal"=> $subtotal
                ];

                $this->orderDetail->update($data, $where);

                //subtract quantity in the inventory

                //get current quantity and subtract the new qty
                $currentQty = $this->inventory->get_current_qty($productId);
                $newQty = (int)$totQty - (int)$quantity;

                $inventoryData = ["Quantity"=>$newQty];

                $where = ["ProductID"=> $productId];
                $this->inventory->update($inventoryData, $where);
            }
            
            //order
            
            $dataOrder = [
                "OrderDate"=>$orderDate,
                "CustomerID"=>$customer,
                "TotalQuantity"=>$totalItems,
                "TotalAmount"=> $totalAmount,
            ];

            $where = ["OrderID"=>$orderId];

            $this->order->update($dataOrder, $where);
            
            echo json_encode(["message"=>"Order Updated Successfully!"]);
        }
    }
    // edit function''
    public function edit($id){

        $errors = [];

        if (isset($_POST['submit'])) {
            //check errors
            if(count($errors) == 0){
                

                Session::set('success', 'Order Updated');
                Url::redirect('/orders');
            }
        }

        $title = 'Edit Order';

        $this->view->render('orders/edit', compact('errors', 'title'));
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

        Session::set('success', 'Order deleted');

        Url::redirect('/orders');
    }
}