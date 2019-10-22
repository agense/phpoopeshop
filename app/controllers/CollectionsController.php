<?php
class CollectionsController extends Controller {
	public function __construct($controller, $action){
		parent:: __construct($controller, $action);

		$this->view->setLayout('default');
		$this->load_model('Collections');
		$this->load_model('Products');
	}

	// DISPLAY COLLECTIONS PAGE
	public function indexAction(){
        $collections = $this->CollectionsModel->getAll();
		 // Number the collections
		 $i = 1;
		 foreach ($collections as $collection) {
		 	$collection->number = $i;
		 	$i++;
		 }
         $this->view->collections = $collections;
         $this->view->render('collections/index');
		 
	}
   
	// DISPLAY SINGLE COLLECTION PAGE WITH COLLECTION PRODUCTS
	public function showAction($collectionSlug){
		if(!$collectionSlug){
			Router::redirect('Collections/index');
		}
		$collection = $this->CollectionsModel->getBySlug($collectionSlug);
		if(!$collection){
            Router::redirect('NotFound/index');
		}
		$collectionProducts = $this->ProductsModel->findCollectionProducts($collection->collection_items); 
        $this->view->collection = $collection;
        $this->view->collectionProducts = $collectionProducts;
        $this->view->render('collections/collection_products');
	}
}	
