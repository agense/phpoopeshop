<?php 
class Orders extends Model{ 
  protected $dbColumns = [
    'id',
    'order_nr',
    'customer_id',
    'customer_billing_details',
    'order_details', 
    'order_payment_amount', 
    'order_tax', 
    'order_status', 
    'order_payment_status', 
    'order_payment_method', 
    'order_payment_date', 
    'order_create_date'
  ];
  public $customer_name, $customer_address, $customer_city, $customer_country, $customer_postal_code;
  public $order_product_ids, $order_products;
  private $order_statuses = [
    1 => 'in process', 
    2 => 'ready', 
    3 => 'completed'
  ];
  private $order_payment_statuses = [
    0 => 'unpaid', 
    1 => 'paid'
  ];
  private $order_payment_methods = [
    1 => 'cash', 
    2 => 'card'
  ]; 

  public function __construct(){
      $table = 'orders';
      parent::__construct($table);
	}  

  // ORDER CREATION HELPER METHODS

  // RETURN ORDER STATUSES PROPERTY ON AN OBJECT
  public function getOrderStatuses(){
    return array_flip($this->order_statuses);
  }
  
  // RETURN ORDER PAYMENT STATUSES PROPERTY ON AN OBJECT
  public function getPaymentStatuses(){
    return array_flip($this->order_payment_statuses);
  }

  // RETURN ORDER PAYMENT METHODS PROPERTY ON AN OBJECT
  public function getPaymentMethods(){
    return array_flip($this->order_payment_methods);
  }

  // CREATE AND RETURN A UNIQUE NUMBER FOR AN ORDER
  public function getOrderNumber(){
    $prefix = rand();
    $orderNumber = uniqid($prefix);
    return $orderNumber;
  }
  
  // FORMAT AND RETURN CUSTOMER DETAILS FOR ORDER
  // Return type is string of comma separated values
  public function setCustomerDetails(){
    $billingDetails = '';
    $billingDetails .= $this->customer_name.',';
    $billingDetails .= $this->customer_address.',';
    $billingDetails .= $this->customer_postal_code.',';
    $billingDetails .= $this->customer_city.',';
    $billingDetails .= $this->customer_country;
    return $billingDetails;
  }

  // FORMAT AND RETURN DETAILS FOR ORDER
  // Used in order processing. Formats order details to be saved in db.
  // Requires on argument, an array of cart products.
  // Returns json encoded array of order products, each one containing an array of details.
  public function setOrderDetails(array $cartProducts){
     $cartDetails = [];
     foreach ($cartProducts as $product){
       $productPrice = ($product->product_price_discounted !== NULL) ? $product->product_price_discounted : $product->product_price;
       $singleProduct = [];
       $singleProduct['id'] = $product->id;
       $singleProduct['product_code'] = $product->product_code;
       $singleProduct['product_name'] = $product->product_name;
       $singleProduct['product_brand'] = $product->product_brand;
       $singleProduct['product_color'] = $product->product_color;
       $singleProduct['product_material'] = $product->product_material;
       $singleProduct['item_sale_price'] = $productPrice;
       $singleProduct['sale_quantity'] = $product->cart_quantity;
       $cartDetails[] = $singleProduct;
     }
     $cartDetails = json_encode($cartDetails);
     return $cartDetails;
  }
  
  // RETURN THE TAX AMOUNT ON FINAL ORDER AMOUNT
  // Requires one argument, the amount of the order. 
  // Uses the tax rate specified as constnat in the config file.
  private function countTax($finalPrice){
      return floatval($finalPrice) * TAX_RATE_PERCENTAGE / (100 + TAX_RATE_PERCENTAGE);
  }
  
  // RETURN THE FINAL ORDER AMOUNT EXCLUDING TAX
  public function orderBeforeTax(){
      return $this->order_payment_amount - $this->order_tax;
  }

  // RETURN ORDER TOTAL INCLUDING TAX
  // Rquires one argument, an array of cart products
  public function getTotalAmount(array $cartProducts){
     $cartTotals = [];
     $total = 0;
     $tax = 0;
     foreach($cartProducts as $product){
        $productPrice = ($product->product_price_discounted !== NULL) ? $product->product_price_discounted : $product->product_price;
        $productSubtotal = floatval($productPrice) * intval($product->cart_quantity);
        $total += $productSubtotal;
        // Count tax
        $productTax = self::countTax($productPrice);
        $tax += $productTax;
     }
     // Set tax
     $tax = round($tax, 2, PHP_ROUND_HALF_UP); 
     // Set cart totals array
     $cartTotals['total'] = $total;
     $cartTotals['tax'] = $tax;
     return $cartTotals;
  }

  // INSERT ORDER INTO DB
  // Return true on success, false otherwise
  public function createOrder(){
      $fields = $this->getFieldData();
      if(empty($fields)) return false;
        if($this->_db->insert($this->_table, $fields)){
           return true;
        }
      return false;  
  }

  // RETURN ALL ORDERS OF SINGLE USER
  // Requires user id as argument
  // Returns an array of objects of order class
  public function findUsersOrders($userId){
     $orders = $this->find(
        ['conditions' => ['customer_id = ?'], 'bind' => ["{$userId}"] ],
         "Orders");
        return $orders;  
  }

  // RETURN ALL ORDERS OF SINGLE USER WITH PRODUCT DATA
  // Requires user id as argument
  // Returns an array of objects of order class, with product data appended to each order
  public function getUsersOrdersWithProducts($userId){
     $orders = self::findUsersOrders($userId);
     foreach ($orders as $order) {
       $order->order_products = self::getOrderProductDetails($order->order_details);
     }
     return $orders;
  }

  // VALIDATORS
	// Perform validation when creating order
  public function validator(){
    $this->runValidation(new ReqValidator($this, ['field'=>'customer_name', 'msg' => 'Full name is required.']));
    $this->runValidation(new ReqValidator($this, ['field'=>'customer_address', 'msg' => 'Address is required.']));
    $this->runValidation(new ReqValidator($this, ['field'=>'customer_city', 'msg' => 'City is required.']));
    $this->runValidation(new ReqValidator($this, ['field'=>'customer_country', 'msg' => 'Country is required.']));
    $this->runValidation(new ReqValidator($this, ['field'=>'customer_postal_code', 'msg' => 'Postal code is required.']));
  }

  // Perform validation when processing order
  public function processValidator(){
    $this->runValidation(new ReqValidator($this, ['field'=>'order_status', 'msg' => 'Order status is required.']));
    $this->runValidation(new ExistanceValidator($this, ['field'=>'order_status', 'rule'=> $this->order_statuses, 'msg' => 'Order status is incorrect.']));
    $this->runValidation(new ExistanceValidator($this, ['field'=>'order_payment_status', 'rule'=> $this->order_payment_statuses, 'msg' => 'Order payment status is incorrect.'])); 
      // If order status is set to complete, order must be paid
      if($this->order_status == 3){
        $this->runValidation(new SpecificValueValidator($this, ['field'=>'order_payment_status', 'rule'=> "1",  'msg' => 'Order payment status must be "paid" for "order status" to be completed'])); 
        $this->runValidation(new ExistanceValidator($this, ['field'=>'order_payment_method', 'rule'=> $this->order_payment_methods, 'msg' => 'Order payment method is incorrect.'])); 
        $this->runValidation(new ReqValidator($this, ['field'=>'order_payment_date', 'msg' => 'Order payment date is required.'])); 
        $this->runValidation(new DateValidator($this, ['field'=>'order_payment_date', 'msg' => 'Order payment date is invalid.'])); 
        $this->runValidation(new DateBeforeNowValidator($this, ['field'=>'order_payment_date', 'msg' => 'Order payment date cannot be in the  future.']));
      }
  }

  // ORDER DISPLAY HEPLERS

  // RETURN FORMATTED CURRENT ORDER STATUS
  // Return type is string
  public function displayOrderStatus(){
    if(array_key_exists($this->order_status, $this->order_statuses)){
      return ucwords($this->order_statuses["{$this->order_status}"]);
    }
  }

  // RETURN FORMATTED CURRENT ORDER PAYMENT STATUS
  // Return type is string
  public function displayPaymentStatus(){
    if(array_key_exists($this->order_payment_status, $this->order_payment_statuses)){
      return ucwords($this->order_payment_statuses["{$this->order_payment_status}"]);
    }
  }

  // RETURN FORMATTED CURRENT ORDER PAYMENT METHODS
  // Return type is string
  public function displayPaymentMethod(){
    if(array_key_exists($this->order_payment_method, $this->order_payment_methods)){
      return ucwords($this->order_payment_methods["{$this->order_payment_method}"]);
    }
  }

  // RETURN FORMATTED CURRENT ORDER BILLING DETAILS
  // Return type is string
  public function displayBillingDetails(){
    $detailsArray = explode(',', $this->customer_billing_details);
    $datails = "{$detailsArray[0]} <br /> {$detailsArray[1]} <br /> {$detailsArray[2]} {$detailsArray[3]} {$detailsArray[4]}";
    return $datails;
  }
  
  // RETURN FORMATTED CURRENT ORDER PAYMENT DETAILS
  // Return type is string
  public function displayPaymentDetails(){
    $details = '';
    $details .= '<div class="payment-table">'.
      '<div>Total Amount: <span>'.Helpers::formatPrice($this->order_payment_amount).'</span></div>'.
      '<div>Payment Status: <span>'.self::displayPaymentStatus().'</span></div>';
    if($this->order_payment_status == 1){
    $details .= '<div>Payment Method: <span>'.$this->displayPaymentMethod().'</span></div>'.
      '<div>Payment Date: <span>'.Helpers::formatDate($this->order_payment_date).'</span></div>';
    }
    $details .= '</div>';
    return $details;
  }

  // RETURN FORMATTED ORDER PRODUCT DETAILS
  // Used to display product info in orders
  // Uses the formatted json as order info, which is saved in db with each order so it is still available even if the product gets deleted
  // Requires a json string holding order details as argument
  // Creates a product object for each product in json order string
  // Returns an array of product class objects with additional order data appended, such as sale quantity sale price for which the product was sold (it is saved along with the order, in case product price is changed at later time)
  public function getOrderProductDetails($order){
    $orderProducts = Helpers::decode($order);
    $productList = [];
    foreach($orderProducts as $product){
      $image = Products::productImage($product->id);
      $product->product_featured_image = $image ? $image : null;
      $product->product_subtotal = floatval($product->item_sale_price) * intval($product->sale_quantity);
      
      $orderProduct = new Products();
      $orderProduct->product_code = $product->product_code;
      $orderProduct->product_name = $product->product_name;
      $orderProduct->product_brand = $product->product_brand;
      $orderProduct->product_color = $product->product_color;
      $orderProduct->product_material = $product->product_material;
      $orderProduct->item_sale_price = $product->item_sale_price;
      $orderProduct->sale_quantity = $product->sale_quantity;
      $orderProduct->product_subtotal = $product->product_subtotal;
      $orderProduct->product_featured_image = $product->product_featured_image;
      $productList[] =  $orderProduct;
    }
    return $productList;
  }

    // ORDER COUNTS/STATISTICS

    // RETURN TOTAL ORDER COUNT
    // Accepts user id as optional argument
    // Returns total order count if argument is not passed, otherwise returns specified users order count 
    // Return type is integer
    public static function getTotalOrderCount($userId = false){
      $order = new self(); 
      if($userId){ 
      $userId = intval($userId);
      $sql = "SELECT COUNT(*) AS order_count FROM orders WHERE customer_id = {$userId}";
      }else{
      $sql = "SELECT COUNT(*) AS order_count FROM orders"; 
      }
      $orderCount =  $order->query($sql, [])->results();
      return $orderCount[0]->order_count;
  }

  // RETURN COMPLETED ORDER COUNT
  // Accepts user id as optional argument
  // Returns total order count for orders that have status of "completed" 
  // If argument is not passed returns count from all orders, otherwise returns specified users completed order count 
  // Return type is integer
  public static function getCompletedOrderCount($userId = false){
      $order = new self();  
      if($userId){ 
      $userId = intval($userId);
        $sql = "SELECT COUNT(*) AS order_count FROM orders WHERE customer_id = {$userId} AND order_status = 3";
      }else{
        $sql = "SELECT COUNT(*) AS order_count FROM orders WHERE order_status = 3";
      }
      $orderCount =  $order->query($sql, [])->results();
      return $orderCount[0]->order_count;
  }

  // RETURN PENDING ORDER COUNT
  // Accepts user id as optional argument
  // Returns total order count for orders that does not have status of "completed" 
  // If argument is not passed returns count from all orders, otherwise returns specified users pending order count 
  // Return type is integer
  public static function getPendingOrderCount($userId = false){
      $order = new self(); 
      if($userId){  
      $userId = intval($userId);
      $sql = "SELECT COUNT(*) AS order_count FROM orders WHERE customer_id = {$userId} AND order_status != 3";
      }else{
        $sql = "SELECT COUNT(*) AS order_count FROM orders WHERE order_status != 3";
      }
      $orderCount =  $order->query($sql, [])->results();
      return $orderCount[0]->order_count;
  }

  // RETURN SALES TOTAL
  // Return type is integer
  public static function salesTotal(){
    $orders = new self();  
    $sql = "SELECT SUM(order_payment_amount) AS 'sales_total' FROM orders";
    $salesTotal =  $orders->query($sql, [])->results();
    $salesTotal = round($salesTotal[0]->sales_total, 2, PHP_ROUND_HALF_EVEN);
    return $salesTotal;
  }

  // RETURN PAID SALES TOTAL
  // Return type is integer
  public static function salesTotalPaid(){
    $orders = new self();  
    $sql = "SELECT SUM(order_payment_amount) AS 'sales_total' FROM orders WHERE order_payment_status = 1";
    $salesTotal =  $orders->query($sql, [])->results();
    $salesTotal = round($salesTotal[0]->sales_total, 2, PHP_ROUND_HALF_EVEN);
    return $salesTotal;
  }

  // RETURN UNPAID SALES TOTAL
  // Return type is integer
  public static function salesTotalUnpaid(){
    $orders = new self();  
    $sql = "SELECT SUM(order_payment_amount) AS 'sales_total' FROM orders WHERE order_payment_status != 1";
    $salesTotal =  $orders->query($sql, [])->results();
    $salesTotal = round($salesTotal[0]->sales_total, 2, PHP_ROUND_HALF_EVEN);
    return $salesTotal;
  }
}