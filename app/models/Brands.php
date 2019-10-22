<?php 
class Brands Extends Model{
  	protected $dbColumns = [
		'id', 
		'brand_name', 
		'brand_image', 
		'featured'
	];
  	public $uploadPath = UPLOAD_PATH.'brand_images';
	public $image_field = 'brand_image';

	public function __construct(){
		$table = 'brands';
		parent::__construct($table);
	}

	// RETURN ALL BRANDS
	public function getAll(){
		return $this->find();
	}

	// RETURN AN OPTION LIST OF BRANDS
 	// Includes only names and ids
  	public function brandList(){
		$brands = $this->getAll();
		$options = [];
		foreach($brands as $brand){
			$options[$brand->brand_name] = $brand->id;
		}  
		return $options;
	}

	// CHECK IF A BRAND IS ATTACHED TO ANY PRODUCTS
	// Requires product id as argument
  	// Returns true or false.
	public function hasProducts($id){
		$sql = "SELECT id FROM products WHERE product_brand_id = ?";
		$products = $this->query($sql, [$id])->results();
		if(!empty($products)){
			return true;
		}else{
			return false;
		}
 	}
  
	// VALIDATOR
	// Perform validation when creating/updating brands
	public function validator(){
		$this->runValidation(new ReqValidator($this, ['field'=>'brand_name', 'msg' => 'Brand name is required.']));
		$this->runValidation(new MaxValidator($this, ['field'=>'brand_name', 'rule'=>100, 'msg' => 'Brand name must be less than 100 characters']));
		$this->runValidation(new AlphaNumValidator($this, ['field'=>'brand_name', 'msg' => 'Brand name can only contain letters, numbers and spaces']));
	}
 
}
