<?php 
// CORE VALIDATOR CLASS, USED AS A BLUEPRINT FOR CREATING CUSTOM VALIDATOR CLASSES
// EVERY VALIDATOR CLASS MUST EXTEND THIS CLASS 
// THE CLASS HAS ONE ABSTRACT METHOD runValidation, WHICH MUST BE DEFINED IN EACH EXTENDING VALIDATOR CLASS AND DEFINE THE VALIDATION LOGIC

// THE CONSTRUCT METHOD OF THE CLASS HAS THE FOLLOWING CONSTRAINTS:
  // Accepts as arguments the model class name and an array of validation params. 
  /* 
   The params array must have at least 2 keys: 'field', containing the name of the field being validated, and
  'msg', containing the custom error message(string). Example: ['field' => 'fieldname', 'msg'=> 'Custom Message'].
   The params array can have an optional 'rule' key, if specifc rule for field validation is required. 
   Example: ['field' => 'fieldname', 'rule' => 'ruleValue', 'msg'=> 'Custom Message']
   Validation call example:
    new CustomValidator($this, ['field'=>'username', 'rule'=>6, 'msg' => 'Username must be at least 6 characters']);
  */

abstract class CustomValidator{
	public $success = true, $msg, $field, $rule;
	protected $_model;

	public function __construct($model, $params){
		$this->_model = $model;
		
		// Check for the "field" key in $params array
		if(!array_key_exists('field', $params)){
			throw new Exception("You must add a 'field' key to the params array.");
		}else{
			$this->field = (is_array($params['field'])) ? $params['field'][0] : $params['field'] ;
		}
		// Check if the value of the field property exists as property in the class that we pass as model, i.e. if it exists on the object being validated
		if(!property_exists($model, $this->field)){
			throw new Exception("The field " .$this->field." must exist in the model");	
		}
		
		// Check for the "msg" key in $params array 
		if(!array_key_exists('msg', $params)){
			throw new Exception("The field 'msg' must exist in the params array.");;	
		}else{
			$this->msg = $params['msg'];
		}

		if(array_key_exists('rule', $params)){
		$this->rule = $params['rule'];
		}

		try{
			/* Set the success property to either true or false, based on the return value of therunValidation method in 
			extending validator class. If the child validation class runValidation method returns true, set this class
			success property to true. That property's value will be checked later when the validator class is called on the 
			validated objects.
			*/
			$this->success = $this->runValidation();
		}catch(Exception $e){
			echo "Validation exception triggered on ".get_class().": ".$e->getMessage()."<br />";
		}
	}	
	
	// This method will be defined in each class extending this one.
	abstract public function runValidation();

}

