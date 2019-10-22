<?php
class Whishlist Extends Model{
  protected $dbColumns = [
    'id', 
    'user_id', 
    'items', 
    'date_created'
  ];
  public $errors;
  
  public function __construct(){
      $table = 'whishlist';
      parent::__construct($table);
      $this->errors = [];
  }

  // ADD A PRODUCT TO LOGGED IN USERS WISHLIST
  // Requires logged in users id and product id as arguments
  // Returns an object of Wishlist class, attached to specified user
	public function addItem($userId, $itemId){
      $this->errors = [];
      $item = intval($itemId);
      // Find users wishlist by logged in users id or create a new one if not found
      $whishlist = $this->findFirst(['conditions'=>'user_id = ?', 'bind'=>[$userId]]);
      if(!$whishlist){
        $whishlist = new self();
        $whishlist->user_id = intval($userId);
      }
      $whishlist->items = explode(',', $whishlist->items);
      // Check if a product does not yet exist in cart
      if(!in_array($item, $whishlist->items )){
          // Add the product to the wishlist
          $whishlist->items[] = $item;
          $whishlist->items = implode(',', $whishlist->items);
          if(substr($whishlist->items, 0, 1) == ','){
              $whishlist->items = ltrim($whishlist->items, ",");
          }
          // Save a product in a wishlist or return an error
          if(!$whishlist->save()){
              $whishlist->errors[] = "There was an error. Item cannot be added tothe whishlist.";
          }
      }else{
          $whishlist->errors[] = "This item is already in your whishlist.";
      }
      return $whishlist;
	}

  // REMOVE A PRODUCT FROM USERS WISHLIST    
  // Requires logged in users id and product id as arguments
  // Returns an object of Wishlist class, attached to specified user
  public function removeItem($userId, $itemId){
      $this->errors = [];
      $item = intval($itemId);
      $whishlist = $this->findFirst(['conditions'=>'user_id = ?', 'bind'=>[$userId]]);
      $whishlist->items = explode(',', $whishlist->items);

      // Check if a product exists in users wishlist
      if(in_array($item, $whishlist->items)){
        // Remove product from the users wishlist
        $whishlist->items = array_diff( $whishlist->items, [$item] );
        // If wishlist is empty, delete if from the db, otherwise update wishlist items
        if(count($whishlist->items) < 1){
          if(!$whishlist->delete()){
            $whishlist->errors[] = "There was an error. Item cannot be removed from the whishlist.";
          }
        }else{
          $whishlist->items = implode(',', $whishlist->items);
          // Save the updated wishlist in db
          if(!$whishlist->save()){
              $whishlist->errors[] = "There was an error. Item cannot be removed from the whishlist.";
          }
        }
      }else{
          $whishlist->errors[] = "This item is not in your whishlist.";
      }
      return $whishlist;
	}

  // REMOVE ALL ITEMS FROM THE USERS WISHLIST
  // Requires logged in users id as argument
  // Returns an object of Wishlist class, attached to specified user
	public function clearWhishlist($userId){
      $this->errors = [];
      $whishlist = $this->findFirst(['conditions'=>'user_id = ?', 'bind'=>[$userId]]);
      // Delete users wishlist from the db
      if(!$whishlist->delete()){
        $whishlist->errors[] = "There was an error. Whishlist cannot be cleared.";
      }
      return $whishlist;
	}

  // RETURN THE USERS WISHLIST WITH PRODUCTS
  // Requires logged in users id as argument
  // Returns an object of Wishlist class, with products associated with specified wishlist
	public function getWhishlist($userId){
      // Find users wishlist by user id
      $whishlist = $this->findFirst(['conditions'=>'user_id = ?', 'bind'=>[$userId]]);
      // Find Whishlist products    
      if($whishlist != false && $whishlist->items !== ""){
        $items = explode(',', $whishlist->items);
        $whishlist->products = self::getWhishlistProducts($items);
      }
      return $whishlist;
	}

  // RETURN ALL PRODUCT DATA FOR PRODUCTS EXISTING IN USERS WISHLIST
  // Requires an array of product id's as argument
  // Returns an array of objects of Product class
  public function getWhishlistProducts($productIds){
      $products = new Products();
      return $products->findProductList($productIds);
  }

}