<?php

class Categories extends Model{
    protected $_softDelete = true;
    protected $dbColumns = [
        'id', 
        'category_name', 
        'category_slug', 
        'parent_category_id',
        'category_description', 
        'category_image', 
        'featured', 
        'deleted'
    ];
    public $subcategories;
    public $uploadPath = UPLOAD_PATH.'category_images';
	public $image_field = 'category_image';

	public function __construct(){
		$table = 'categories';
        parent::__construct($table);
	}

    // RETURN ALL CATEGORIES
	public function getAll(){
		return $this->find();
	}

    // RETURN TOP LEVEL CATEGORIES
    public function getTopCategories(){
        $sql = "SELECT * FROM categories WHERE parent_category_id = ?";
        return $this->find(['conditions'=>['parent_category_id = ?'], 'bind' =>['0']]);    
    }

    // RETURN ALL FEATURED CATEGORIES
    public function getFeaturedCategories(){
        $sql = "SELECT * FROM categories WHERE featured = ?";
        return $this->find(['conditions'=>['featured = ?'], 'bind' =>['1']]);    
    }
    
    // RETURN SUBCATEGORIES FOR PARENT CATEGORY BY PARENT CATEGORY ID
    // Requires a top category id as argument
    // Accepts class name as second optional argument
    // Returns an array of objects of category class
    public function getSubCategories($pId, $class = TRUE){
        $subcategories = $this->find([
        'conditions' => ['parent_category_id = ?'],
        'bind' => ["{$pId}"]
        ], $class);
        return $subcategories;  
    }

    // RETURN TOP CATEGORIES WITH APPENDED SUBCATEGORIES FOR EACH
    // Contains full data of top category and all subcategories
    // Returns an array of top categories ad category class objects with appended subcategories
    public function getFullCategories(){
        $topcats = $this->getTopCategories();
        $class = get_class($this);
        // Get subcategories(objects) of each category and attach the as subcategories property
        foreach($topcats as $topcat){
            $topcat->subcategories = self::getSubCategories($topcat->id, $class);
        }
        return $topcats;
    }

    // RETURN SINGLE CATEGORY BY SLUG
    // Requires a category slug as argument
    // Returns an object of category class
    public function getBySlug($slug){
        return $this->findFirst([
            'conditions' => ['category_slug = ?'],
            'bind' => ["{$slug}"]
        ]);
    }

    // RETURN THE IDS OF ALL SUBCATEGORIES ATTACHED TO PARENT CATEGORY
    // Requires a top category id as argument
    // Returns an array of ids of all subcategories of a top category
    public function getSubcatIds($pId){
        $sql = "SELECT id from categories WHERE parent_category_id = '{$pId}'";      
        $subcategories = $this->query($sql)->results(); 
        $subcatIds = [];
        foreach($subcategories as $subcat){
             $subcatIds[] = $subcat->id;
        }
        return $subcatIds;
    }

    // RETURN TOP CATEGORY OPTION LIST
    // Create and return a list of top categories as an option list, including category id and name.
    // Used in select elements to select parent category. 
    public function parentCategoryOptionList(){
        $sql = "SELECT id, category_name FROM categories WHERE parent_category_id = 0";
        $cats = $this->query($sql)->results();
        $options = [];
        $options["Top Category"] = 0; 
        foreach($cats as $cat){
            $options[$cat->category_name] = $cat->id;
        }
        return $options;
    }

    // RETURN AN OPTION LIST OF SUBCATEGORIES BY PARENT CATEGORY ID
    // Requires top category id as argument. Default is 0, which returns all top categories.
    // Returns an option list with category name and id or an option list with category name and slug if second argument is true
    public function categoryList($parentId, $slug = FALSE){
        $parentId = ($parentId) ? intval($parentId) : 0;
        $sql = "SELECT id, category_name, category_slug FROM categories WHERE parent_category_id = {$parentId}";
        $categories = $this->query($sql)->results();   
        $options = [];
        if($slug){
           foreach($categories as $category){
                $options["{$category->category_name}"] = "{$category->category_slug}";
           } 
        }else{
          foreach($categories as $category){
                $options["{$category->category_name}"] = "{$category->id}";
          } 
        }
        return $options;
    }

    // CHECK IF A TOP CATEGORY HAS ANY ATTACHED SUBCATEGORIES
    // Requires top category id as argument.
    // Returns true or false.
    public function hasSubcategories($catId){
        $sql = "SELECT id FROM categories WHERE parent_category_id = ?";
        $products = $this->query($sql, [$catId])->results();
        if(!empty($products)){
            return true;
        }else{
            return false;
        }
    }

    // CHECK IS A CATEGORY IS ATTACHED TO ANY PRODUCTS
    // Requires a subcategory id as argument.
    // Returns true or false.
    public function hasProducts($catId){
        $sql = "SELECT id FROM products WHERE product_category_id = ?";
        $products = $this->query($sql, [$catId])->results();
        if(!empty($products)){
            return true;
        }else{
            return false;
        }
    }

    // RETURN DELETED CATEGORIES
    // Overrides the default findDeleted method of the model to include parent category name.
    // Accepts a category id as argument.
    // Returns an array of objects of category class, with appended top category name.
    public function findDeleted($id = FALSE){
       $deleted = parent::findDeleted($id);
       if(is_array($deleted)){
        foreach($deleted as $category){
            if($category->parent_category_id == 0){
                $category->parent_category_name = "Top Category";
            }else{
                $parent = self::parentCategory($category->parent_category_id);
                $category->parent_category_name = $parent->category_name;
                }
            }
       }
       return $deleted;
    }

    // RETURN PARENT CATEGORY FOR A SUBCATEGORY
    // Requires a top category id as argument.
    // Returns an object of Category class.
    public function parentCategory($parentId){
        $sql = "SELECT * FROM categories WHERE id = ?";
        return $this->query($sql, [$parentId])->first();
    }

    // VALIDATION
    // Perform validation when creating/updating categories
     public function validator(){
        $this->runValidation(new ReqValidator($this, ['field'=>'category_name', 'msg' => 'Category name is required.']));
        $this->runValidation(new MaxValidator($this, ['field'=>'category_name', 'rule'=>100, 'msg' => 'Category name must be less than 100 characters']));
        $this->runValidation(new AlphaNumValidator($this, ['field'=>'category_name', 'msg' => 'Category name can only contain letters, numbers and spaces']));
    }


}    
