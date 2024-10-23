<?php

namespace App\Controllers;
use System\BaseController;
use App\Helpers\Session;
use App\Helpers\Url;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\OrderItem;



class Reports extends BaseController{

    protected $product;
    protected $supplier;
    protected $customer;
    protected $inventory;
    protected $orderitem;


    public function __construct(){
        parent::__construct();

        
        if (!Session::get('logged_in')) {
            Url::redirect('/admin/login');
        }

        if(Session::get('user_username') != 'admin'){
            if(Session::get('user_username') != 'superadmin'){
                Url::redirect('/orders');
            }
        }

        $this->product = new Product();
        $this->supplier = new Supplier();
        $this->customer = new Customer();
        $this->inventory = new Inventory();
        $this->orderitem = new OrderItem();
    }

    //view function
    public function index(){
        $products = $this->product->getProducts();
        $suppliers = $this->supplier->getSuppliers();
        $customers = $this->customer->getCustomers();
        $inventories = $this->inventory->getInventories();
        $orderitems = $this->orderitem->get_orderitems();


        $title = 'Reports';
        $this->view->render('reports/index', compact('products', 'suppliers','customers','inventories','orderitems','title'));
    }

    
}