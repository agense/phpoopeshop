<?php 
// EVERY VALIDATOR CLASS MUST EXTEND CUSTOM VALIDATOR CLASS AND IMPLEMENT runValidation METHOD

// VALIDATES IF THE VALUE OF SPECIFIC FIELD EXISTS AS A KEY IN A PASSED ASSOCIATIVE ARRAY OR A VALUE IN A PASSED NUMERIC ARRAY 
// Returns boolean true if validation passes, false otherwise

/* Usage Example:
 	$this->runValidation( new ExistanceValidator(
	 	$this, ['field'=>'fieldname', 'rule'=> [$key => $value], 'msg' => 'Field value is incorrect.']
	));
*/

 class ExistanceValidator extends CustomValidator{
  public function runValidation(){
	$value = $this->_model->{$this->field};
	if(!is_array($this->rule)) return false;
	if(!is_array($value)){
		$pass = array_key_exists($value, $this->rule);
	}else{
        foreach($value as $item){
           if(array_key_exists($item, $this->rule) || in_array($item, $this->rule)){
            	$pass = true;
		   }else{
			   $pass = false;
			   break;
		   }
		}
	} 
  	return $pass;
  }
}