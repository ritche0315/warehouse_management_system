<?php

namespace App\Controllers;
use System\BaseController;
use App\Helpers\Session;
use App\Helpers\Url;


class Orders extends BaseController{


    
    public function __construct(){
        parent::__construct();

        // if (! Session::get('logged_in')) {
        //     Url::redirect('/admin/login');
        // }

    }

    //view function
    public function index(){
        $title = "Order";
        $this->view->render('orders/index', compact('title'));
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

        //render view
        $this->view->render('orders/add', compact('errors','title'));
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