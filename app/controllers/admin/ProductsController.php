<?php
class ProductsController extends Controller{

	public function __construct($controller, $action){
		parent::__construct($controller, $action);
    // This instantiates a new model class of whichever model class we pass and saves it in $this->modelName property. Here we will have $this->usersModel = new Users('Users'); The argument we pass must be the model name we want to load.
		$this->load_model('Products');
    $this->load_model('ProductImages');
		$this->view->setLayout('admin_default');
	}

  // SHOW ALL PRODUCTS
	public function indexAction(){ 
    $products = $this->ProductsModel->allProducts();
		$this->view->products = $products;
		$this->view->render('admin/products/products');
  }

  // ADD A PRODUCT
  public function addAction(){
    $product = new Products();
    $colorList = $this->ProductsModel->getColorList();
    $materialList = $this->ProductsModel->getMaterialList();
    $brandList = $this->ProductsModel->getBrandList();
    $topCategoryList = $this->ProductsModel->getCategoryList();
    $cat = $this->ProductsModel->getCategoryList(1);

    if($this->request->isPost()){
      $this->request->csrfCheck();
      $product->assign($this->request->get());
      $product->top_category_id = $this->request->get('parent_category_id');
      // Custom adjustments
      unset($product->product_price_discounted);
      unset($product->product_discount_type);
      unset($product->product_upload_date);
      
      $newProductId = $product->create();
        if($newProductId){
          Session::addMsg('success', 'Product Created');
          // If product was created and there are multiple images for upload, upload images
          if(!empty($_FILES['product_images']['name'][0])){
            // The method returns upload errors if found, false otherwise
            // Format the file array
            $files = Uploader::formatArray($_FILES['product_images']);
            $upload = $this->ProductImagesModel->saveFiles($newProductId, $files);
            if($upload->get_upload_errors()){
              Session::addMsg('danger', $upload->get_formatted_errors());
            }
          }
          Router::redirect('admin/products/index');
        }     
    }
    $this->view->topCategoryList = $topCategoryList;
    $this->view->colorList = $colorList;
    $this->view->materialList = $materialList;
    $this->view->brandList = $brandList;
    $this->view->displayErrors = $product->getErrorMessages();
    $this->view->render('admin/products/product_add');
  }

  // EDIT A PRODUCT
  public function editAction($id){
    $product = $this->ProductsModel->findProduct($id);
    $colorList = $this->ProductsModel->getColorList();
    $materialList = $this->ProductsModel->getMaterialList();
    $brandList = $this->ProductsModel->getBrandList();
    $topCategoryList = $this->ProductsModel->getCategoryList();
    $categoryList = $this->ProductsModel->getCategoryList($product->product_top_category_id);

    if($this->request->isPost()){
        $this->request->csrfCheck();

        $product->assign($this->request->get());
        $product->top_category_id = $this->request->get('parent_category_id');
        // Custom adjustments
        unset($product->product_quantity);
        unset($product->product_price_discounted);
        unset($product->product_discount_type);
        unset($product->product_upload_date);
        unset($product->product_featured);
        if($product->saveChanges()){
            Session::addMsg('success', 'Product Updated');
            Router::redirect('admin/products/index');
        }
    }
    $this->view->product = $product; 
    $this->view->topCategoryList = $topCategoryList;
    $this->view->categoryList = $categoryList;
    $this->view->colorList = $colorList;
    $this->view->materialList = $materialList;
    $this->view->brandList = $brandList;
    $this->view->displayErrors = $product->getErrorMessages();
    $this->view->render('admin/products/product_edit');
  }

  // UPDATE PRODUCT QUANTITIES   
  public function quantitiesAction(){
    $products = $this->ProductsModel->allProducts();
    // Handle Uploads
    if($this->request->isPost()){
        if(!$this->request->isAjax())Router::redirect('restricted/unauthorized');
        // Get post values
        $id = intval($this->request->get('id'));
        $quantity = intval($this->request->get('product_quantity'));

        $product = $this->ProductsModel->findById($id);
        if($product){
          $product->product_quantity = $quantity;
          $results = $product->updateProperties(['product_quantity']);
          if($results){
              $this->jsonResponse($quantity);
          }
        }
        $this->jsonResponse('Update Error');
    }
    $this->view->products = $products;
    $this->view->render('admin/products/product_quantities');
  }

  // SET PRODUCT DISCOUNTS
  public function pricesAction(){
    $products = $this->ProductsModel->allProducts();
    foreach($products as $product){
        $product->discount_amount = Helpers::countAmount($product->product_price, $product->product_price_discounted); 
        $product->discount_percentage = Helpers::countPercent($product->product_price, $product->discount_amount); 
    }
    $this->view->products = $products;
    $this->view->render('admin/products/product_prices');
  }

  // EDIT PRODUCT PRICES
  public function editPriceAction($id){
    $product = $this->ProductsModel->findById($id);
    $product->discount_amount = Helpers::countAmount($product->product_price, $product->product_price_discounted); 
    $product->discount_percentage = Helpers::countPercent($product->product_price, $product->discount_amount); 

    if($this->request->isPost()){
        $this->request->csrfCheck();
        $product->priceValidator();
        
        $initPrice = $this->request->get('product_price');
        $discountAmount = $this->request->get('discount_amount');
        $discountType = $this->request->get('product_discount_type');
        // Validate data
        // Manual validation of fields - before they are assigned
        if($initPrice == "" || !is_numeric($initPrice) || $initPrice < 0){
            $product->addErrorMessage('product_price', 'Product price is required and must be a positive number.');
        }
        if($discountAmount !== "" && !is_numeric($discountAmount) || $discountAmount < 0){
            $product->addErrorMessage('discount_amount', 'Discount amount must be a positive number.');
        }   
        if($product->validationPassed()){
            // Update product's base price
            $product->product_price = floatval($initPrice);

            // Update discounted price
            if($discountAmount !== ""){
              if($discountAmount === "0"){
                // Remove discount - sets discount type and discounted price db columns to NULL. Then unset them from properties so they do not affect the following query.
                if($product->removeDiscount()){
                  unset($product->product_price_discounted);
                  unset($product->product_discount_type);
                }else{
                  $product->addErrorMessage('discount_amount', 'There was a problem removing discount. Please set the  value to 0 and try again.');
                }
              }else{
                $discountedPrice = $product->getDiscountedPrice($initPrice, $discountType, $discountAmount);
                // Count discount price and set dicount price and discount type
                if($discountedPrice){
                    $product->product_discount_type = intval($discountType);
                    $product->product_price_discounted = $discountedPrice;
                }else{
                  $product->addErrorMessage('discounted_price', 'There was a problem setting new discount. Please set the  value correctly and try again.');
                }
            }
          }
          // Add second validation - after setting values
          if($product->validationPassed()){
              $product->updatePrice();
              Session::addMsg('success', 'Price Updated.');
              Router::redirect('admin/products/prices'); 
          }
        }
    }
    $this->view->product = $product;
    $this->view->dicountTypes = $this->ProductsModel->getDiscountTypes();
    $this->view->displayErrors = $product->getErrorMessages();
    $this->view->render('admin/products/product_price_edit');  
  }

  // SOFT DELETE A PRODUCT
  public function deleteAction($id){
    $product = $this->ProductsModel->findById($id);
    if($product){
      if($product->delete()){
        Session::addMsg('success', 'Product Deleted.');
      }else{
        Session::addMsg('danger', 'The product was not deleted. Please try again.');
      }
    }
    Router::redirect('admin/products/index');
  }

  // SHOW SOFT DELETED PRODUCTS
  public function deletedAction(){
      $deletedProducts = $this->ProductsModel->getDeleted();
      $this->view->products = $deletedProducts;
      $this->view->render('admin/products/products_deleted'); 
  }
  
  // RESTORE SOFT DELETED PRODUCTS
  // Return a json response
  public function restoreDeletedAction(){
      if(!$this->request->isAjax()){
        Router::redirect('restricted/unauthorized');
      }else{
        $productId = intval($this->request->get('id'));
        $product = $this->ProductsModel->findDeleted($productId);
        if($product){
          $product->deleted = 0;
          $results = $product->updateProperties(['deleted']);
          if($results){
            return $this->jsonResponse("success");
          }
        }
        return $this->jsonResponse("error");
    } 
  }

  // DELETE SOFT DELETED PRODUCTS FROM DB AND THEIR IMAGES FROM STORAGE
  public function finalDeleteAction(){
    $id = intval($this->request->get('id'));
    $product = $this->ProductsModel->findDeleted($id);
    if(!$product){
        Session::addMsg('danger', 'Sorry, product not found');   
        Router::redirect('admin/products/deleted');
    }else{
        // Delete all product images
        $productImages = $this->ProductImagesModel->findProductImages($product->id);
        foreach($productImages as $image){
           $this->ProductImagesModel->deleteImage($image->id);
        }
        if($product->finalDelete()){
          Session::addMsg('success', 'The product was deleted successfully.');
          Router::redirect('admin/products/deleted');
        }
        Session::addMsg('danger', 'The product was not deleted. Please try again.');
        Router::redirect('admin/products/deleted');
    }
  }

  // UPDATE PRODUCTS FEATURED IMAGE
  // Return a json response
  public function imageUpdateAction(){
    if(!$this->request->isAjax()){
      Router::redirect('restricted/unauthorized');
    }else{
      $productId = intval($this->request->get('id'));
      $productImages = $this->ProductImagesModel->findProductImages($productId);
      return $this->jsonResponse($productImages);
    }
  }

  // DELETE IMAGE FROM PRODUCT'S MULTIPLE IMAGES
  // Return a json response
  public function imageDeleteAction(){
    if(!$this->request->isAjax()){
        Router::redirect('restricted/unauthorized');
    }else{
        $imgId = intval($this->request->get('id'));
        $imageDelete = $this->ProductImagesModel->deleteImage($imgId);
        if($imageDelete){
          return $this->jsonResponse(['success', 'Image Deleted']);
        }else{
          return $this->jsonResponse(['error', 'Image Delete Failed']);
        }
    }
  }

  // UPLOAD PRODUCT IMAGE TO PRODUCT IMAGES ARRAY
  // Return a json response
  public function imagesUploadAction(){
    if(!$this->request->isAjax()){
        Router::redirect('restricted/unauthorized');
    }else{
        $productId = intval($this->request->get('id'));
        $files = $_FILES;
        $response = [];
        $uploadedImgs = $this->ProductImagesModel->saveFiles($productId, $files);
        if($uploadedImgs->get_upload_errors()){
          $response['errors'] = $uploadedImgs->get_formatted_errors();
        }
        if($uploadedImgs->get_uploaded_files()){
          $response['success'] = $uploadedImgs->get_uploaded_files();
        }
        $this->jsonResponse($response); 
    }
  }

  // DISPLAY PRODUCT DISCOUNTED PRICE
  // Return a json response
  public function displayDiscountedPriceAction(){
    if(!$this->request->isAjax()){
      Router::redirect('restricted/unauthorized');
    }else{
      $initPrice = floatval($this->request->get('product_price'));
      $discountType = intval($this->request->get('product_discount_type'));
      $discountAmount = floatval($this->request->get('discount_amount'));
      $discountPrice = $this->ProductsModel->getDiscountedPrice($initPrice, $discountType, $discountAmount);
      $this->jsonResponse($discountPrice);
    }
  }

  // TOGGLE FEATURED PRODUCTS
  // Return a json response
  public function updateFeaturedAction(){
    if(!$this->request->isAjax()){
      Router::redirect('restricted/unauthorized');
    }else{
      $productId = intval($this->request->get('id'));
      $product = $this->ProductsModel->findById($productId);
      if($product){
        if($product->featured == 0){
            $product->featured = 1;
        }else{
            $product->featured = 0;
        }
        $results = $product->updateProperties(['featured']);
        if($results){
          $this->jsonResponse("success");
        }
      }
      $this->jsonResponse("error"); 
    }
  }

  // SHOW PRODUCT SUBCATEGORY LIST FOR EACH CATEGORY
  // Return a json response
  public function ajaxInputAction(){
    if(!$this->request->isAjax()){
        Router::redirect('restricted/unauthorized');
    }else{
        $id = intval($this->request->get('id'));
        $subcategories = $this->ProductsModel->getCategoryList($id);
        $response = json_encode($subcategories);
        $this->jsonResponse($response);
    }
  }
}
