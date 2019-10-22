<?php
class UsersController extends Controller{

	public function __construct($controller, $action){
		parent::__construct($controller, $action);
    // This instantiates a new model class of whichever model class we pass and saves it in $this->modelName property. Here we will have $this->usersModel = new Users('Users'); The argument we pass must be the model name we want to load.
		$this->load_model('Users');
    $this->load_model('Orders');
		$this->view->setLayout('default');
	}

  // REDIRECT TO USERS ACCOUNT PAGE
	public function indexAction(){
      Router::redirect('users/account');
  }
  
  // DISPLAY LOGGED IN USERS ACCOUNT PAGE
  public function accountAction(){
    $user = Users::currentUser();
    if(!$user){
      Router::redirect('register/login');
    }
    $this->view->totalOrders = Orders::getTotalOrderCount($user->id);
    $this->view->completedOrders = Orders::getCompletedOrderCount($user->id);
    $this->view->inProcessOrders = Orders::getPendingOrderCount($user->id);
    $this->view->user = $user;
    $this->view->render('users/account'); 

  }

  // EDIT LOGGED IN USERS DATA
  public function editAction($id){
       $user = Users::currentUser();
       if(!$user){
          Router::redirect('register/login');
       }
       // Prevent viewing or editing other users profiles  
       if(!($user->id == $id)){
        Router::redirect('restricted/unauthorized');
       }
       // Handle form submit
        if($this->request->isPost()){
        // Prevent editing other users profiles  
        if(!($user->id == $id)){
            Router::redirect('restricted/unauthorized');
        }
        // Check the token for csrf protection
         $this->request->csrfCheck();
         // Assign data
          $user ->assign($this->request->get());
          // Unset empty fields
          unset($user->acl);
          if($this->request->get('phone') == ""){
            unset($user->phone);
          }
          if($this->request->get('address') == ""){
            unset($user->address);
          }
          if($this->request->get('city') == ""){
            unset($user->city);
          }
          if($this->request->get('region') == ""){
            unset($user->region);
          }
          if($this->request->get('postal_code') == ""){
            unset($user->postal_code);
          }
          if($this->request->get('country') == ""){
            unset($user->country);
          }
          // Handle password fields
          if($this->request->get('password') == ""){
            unset($user->password);
          }else{
            // Set confirmation field
            $user->setConfirm($this->request->get('confirm'));
          }
          // Validate Data
          $user->updateValidator();
          if($user->validationPassed()){
            // If password change is required, hash the password
            if(isset($user->password)){
              $user->hashPassword();
            }
            if($user->save()){
                Session::addMsg('success', 'You profile has been updated.');
                Router::redirect('users/account');
            }
          }
        }
       $this->view->displayErrors = $user->getErrorMessages();
       $this->view->user = $user;
       $this->view->render('users/edit'); 
  }

  // DISPLAY LOGGED IN USERS ORDERS PAGE
  public function ordersAction(){
      $user = Users::currentUser();
      if(!$user){
        Router::redirect('register/login');
      }
      $userOrders = $this->OrdersModel->getUsersOrdersWithProducts($user->id);
      $this->view->orders = $userOrders;
      $this->view->render('users/orders'); 
  }

  // DISPLAY LOGGED IN USERS SINGLE ORDER PAGE
  public function orderAction($orderId){
       $user = Users::currentUser();
       if(!$user){
          Router::redirect('register/login');
       }
       $order = $this->OrdersModel->findById($orderId);
       if(!$order || !($order->customer_id == $user->id)){
        Router::redirect('restricted/unauthorized');
       }
       $order->order_products = $this->OrdersModel->getOrderProductDetails($order->order_details);
       $this->view->order = $order;
       $this->view->billingInfo = $order->displayBillingDetails();
       $this->view->render('users/order'); 
  }
}