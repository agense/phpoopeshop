<?php
class OrderController extends Controller {
	public function __construct($controller, $action){
		parent:: __construct($controller, $action);
		$this->view->setLayout('default');
    $this->load_model('Orders');
		$this->load_model('Products');
	}

  // SHOW ORDERING PAGE AND CREATE A NEW ORDER
  // On successful order creation, redirect to order confirmation page
  public function indexAction(){
       if(!Session::exists('cart')){
       	Router::redirect('cart/index');
       }	
       if(!Session::exists(CURRENT_USER_SESSION_NAME)){
          Router::redirect('register/login');  
       }
       $order = new Orders();
       // Get customer data
       $customer = Users::currentUser();
       $customerName = $customer->fname.' '.$customer->lname;

       // Get cart data
       $cart = Cart::getCart();
       $cartProducts = $this->ProductsModel->getCartProductData($cart, TRUE);
       $cartTotals = Cart::countCartTotals($cartProducts, TRUE);

        // Handle order form
        if($this->request->isPost()){
           $this->request->csrfCheck();
           $order->assign($this->request->get());
           $order->validator();
           if($order->validationPassed()){
               // Assign values
               $order->order_nr = $order->getOrderNumber();
               $order->customer_id = $customer->id;
               $order->customer_billing_details = $order->setCustomerDetails();
               $order->order_details = $order->setOrderDetails($cartProducts);
               $order->order_payment_amount = $order->getTotalAmount($cartProducts)['total'];
               $order->order_tax = $order->getTotalAmount($cartProducts)['tax'];
               $order->order_status = 1;
               $order->order_payment_status = 0;
               unset($order->order_payment_method);
               unset($order->order_payment_date);
               unset($order->order_create_date);
               // Create order
               if($order->createOrder()){
                  // Update sold product quantity
                  foreach($cartProducts as $product){
                  $product->updateQuantityOnSale();
                  }
               }
               // Clear the cart
               Cart::clearCart();
               // Redirect to thank you page
               Session::set('order_confirmed', 'true');
               Router::redirect('order/orderConfirmed/'.$order->order_nr);
           }
        }
       $this->view->cartProducts = $cartProducts;
       $this->view->customerName = $customerName;
       $this->view->cartTotals = $cartTotals;
       $this->view->displayErrors = $order->getErrorMessages();
       $this->view->render('orders/order'); 
  } 

  // SHOW ORDER CONFIRMATION PAGE
  public function orderConfirmedAction($orderNr = 1){
      if(!Session::exists('order_confirmed') || !$orderNr){
        Router::redirect('home/index');
      }else{
        Session::delete('order_confirmed');
      }
      $this->view->orderNr = $orderNr;
      $this->view->render('orders/order_confirmed');
  }

}	
