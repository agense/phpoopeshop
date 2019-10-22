<?php
class Router{
// CORE ROUTER CLASS - ROUTES THE INCOMING REQUESTS, LOADS THE CONTROLLERS AND ACTIONS

	// ROUTING OF THE INCOMING REQUESTS
	public static function route($url){
		if(isset($url[0]) && $url[0] == 'admin'){
			$userType = 'admin';
			array_shift($url); 
			// Set the Controller for admin area
		    $controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]).'Controller' : ADMIN_DEFAULT_CONTROLLER .'Controller';
		}else{
		   	$userType = 'client';
           	// Set the Controller for front end area
		  	$controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]).'Controller' : DEFAULT_CONTROLLER .'Controller';
		}
		$controller_name = str_replace('Controller', '', $controller);
		array_shift($url); 

		// Set the Action
		$action = (isset($url[0]) && $url[0] != '') ? $url[0].'Action' : 'indexAction';
		$action_name = (isset($url[0]) && $url[0] != '') ? $url[0] : 'index';
		array_shift($url); 

        // User access check based on user role
        $grantAccess =  self::accessCheck($controller_name, $action_name, $userType);
        if(!$grantAccess){
        	$controller = ACCESS_RESTRICTED.'Controller';
        	$controller_name = ACCESS_RESTRICTED;
        	$action = 'indexAction';
		}
		
		// Set the Query params
		$queryParams = $url;
      
        // Instantiate the Controller class, and set the action
	    $dispatch = new $controller($controller_name, $action);

	    if(method_exists($controller, $action)){
			// Call the controllers method coresponding to the action passed, and set the query params
	    	call_user_func_array([$dispatch, $action], $queryParams);
	    }else{
	    	self::redirect('NotFound');
	    }
	}

	// REDIRECTION
	public static function redirect($location){
		if(!headers_sent()){
			header('Location: '.PROOT.$location);
			exit();
		}else{
			echo '<script type="text/javascript">';
			echo 'window.location.href="'.PROOT.$location.'";';
			echo '</script>';
			echo '<noscript>';
			echo '<meta http-equiv="refresh" content="0;url='.$location.'" />';
			echo '</noscript>';
			exit;
		}
	}

	// USER ACCESS CONTROL
	public static function accessCheck($controller_name, $action_name = 'index', $userType ='client'){
		// Check if a user is admin or client
        if($userType == "admin"){
           $accessFile =  'admin_acl';
           $sessionName = ADMIN_SESSION_NAME;
           $userClass = "Administrators";
           $userAccessMethod = "currentAdminUser";
        }else{
        	$accessFile = 'acl';
        	$sessionName = CURRENT_USER_SESSION_NAME;
        	$userClass = "Users";
        	$userAccessMethod = "currentUser";
        }
    	// Read and decode the user permissions from json file
    	if($accessFile){
			$acl_file = file_get_contents(ROOT.DS.'app'.DS.$accessFile.'.json');
			$acl = json_decode(html_entity_decode($acl_file), true);
			
			// Create the array of current user's roles
			// Each user has the role of guest initially
			$current_user_acls = ["Guest"];
			$grantAccess = false;

			// If the user is logged in, add the "LoggedIn" role to the users roles array,
			if(Session::exists($sessionName)){
				$current_user_acls[] = "LoggedIn";
				// Get the logged in users roles from the db and if any exist, add them to current user's roles array.
				// The acls() method returns the users roles from the acl table column in db
				foreach ($userClass::$userAccessMethod()->acls() as $accessLevel) {
					$current_user_acls[] = $accessLevel;
				}
			}
			/* Compare current users roles($current_user_acls array) 
			   against the json permission file to grant or deny access for specific controller and method
			*/
			foreach($current_user_acls as $level){
				// Check for current users existing permissions
				if(array_key_exists($level, $acl) && array_key_exists($controller_name, $acl[$level])){
					if(in_array($action_name, $acl[$level][$controller_name]) || in_array("*", $acl[$level][$controller_name])){
						$grantAccess = true;
						break;
					}
				}   
			}
			// Check for denied permissions
			foreach($current_user_acls as $level){
				$denied = isset($acl[$level]['denied']) ? $acl[$level]['denied'] : null;
				if(!empty($denied) && array_key_exists($controller_name, $denied) && in_array($action_name, $denied[$controller_name])){
					$grantAccess = false;
					break;
				}
			}
			return $grantAccess;
	 	}	
		return false;
    }

}