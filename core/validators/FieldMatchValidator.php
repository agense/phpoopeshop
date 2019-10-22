<?php
// EVERY VALIDATOR CLASS MUST EXTEND CUSTOM VALIDATOR CLASS AND IMPLEMENT runValidation METHOD

// VALIDATES IF THE VALUES OF TWO FIELDS MATCH
// Returns boolean true if validation passes, false otherwise

/*USAGE EXAMPLE:
  $this->runValidation(
     new FieldMatchValidator($this, ['field'=>'field1', 'rule'=>'field2', 'msg' => 'Fields do not match.']
  ));
*/

class FieldMatchValidator extends CustomValidator{
  public function runValidation(){
  	$value = $this->_model->{$this->field};
    return $value == $this->rule;
  }
}