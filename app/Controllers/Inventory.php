<?php

namespace App\Controllers;
use System\BaseController;
use App\Helpers\Session;
use App\Helpers\Url;
use App\Models\Inventory as InventoryModel;
use App\Models\Product;
use App\Models\Warehouse;


class Inventory extends BaseController{

    protected $inventory;
    protected $product;
    protected $warehouse;

    public function __construct(){
        parent::__construct();

        
        // if (!Session::get('logged_in')) {
        //     Url::redirect('/admin/login');
        // }
        
        // if(Session::get('user_username') != 'admin'){
        //     if(Session::get('user_username') != 'superadmin'){
        //         Url::redirect('/orders');
        //     }
        // }

        $this->inventory = new InventoryModel();
        $this->product = new Product();
        $this->warehouse = new Warehouse();
    }

    //view function
    public function index(){
        $inventories = $this->inventory->getInventories();

        $title = 'Inventory';
        $userloggedIn = Session::get('user_username');
        $this->view->render('inventory/index', compact('inventories','userloggedIn','title'));
    }

    public function fetch_inventory($barcode){
        $inventories = $this->inventory->get_inventory_by_barcode($barcode);

        // $userloggedIn = Session::get('user_username');
        // $this->view->render('inventory/index', compact('inventories','userloggedIn','title'));

        echo json_encode($inventories);
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


        $title = 'Add Inventory';
        //populate warehouse and product
        $warehouses = $this->warehouse->getWarehouses();
        $products = $this->product->getProducts();
        //render view
        $this->view->render('inventory/add', compact('warehouses','products','errors', 'title'));
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

    //adjustment

    public function adjustment(){

        $errors = [];

        if (isset($_POST['submit'])) {
            
            $product = (isset($_POST['product']) ? $_POST['product'] : null);
            $currentQuantity = (isset($_POST['currentQuantity']) ? $_POST['currentQuantity'] : null);
            $quantity = (isset($_POST['quantity']) ? $_POST['quantity']: null);

            //input validation
            if($product == 0) $errors[] = "Please select a product";

            
            if (count($errors) == 0) {

                $totalQuantity = (int)$quantity + (int)$currentQuantity;
                $data = [
                    'quantity'=> $totalQuantity,
                ];

                $where = ['ProductID' => $product];

                $this->inventory->update($data, $where);

                Session::set('success', 'Inventory updated');

                Url::redirect('/inventory');
            }

        }

        $title = 'Inventory Adjustment';
        //populate inventory
        $products = $this->inventory->getInventories();

        $this->view->render('inventory/adjustment', compact('products','errors', 'title'));
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