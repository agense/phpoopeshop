<?php
class Application{
	public function __construct(){
		$this->set_reporting();
		$this->unregister_globals();
	}

	// SET ERROR REPORTING
	private function set_reporting(){
        if(DEBUG){
        	error_reporting(E_ALL);
        	ini_set('display_errors', 1);
        }else{
            error_reporting(0);
        	ini_set('display_errors', 0);	
        	ini_set('log_errors', 1);
        	ini_set('errors_log', ROOT.DS.'tmp'.DS.'logs'.DS.'errors.log');
        }
	}

	// UNREGISTER GLOBALS
	private function unregister_globals(){
       if(ini_get('register_globals')){
       	$globalsAry = ['_SESSION', '_COOKIE', '_POST', '_GET', '_REQUEST', '_SERVER', '_ENT', '_FILES'];
       	foreach ($globalsAry as $g) {
       		foreach($GLOBALS[$g] as $k => $v){
       			if($GLOBALS[$k] === $v){
       				unset($GLOBALS[$k]);
       			}
       		 }
       	  }
       }     
	}
}