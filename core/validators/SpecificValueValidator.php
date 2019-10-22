<?php 
// EVERY VALIDATOR CLASS MUST EXTEND CUSTOM VALIDATOR CLASS AND IMPLEMENT runValidation METHOD

// VALIDATES IF A FIELD HAS A SPECIFIC VALUE DEFINED IN RULE.
/* This is a conditional validator used with related form fields, where one fields value is dependent on another
 fields value, i.e. if for one field to be allowed to have some value, some other field must have 
 a specific predefined value.

USAGE EXAMPLE: 
	$this->runValidation(new SpecificValueValidator(
		$this, ['field'=>'fieldname', 'rule'=> "paid",  'msg' => 'The value of the field must be "paid"'];
	)); 
*/
// Returns boolean true if validation passes, false otherwise
class SpecificValueValidator extends CustomValidator{
  public function runValidation(){
  	$value = $this->_model->{$this->field};
  	$pass = ($value == $this->rule);
  	return $pass;
  }
}