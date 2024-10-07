<?php

namespace App\Controllers;
use System\BaseController;
use App\Helpers\Session;
use App\Helpers\Url;
use App\Models\LastIssuedNo as LastIssuedNo_Model;


class LastissuedNo extends BaseController{

    protected $lastIssuedNo;

    public function __construct(){
        parent::__construct();

        // if (! Session::get('logged_in')) {
        //     Url::redirect('/admin/login');
        // }

        $this->lastIssuedNo = new LastIssuedNo_Model();
    }

    //view function
    public function generateOrderNumber(){
        $year = date("Y");

        $data = $this->lastIssuedNo->getOrderNo($year);
        

        //generate first order transaction
        if(!$data){
            $yearIssued = date('Y');
            $orderNo = 1;
 
            $data = ['OrderNo'=> $orderNo, 'YearIssued'=>$yearIssued];
           
            // $this->lastIssuedNo->insert($data);

            $date = date('Y-m-d');
            $newStr = "";
            for($i=0; $i < strlen($date); $i++){
                if($date[$i] != '-'){
                    $newStr = $newStr . $date[$i];
                }
            }
            $issuedNo = $newStr."".$orderNo;
            // Session::set('issuedNo', $issuedNo);


            return $issuedNo;
        }

        //generate subsequent order transaction
        $id = $data->id;
        $yearIssued = $data->YearIssued;
        $orderNo = $data->OrderNo;

        $newOrderNo = $orderNo + 1;

        $data = ['OrderNo'=> $newOrderNo];
        $where = ['YearIssued'=>$yearIssued];

        // $this->lastIssuedNo->update($data, $where);

        $date = date('Y-m-d');
        $newStr = "";
        for($i=0; $i < strlen($date); $i++){
            if($date[$i] != '-'){
                $newStr = $newStr . $date[$i];
            }
        }
        $issuedNo = $newStr."".$newOrderNo;
        // Session::set('issuedNo', $issuedNo);
        return $issuedNo;
       
    }

    
}