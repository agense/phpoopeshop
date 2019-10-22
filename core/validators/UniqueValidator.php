<?php
// EVERY VALIDATOR CLASS MUST EXTEND CUSTOM VALIDATOR CLASS AND IMPLEMENT runValidation METHOD

// VALIDATES IF A SPECIFIC FIELDS VALUE IS UNIQUE IN THE DB TABLE IN WHICH THAT RECORD IS BEING INSERTED
// !!! Unique Validator ignores the same field value for the record being updated, preventing the error on update.
// Returns boolean true if validation passes, false otherwise

/* EXAMPLE USAGE:
$this->runValidation(new UniqueValidator(
	$this, ['field'=>'fieldname', 'msg' => 'This fieldname already exists.']
));
*/
class UniqueValidator extends CustomValidator{
	public function runValidation(){
		$field = (is_array($this->field))? $this->field[0] : $this->field;
		$value = $this->_model->{$field};

		$conditions = ["{$field} = ?"];
		$bind = [$value];

		// Check if we are updating or adding a record
		if(!empty($this->_model->id)){
			$conditions[] = "id != ?";
			$bind[] = $this->_model->id;
		}
		// Allows to check multiple fields for unique
		if(is_array($this->field)){
			array_unshift($this->field);
			foreach($this->field as $addon){
              $conditions[] = "{$addon} = ?";
              $bind[] = $this->_model->{$addon};
			}
		}

		$queryParams = ['conditions' => $conditions, 'bind' => $bind];
		$other = $this->_model->findFirst($queryParams);
		return (!$other);
	}
}