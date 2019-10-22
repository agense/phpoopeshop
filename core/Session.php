<?php
class Session{
// THE HELPER SESSION CLASS: 
// PROVIDES METHODS TO SET, GET, DELETE STANDARD SESSIONS 
// ALLOWS TO CHECK FOR SPECIFIC SESSION EXISTANCE
// PROVIDES METHODS FOR SETTING FLASH SESSION MESSAGES

	// CHECK IF SPECIFIC SESSION EXISTS BY NAME
	// Rquires as argument the session name
	// Returns true if session exists, false otherwise
	public static function exists($name){
       return (isset($_SESSION[$name])) ? true : false;
	}

	// RETURN SESSION VALUE NAME
	// Requires as argument the session name
	public static function get($name){
       return $_SESSION[$name];
	}

	// SET A SESSION
	// Requires as argument the session name and value 
	// Returns true on successful session creation, false otherwise
	public static function set($name, $value){
       return $_SESSION[$name] = $value;
	}

	// DELETE A SESSION
	// Requires as argument the session name
	// Returns true on successful session delete, false otherwise
	public static function delete($name){
       if(self::exists($name)){
       	unset($_SESSION[$name]);
       }
	}

	// RETURN THE USER AGENT OF THE CURRENT USER
	// Helper method for setting automatic login cookies
	public static function uagent_no_version(){
		$uagent = $_SERVER['HTTP_USER_AGENT'];
		$regx = '/\/[a-zA-Z0-9.]+/';
		$userAgent = preg_replace($regx,'', $uagent);
		return $userAgent;
	}

	// SESSION FLASH MESSAGES

	// SET A FLASH MESSAGE IN A SESSION
	// Requires message type(string) and message text(string) as arguments
	// Message types are: info, success, warning and danger
	// Returns void
	public static function addMsg($type, $msg){
        $sessionName = 'alert-'.$type;
        self::set($sessionName, $msg);
	}

	// RETURN THE FLASH SESSION MESSAGE FORMATTED AS HTML
	public static function displayMsg(){
		$html = '';
		$alerts = ['alert-info', 'alert-success', 'alert-warning', 'alert-danger'];
		foreach($alerts as $alert){
			if(self::exists($alert)){
               $html .= '<div class="alert '.$alert.' alert-dismisable" role="alert">';
               $html .= '<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>';
               $html.= self::get($alert);
               $html .= '</div>';
               self::delete($alert);
			}
		}
		return $html;
	}
}