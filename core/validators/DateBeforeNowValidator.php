<?php
// EVERY VALIDATOR CLASS MUST EXTEND CUSTOM VALIDATOR CLASS AND IMPLEMENT runValidation METHOD

// VALIDATES IF A DATE FIELDS VALUE IS NOT GREATER THAN CURRENT TIMESTAMP
// Returns boolean true if validation passes, false otherwise

/* EXAMPLE USAGE:
	$this->runValidation(new DateBeforeNowValidator(
    $this, ['field'=>'fieldname', 'msg' => 'The date cannot be in the future.']
  ));
*/
class DateBeforeNowValidator extends CustomValidator{
  public function runValidation(){
  	$value = $this->_model->{$this->field};
    $date = new DateTime($value);
    $now = new DateTime();
    $pass = $date <= $now;
  	return $pass;
  	
  }
}