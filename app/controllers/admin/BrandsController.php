<?php
class BrandsController extends Controller{

	public function __construct($controller, $action){
		parent::__construct($controller, $action);
    // This instantiates a new model class of whichever model class we pass and saves it in $this->modelName property. Here we will have $this->usersModel = new Users('Users'); The argument we pass must be the model name we want to load.
		$this->load_model('Brands');
		$this->view->setLayout('admin_default');
	}

  // SHOW A LIST OF ALL BRANDS
	public function indexAction(){
		$brands = new Brands();
		$allBrands = $this->BrandsModel->getAll();
		$this->view->brands = $allBrands;
		$this->view->render('admin/brands/brands');
  }

  // ADD A NEW BRAND
  public function addAction(){
    	$brand = new Brands();
    	if($this->request->isPost()){
           $this->request->csrfCheck();
           $brand->assign($this->request->get());
           if($brand->create()){
                Router::redirect('admin/brands/index');
           }   
         }
    	$this->view->displayErrors = $brand->getErrorMessages();
    	$this->view->render('admin/brands/brand_add');    
    }

  // EDIT BRAND
  public function editAction($id){
      $brand = $this->BrandsModel->findById($id);
      if($this->request->isPost()){
          $this->request->csrfCheck();
          // Updating values
          $brand->assign($this->request->get());
            if($brand->saveChanges()){
              Router::redirect('admin/brands/index');
            }
      }
      $this->view->displayErrors = $brand->getErrorMessages();
      $this->view->brand = $brand;
      $this->view->render('admin/brands/brand_edit');  
  }

  // DELETE A BRAND
  // Redirect back to all brands display
  public function deleteAction($id){
      $brand = $this->BrandsModel->findById($id);
      if($brand){
        // Check if brand has products
        if($this->BrandsModel->hasProducts($brand->id)){
            Session::addMsg('danger', 'This brand has products attached! Please remove all products before attempting to delete the brand.');   
            Router::redirect('admin/brands/index');
            return false;
        }
        if($brand->delete()){
            Session::addMsg('success', 'The brand was deleted successfully.');
        }else{
            Session::addMsg('danger', 'The brand was not deleted. Please try again.');
        }
      }
      Router::redirect('admin/brands/index');
  }

  // TOGGLE FEATURED CATEGORIES
  // Return a json response
  public function updateFeaturedAction(){
    if(!$this->request->isAjax()){
        Router::redirect('restricted/unauthorized');
    }else{
        $brandId = intval($this->request->get('id'));
        $brand = $this->BrandsModel->findById($brandId);
        if($brand){
          if($brand->featured == 0){
            $brand->featured = 1;
          }else{
            $brand->featured = 0;
          }
          $results = $brand->updateProperties(['featured']);
          if($results){
              $this->jsonResponse("success");
              }
          }
          $this->jsonResponse("error"); 
    }
  }
}    