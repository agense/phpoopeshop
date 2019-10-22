<?php
class CartController extends Controller {
	public function __construct($controller, $action){
		parent:: __construct($controller, $action);
		$this->view->setLayout('default');
		$this->load_model('Products');
		$this->load_model('Whishlist');
	}

  // DISPLAY SHOPPING CART PAGE
	public function indexAction(){
		$cartProducts = [];
		$cartTotals = [];
		$cart = Cart::getCart();
    // Get cart product data and count totals
    if($cart){
      // If second argument to getCartProductData is true, returns full product data set from multiple tables
      $cartProducts = $this->ProductsModel->getCartProductData($cart, TRUE);
			$cartTotals = Cart::countCartTotals($cartProducts, TRUE);
    }	
		$this->view->cartTotals = $cartTotals;
		$this->view->cartProducts = $cartProducts;
    $this->view->render('cart/cart'); 
	}

  // REMOVES ALL ITEMS FROM CART
  // Redirect back to shopping cart page
  public function clearCartAction(){
    if(Cart::clearCart()){
    		Router::redirect('cart/index');
    }
  }

  // ADD PRODUCT TO THE CART
  // Return a json response
	public function addAction(){
		if(!$this->request->isAjax()){
        Router::redirect('notFound/index');
    }else{	
		 $productId =  intval($this->request->get('id'));
		 $product = $this->ProductsModel->singleProduct($productId, FALSE);

		 if(!$product){
		 	 return $this->jsonResponse(["error" => "Sorry, there was an error adding product to the cart."]);
		 }
		 // Check quantity
		 $productQty = $product->product_quantity;
		 $requestQty = intval($this->request->get('qty'));
		 if($requestQty > $productQty){
		 	return $this->jsonResponse(["error" => "Sorry, there are only {$productQty} items available"]);
		 }else{
		   // Add item to cart		
           if(Cart::addItem($product->id, $requestQty)){
           	$cartCount = Cart::countItems();
            // On success, return cart item count and product name 
            return $this->jsonResponse(['success' => ['cartCount' =>$cartCount, 'product_name' => $product->product_name ]]);
           }else{
            return $this->jsonResponse(["error" => "Product already exists in yout cart. You can update quantity in the cart."]);
           } 
		 }
		 return $this->jsonResponse($productQty);
    }	
	}
    
  // REMOVE A PRODUCT FROM THE CART
  // Return a json response
  public function removeAction(){
     if(!$this->request->isAjax()){
        Router::redirect('notFound/index');
     }else{	
		 $productId =  intval($this->request->get('id'));

     // Check if item exists in cart
     $cartItems = Cart::getCartItemIdArray();
     if(!Cart::checkExistance($cartItems, $productId)){
        return $this->jsonResponse(["error" => "Sorry, this product is not in your cart."]);
     }
     // Remove item
		 if(Cart::removeItem($productId)){
		  // Count new cart totals
		 	$cart = Cart::getCart();
		 	if($cart){
		 	    // If second argument to getCartProductData is FALSE, returns product data from products table only
		 	    $cartProducts = $this->ProductsModel->getCartProductData($cart, FALSE);
			    $totals = Cart::countCartTotals($cartProducts, TRUE);
			    return $this->jsonResponse(["success" => $totals]);
            }else{
          	    return $this->jsonResponse(["success" => ["empty" => true]]);
            }
		 }else{
            return $this->jsonResponse(["error" => "Sorry, there was an error removing item."]);
		 }
    }  
  }
    
  // UPDATE ITEM QUANTITY IN THE CART
  // Return a json response
  public function updateQuantityAction(){
        if(!$this->request->isAjax()){
           Router::redirect('notFound/index');
        }else{	
		   $productId =  intval($this->request->get('id'));
		   $newQuantity = intval($this->request->get('quantity'));

		   // Check if product exists
		   // If second argument to singleProduct is false, returns only data from products table
           $product = $this->ProductsModel->singleProduct(intval($productId), FALSE);
           if(!$product){ return $this->jsonResponse(["error" => "Sorry, there was an error."]); }

           //Check if requested product quantity is avilable
           if($product->product_quantity < intval($newQuantity) || intval($newQuantity) == 0){
           	  return $this->jsonResponse(["error" => "Product quantity is incorrect. Please select quantity between 1 and {$product->product_quantity}"]);
           }else{
           	    // Count updated product's subtotal
                $updatedProductPrice = ($product->product_price_discounted !== NULL) ? $product->product_price_discounted : $product->product_price;
			          $updatedProductSubtotal = Cart::countProductSubtotal($updatedProductPrice, intval($newQuantity));
			          $updatedProductSubtotal = Helpers::formatPrice($updatedProductSubtotal);

           	  // Update cart quantity
           	  if(Cart::updateItemQuantity($productId, $newQuantity)){
		   	         // Recount the new cart values
		   	          $cart = Cart::getCart();
		 	            if($cart){
		 	    	        // If second argument to getCartProductData is FALSE, returns product data from products table only
		 	                $cartProducts = $this->ProductsModel->getCartProductData($cart, FALSE);
			                $totals = Cart::countCartTotals($cartProducts, TRUE);
                      return $this->jsonResponse(["success" => ["totals" => $totals, "singleProductSubtotal" => $updatedProductSubtotal]]);
		 	            }else{
			               return $this->jsonResponse(["error" => "Sorry, there was an error."]);
		              }  
              } 
           }
        }
    }

    // MOVE A PRODUCT FROM CART TO LOGGED IN USERS WISHLIST
    // Return a json response
    public function moveToWhishlistAction(){
      if(!$this->request->isAjax()){
           Router::redirect('notFound/index');
      }else{
          $user = Users::currentUser();
          if(!$user){
               return $this->jsonResponse(["error" => "Please login to add items to your whishlist."]);
          }
          // Get moved item id
          $itemId =  intval($this->request->get('id'));
          // Check if item exists in cart
          $cartItems = Cart::getCartItemIdArray();
          if(!Cart::checkExistance($cartItems, $itemId)){
                 return $this->jsonResponse(["error" => "Sorry, this product is not in your cart."]);
          }
          // Add to whishlist
          $whishlist = $this->WhishlistModel->addItem($user->id, $itemId);
          if(!empty($whishlist->errors)){
          	return $this->jsonResponse(["error" => $whishlist->errors]);
          }else{
          // Remove from cart
          	if(Cart::removeItem($itemId)){
		           // Count new cart totals
		       	    $cart = Cart::getCart();
		          	if($cart){
		 	             // If second argument to getCartProductData is FALSE, returns product data from products table only
		 	             $cartProducts = $this->ProductsModel->getCartProductData($cart, FALSE);
			             $totals = Cart::countCartTotals($cartProducts, TRUE);
			             return $this->jsonResponse(["success" => $totals]);
                }else{
            	     // Return if cart is empty
          	       return $this->jsonResponse(["success" => ["empty" => true]]);
                }
		        }else{
		    	    // Return if item was not removed from the cart
		    	    return $this->jsonResponse(["error" => "Sorry, there was an error removing item from the cart."]);
		        } 
          }
      }	
    }
}	