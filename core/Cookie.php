<?php
class Cookie{
// THE HELPER COOKIE CLASS: PROVIDES METHODS TO SET, GET, DELETE COOKIES AND CHECK FOR COOKIE EXISTANCE

	// SET A COOKIE
	// Requires as arguments cookie name, cookie value and cookie expiry date in miliseconds
	// Returns true on successful cookie creation, false otherwise
	public static function set($name, $value, $expiry){
       if(setcookie($name, $value, time()+$expiry, '/')){
       	return true;
       }
       return false;
	}

	// DELETE A COOKIE
	// Requires as argument the cookie name
	// Returns true on successful cookie delete, false otherwise
	public static function delete($name){
		unset($_COOKIE[$name]);
		setcookie($name, '', time() - 3600, '/'); 
	}

	// RETURN COOKIE VALUE BY COOKIE NAME
	// Requires as argument the cookie name
	public static function get($name){
       return $_COOKIE[$name];
	}

	// CHECK IF SPECIFIC COOKIE EXISTS BY NAME
	// Requires as argument the cookie name
	// Returns true if cookie exists, false otherwise
	public static function exists($name){
		return isset($_COOKIE[$name]);
	}
}