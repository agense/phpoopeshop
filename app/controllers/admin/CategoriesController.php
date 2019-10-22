<?php
class CategoriesController extends Controller{

	public function __construct($controller, $action){
		parent::__construct($controller, $action);
    // This instantiates a new model class of whichever model class we pass and saves it in $this->modelName property. Here we will have $this->usersModel = new Users('Users'); The argument we pass must be the model name we want to load.
    $this->load_model('Categories');
    $this->load_model('Products');
		$this->view->setLayout('admin_default');
	}

  // SHOW ALL CATEGORIES
	public function indexAction(){
		$categories= new Categories();
		$allcats = $this->CategoriesModel->getFullCategories();
		$this->view->categories = $allcats;
		$this->view->render('admin/categories/categories');
  }

  // ADD A CATEGORY
  public function addAction(){
    $category = new Categories();
    $pCatOptList = $category->parentCategoryOptionList();
    if($this->request->isPost()){
        $this->request->csrfCheck();
        $category->assign($this->request->get());
        $category->category_slug = Helpers::createSlug($this->request->get('category_name'));
          if($category->create()){
                Router::redirect('admin/categories/index');
          }     
    }
    $this->view->displayErrors = $category->getErrorMessages();
    $this->view->catparentoptions = $pCatOptList;
    $this->view->render('admin/categories/category_add');
  }
    
  // EDIT A CATEGORY
  public function editAction($id){
    $pCatOptList = $this->CategoriesModel->parentCategoryOptionList();
    $category = $this->CategoriesModel->findById($id);
      if($this->request->isPost()){
        $this->request->csrfCheck();
        $category->assign($this->request->get());
        $category->category_slug = Helpers::createSlug($this->request->get('category_name'));
        if($category->saveChanges()){
          Router::redirect('admin/categories/index');
        }
      }
      $this->view->category = $category; 
    	$this->view->catparentoptions = $pCatOptList;
      $this->view->displayErrors = $category->getErrorMessages();
    	$this->view->render('admin/categories/category_edit');
  }

  // SHOW CATEGORY DETAILS
    public function detailsAction(){
      $this->view->render('admin/categories/category_details');
  }

  // SOFT DELETE A CATEGORY
  public function deleteAction($id){
      $category = $this->CategoriesModel->findById($id);
      if($category){
        if($category->delete()){
            Session::addMsg('success', 'The category was deleted successfully.');
        }else{
            Session::addMsg('danger', 'The category was not deleted. Please try again.');
        }
      }
      Router::redirect('admin/categories/index');
  }

  // SHOW DELETED CATEGORIES
  public function deletedAction(){
    $categories = $this->CategoriesModel->findDeleted(); 
    $this->view->categories = $categories;
    $this->view->render('admin/categories/categories_deleted'); 
  }

  // RESTORE DELETED CATEGORIES
  // Return a json response
  public function restoreDeletedAction(){
    if(!$this->request->isAjax()){
        Router::redirect('restricted/unauthorized');
    }else{
       $catId = intval($this->request->get('id'));
       $category = $this->CategoriesModel->findDeleted($catId);
       if($category){
        $category->deleted = 0;
        $results = $category->updateProperties(['deleted']);
          if($results){
              return $this->jsonResponse("success");
         }
      }
      return $this->jsonResponse("error");
    } 
  }

 // TOGGLE FEATURED CATEGORIES
 // Return a json response
  public function updateFeaturedAction(){
    if(!$this->request->isAjax()){
        Router::redirect('restricted/unauthorized');
    }else{
      $catId = intval($this->request->get('id'));
      $category = $this->CategoriesModel->findById($catId);
      if($category){
        if($category->featured == 0){
          $category->featured = 1;
        }else{
          $category->featured = 0;
        }
        $results = $category->updateProperties(['featured']);
          if($results){
              $this->jsonResponse("success");
          }
      }
      $this->jsonResponse("error"); 
    }
  }

  // DELETE SOFT DELETED CATEGORIES FROM DB
  public function finalDeleteAction(){
      $categoryId = intval($this->request->get('id'));
      $category = $this->CategoriesModel->findDeleted($categoryId);
      if(!$category){
        Session::addMsg('danger', 'Sorry, this category was not found');   
        Router::redirect('admin/categories/deleted');
      }
      // Check the category being deleted is a top category of a subcategory.
      if($category->parent_category_id !== 0){
         // This is a subcategory
         // Check if category has any products
          if($this->CategoriesModel->hasProducts($categoryId)){
             Session::addMsg('danger', 'This category cannot be deleted because it has products attached! Please remove all products from the category before attempting to delete it.');   
             Router::redirect('admin/categories/deleted');
          }else{
            if($category->finalDelete()){
              Session::addMsg('success', 'The category was deleted successfully.');
              Router::redirect('admin/categories/deleted');
            }else{
              Session::addMsg('danger', 'The category was not deleted. Please try again.');
              Router::redirect('admin/categories/deleted');
            }
          }
      }else{
          // This is a top category - it cannot have products, but if can have subcategories
          // Check if any subcategories exist, if they do, user has to delete them first.
            if($this->CategoriesModel->hasSubcategories($categoryId)){
                Session::addMsg('danger', 'This category cannot be deleted because it has subcategories! Please remove all subcategories from the category before attempting to delete it.');   
                Router::redirect('admin/categories/deleted');
            }else{
                if($category->finalDelete()){
                  Session::addMsg('success', 'The category was deleted successfully.');
                  Router::redirect('admin/categories/deleted');
                }else{
                  Session::addMsg('danger', 'The category was not deleted. Please try again.');
                  Router::redirect('admin/categories/deleted');
                }
            }
      }
    }

}