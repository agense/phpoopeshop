<?php
class ColorsController extends Controller{

	public function __construct($controller, $action){
		parent::__construct($controller, $action);
    // This instantiates a new model class of whichever model class we pass and saves it in $this->modelName property. Here we will have $this->usersModel = new Users('Users'); The argument we pass must be the model name we want to load.
		$this->load_model('Colors');
		$this->view->setLayout('admin_default');
	}

  // SHOW ALL COLORS
	public function indexAction(){
		$colors = $this->ColorsModel->getAll();
		$this->view->colors = $colors;
		$this->view->render('admin/colors/colors');
	}

  // ADD A COLOR
	public function addAction(){
    $color = new Colors();
    if($this->request->isPost()){
        $this->request->csrfCheck();
        $color->assign($this->request->get());
        if($color->create()){
          Router::redirect('admin/colors/index');
        }     
    }
    $this->view->displayErrors = $color->getErrorMessages();
    $this->view->render('admin/colors/color_add');
  }

  // EDIT A COLOR
  public function editAction($id){
    $color = $this->ColorsModel->findById($id);
      if($this->request->isPost()){
        $this->request->csrfCheck();
        $color->assign($this->request->get());
        if($color->saveChanges()){
          Router::redirect('admin/colors/index');
        }
      }
    $this->view->displayErrors = $color->getErrorMessages();
    $this->view->color = $color;
    $this->view->render('admin/colors/color_edit');  
  }

  // DELETE A COLOR
  public function deleteAction($id){
    $color = $this->ColorsModel->findById($id);
    if($color){
      if($this->ColorsModel->hasProducts($color->id)){
        Session::addMsg('danger', 'This color has products attached! Please remove all products before attempting to delete the color.');   
        Router::redirect('admin/colors/index');
        return false;
      }
      if($color->delete()){
        Session::addMsg('success', 'The color was deleted successfully.');
      }else{
        Session::addMsg('danger', 'The color was not deleted. Please try again.');
      }
    }
    Router::redirect('admin/colors/index');
  }

}	