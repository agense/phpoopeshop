<?php
class DashboardController extends Controller{

	public function __construct($controller, $action){
       parent::__construct($controller, $action);
       $this->view->setLayout('admin_default');
	}

  // DISPLAY ADMIN DASHBOARD
  public function indexAction(){
    $this->view->pageCount = Pages::itemCount('pages');
    $this->view->brandCount = Brands::itemCount('brands');
    $this->view->productCount = Products::itemCount('products');
    $this->view->collectionCount = Collections::itemCount('collections');
    $this->view->userCount = Users::itemCount('users');

    $this->view->orderCount = Orders::itemCount('orders');
    $this->view->completedOrderCount = Orders::getCompletedOrderCount();
    $this->view->pendingOrderCount = Orders::getPendingOrderCount();

    $this->view->salesTotal = Helpers::formatPrice(Orders::salesTotal());
    $this->view->salesTotalPaid = Helpers::formatPrice(Orders::salesTotalPaid());
    $this->view->salesTotalUnpaid = Helpers::formatPrice(Orders::salesTotalUnpaid());

    $this->view->render('admin/dashboard');
  }

}