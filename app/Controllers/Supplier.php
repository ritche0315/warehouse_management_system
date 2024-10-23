<?php
    namespace App\Controllers;
    use System\BaseController;
    use App\Helpers\Session;
    use App\Helpers\Url;
    use App\Models\Supplier as SupplierModel;


    class Supplier extends BaseController{
        
        protected $supplier;

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

            $this->supplier = new SupplierModel();
        }
        
        public function index(){
            $suppliers = $this->supplier->getSuppliers();
            $title = 'Suppliers';
            $this->view->render('supplier/index', compact('suppliers', 'title'));
        }

        public function add(){
            $errors = [];
           
            if(isset($_POST['submit'])){
               //payload

                $name = (isset($_POST['name'])? $_POST['name'] : null);
                $address= (isset($_POST['address']) ? $_POST['address'] : null);
                $phone = (isset($_POST['phone']) ? $_POST['phone']: null);
            

                if(count($errors) == 0){
                 $data = [
                    "Name" => $name,
                    "Address" => $address,
                    "Phone" => $phone
                 ];
                 
                 
                 $this->supplier->insert($data);
                 Session::set('success',  'Supplier created');
                 Url::redirect('/supplier');
                }
            }   

            $title='Add Supplier';
            $this->view->render('supplier/add', compact('errors','title'));
        }

        public function edit($id){
            $errors = [];
           
            if(!is_numeric($id)){
                Url::redirect('/supplier');
            }

            $supplier = $this->supplier->get_supplier($id);

            if($supplier == null){
                Url::redirect('/404');
            }

            if(isset($_POST['submit'])){


               //payload

                $name = (isset($_POST['name'])? $_POST['name'] : null);
                $address= (isset($_POST['address']) ? $_POST['address'] : null);
                $phone = (isset($_POST['phone']) ? $_POST['phone']: null);
            

                if(count($errors) == 0){
                 $data = [
                    "Name" => $name,
                    "Address" => $address,
                    "Phone" => $phone
                 ];
                 
                 
                 $where = ["SupplierID" => $id];

                 $this->supplier->update($data, $where);
                 Session::set('success',  'Supplier updated!');
                 Url::redirect('/supplier');
                }
            }   

            $title='Edit Supplier';
            $this->view->render('supplier/edit', compact('errors','supplier','title'));
        }

        public function delete($id){
            $errors = [];

            if(!is_numeric($id)){
                Url::redirect('/supplier');
            }

            $where = ['SupplierID'=>$id];

            $this->supplier->delete($where);

            Session::set('success', 'Supplier deleted');
            Url::redirect('/supplier');
        }
    }
?>