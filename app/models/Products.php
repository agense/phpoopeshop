<?php
class Products extends Model{
  protected $_softDelete = true;
  protected $dbColumns = [
    'id',
    'product_code', 
    'product_name', 
    'product_price',
    'product_price_discounted',
    'product_discount_type',
    'product_quantity', 
    'product_brand_id', 
    'product_category_id', 
    'product_material_id', 
    'product_color_id', 
    'product_featured_image', 
    'product_description',
    'featured', 
    'deleted',
    'product_upload_date'
  ];
	public $product_brand, $product_category, $product_material, $product_color, $parent_category;
  public $uploadPath = UPLOAD_PATH.'product_images';
	public $image_field = 'product_featured_image';
  private $discount_types = [1 => 'exact', 2 => 'percent'];
  public $discount_amount = NULL;
  public $discount_percentage = NULL;

	public function __construct(){
		$table = 'products';
		parent::__construct($table);
	}

  // RETURN ALL PRODUCTS
  public function getAll(){
      return $this->find();
  }

  // RETURN ALL NOT DELETED PRODUCTS (FULL DATA SET)
  public function allProducts(){
    return self::getFullData();
  }

  // RETURN FULL SINGLE/MULTIPLE PRODUCT DATA SET OF ALL PRODUCTS 
  /* A private method used by other methods of the class. 
  Fetches product data via join from multiple db tables: products, categories, materials, colors and brands.
  Includes all existing products, including the soft deleted ones.
  Returns single product as an object if product id is passed as argument. 
  Returns all products as an array of objects if product id is not passed as argument.
  */
  private function getFullData($id = FALSE, $deleted = FALSE){
        $del = ($deleted == FALSE) ? "0" : "1";
        $sql="SELECT P.*, B.brand_name AS 'product_brand', C.category_name AS 'product_category', C.category_slug AS 'product_category_slug', PC.category_slug AS 'parent_category_slug', PC.category_name AS 'parent_category', M.material_name AS 'product_material', CL.color_name AS 'product_color'
              FROM products P JOIN brands B JOIN categories C JOIN categories PC JOIN materials M JOIN colors CL 
              WHERE P.product_brand_id = B.id 
              AND P.product_category_id = C.id 
              AND P.product_material_id = M.id 
              AND P.product_color_id = CL.id
              AND C.parent_category_id = PC.id
              AND P.deleted = {$del}";
        if($id){
            $id = intval($id);
            $sql .= " AND P.id = ?";
            $results = $this->query($sql, [$id], 'Products')->results()[0];
          }else{
            $sql .= " ORDER BY product_upload_date DESC";
            $results = $this->query($sql, [], 'Products')->results();
        }
      return $results;
  }

  // RETURN SINGLE NOT DELETED PRODUCT BY ID
  // Requires product id as argument.
  // If second argument is is passed as true, returns  product data from multiple tables. 
  // Otherwise if false, returns data only from products table.
  public function singleProduct($id, $fullData = TRUE){
        if(!intval($id))return false;
        $id = intval($id);
        if($fullData == TRUE){
          return self::getFullData($id);
        }else{
          return self::findById($id);
        } 
  }

  // RETURN SINGLE/ALL SOFT DELETED PRODUCTS - FULL DATA SET
  /*  
  Fetches soft deleted product data via join from multiple db tables: products, categories, materials, colors and brands.
  Returns single product as an object if product id is passed as argument. 
  Returns all products as an array of objects if product id is not passed as argument.
  */
  public function getDeleted($id = FALSE){
      if($this->_softDelete == TRUE){
        if(intval($id)){
            $deleted = self::getFullData($id, TRUE);
        }else{
            $deleted = self::getFullData('',TRUE);
        }
        return $deleted;
      }
      return false;
  }

  // RETURN A SINGLE PRODUCT BY ID WITH ITS TOP CATEGORY
  // Requires product id as argument.
  // Does not include soft deleted products.
  // Used in products controller to update product data
  // Returns single product data as object, including products top category id.
  public function findProduct($id){
      $sql="SELECT P.*, C.parent_category_id AS 'product_top_category_id'
            FROM products P JOIN categories C 
            WHERE P.id = '{$id}'
            AND P.product_category_id = C.id
            AND P.deleted = 0";
      $product = $this->query($sql, [], 'Products')->results();
      if($product){
        return $product[0];
      }
      return false;
  }

  // RETURN PRODUCTS BELONGING TO SPECIFIED SUBCATEGORY/ SUBCATEGORIES
  // Requires subcategory id or array of ids
  // Gets product data from multiple tables: products, categories, brands
  // Returns products in a single or multiple subcategories as an array of product class objects
  public function findProductsByCategory($catid){
      $catid = Helpers::sanitize($catid);  
      if(!is_array($catid)){
          $operator = "=";
      }else{
          $operator = "IN";
          $catid = implode(',', $catid);
          $catid = "($catid)";
      }  
      $sql="SELECT P.*, B.brand_name AS 'brand_name'
            FROM products P JOIN brands B 
            WHERE P.product_category_id {$operator} {$catid}
            AND P.product_brand_id = B.id
            AND P.deleted = 0";           
      $products = $this->query($sql, [], 'Products')->results();
      return $products;
  }
    
  // RETURN MULTIPLE PRODUCTS BY THEIR IDS
  // Requires an array of product ids as argument
  // Gets product data from multiple tables: products, brands, materials, colors, i.e. all except from the category
  // Returns an array of product class objects
  public function findProductList($ids){
      if(is_array($ids)){
        $ids = implode(',', $ids);
      }
      $sql = "SELECT P.*, B.brand_name AS 'product_brand', M.material_name AS 'product_material' , CL.color_name AS 'product_color'
              FROM products P JOIN brands B JOIN materials M JOIN colors CL 
              WHERE p.id IN ({$ids})
              AND P.product_brand_id = B.id
              AND P.product_material_id = M.id 
              AND P.product_color_id = CL.id
              AND P.deleted != 1";
      $products = $this->query($sql, [], get_class($this))->results();  
      return $products;
  }

  // RETURN NEW PRODUCTS OR NEW PRODUCTS BY SUBCATEGORIES
  // Used in front end product filtering.
  // Gets the products uploaded after the specified date, which is defined as contant in the config file.
  // Default threshold date is 60 days prior to the current date
  // Accepts an optional argument: an array of ids of specific subcategories. 
  // Gets product data from multiple tables: products, categories, brands
  // Returns new products belonging to specified subcategories if second argument is passed, all new products otherwise.
  // Return type is an array of product class objects.
  public function findNewProducts($categories = FALSE){
        $tresholdDate = Helpers::getThresholdDate();
        if($categories){
            if(is_array($categories)){
            $categories =  implode(',', $categories);
            }
            $sql = "SELECT P.*, B.brand_name AS 'brand_name'
                    FROM products P JOIN brands B 
                    WHERE p.product_upload_date >= '{$tresholdDate}'
                    AND p.product_category_id IN ({$categories})
                    AND P.product_brand_id = B.id
                    AND P.deleted != 1
                    ORDER BY p.product_upload_date";
        }else{
            $sql = "SELECT P.*, B.brand_name AS 'brand_name'
                    FROM products P JOIN brands B 
                    WHERE p.product_upload_date >= '{$tresholdDate}'
                    AND P.product_brand_id = B.id
                    AND P.deleted != 1
                    ORDER BY p.product_upload_date";
        }      
        return $this->query($sql, [], get_class($this))->results();        
  }

  // RETURN PRODUCTS THAT ARE ON SALE BY SUBCATEGORY
  // Used in front end product filtering.
  // Requires subcategory id as argument.
  // Gets product data from multiple tables: products, categories, brands.
  // Does not include soft deleted products
  // Returns products on sale belonging to specified subcategory as an array of product class objects.
  public function findSaleProducts($category){
      $categoryId = intval($category);
      $sql = "SELECT P.*, B.brand_name AS 'brand_name', C.*
              FROM products P JOIN brands B JOIN categories C
              WHERE P.product_price_discounted != 'NULL'
              AND C.parent_category_id = {$categoryId}
              AND P.product_category_id = C.id
              AND P.product_brand_id = B.id
              AND P.deleted != 1";
      return $this->query($sql, [], get_class($this))->results();
   }

  // RETURN FEATURED PRODUCTS
  // Used in front end landing page to display featured product slider
  // Gets product data from products and brands tables.
  // Does not include soft deleted products
  // Returns products set as featured as an array of product class objects.
  public function findFeatured(){
      $sql = "SELECT P.*, B.brand_name AS 'brand_name'
              FROM products P JOIN brands B 
              WHERE p.featured = 1
              AND P.product_brand_id = B.id
              AND P.deleted != 1";
      return $this->query($sql, [], get_class($this))->results();   
  }

  // RETURN PRODUCTS MATCHING SPECIFIED FILTERS
  // Used in front end product filtering and sorting
  // Gets product data from multiple tables: products, categories, brands, materials, colors
  // Does not include soft deleted products
  // Requires as argument an array of filter options, each filter set as name and value pair.
  // Returns matching products as an array of objects.
  public function getFilteredProducts($filters){
      $sql="SELECT P.*, B.brand_name AS 'product_brand', C.category_name AS 'product_category', PC.category_name AS 'parent_category', M.material_name AS 'product_material', CL.color_name AS 'product_color'
            FROM products P JOIN brands B JOIN categories C JOIN categories PC JOIN materials M JOIN colors CL 
            WHERE P.product_brand_id = B.id 
            AND P.product_category_id = C.id 
            AND P.product_material_id = M.id 
            AND P.product_color_id = CL.id
            AND C.parent_category_id = PC.id
            AND P.deleted = 0";
      // Set on sale filter
      if($filters[0]->filterType == 'sale_filter'){
          if(!empty($filters[0]->filterOptions)){
             $sql .= " AND P.product_price_discounted != 'NULL'";  
          }
      }
      // Set additional search conditions
      $filterTypes = ['product_category_id', 'product_brand_id', 'product_material_id', 'product_color_id'];
      // Set filtering conditions
      $conditions = "";
        foreach($filters as $filter){
          if(isset($filter->filterType) && in_array($filter->filterType, $filterTypes) && count($filter->filterOptions) > 0){
            $filterValues = implode(',', $filter->filterOptions);
            $conditions .= " AND P.{$filter->filterType} IN ({$filterValues})";
          }
          // Check for sort type
          if(isset($filter->sortType)){
            $orderBy = $filter->sortType;
            $orderDirection = $filter->sortDirection;
          }else{
            $orderBy = "id";
            $orderDirection = "ASC";
          }
        }
      $conditions .= " ORDER BY P.{$orderBy} {$orderDirection}";
      $sql .= $conditions;
      return $this->query($sql, [], FALSE)->results();     
    }
    
  // RETURN PRODUCT FEATURED IMAGE URL
  // Requires product id as argument
  // Returns products featured image url or false if not found
  public static function productImage($id){
    if(!$id){ return false; }
    $obj = new Self();
    $sql = "SELECT product_featured_image FROM `products` WHERE id = ?";
    $product = $obj->query($sql, [intval($id)])->results();
    if($product){
      return $product[0]->product_featured_image; 
    }
    return false;
  }

  // PRICE SETTING FUNCTIONALITY

  // RETURN PRODUCT DISCOUNT TYPES
  // Returns discount types property on current object as an array.
  public function getDiscountTypes(){
    $types = array_flip($this->discount_types);
    return $types;
  }

  // RETURN CALCULATED DISCOUNTED PRICE FOR A PRODUCT
  // Requires three aguemnts: initail price, discount type and discount amount.
  // Calculates a discounted product price based on arguments.
  // Returns a discounted price as an integer
  public function getDiscountedPrice($initPrice, $discountType, $discountAmount){
      // Check if discount type has correct value
     $discountType = intval($discountType);

    if(!in_array($discountType, array_keys($this->discount_types))){
      $this->addErrorMessage('', 'Discount Type Is Incorrect');
      return false;
    }else{
      $initPrice = floatval($initPrice);
      $discountAmount = floatval($discountAmount);
      $discountedPrice = NULL;
      // Count discount price
      if($discountType == 1){
        $discountedPrice = $initPrice - $discountAmount;
      }elseif($discountType == 2){
        $discountedPrice = $initPrice - ($initPrice * ($discountAmount / 100));
      }else{
        $discountedPrice = NULL;
      }
    }
    if($discountedPrice !== NULL){
      return round($discountedPrice, 2, PHP_ROUND_HALF_UP); 
    }
    return false;
  }

  // SET PRODUCT DISCOUNT IN DB
  // Sets and updates specified columns in products table, i.e. product_discount_type and product_price_discounted
  // Returns true on success, false otherwise
  public function updatePrice(){ 
      $props = ['product_price'];
      if(isset($this->product_price_discounted) && $this->product_price_discounted != ""){
          $props[] = 'product_discount_type';
          $props[] = 'product_price_discounted';
      }
      if($this->updateProperties($props)){
        return true;
      }
      return false;    
  }

  // REMOVE PRODUCT DISCOUNT IN DB
  // Sets the product_discount_type and product_price_discounted columns in products table to null value
  // Returns true on success, false otherwise
  public function removeDiscount(){
    if($this->setNull(intval($this->id), ['product_price_discounted', 'product_discount_type'])){
      return true;
    }
    return false;
  }

  // UPDATE PRODUCT QUANTITY ON SALE
  // Calculates the value of remaining products on product sale
  // Sets the product_quantity column in products table to a new calculated value
  // Returns true on success, false otherwise
  public function updateQuantityOnSale(){
    $newQty = $this->product_quantity - $this->cart_quantity;
    if($this->update($this->id, ['product_quantity' => $newQty])){
       return true;
    }
    return false;
  }

  // VALIDATORS
  // Perform validation when creating/updating products
  public function validator(){

    // Validate Product Name
    $this->runValidation(new ReqValidator($this, ['field'=>'product_name', 'msg' => 'Product name is required.']));
    $this->runValidation(new MaxValidator($this, ['field'=>'product_name', 'rule'=>100, 'msg' => 'Product name must be less than 100 characters']));
    $this->runValidation(new AlphaNumValidator($this, ['field'=>'product_name', 'msg' => 'Product name can only contain letters, numbers and spaces']));
    
    // Validate Price
    $this->runValidation(new ReqValidator($this, ['field'=>'product_price', 'msg' => 'Price is required.']));
    $this->runValidation(new NumericValidator($this, ['field'=>'product_price', 'msg' => 'Product price must be a number.']));
   
    // Validate Product Category Id
    $this->runValidation(new ReqValidator($this, ['field'=>'product_category_id', 'msg' => 'Category is required.']));
    $catIdList = array_flip($this->getCategoryList(intval($this->top_category_id)));
    $this->runValidation( new ExistanceValidator($this, ['field'=>'product_category_id', 'rule'=> $catIdList, 'msg' => 'Category is incorrect.']));
    
    // Validate Product Brand Id
    $this->runValidation(new ReqValidator($this, ['field'=>'product_brand_id', 'msg' => 'Brand is required.']));
    $this->runValidation( new ExistanceValidator($this, ['field'=>'product_brand_id', 'rule'=> array_flip($this->getBrandList()), 'msg' => 'Brand is incorrect.']));
    
    // Validate Product Material Id
    $this->runValidation(new ReqValidator($this, ['field'=>'product_material_id', 'msg' => 'Material is required.']));
    $this->runValidation( new ExistanceValidator($this, ['field'=>'product_material_id', 'rule'=> array_flip($this->getMaterialList()), 'msg' => 'Material is incorrect.']));
    
    // Validate Product Color Id
    $this->runValidation(new ReqValidator($this, ['field'=>'product_color_id', 'msg' => 'Color is required.']));
    $this->runValidation( new ExistanceValidator($this, ['field'=>'product_color_id', 'rule'=> array_flip($this->getColorList()), 'msg' => 'Color is incorrect.']));
  }

  // Perform validation when updating product price/setting discount
  public function priceValidator(){
    $this->runValidation(new ReqValidator($this, ['field'=>'product_price', 'msg' => 'Product price is required.']));
    $this->runValidation(new NumericValidator($this, ['field'=>'product_price', 'msg' => 'Product price must be a number.']));
    $this->runValidation(new NumericValidator($this, ['field'=>'discount_amount', 'msg' => 'Discount amount must be a number.']));
  }
  
  // HELPERS PRODUCT MODEL FROM OTHER CLASSES
  
  // RETURN AN OPTION LIST OF TOP CATEGORIES
	public function getTopCategoryList(){
    $topCats = new Categories();
    return $topCats->parentCategoryOptionList();
  } 
  
  // RETURN AN OPTION LIST OF SUBCATEGORIES BY PARENT CATEGORY ID
  // Requires top category id as argument. Default is 0, which returns all top categories.
  // Includes only names and slugs 
  public function getCategoryList($id = 0){
    $categories = new Categories();
    return $categories->categoryList($id);
  }

  // RETURN AN OPTION LIST OF COLORS
  // Includes only names and ids
  public function getColorList(){
    $colors = new Colors();
    return $colors->colorList();
  }
  
  // RETURN AN OPTION LIST OF MATERIALS
  // Includes only names and ids
  public function getMaterialList(){
    $materials = new Materials();
    return $materials->materialList();
  }
  
  // RETURN AN OPTION LIST OF BRANDS
  // Includes only names and ids
  public function getBrandList(){
    $brands = new Brands();
    return $brands->brandList();
  }
  
  // RETURN AN OPTION LIST OF PRODUCT COLLECTIONS
  // Includes only collection names and ids
  public function getCollectionList(){
    $collections = new Collections();
    return $collections->collectionList();
  }
      
  // RETURN PRODUCT OPTION LIST 
  // Used as helper for collections class for adding products to collections by a checkbox selection
  public function productList(){
    $products = $this->allProducts();
    $options = [];
    $info = [];
    $product_info = [];
    foreach($products as $product){
        $options[$product->product_name] = $product->id;
        $info[$product->id] = ['Code:' => $product->product_code,'Brand:' => $product->product_brand, 'Category:' => $product->product_category];
    } 
    $product_info['options'] = $options;
    $product_info['info'] = $info;
    return $product_info;
  }

  // RETURN PRODUCTS ATTACHED TO SPECIFIED PRODUCT COLLECTION
  // Requires an array of product ids as argument
  // Gets product data from products and brands tables
  // Returns an array of product class objects, ordered by subcategory
  public function findCollectionProducts($ids){
        if(!$ids || $ids == "") return FALSE;
           if(is_array($ids)){
             $ids =  implode(',', $ids);
        }
        $sql = "SELECT P.*, B.brand_name AS 'brand_name'
                FROM products P JOIN brands B 
                WHERE p.id IN ({$ids})
                AND P.product_brand_id = B.id
                AND P.deleted != 1
                ORDER BY p.product_category_id";
        return $this->query($sql, [], get_class($this))->results();
  }

  // CART HELPER METHOD
  // Returns product data for counting totals in the cart
  // Requires one argument - an array of cart items from the session
  // Accepts an optional second argument, true or false, defining the scope of product data to return
  // Returns full product data set from multiple tables if second argument is true, else returns data from products table only 
    public function getCartProductData(array $cart, $fullData = TRUE){
       $cartProducts = [];
       foreach($cart as $item){
          $product = self::singleProduct($item['product_id'], $fullData);
          $product->cart_quantity = $item['product_qty'];
          $productPrice = ($product->product_price_discounted !== NULL) ? $product->product_price_discounted : $product->product_price;
          $product->cart_product_subtotal = Cart::countProductSubtotal($productPrice, $product->cart_quantity);
          $cartProducts[] = $product;
        }
        return $cartProducts;
    }

}
