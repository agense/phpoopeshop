<?php 
// EVERY VALIDATOR CLASS MUST EXTEND CUSTOM VALIDATOR CLASS AND IMPLEMENT runValidation METHOD

// VALIDATES IF AN EMAIL FIELD CONTAINS A VALID EMAIL
// Returns boolean true if validation passes, false otherwise

/* USAGE EXAMPLE:
 $this->runValidation(new EmailValidator($this, ['field'=>'email', 'msg' => 'Email address is invalid.']));
*/

class EmailValidator extends CustomValidator{
  public function runValidation(){
  	$email = $this->_model->{$this->field};
  	$pass = true;
  	if(!empty($email)){
  		$pass = filter_var($email, FILTER_VALIDATE_EMAIL);
  	}
  	return $pass;
  }
}