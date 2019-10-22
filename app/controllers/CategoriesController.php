<?php
class CategoriesController extends Controller {
	public function __construct($controller, $action){
		parent:: __construct($controller, $action);
		$this->view->setLayout('default');
		$this->load_model('Categories');
		$this->load_model('Products');
	}

	// DISPLAY A PAGE OF TOP CATEGORIES
	public function indexAction(){
        $categories = $this->CategoriesModel->getTopCategories();
		 $i = 1;
		 foreach ($categories as $category) {
		 	$category->number = $i;
		 	$i++;
		 }
        $this->view->categories = $categories;
        $this->view->render('categories/index'); 
	}

	// SHOW A PAGE WITH SUBCATEGORIES OF A SINGLE TOP CATEGORY FOUND BY SLUG
	public function showAction($catSlug){
		if(!$catSlug){
			Router::redirect('categories/index');
		}
        $category = $this->CategoriesModel->getBySlug($catSlug);
        if(!$category){
			Router::redirect('notFound/index');
		}
        $subcategories = $this->CategoriesModel->getSubCategories($category->id);        
        $this->view->topCategory = $category;
        $this->view->subcategories = $subcategories;
        $this->view->render('categories/category'); 
        
	}
	
}
