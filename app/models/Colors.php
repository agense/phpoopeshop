<?php 
class Colors Extends Model{
	protected $dbColumns = [
    'id', 
    'color_name'
  ];
	public function __construct(){
		$table = 'colors';
		parent::__construct($table);
	}

  // RETURN ALL COLLORS
	public function getAll(){
		return $this->find();
	}

  // RETURN AN OPTION LIST OF COLLORS
  // Includes only names and ids
  public function colorList(){
    $colors = $this->getAll();
    $options = [];
    foreach($colors as $color){
        $options[$color->color_name] = $color->id;
    }  
    return $options;
  }

  // CHECK IS A COLOR IS ATTACHED TO ANY PRODUCTS
  // Requires a color id as argument
  // Returns true or false.
	public function hasProducts($id){
		$sql = "SELECT id FROM products WHERE product_color_id = ?";
		$products = $this->query($sql, [$id])->results();
		if(!empty($products)){
			return true;
		}else{
			return false;
		}
	}

  // VALIDATOR
  // Perform validation when creating/updating collors
  public function validator(){
      $this->runValidation(new ReqValidator($this, ['field'=>'color_name', 'msg' => 'Color name is required.']));
      $this->runValidation(new MaxValidator($this, ['field'=>'color_name', 'rule'=>60, 'msg' => 'Color name must be less than 60 characters']));
      $this->runValidation(new AlphaNumValidator($this, ['field'=>'color_name', 'msg' => 'Color name can only contain letters, numbers and spaces']));
  }
  
}