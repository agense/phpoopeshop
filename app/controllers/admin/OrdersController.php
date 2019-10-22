<?php
class OrdersController extends Controller {
	public function __construct($controller, $action){
		parent:: __construct($controller, $action);     
		$this->view->setLayout('admin_default');
    $this->load_model('Orders');
		$this->load_model('Products');
		$this->load_model('Users');
	}

  // SHOW ALL ORDERS
	public function indexAction(){
    $orders = $this->OrdersModel->getAll();
    foreach($orders as $order){
      $customerData = explode(',', $order->customer_billing_details);
      $order->customer_name = $customerData[0];
      $order->order_status_display = $order->displayOrderStatus();
      $order->order_payment_status_display = $order->displayPaymentStatus();
      $order->order_date = Helpers::formatDate($order->order_create_date);
    }
    $this->view->orders = $orders;
    $this->view->render('admin/orders/orders');
	}

  // SHOW SINGLE ORDER DETAILS
	public function detailsAction($id){
	  $order = $this->OrdersModel->findById($id);
	  $order->order_before_tax = $order->orderBeforeTax();
    $order->products = $order->getOrderProductDetails($order->order_details);
    $accountHolder = $this->UsersModel->findById($order->customer_id);
    $accountHolder->full_name = $accountHolder->fname .' '.$accountHolder->lname;
    $this->view->order = $order;
	  $this->view->billingInfo = $order->displayBillingDetails();
    $this->view->render('admin/orders/order_details');
	}

  // PROCESS ORDER
  public function processAction($orderId){
    $order = $this->OrdersModel->findById($orderId);
    if($this->request->isPost()){
      $this->request->csrfCheck();
      $order->assign($this->request->get());
      $order->processValidator();
      if($order->validationPassed()){
          // Unset properties that do not change               
          unset($order->order_order_nr);
          unset($order->order_customer_id);
          unset($order->order_customer_billing_details);
          unset($order->order_details);
          unset($order->order_payment_amount);
          unset($order->order_tax);
          unset($order->order_create_date);
          if($order->save()){
            Session::addMsg('success', 'Order has been updated.');
            Router::redirect('admin/orders/details/'.$order->id);
          }
      }       
    }
    $this->view->order = $order;
    $this->view->displayErrors = $order->getErrorMessages();
    $this->view->render('admin/orders/process');
  }
}	