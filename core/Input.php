<?php
class Input{
// REQUEST HANDLING HELPER

	// RETURN THE REQUEST METHOD
	// returns the request method: get, post, put, etc
	public function getRequestMethod(){
		return strtoupper($_SERVER['REQUEST_METHOD']);
	}

    // CHECK IF REQUEST METHOD IS POST
	// Returns boolean true/false
	public function isPost(){
		return $this->getRequestMethod() === 'POST';
	}

	// CHECK IF REQUEST METHOD IS PUT
	// Returns boolean true/false
	public function isPut(){
		return $this->getRequestMethod() === 'PUT';
	}

	// CHECK IF REQUEST METHOD IS GET
	// Returns boolean true/false
	public function isGet(){
		return $this->getRequestMethod() === 'GET';
	}

    // CHECK IF A REQUEST IS AN AJAX REQUEST
	// Returns boolean true/false
	public function isAjax(){
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
	}

	// CHECK IF A REQUEST HAS A SPECIFIC FILE ATTACHED AND HAS NO DEFAULT PHP UPLOAD ERRORS
	// Requires a filename as argument
	// Returns boolean true/false
	public static function hasFile($filename){
		if($_FILES && $_FILES[$filename]['error'] != 4){
		return true;
		}
		return false;
	}
	
	// RETURN THE FIRST FILE FROM $_FILES ARRAY IF EXISTS
	// Requires a filename as argument
	// Returns false if file is not found
	public static function getFile($filename){
		if(self::hasFile($filename)){
			return $_FILES[$filename];
		}
        return false;
	}

	// SANITIZE FLOAT INPUTS
	public static function getFloat($string){
	return filter_var($string, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	}

	// SANITIZE REQUEST DATA
	// Accepts a specified input to be sanitized. This argument is optional.
	// Returns a sanitized single input if provided, otherwise returns a sanitized entire request array 
	public function get($input = false){
		if(!$input){
			// Sanitize and return the entire request array 
			$data = [];
			foreach($_REQUEST as $field => $value){
			$data[$field] = Helpers::sanitize($value);
			}
			return $data;
		}
		// Sanitize and return a single form input, whichever is passed as argument
		return Helpers::sanitize($_REQUEST[$input]);
	}

	// REQUEST AUTHORIZATION BASED ON CSRF TOKEN CHECK 
	// Used for protection against cross site request forgery
	// Uses the FH (form helpers) class to check the token validity
	// Returns true on successful token check, redirects to unauthorized page view otherwise
	public function csrfCheck(){
		if(!FH::checkToken($this->get('csrf_token'))) Router::redirect('restricted/unauthorized');
		return true;	
	}

}