<?php
class RegisterController extends Controller{

	public function __construct($controller, $action){
		parent::__construct($controller, $action);
    // This instantiates a new model class of whichever model class we pass and saves it in $this->modelName property. Here we will have $this->usersModel = new Users('Users'); The argument we pass must be the model name we want to load.
		$this->load_model('Users');
		$this->view->setLayout('default');
	}

// USER LOGIN
 public function loginAction(){
   $user = new Users();
   if($this->request->isPost()){
      $this->request->csrfCheck();
    $user->assign($this->request->get());
    // Validate login credentials
    $user->loginValidator();
    if($user->validationPassed()){
      // Redefine user var by getting user data from db. If user is not found by username in db, returns false
      $user = $this->UsersModel->findByUsername($this->request->get('username'));
      // Check user password
      if($user && password_verify($this->request->get('password'), $user->password)){
        $remember  = (isset($_POST['remember']) && $this->request->get('remember')) ? true : false;
        $user->login($remember);
        Router::redirect('');
      }else{
        $user = new Users();
        $user->addErrorMessage('username', 'There was a problem with your login credentials');
      }
     }
    }
   $this->view->displayErrors = $user->getErrorMessages();
   $this->view->render('register/login');
}

  // USER LOGOUT
	public function logoutAction(){
		if(Users::currentUser()){
		  Users::currentUser()->logout(); 
		}
		Router::redirect('register/login');
	}

  // USER REGISTRATION WITH BUILT IN VALIDATOR AND CSRF PROTECTION
   public function registerAction(){
    $newUser = new Users();
    if($this->request->isPost()){
      // Check the token for csrf protection
      $this->request->csrfCheck();
      // Assign post forms values to the object $newUser
      $newUser ->assign($this->request->get());
      unset($newUser->phone);
      unset($newUser->address);
      unset($newUser->city);
      unset($newUser->region);
      unset($newUser->postal_code);
      unset($newUser->country);
      unset($newUser->acl);
      // Validate data
      // Set password confirmation 
      $newUser->setConfirm($this->request->get('confirm'));
      $newUser->validator();
      if($newUser->validationPassed()){
        $newUser->hashPassword();
        if($newUser->save()){
          Router::redirect('register/login');
        }
      }
    }
    // Send the newUser object data to the view
    $this->view->newUser = $newUser;
    $this->view->displayErrors = $newUser->getErrorMessages();
    $this->view->render('register/register');
  }

}

