<?php
// EVERY VALIDATOR CLASS MUST EXTEND CUSTOM VALIDATOR CLASS AND IMPLEMENT runValidation METHOD

// VALIDATES IF A FIELD HAS A VALUE THAT IS MORE THAN THE MINIMUM VALUE ALLOWED
// Returns boolean true if validation passes, false otherwise

/* USAGE EXAMPLE:
    $this->runValidation(new MinValidator(
		$this, ['field'=>'fieldname', 'rule'=> 6, 'msg' => 'Fieldname must be at least 6 characters']
	));
*/

class MinValidator extends CustomValidator{
  public function runValidation(){
  	// Return false;
    // Allows us to pass the field's value as property to the model property
  	$value = $this->_model->{$this->field};
  	$pass = (strlen($value) >= $this->rule);
  	return $pass;
  	
  }
}