<?php
class AdministratorsController extends Controller{
        public function __construct($controller, $action){
        parent::__construct($controller, $action);
        // This instantiates a new model class of whichever model class we pass and saves it in $this->modelName property. Here we will have $this->usersModel = new Users('Users'); The argument we pass must be the model name we want to load.
        $this->load_model('Administrators');
        $this->view->setLayout('admin_default');
    }
    
    // SHOW ALL ADMIN USERS
    public function indexAction(){
       $admins = $this->AdministratorsModel->getAllAdminUsers();
       foreach($admins as $admin){
           $admin->name = ucfirst($admin->fname).' '.ucfirst($admin->lname);
           $admin->roles = $admin->acls();
       }
       $this->view->admins = $admins;
       $this->view->render('admin/administrators/index');
    }

    // ADD A NEW ADMINISTRATOR
    public function addAction(){
        $admin = new Administrators();
        //Create admin roles option list for the form
        $roles = Administrators::getRoles();
        $adminRoles = [];
        foreach($roles as $role){
            $adminRoles[$role] = $role;
        }
        if($this->request->isPost()){
            $this->request->csrfCheck();
            $admin->assign($this->request->get());
            $admin->validator();
            $admin->hashPassword();
            $admin->encodeACL();
            if($admin->validationPassed()){
                $data = $admin->getFieldData();
                if($admin->insert($data)){
                    Router::redirect('admin/administrators/index');
                }else{
                    $admin->addErrorMessage('username', 'Sorry, there was a problem. Please try again');
                }  
            }
        }
        $this->view->adminRoles = $adminRoles;
        $this->view->displayErrors = $admin->getErrorMessages();
        $this->view->render('admin/administrators/administrator_add');    
    }

    
    // EDIT AN ADMINISTRATOR
    public function editAction($id){
        $id = intval($id);
        $admin = $this->AdministratorsModel->findById($id);
        $admin->roles = $admin->acls();
        // Get an administrator class role list
        $roles = Administrators::getRoles();
        $adminRoles = [];
        foreach($roles as $role){
            $adminRoles[$role] = $role;
        }
        if($this->request->isPost()){
            $this->request->csrfCheck();
            // Updating values
            $admin->fname = $this->request->get('fname');
            $admin->lname = $this->request->get('lname');
            $admin->email = $this->request->get('email');
            $admin->username = $this->request->get('username');
            $admin->acl = $this->request->get('acl');
            $admin->validator();
            if($this->request->get('password') != ""){
                $admin->password = $this->request->get('password');
                $admin->hashPassword();
            }
            if($admin->validationPassed()){
                $admin->encodeACL();
                $data = $admin->getFieldData();
                if($admin->update($id,$data)){
                    Router::redirect('admin/administrators/index');
                }else{
                    $admin->addErrorMessage('fname', 'Sorry, there was a problem. Please try again');
                }  
            }
        }
        $this->view->displayErrors = $admin->getErrorMessages();
        $this->view->adminRoles = $adminRoles;
        $this->view->admin = $admin;
        $this->view->render('admin/administrators/administrator_edit');  
    }

    // SOFT DELETE AN ADMINISTRATOR
    // Redirect back to all administrators display
    public function deleteAction($id){
        $id = intval($id);
        $admin = $this->AdministratorsModel->findById($id);
        if($admin->delete()){
            Session::addMsg('success', 'Administrator was deleted successfully.');
        }else{
            Session::addMsg('danger', 'Administrator was not deleted. Please try again.');
        }
        Router::redirect('admin/administrators/index');
    }
    
    // SHOW DELETED ADMINISTRATORS
    public function deletedAction(){
        $admins = $this->AdministratorsModel->findDeleted();    
        foreach($admins as $admin){
            $admin->name = ucfirst($admin->fname).' '.ucfirst($admin->lname);
            $admin->roles = $admin->acls();
        } 
        $this->view->admins = $admins;
        $this->view->render('admin/administrators/administrators_deleted'); 
    }

    // DELETE SOFT DELETED COLLECTIONS
    public function finalDeleteAction(){
        $id = intval($this->request->get('id'));
        $admin = $this->AdministratorsModel->findDeleted($id);
        if(!$admin){
            Session::addMsg('danger', 'Sorry, administrator not found');
            Router::redirect('admin/administrators/deleted');
        }
        if($admin->finalDelete()){
            Session::addMsg('success', 'The administrator was deleted successfully.');
            Router::redirect('admin/administrators/deleted');
        }else{
            Session::addMsg('danger', 'The administrator was not deleted. Please try again.');
            Router::redirect('admin/administrators/deleted');
        }   
    }

    // RESTORE DELETED COLLECTIONS
    // Return a json response
    public function restoreDeletedAction(){
        if(!$this->request->isAjax()){
            Router::redirect('restricted/unauthorized');
        }else{
            $id = intval($this->request->get('id'));
            $admin = $this->AdministratorsModel->findDeleted($id);
            if($admin){
            $admin->deleted = 0;
            $results = $admin->updateProperties(['deleted']);
                if($results){
                    return $this->jsonResponse("success");
                }
            }
            return $this->jsonResponse("error");
        } 
    }

}  