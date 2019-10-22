<?php
class HomeController extends Controller {
	public function __construct($controller, $action){
		parent:: __construct($controller, $action);

		$this->view->setLayout('default');
		$this->load_model('Categories');
		$this->load_model('Collections');
		$this->load_model('Products');
	}

	// DISPLAY LANDING PAGE
	public function indexAction(){
		 $topCategories = $this->CategoriesModel->getFeaturedCategories();
		 // Number the categories
		 $i = 1;
		 foreach ($topCategories as $category) {
		 	$category->number = $i;
		 	$i++;
		 }
		 $collections = $this->CollectionsModel->getAll();
		 $newItems = $this->ProductsModel->findNewProducts();
		 $featuredItems = $this->ProductsModel->findFeatured();

		 $this->view->categories = $topCategories;
		 $this->view->newItems = $newItems;
		 $this->view->featuredItems = $featuredItems;
		 $this->view->collections = $collections;
         $this->view->render('home/index');
	}
}