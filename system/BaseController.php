<?php

namespace System;

class BaseController{
    public $view;
    public $url;


    public function __construct(){
        //initialise the views object
        $this->view = new View();
   
        //get the current relative url
       $this->url = $this->getUrl();

       if(ENVIRONMENT == 'development') {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
      }
    }

    protected function getUrl(){
        $url = isset($_SERVER['REQUEST_URI']) ? rtrim($_SERVER['REQUEST_URI'], '/') : NULL;
        $url = filter_var($url, FILTER_SANITIZE_URL);
        return $this->url = $url;
    }
    
}