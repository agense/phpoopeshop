<?php
// EVERY VALIDATOR CLASS MUST EXTEND CUSTOM VALIDATOR CLASS AND IMPLEMENT runValidation METHOD

// VALIDATES IF A FIELD HAS A NUMERIC VALUE
// Returns boolean true if validation passes, false otherwise

/* EXAMPLE USAGE:
	$this->runValidation(new NumericValidator(
		$this, ['field'=>'fieldname', 'msg' => 'Field must have a numeric value']
	));
 */

class NumericValidator extends CustomValidator{
  public function runValidation(){
  	$value = $this->_model->{$this->field};
  	$pass = true;
  	if(!empty($value)){
  		$pass = is_numeric($value);
  	}
  	return $pass;
  }
}