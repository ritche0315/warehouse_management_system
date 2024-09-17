<?php

namespace App\Controllers;
use System\BaseController;
use App\Helpers\Session;
use App\Helpers\Url;
use App\Models\Customer;


class Customers extends BaseController{

    protected $customer;

    public function __construct(){
        parent::__construct();

        // if (! Session::get('logged_in')) {
        //     Url::redirect('/admin/login');
        // }

        $this->customer = new Customer();
    }

    //view function
    public function index(){
        $customers = $this->customer->getCustomers();

        $title = 'Customers';
        $this->view->render('customers/index', compact('customers','title'));
    }

    //add function
    public function add(){
        $errors = [];

        if(isset($_POST['submit'])){
            
            //payload
            $firstName = (isset($_POST['firstName']) ? $_POST['firstName'] : null);
            $lastName = (isset($_POST['lastName']) ? $_POST['lastName'] : null);
            $email = (isset($_POST['email']) ? $_POST['email'] : null);
            $phone = (isset($_POST['phone']) ? $_POST['phone'] : null);
            $address = (isset($_POST['address']) ? $_POST['address'] : null);
            

            //input validation
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors[] = 'Please enter a valid email address';
            }
        
            //check errors
            if(count($errors) == 0){
                // no errors exec.
                $data = [
                    'FirstName'=> $firstName,
                    'LastName'=>$lastName,
                    'Email'=>$email,
                    'Phone'=> $phone,
                    'Address'=> $address
                ];
                
                $this->customer->insert($data);
                Session::set('success', 'Customer added');
                Url::redirect('/customers');
            }
        }


        $title = 'Add Customer';
        //render view
        $this->view->render('customers/add', compact('errors', 'title'));
    }
    // edit function
    public function edit($id){

        //CHECK customer ID IF VALID
        if (! is_numeric($id)) {
            Url::redirect('/customers');
        }

        //GET customer THROUGH ID
        $customer = $this->customer->get_customer($id);


        //THROW 404 IF NOT FOUND
        if ($customer == null) {
            Url::redirect('/404');
        }

        $errors = [];

        if (isset($_POST['submit'])) {

            $firstName = (isset($_POST['firstName']) ? $_POST['firstName'] : null);
            $lastName = (isset($_POST['lastName']) ? $_POST['lastName'] : null);
            $email = (isset($_POST['email']) ? $_POST['email'] : null);
            $phone = (isset($_POST['phone']) ? $_POST['phone'] : null);
            $address = (isset($_POST['address']) ? $_POST['address'] : null);

            
            if (count($errors) == 0) {

                $data = [
                    'FirstName'=> $firstName,
                    'LastName'=>$lastName,
                    'Email'=>$email,
                    'Phone'=> $phone,
                    'Address'=> $address
                ];

                $where = ['CustomerID' => $id];

                $this->customer->update($data, $where);

                Session::set('success', 'Customer updated');

                Url::redirect('/customers');

            }

        }

        $title = 'Edit Customer';
        $this->view->render('customers/edit', compact('customer', 'errors', 'title'));
    }
    public function delete($id){
        if (! is_numeric($id)) {
            Url::redirect('/customers');
        }

        // if (Session::get('user_id') == $id) {
        //     die('You cannot delete yourself.');
        // }

        // $user = $this->user->get_user($id);

        // if ($user == null) {
        //     Url::redirect('/404');
        // }

        $where = ['CustomerID' => $id];

        $this->customer->delete($where);

        Session::set('success', 'Customer deleted');

        Url::redirect('/customers');
    }
}