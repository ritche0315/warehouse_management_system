<?php

namespace App\Controllers;
use System\BaseController;
use App\Helpers\Session;
use App\Helpers\Url;
use App\Models\Product;
use App\Models\Supplier;


class Products extends BaseController{

    protected $product;
    protected $supplier;

    public function __construct(){
        parent::__construct();

        // if (! Session::get('logged_in')) {
        //     Url::redirect('/admin/login');
        // }

        $this->product = new Product();
        $this->supplier = new Supplier();
    }

    //view function
    public function index(){
        $products = $this->product->getProducts();

        $title = 'Products';
        $this->view->render('products/index', compact('products','title'));
    }

    //add function
    public function add(){
        $errors = [];

        if(isset($_POST['submit'])){
            
            //payloads
            $sku = (isset($_POST['sku']) ? $_POST['sku'] : null);
            $name = (isset($_POST['name']) ? $_POST['name'] : null);
            $description = (isset($_POST['description']) ? $_POST['description'] : null);
            $unitPrice = (isset($_POST['unitPrice']) ? $_POST['unitPrice'] : null);
            $supplier = (isset($_POST['supplier']) ? $_POST['supplier'] : null);

            //input validation
            if(!is_numeric($unitPrice)){
                $errors[] = "Unit Price must be a numeric value";
            }

            if($supplier == "0"){
                $errors[] = "Supplier is required.";
            }

            //check errors
            if(count($errors) == 0){
                $data = [
                    'SKU'=> $sku,
                    'Name'=>$name,
                    'Description'=>$description,
                    'UnitPrice'=> $unitPrice,
                    'SupplierID'=> $supplier
                ];
                
                $this->product->insert($data);
                Session::set('success', 'Product created');
                Url::redirect('/products');
            }
        }


        $title = 'Add Product';
        $suppliers = $this->supplier->getSuppliers();
        //render view
        $this->view->render('products/add', compact('errors','suppliers', 'title'));
    }
    // edit function
    public function edit($id){

        //CHECK PRODUCT ID IF VALID
        if (! is_numeric($id)) {
            Url::redirect('/products');
        }

        //GET PRODUCT THROUGH ID
        $product = $this->product->get_product($id);


        //THROW 404 IF NOT FOUND
        if ($product == null) {
            Url::redirect('/404');
        }

        $errors = [];

        if (isset($_POST['submit'])) {

            $sku = (isset($_POST['sku']) ? $_POST['sku'] : null);
            $name = (isset($_POST['name']) ? $_POST['name'] : null);
            $description = (isset($_POST['description']) ? $_POST['description'] : null);
            $unitPrice = (isset($_POST['unitPrice']) ? $_POST['unitPrice'] : null);
            $supplier = (isset($_POST['supplier']) ? $_POST['supplier'] : null);

            
            if (count($errors) == 0) {

                $data = [
                    'SKU'=> $sku,
                    'Name'=>$name,
                    'Description'=>$description,
                    'UnitPrice'=> $unitPrice,
                    'SupplierID'=> $supplier
                ];

                $where = ['ProductID' => $id];

                $this->product->update($data, $where);

                Session::set('success', 'Product updated');

                Url::redirect('/products');

            }

        }

        $suppliers = $this->supplier->getSuppliers();
        $title = 'Edit Product';
        $this->view->render('products/edit', compact('product', 'suppliers','errors', 'title'));
    }
    public function delete($id){
        if (! is_numeric($id)) {
            Url::redirect('/products');
        }

        // if (Session::get('user_id') == $id) {
        //     die('You cannot delete yourself.');
        // }

        // $user = $this->user->get_user($id);

        // if ($user == null) {
        //     Url::redirect('/404');
        // }

        $where = ['ProductID' => $id];

        $this->product->delete($where);

        Session::set('success', 'Product deleted');

        Url::redirect('/products');
    }
}