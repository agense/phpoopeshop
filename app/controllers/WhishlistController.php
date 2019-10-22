<?php
class WhishlistController extends Controller {
	public function __construct($controller, $action){
		parent:: __construct($controller, $action);
		$this->view->setLayout('default');
		$this->load_model('Whishlist');
    $this->load_model('Products');
    $this->load_model('Cart');
	}

	private function checkedLoggedIn(){
       $user = Users::currentUser();
       if(!$user){
         Router::redirect('register/login');
       }
       return $user;
    } 

  // DISPLAY LOGGED IN USERS WISHLIST PAGE
	public function indexAction(){
	  $user = $this->checkedLoggedIn();
    $whishlist = $this->WhishlistModel->getWhishlist($user->id);
    $this->view->whishlist = $whishlist;
		$this->view->render('whishlist/index');
	}

  // REMOVE ALL PRODUCTS FROM LOGGED IN USERS WISHLIST
  // Redirect back to users wishlist page
  public function clearAction(){
 	   $user = $user = $this->checkedLoggedIn();
 	   $whishlist = $this->WhishlistModel->clearWhishlist($user->id);
 	   if(!empty($whishlist->errors)){
            Session::addMsg('danger', $whishlist->errors[0]);
            Router::redirect('whishlist');
 	   }else{
            Session::addMsg('success', 'All items have been removed from your whishlist');
            Router::redirect('whishlist');
 	   }
 	}

  // ADD A PRODUCT TO LOGGED IN USERS WISHLIST
  // Return a json response
	public function addAction(){
		if(!$this->request->isAjax()){
        Router::redirect('notFound/index');
        }else{	
        $user = Users::currentUser();
        if(!$user){
          return $this->jsonResponse(["error" => "Please log in to add item to your whishlist."]);
        }
        $itemId =  intval($this->request->get('id'));
        $whishlist = $this->WhishlistModel->addItem($user->id, $itemId);
        if(!empty($whishlist->errors)){
        	return $this->jsonResponse(["error" => [$whishlist->errors]]);
        }else{
        	return $this->jsonResponse(['success' => 'Item added successfuly']);
        }
       }	
	}
    
  // REMOVE A PRODUCT FROM LOGGED IN USERS WISHLIST
  // Return a json response
  public function removeAction($itemId){
     $user = $user = $this->checkedLoggedIn();
     $itemId = intval($itemId);
 	   $whishlist = $this->WhishlistModel->removeItem($user->id, $itemId);
 	   if(!empty($whishlist->errors)){
            Session::addMsg('danger', $whishlist->errors[0]);
            Router::redirect('whishlist');
 	   }else{
            Session::addMsg('success', 'Product has been removed from your whishlist');
            Router::redirect('whishlist');
 	   }
  }  
    
  // MOVE A PRODUCT FROM LOGGED IN USERS WISHLIST TO THE CART
  // Redirect back to users wishlist page
  public function moveToCartAction($itemId){
       $user = $user = $this->checkedLoggedIn();
       $itemId = intval($itemId);
       $product = $this->ProductsModel->singleProduct($itemId, FALSE);
       if(!$product){
          Session::addMsg('danger', 'Sorry, there was an error. Product cannot be moved to cart.');
          Router::redirect('whishlist');
       }
       // Check if product is available
       if($product->product_quantity < 1){
          Session::addMsg('danger', 'Sorry, this product is currently unavailable');
          Router::redirect('whishlist');
       }
       // Check if product is already in cart
       $cartItems = Cart::getCartItemIdArray();
       $exists = Cart::checkExistance($cartItems, $itemId);
       if($exists){
          Session::addMsg('danger', 'This product is already in your cart.');
          Router::redirect('whishlist');
       }
       // Add item to cart
       if(!Cart::addItem($itemId,1)){
          Session::addMsg('danger', 'Sorry, there was an error. Product cannot be moved to cart.');
          Router::redirect('whishlist');
       }else{
        // Remove item from the whishlist
        $whishlist = $this->WhishlistModel->removeItem($user->id, $itemId);
        if(!empty($whishlist->errors)){
          Session::addMsg('danger', 'The product was added to your cart. There was an error removing it from the whishlist.');
          Router::redirect('whishlist');
        }else{
          Session::addMsg('success', 'The product was moved to cart.');
          Router::redirect('whishlist');
        }
       }
     }
  
}	