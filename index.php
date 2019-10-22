<?php
// DEFINE MAIN CONSTANTS
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

// LOAD CONFIGURATION AND HELPER FUNCTIONS
require_once(ROOT.DS.'config'.DS.'config.php');
require_once(ROOT.DS.'config'.DS.'db_config.php');
require_once(ROOT.DS.'config'.DS.'display_config.php');

// SET THE PATH FOR THE ROUTER
$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];

// AUTOLOAD CLASSES
function autoload($className){	
 if(file_exists(ROOT.DS.'core'.DS.$className.'.php')){
   require_once(ROOT.DS.'core'.DS.$className.'.php');

 }elseif(file_exists(ROOT.DS.'app'.DS.'models'.DS.$className.'.php')){
   require_once(ROOT.DS.'app'.DS.'models'.DS.$className.'.php');

 }elseif(file_exists(ROOT.DS.'app'.DS.'custom_validators'.DS.$className.'.php')){
   require_once(ROOT.DS.'app'.DS.'custom_validators'.DS.$className.'.php');

 }elseif(file_exists(ROOT.DS.'core'.DS.'validators'.DS.$className.'.php')){
   require_once(ROOT.DS.'core'.DS.'validators'.DS.$className.'.php');
 }
}

function autoload_frontend_controllers($className){
   if(file_exists(ROOT.DS.'app'.DS.'controllers'.DS.$className.'.php')){
   require_once(ROOT.DS.'app'.DS.'controllers'.DS.$className.'.php');
 }
}

function autoload_admin_controllers($className){	
   if(file_exists(ROOT.DS.'app'.DS.'controllers'.DS.'admin'.DS.$className.'.php')){
   require_once(ROOT.DS.'app'.DS.'controllers'.DS.'admin'.DS.$className.'.php');
 }
}

if(isset($url[0]) && $url[0] == 'admin'){
	  spl_autoload_register('autoload_admin_controllers');
}else{
    spl_autoload_register('autoload_frontend_controllers');
}
spl_autoload_register('autoload');


// START THE SESSION
// Needs to be after spl_autoload_register.
session_start();


// LOGIN THE USER FROM COOKIE
if(!Session::exists(CURRENT_USER_SESSION_NAME) && Cookie::exists(REMEMBER_ME_COOKIE_NAME)){
	Users::cookieLogin();
}

// ROUTE THE REQUESTS
Router::route($url);

