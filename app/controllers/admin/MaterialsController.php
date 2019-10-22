<?php
class MaterialsController extends Controller{

	public function __construct($controller, $action){
		parent::__construct($controller, $action);
    // This instantiates a new model class of whichever model class we pass and saves it in $this->modelName property. Here we will have $this->usersModel = new Users('Users'); The argument we pass must be the model name we want to load.
		$this->load_model('Materials');
		$this->view->setLayout('admin_default');
	}

  // SHOW ALL MATERIALS
	public function indexAction(){
		$materials = $this->MaterialsModel->getAll();
		$this->view->materials = $materials;
		$this->view->render('admin/materials/materials');
	}
  
  // ADD A MATERIAL
  public function addAction(){
    $material= new Materials();
    if($this->request->isPost()){
      $this->request->csrfCheck();
      $material->assign($this->request->get());
        if($material->create()){
          Router::redirect('admin/materials/index');
        }     
    }
    $this->view->displayErrors = $material->getErrorMessages();
    $this->view->render('admin/materials/material_add');
  }

  // EDIT A MATERIAL
  public function editAction($id){
    $material = $this->MaterialsModel->findById($id);
    if($this->request->isPost()){
      $this->request->csrfCheck();
      $material->assign($this->request->get());
      if($material->saveChanges()){
        Router::redirect('admin/materials/index');
      }
    }
    $this->view->displayErrors = $material->getErrorMessages();
    $this->view->material = $material;
    $this->view->render('admin/materials/material_edit');  
  }

  // DELETE A MATERIAL
  public function deleteAction($id){
    $material = $this->MaterialsModel->findById($id);
    if($material){
      // Check if material has any products attached
      if($this->MaterialsModel->hasProducts($material->id)){
        Session::addMsg('danger', 'This material has products attached! Please remove all products before attempting to delete the material.');   
        Router::redirect('admin/materials/index');
        return false;
      }
      if($material->delete()){
        Session::addMsg('success', 'The material was deleted successfully.');
      }else{
        Session::addMsg('danger', 'The material was not deleted. Please try again.');
      }
    }
    Router::redirect('admin/materials/index');
  }

}	