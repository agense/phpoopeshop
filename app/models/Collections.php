<?php 
class Collections Extends Model{
    protected $_softDelete = true;
    protected $dbColumns = [
        'id',
        'collection_name', 
        'collection_slug', 
        'collection_description',
        'collection_image', 
        'collection_items', 
        'deleted'
    ];
    public $uploadPath = UPLOAD_PATH.'collection_images';
	public $image_field = 'collection_image';

	public function __construct(){
		$table = 'collections';
		parent::__construct($table);
	}

    // RETURN ALL COLLECTIONS
    public function getAll(){
		$collections = $this->find();
		foreach($collections as $collection){	
		   if($collection->collection_items !== ""){
              $collection->collection_items = explode(',', $collection->collection_items);
		   }else{
              $collection->collection_items = [];
		   }	
		}
		return $collections;
	}

    // RETURN PRODUCT OPTION LIST 
    // Used for adding products to collections by a checkbox selection
    // Returns an array of objects of Product class.
	public function getProductList(){
		$products = new Products();
		return $products->productList();
	}

    // RETURN AN OPTION LIST OF COLLECTIONS
    // Includes only collection names and ids
    public function collectionList(){
    $collections = $this->getAll();
    $options = [];
       foreach($collections as $collection){
          $options[$collection->collection_name] = $collection->id;
       }  
    return $options;
    }

    // RETURN COLLECTION BY ITS SLUG
    // Requires collection slug as argument
    // Returns an object of Collection class
    public function getBySlug($slug){
       return $this->findFirst([
            'conditions' => ['collection_slug = ?'],
            'bind' => ["{$slug}"]
        ]);
    }

    // VALIDATOR
    // Perform validation when creating/updating collections
	public function validator(){
        $this->runValidation(new ReqValidator($this, ['field'=>'collection_name', 'msg' => 'Collection name is required.']));
        $this->runValidation(new MaxValidator($this, ['field'=>'collection_name', 'rule'=>100, 'msg' => 'Collection name must be less than 100 characters']));
        $this->runValidation(new AlphaNumValidator($this, ['field'=>'collection_name', 'msg' => 'Collection name can only contain letters, numbers and spaces']));
    }  
}	