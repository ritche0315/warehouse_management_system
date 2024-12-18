<?php
    if(file_exists('../vendor/autoload.php')){
        require '../vendor/autoload.php';
    } else {
        echo "<h1>Please install via composer.json</h1>";
        echo "<p>Install Composer instructions: <a href='https://
        getcomposer.org/doc/00-intro.md#globally'>https://getcomposer.org/
        doc/00-intro.md#globally</a></p>";
        echo "<p>Once composer is installed navigate to the working 
        directory in your terminal/command prompt and enter 'composer 
        install'</p>";
    exit;
    }

    define('ENVIRONMENT', 'development');

    if (defined('ENVIRONMENT')){
        switch (ENVIRONMENT){
        case 'development':
            error_reporting(E_ALL);
            break;
        case 'production':
            error_reporting(0);
            break;
        default:
                exit('The application environment is not set correctly.');
        }
    }


    defined('DS') || define('DS', DIRECTORY_SEPARATOR);
    define('APPDIR', realpath(__DIR__.'/../app/').DS);
    define('SYSTEMDIR', realpath(__DIR__.'/../system/').DS);
    define('PUBLICDIR', realpath(__DIR__).DS);
    define('ROOTDIR', realpath(__DIR__.'/../').DS);

    //initiate config
    $config = App\Config::get();
    new System\Route($config);
?>