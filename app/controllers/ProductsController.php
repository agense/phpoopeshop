<?php
class ProductsController extends Controller {
	public function __construct($controller, $action){
		parent:: __construct($controller, $action);
		$this->view->setLayout('default');
		$this->load_model('Products');
    $this->load_model('ProductImages');
		$this->load_model('Categories');
	}

  // REDIRECT TO CATEGORIES DISPLAY ROUTE
	public function indexAction(){
     Router::redirect('categories/index');
	}

  // SHOW PRODUCTS PAGE WITH FILTERS AND SORTING OPTIONS
  public function showAction($topCat, $subCat = NULL){
    if(!$topCat){
      Router::redirect('categories/index');
    }
    // Get top category
    $topCategory = $this->CategoriesModel->getBySlug($topCat);
    if(!$topCategory || $topCategory->parent_category_id != 0){
      Router::redirect('notFound/index');
    }
    $sales = false;

    // Get subcategory if exists
    if($subCat && $subCat == 'sales'){
      $salesProducts = $this->ProductsModel->findSaleProducts($topCategory->id);
      $sales = true;

    }elseif($subCat && $subCat != 'sales'){
      $subCategory = $this->CategoriesModel->getBySlug($subCat);

    // If top category is not found, or if subcategory var exists and subcategory is not found, redirect to notFound
    if($subCat && !isset($subCategory)){
      Router::redirect('notFound/index');
    }
   }
     // Get subcategory list for top category and add subcategory ids to top category
     $catIds = $this->CategoriesModel->getSubcatIds($topCategory->id);
     $topCategory->subcategory_ids = implode(',', $catIds);

    // Get category or subcategory products
    if(isset($subCategory) && $subCategory->parent_category_id > 0){
      // Get only subcategory products
      $products = $this->ProductsModel->findProductsByCategory($subCategory->id);
    }else{
      // Get all top category products
       $products = $this->ProductsModel->findProductsByCategory($catIds);
    }
     // Get category details        
        $this->view->topCategory = $topCategory;
        $this->view->category = (isset($subCategory)) ? $subCategory : $topCategory;
        $this->view->subCategory = (isset($subCategory)) ? $subCategory : NULL;
        $this->view->sales = $sales;
     
      // Get filter lists
        $this->view->categories = $this->CategoriesModel->getTopCategories();
        $this->view->subcategories = $this->CategoriesModel->categoryList($topCategory->id);
        $this->view->colors = $this->ProductsModel->getColorList();
        $this->view->materials = $this->ProductsModel->getMaterialList();
        $this->view->brands = $this->ProductsModel->getBrandList();
        $this->view->collections = $this->ProductsModel->getCollectionList();
        $this->view->products = isset($salesProducts) ? $salesProducts : $products;
        $this->view->render('products/category_products');      
  }

    // DISPLAY A PAGE OF NEW PRODUCTS BY SUBCATEGORY
    public function newAction($catSlug){
    	if(!$catSlug){
			   Router::redirect('products/index');
		  }
        // Get the category
    	  $category = $this->CategoriesModel->getBySlug($catSlug);
        // Get ids of all subcategories as an array
        $subcatIds = $this->CategoriesModel->getSubcatIds($category->id);
        // Get all new products in specified subcategories
	    	$newProducts = $this->ProductsModel->findNewProducts($subcatIds);
		    // Filter lists
		    $subcategoryList= $this->CategoriesModel->categoryList($category->id);
		    $colorList = $this->ProductsModel->getColorList();
    	  $materialList = $this->ProductsModel->getMaterialList();
    	  $brandList = $this->ProductsModel->getBrandList();
    	  $collectionList = $this->ProductsModel->getCollectionList();

        $this->view->category =  $category;
		    $this->view->products = $newProducts;
        $this->view->render('products/category_new'); 
	}

  // DISPLAY SINGLE PRODUCT PAGE
	public function productAction($id){
      $product = $this->ProductsModel->singleProduct($id); 
      if(!$product){
        Router::redirect('notFound/index');
      }
      // Get sources of all product images 
      $productImages = $this->ProductImagesModel->getImageSources($id);
      // Add product featured image to product image array if exists
      if($product->product_featured_image){
        array_unshift($productImages, $product->product_featured_image);
      }
      // Add product images array to product object
      $product->product_images = $productImages;

      // Get related items
      $relatedItems = $this->ProductsModel->findNewProducts();
      $this->view->product = $product;
      $this->view->relatedItems = $relatedItems;
      $this->view->render('products/product'); 
	}

  // FILTER PRODUCTS BY USER REQUEST PARAMS AND RETURN A JSON RESPONSE
  // Return a json response
  public function getFilteredProductsAction(){
     if(!$this->request->isAjax()){
        Router::redirect('notFound/index');
      }else{
        $data = json_decode($_POST['data']);
        $products = $this->ProductsModel->getFilteredProducts($data);
        // Modify filtered product data
        foreach($products as $product){
          if(Helpers::checkNew($product->product_upload_date)){
            $product->new = "true";
          }else{
            $product->new = "false";
          }
          $product->product_featured_image = PRODUCT_IMG_FOLDER.$product->product_featured_image;
          $product->product_price = Helpers::formatPrice($product->product_price);
          if($product->product_price_discounted != null){
            $product->product_price_discounted = Helpers::formatPrice($product->product_price_discounted);
          }
        }
        return $this->jsonResponse($products);
      }
  }
  
}