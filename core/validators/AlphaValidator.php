<?php
// EVERY VALIDATOR CLASS MUST EXTEND CUSTOM VALIDATOR CLASS AND IMPLEMENT runValidation METHOD

// VALIDATES IF A FIELD VALUE IS ONLY COMPOSED OF LETTERS AND SPACES
// Returns boolean true if validation passes, false otherwise

/* EXAMPLE USAGE:
	$this->runValidation(new AlphaValidator(
		$this, ['field'=>'fieldname', 'msg' => 'Field value can only contain letters and spaces']
	));
 */

class AlphaValidator extends CustomValidator{
  public function runValidation(){
    $value = $this->_model->{$this->field};
    $pass = false;
    if(!is_string($value)) return false;
  	if(!empty($value)){
  		$pass = ctype_alpha(str_replace(' ', '', $value));
  	}
  	return $pass;
  }
}