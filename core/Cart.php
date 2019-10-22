<?php
class Cart{
   // SAVES AND UPDATES USERS SHOPPING CART. 
   // CART IS SAVED IN SESSION

   // ADD PRODUCT TO CART
   // Requires two arguments, product id and product quantity
   // If cart session exists, adds new product to it, otherwise creates a new instance of a cart and adds a product to it. 
   // Returns true on success and false otherwise
	public static function addItem($productId, $productQty){
        $cart = [];
        if(!Session::exists("cart")){
            $cart[] =  "{$productId}:{$productQty}";
            $cart = implode(',', $cart);
            Session::set('cart', $cart);
            return true;
        }else{
        	   // get existing cart items
         	$cartItems = explode(',', Session::get('cart'));
            // check if item already exists in cart
            if(!self::checkExistance($cartItems, $productId)){ 
        	   $newItem = "{$productId}:{$productQty}";
        	   $cartItems[] = $newItem;
               $cart = implode(',', $cartItems);
               Session::set('cart', $cart);
               return true;
            }
           return false;  
        }
	}
  
  // RETURN AN ARRAY OF IDS OF ALL PRODUCTS IN CART
  // If cart does not exist, returns empty array
  public static function getCartItemIdArray(){
        if(Session::exists('cart')){
          $idArray = [];
          $cart = explode(',', Session::get('cart'));
          foreach($cart as $item){
             $itemArray = [];
             $cItem = explode(':', $item);
             $idArray[] = $cItem[0];
          }
          return $idArray;
       }else{
        return [];
       }
  }

   // CHECK IF SPECIFIC PRODUCT EXISTS IN A CART
   // Requires two arguments: an array of ids of products in cart, and an id of the product to check against
   // Returns true if product exists, false otherwise
	public static function checkExistance($itemsArr, $newItemId){
		$exists = [];
        foreach($itemsArr as $item){
            	$singleItemArray = explode(':', $item);
            	$itemId = $singleItemArray[0];
            	if($itemId == $newItemId){
            		$exists[] = $itemId;
            	}
            }
        if(count($exists) == 0){
        	return false;
        }else{
        	return true;
        }   
	}
   
   // REMOVE PRODUCT FROM CART
   // Requires product id as argument
   // Returns true on success, false otherwise
   public static function removeItem($itemId){
      $cart = self::getCart();
      $filtered = array_filter($cart, function($arrItem) use($itemId){
         if($arrItem['product_id'] == $itemId){
               return false;
         }else{
               return true;
         }
      });
      $newCart = self::stringifyCart($filtered);
      if(!empty($newCart)){
         Session::set('cart', $newCart);
         return true;
      }else{
         Session::delete('cart');
         return true;
      }
      return false;
	}

   // UPDATE SINGLE PRODUCT QUANTITY IN CART
   // Requires two arguments: product id and qunatity to be set
   // Returns true on success, false otherwise
   public static function updateItemQuantity($itemId, $newQty){
      if(!intval($itemId) || !intval($newQty)) return false;
      $cart = self::getCart();
      $newCart = [];
      foreach($cart as $item){
         if($item['product_id'] == intval($itemId)){
            $item['product_qty'] = intval($newQty);
         }
         $newCart[] = $item;
      }
      $newCart = self::stringifyCart($newCart);
      if(Session::set('cart', $newCart)){
         return true;
      }
      return false;
   }
  
   // EMPTY THE CART
   // Removes all products from the cart.
   // Returns true on success, false otherwise
	public function clearCart(){
	   if(Session::exists('cart')){
        Session::delete('cart');
        return true;
      }
      return false;
	}

   // RETURN CART 
   // Returns an array of cart products, where key is product id and value is product quantity
   // Returns false if cart does not exist
	public static function getCart(){
      if(Session::exists('cart')){
         $cartArray = [];
         $idArray = [];
         $cart = explode(',', Session::get('cart'));
         foreach($cart as $item){
               $itemArray = [];
               $cItem = explode(':', $item);
               $itemArray['product_id'] = $cItem[0];
               $itemArray['product_qty'] = $cItem[1];
               $cartArray[] = $itemArray;	 
         }
         $fullArray['productIds'] = $idArray;
         return $cartArray;
      }
      return false;
	}

  // RETURN CART AS STRING : HELPER METHOD
  private static function stringifyCart(array $cartArray){
      $newArr = [];
        foreach($cartArray as $item){
        $newArr[] = implode(':', $item);
     }
     $cartString = implode(',', $newArr);
     return $cartString;
  }
   
   // RETURN CART ITEM COUNT
   // Return type is integer.Returns 0 if cart does not exist.
	public static function countItems(){
      if(Session::exists('cart')){
         $cartItems = explode(',', Session::get('cart'));
         return count($cartItems);
      }
      return 0;
   }

   // CART TOTALS COUNTERS

   // RETURN SUBTOTAL AMOUNT FOR SINGLE CART PRODUCT BASED ON QUANTITY
   // Requires product price and quantity as arguments
   // Returns product price multiplied by quantity as integer
   public static function countProductSubtotal($productPrice, $productQty){
      if(!intval($productQty) || !floatval($productPrice)) return false;
      $pSubtotal = floatval($productPrice) * intval($productQty);
      return $pSubtotal;
   }

   // RETURN TAX
   // Requires product price as argument
   // Uses a constant set in config file for tax rate
   // Returns tax on price as integer
   private static function countTax($price){
      return floatval($price) * TAX_RATE_PERCENTAGE / (100 + TAX_RATE_PERCENTAGE);
   }

   // RETURN CART TOTALS
   // Requires an array of product objects as argument
   // Each product object in this array must contain: product id, product_price, product_price_discounted, cart_quantity for each product 
   // Uses a constant set in config file for tax rate
   // Returns an array of cart totals: subtotal before tax, cart tax and cart total with tax
   // Accepts an optional second argument of format
   // If second argument is true, attaches currency  and money formatting to each item in totals array
   public static function countCartTotals(array $cartData, $format = FALSE){
      if(!$cartData || !is_array($cartData) || !TAX_RATE_PERCENTAGE) return false;
      $totals = [];
      $tax = 0;

      // count cart total
      $cartTotal = 0;
      foreach($cartData as $cartItem){
         $itemPrice = ($cartItem->product_price_discounted !== NULL) ? $cartItem->product_price_discounted : $cartItem->product_price;
         $itemSubtotal = floatval($itemPrice) * intval($cartItem->cart_quantity);
         $cartTotal += $itemSubtotal;

         // count taxes
         $itemTax = self::countTax($itemPrice);
         $tax += $itemTax;
      }
      $tax = round($tax, 2, PHP_ROUND_HALF_UP);

      // count total before tax
      $totalBeforeTax = $cartTotal - $tax;

      // add subtotal, tax and total to totals array 
      if($format == TRUE){
         $totals['beforeTax'] = Helpers::formatPrice($totalBeforeTax);
         $totals['tax'] = Helpers::formatPrice($tax);
         $totals['total'] = Helpers::formatPrice($cartTotal);
      }else{
         $totals['beforeTax'] = $totalBeforeTax;
         $totals['tax'] = $tax;
         $totals['total'] = $cartTotal;
      }
      return $totals;
   }
}