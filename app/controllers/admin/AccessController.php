<?php
class AccessController extends Controller{

  public function __construct($controller, $action){
    parent::__construct($controller, $action);
    // This instantiates a new model class of whichever model class we pass and saves it in $this->modelName property. Here we will have $this->usersModel = new Users('Users'); The argument we pass must be the model name we want to load.
    $this->load_model('Administrators');
    $this->view->setLayout('admin_default');
  }
   
  // SHOW ADMIN DASHBOARD
  public function indexAction(){
      if(Session::exists(ADMIN_SESSION_NAME)){
          Router::redirect('admin/dashboard');  
      }
        Router::redirect('admin/access/login');
  }

  // LOGIN ADMIN USERS TO ADMIN AREA
  public function loginAction(){
     $adminUser = new Administrators();
     if($this->request->isPost()){
        $this->request->csrfCheck();

        $adminUser->assign($this->request->get());
        $adminUser->loginValidator();
        if($adminUser->validationPassed()){
            // Redefine user var by getting user data from db. If user is not found by username in db, returns false
            $adminUser = $this->AdministratorsModel->findByUsername($this->request->get('username')); 
            // Check user password
            if($adminUser && password_verify($this->request->get('password'), $adminUser->password)){
              $adminUser->login();
              Router::redirect('admin/dashboard');
            }else{
              $adminUser = new Administrators();
              $adminUser->addErrorMessage('username', 'There was a problem with your login credentials');
          }
        }
    }   
      // Send variables to the view and render the view
      $this->view->displayErrors = $adminUser->getErrorMessages();
      $this->view->setLayout('admin_login');
      $this->view->render('admin/login');
  }

  //USER LOGOUT
  public function logoutAction(){
      if(Administrators::currentAdminUser()){
          Administrators::currentAdminUser()->logout(); // currrentUser function is in helpers, logout is in the users model
      }
      Router::redirect('admin/access/login'); 
  }

  //RETURN THE DOMAIN NAME OF THE SITE 
  //uSED IN JS FUNCTIONS
  public function getDomainAction(){
    return ROOT;
  }

} 