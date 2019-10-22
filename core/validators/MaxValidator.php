<?php
// EVERY VALIDATOR CLASS MUST EXTEND CUSTOM VALIDATOR CLASS AND IMPLEMENT runValidation METHOD 

// VALIDATES IF A FIELD HAS A VALUE THAT IS LESS THAN THE MAXIMUM VALUE ALLOWED
// Returns boolean true if validation passes, false otherwise

/* USAGE EXAMPLE:
	$this->runValidation(new MaxValidator(
		$this, ['field'=>'fieldname', 'rule'=>150, 'msg' => 'Fieldname must be less than 150 characters']
	));
 */

class MaxValidator extends CustomValidator{
  public function runValidation(){
  	$value = $this->_model->{$this->field};
  	$pass = (strlen($value) <= $this->rule);
  	return $pass;
  }
}