<?php
// EVERY VALIDATOR CLASS MUST EXTEND CUSTOM VALIDATOR CLASS AND IMPLEMENT runValidation METHOD

// VALIDATES IF A DATE FIELDS VALUE IS A VALID DATE
// Returns boolean true if validation passes, false otherwise

/* EXAMPLE USAGE:
$this->runValidation(new DateValidator(
	$this, ['field'=>'fieldname', 'msg' => 'Field must be a valid date.']
)); 
*/

class DateValidator extends CustomValidator{
  public function runValidation(){
    // allows us to pass the field's value as property to the model property
  	$value = $this->_model->{$this->field};
  	$year = substr($value, 0, 4); 
  	$month = substr($value, 5, 2);  
    $day = substr($value, 8, 2);   
  	$pass = checkdate($month, $day, $year);
  	return $pass;
  	
  }
}