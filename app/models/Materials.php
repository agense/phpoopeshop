<?php 
class Materials Extends Model{
	protected $dbColumns = [
		'id', 
		'material_name'
	];
	public function __construct(){
		$table = 'materials';
		parent::__construct($table);
	}

	// RETURN ALL MATERIALS
	public function getAll(){
		return $this->find();
	}
	
 	// RETURN AN OPTION LIST OF MATERIALS
 	// Includes only names and ids
    public function materialList(){
       $materials = $this->getAll();
       $options = [];
       foreach($materials as $material){
          $options[$material->material_name] = $material->id;
       }  
    	return $options;
    }
	
	// CHECK IS A MATERIAL IS ATTACHED TO ANY PRODUCTS
	// Requires a material id as argument
 	// Returns true or false.
	public function hasProducts($id){
		$sql = "SELECT id FROM products WHERE product_material_id = ?";
		$products = $this->query($sql, [$id])->results();
		if(!empty($products)){
			return true;
		}else{
			return false;
		}
	}
	
	// VALIDATOR
	// Perform validation when creating/updating materials
    public function validator(){
		$this->runValidation(new ReqValidator($this, ['field'=>'material_name', 'msg' => 'Material name is required.']));
		$this->runValidation(new MaxValidator($this, ['field'=>'material_name', 'rule'=>60, 'msg' => 'Material name must be less than 60 characters']));
		$this->runValidation(new AlphaNumValidator($this, ['field'=>'material_name', 'msg' => 'Material name can only contain letters, numbers and spaces']));
	}
}
