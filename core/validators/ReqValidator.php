<?php 
// EVERY VALIDATOR CLASS MUST EXTEND CUSTOM VALIDATOR CLASS AND IMPLEMENT runValidation METHOD

// VALIDATES IF A REQUIRED FIELD IS NOT EMPTY
// Returns boolean true if validation passes, false otherwise

/* EXAMPLE USAGE:
	$this->runValidation(new ReqValidator($this, ['field'=>'fieldname', 'msg' => 'Fieldname is required.']));
*/

class ReqValidator extends CustomValidator{ 
	public function runValidation(){
		$value = $this->_model->{$this->field};
		$passes = (!empty($value));
		return $passes;
	}
}