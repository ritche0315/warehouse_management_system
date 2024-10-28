<?php
namespace App\Controllers;

use System\BaseController;
use App\Helpers\Session;
use App\Helpers\Url;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Inventory;
use App\Models\Supplier;
use App\Models\Customer;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\Config;

class Admin extends BaseController{
    protected $user;
    protected $inventory;
    protected $order;
    protected $supplier;
    protected $customer;
    protected $orderitem;

    public function __construct()
    {
        parent::__construct();

      
        $this->user = new User();
        $this->customer = new Customer();
        $this->order = new Order();
        $this->inventory = new Inventory();
        $this->supplier = new Supplier();
        $this->orderitem = new OrderItem();
    }

    public function index()
    {
      
        if (!Session::get('logged_in')) {
            Url::redirect('/admin/login');
        }
        

        if(Session::get('user_username') != 'admin'){
            if(Session::get('user_username') != 'superadmin'){
                Url::redirect('/orders');
            }
        }
        
        $customers = count($this->customer->getCustomers());
        $suppliers = count($this->supplier->getSuppliers());
        $inventory = count($this->inventory->getInventories());
        $orders = count($this->order->get_orders());
        
        $orderitems = $this->orderitem->get_totalqty_orderitems();
    

        $reports = [
            "customers"=> $customers,
            "suppliers"=> $suppliers,
            "inventory"=> $inventory,
            "orders"=> $orders
        ];

        $title = 'Dashboard';
        $this->view->render('admin/index', compact('title','reports','orderitems'));

    }

    public function login(){
        if (Session::get('logged_in')) {
            Url::redirect('/admin');
        }
        
        $errors = [];

        if (isset($_POST['submit'])) {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
    
            if (password_verify($password, $this->user->get_hash($username)) == false) {
                $errors[] = 'Wrong username or password';
            }
    
            if (count($errors) == 0) {
    
                //logged in
                $data = $this->user->get_data($username);
    
                Session::set('logged_in', true);
                Session::set('user_id', $data->id);
                Session::set('user_username', $data->username);
    
                Url::redirect('/admin');
            }
        }

        $title = 'Login';
        $this->view->render('admin/auth/login', compact('title', 'errors'));
    }

    public function logout(){
        Session::destroy();
        Url::redirect('/admin/login');
    }

    public function reset(){

        if (!Session::get("logged_in")) {
            Url::redirect("/admin");
        }
    
        if(Session::get('user_username') != 'admin'){
            if(Session::get('user_username') != 'superadmin'){
                Url::redirect('/orders');
            }
        }
        
        $errors = [];
    
        if (isset($_POST["submit"])) {
    
           $email = (isset($_POST["email"]) ? $_POST["email"] : null);
    
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Please enter a valid email address";
            } else {
                if ($email != $this->user->get_user_email($email)){
                    $errors[] = "Email address not found";
                }
            }
    
            if (count($errors) == 0) {
    
                $token = md5(uniqid(rand(),true));
                $data  = ["reset_token" => $token];
                $where = ["email" => $email];
                $this->user->update($data, $where);
                
                
                $config = Config::getMailProps();//PHPmailer props from config
                $mail = new PHPMailer(true);
    
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                $mail->Host = $config['MAILHOST'];
                $mail->Username = $config['USERNAME'];
                $mail->Password = $config['PASSWORD'];
            
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                // $mail->setFrom($config['SEND_FROM'], $config['SEND_FROM_NAME']);
                $mail->addAddress($email);
                // $mail->addReplyTo($config['REPLY_TO'], $config['REPLY_TO_NAME']);

                $mail->isHTML(true);
                $mail->Subject = "Reset your account";
                $mail->Body    = "<p>To change your password please click <a href='http://localhost:8000/admin/change_password/$token'>this link</a></p>";
                $mail->AltBody = "To change your password please go to this address: http://localhost:8000/admin/change_password/$token";
                
                $mail->send();
    
                Session::set("success", "Email sent to ".htmlentities($email));
    
                Url::redirect("/admin/reset");
    
            }
    
        }
    
         $title = "Reset Account";
    
        $this->view->render("admin/auth/reset", compact("title", "errors"));
    }

    public function change_password($token){
        if (Session::get("logged_in")) {
            Url::redirect("/admin");
        }
    
        $errors = [];

        $user = $this->user->get_user_reset_token($token);

        if($user == null){
            $errors[] = 'user not found';
        }
        if (isset($_POST["submit"])) {

            $token            = htmlspecialchars($_POST["token"]);
            $password         = htmlspecialchars($_POST["password"]);
            $password_confirm = htmlspecialchars($_POST["password_confirm"]);
    
            $user = $this->user->get_user_reset_token($token);
    
            if ($user == null) {
                $errors[] = "user not found.";
            }
    
            if ($password != $password_confirm) {
                $errors[] = "Passwords to not match";
            } elseif (strlen($password) < 3) {
                $errors[] = "Password is too short";
            }
    
            if (count($errors) == 0) {
    
                $data  = [
                    "reset_token" => null,
                    "password" => password_hash($password, PASSWORD_BCRYPT)
                ];
    
                $where = [
                    "id" => $user->id,
                    "reset_token" => $token
                ];
    
                $this->user->update($data, $where);
    
                Session::set("logged_in", true);
                Session::set("user_id", $user->id);
                Session::set("success", "Password updated");
    
                Url::redirect("/admin");
    
            }
    
        }
        $title = "Change Password";

        $this->view->render("admin/auth/change_password", compact("title", "token", "errors"));
    }
}