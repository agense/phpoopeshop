<?php
// EVERY VALIDATOR CLASS MUST EXTEND CUSTOM VALIDATOR CLASS AND IMPLEMENT runValidation METHOD

// VALIDATES IF A FIELD VALUE IS ONLY COMPOSED OF LETTERS, NUMBERS AND SPACES
// Returns boolean true if validation passes, false otherwise

/* EXAMPLE USAGE:
	$this->runValidation(new AlphaNumValidator(
		$this, ['field'=>'fieldname', 'msg' => 'Field value can only contain letters, numbers and spaces']
	));
 */

class AlphaNumValidator extends CustomValidator{
  public function runValidation(){
    $value = $this->_model->{$this->field};
    $pass = false;
    if(!is_string($value)) return false;
  	if(!empty($value)){
  		$pass = preg_match ("/(^[A-Za-z0-9\s]+$)+/", $value);
  	}
  	return $pass;
  }
}