<?php
namespace App;
use App\Helpers\Session;

class Config{


    public static function get(){

        //turn on sessions
        Session::init();
        return [
            //set the namespace for routing
            'namespace' => 'App\Controllers\\',

            //set default controller
            'default_controller' => 'Home',

            //set default method
            'default_method' => 'index',

            //database
            'db_type'     => 'mysql',
            'db_host'     => '127.0.0.1:3307',
            'db_name'     => 'warehouse_db',
            'db_username' => 'root',
            'db_password' => '',
        ];
    }

    //PHPmailer
    public static function getMailProps(){
        return [
            'MAILHOST'=>'smtp.gmail.com',
            'USERNAME'=>'ritche2000@gmail.com',
            'PASSWORD'=>'jddn sfst joez bqrt',

            'SEND_FROM'=>'mitsuki0315@proton.me',
            'SEND_FROM_NAME'=>'Secure-Password-Manager',
            'REPLY_TO'=>'mitsuki0315@proton.me',
            'REPLY_TO_NAME'=>'Ritche'
        ];
    }
}