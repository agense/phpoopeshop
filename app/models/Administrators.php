<?php
class Administrators extends Model{
  private $_isLoggedIn, $_sessionName;
  private static $admin_roles = ['Editor', 'Admin', 'SuperAdmin']; 
	private static $loggedInUser = null;
  public $id, $username, $email, $password, $fname, $lname, $acl, $deleted = 0; 
  protected $dbColumns = [
		'id', 
    'username', 
    'email',
		'password', 
    'password',
    'fname',
    'lname',
    'acl',
    'deleted'
	];

  public function __construct($user=''){
    $table = 'administrators';
    parent::__construct($table);
    $this->_sessionName = ADMIN_SESSION_NAME;
    $this->_softDelete = true;

    if($user != ''){
      if(is_int($user)){
          // FindFisrst parameters are:table name, params, class name
      		$u = $this->_db->findFirst('administrators', ['conditions'=>'id = ?', 'bind'=>[$user]], 'Administrators');
      }else{
      		$u = $this->_db->findFirst('administrators', ['conditions'=>'username = ?', 'bind'=>[$user]], 'Administrators');
      }
      if($u){
      	foreach($u as $key => $val){
      		$this->$key = $val;
      	}
      }
    } 
  }

  // LOGIN VALIDATION
  public function loginValidator(){
    $this->runValidation(new ReqValidator($this, ['field'=>'username', 'msg' => 'Username is required.']));
    $this->runValidation(new ReqValidator($this, ['field'=>'password', 'msg' => 'Password is required.']));
  }

  public function validator(){
    //First Name Validation
    $this->runValidation(new ReqValidator($this, ['field'=>'fname', 'msg' => 'First name is required.']));
    $this->runValidation(new MaxValidator($this, ['field'=>'fname', 'rule'=>150, 'msg' => 'First name must be less than 150 characters']));
    $this->runValidation(new AlphaValidator($this, ['field'=>'fname', 'msg' => 'First name can only contain letters and spaces']));
    //Last Name Validation
    $this->runValidation(new ReqValidator($this, ['field'=>'lname', 'msg' => 'Last name is required.']));
    $this->runValidation(new MaxValidator($this, ['field'=>'lname', 'rule'=>150, 'msg' => 'Last name must be less than 150 characters']));
    $this->runValidation(new AlphaValidator($this, ['field'=>'lname', 'msg' => 'Last name can only contain letters and spaces']));
    //Username Validation
    $this->runValidation(new ReqValidator($this, ['field'=>'username', 'msg' => 'Username is required.']));
    $this->runValidation(new MaxValidator($this, ['field'=>'username', 'rule'=>150, 'msg' => 'Username must be less than 150 characters']));
    $this->runValidation(new MinValidator($this, ['field'=>'username', 'rule'=> 6, 'msg' => 'Username must be at least 6 characters']));
    $this->runValidation(new UniqueValidator($this, ['field'=>'username', 'msg' => 'This username already exists. Please choose another username.']));
    //Email Validation
    $this->runValidation(new ReqValidator($this, ['field'=>'email', 'msg' => 'Email is required.']));
    $this->runValidation(new MaxValidator($this, ['field'=>'email', 'rule'=>150, 'msg' => 'Email must be less than 150 characters']));
    $this->runValidation(new EmailValidator($this, ['field'=>'email', 'msg' => 'The email is invalid.']));
    $this->runValidation(new UniqueValidator($this, ['field'=>'email', 'msg' => 'This email already exists. Please choose another email.']));
    //Password Validation
    $this->runValidation(new ReqValidator($this, ['field'=>'password', 'msg' => 'Password is required.']));
    $this->runValidation(new MaxValidator($this, ['field'=>'password', 'rule'=>150, 'msg' => 'Password must be less than 150 characters'])); 
    $this->runValidation(new MinValidator($this, ['field'=>'password', 'rule'=> 6, 'msg' => 'Password must be at least 6 characters']));
    //Role Validation
    $this->runValidation( new ExistanceValidator($this, ['field'=>'acl', 'rule'=> $this->getRoles(), 'msg' => 'Roles value is incorrect.']));
  }

  // FIND USER BY USERNAME
  // Requires users username as argument
  public function findByUsername($username){
    return $this->findFirst(['conditions'=>'username = ?', 'bind'=>[$username]]);
  }

  // LOG THE ADMIN USER IN
  public function login(){
    if(Session::set($this->_sessionName, $this->id)){
      self::currentAdminUser();
    }
  }

  // LOG THE ADMIN USER OUT
  public function logout(){
      // Delete the session
      Session::delete(ADMIN_SESSION_NAME);
      // Set currentLoggedInUser to null
      self::$loggedInUser = null;
  }

  // RETURN THE USER OBJECT POPULATED WITH LOGGED IN USERS DATA 
  public static function currentAdminUser(){
      // If $currentAdminUser is not set, and admin session exists, set the $currentAdminUser property's value to session value(i.e. users id)
      if(!isset(self::$loggedInUser) && Session::exists(ADMIN_SESSION_NAME)){
        // CURRENT_USER_SESSION_NAME holds the id of the user in the db
        $admUser = new self((int)Session::get(ADMIN_SESSION_NAME));
        self::$loggedInUser = $admUser;
        $admUser->_db->clearResult();
      }
      return self::$loggedInUser;
  }

  // RETURN THE LOGGED IN USERS PERMISSIONS FROM THE $ACL PROPERTY
  public function acls(){
      if(empty($this->acl)) return [];
      $decoded = stripslashes(html_entity_decode($this->acl));
      return json_decode($decoded, true);
  }
  
  // RETURN ALL ADMINISTRATOR USERS
  public function getAllAdminUsers(){
      return $this->find();
  }

  // RETURN ADMINISTRATOR ROLES PRIVATE PROPERTY
  public static function getRoles(){
    return self::$admin_roles;
  }

    // HELPER METHOD FOR PASSWORD HASHING
    public function hashPassword(){
      $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    // HELPER METHOD TO ENCODE ADMINISTRATOR ROLES IN JSON
    public function encodeACL(){
      $this->acl = json_encode($this->acl);
    }

    // USER PERMISSION METHODS
    
    // CHECK IF A USER HAS SUPERADMIN PERMISSIONS
    // Returns true or false
    public static function isSuperAdmin(){
      $userACLS = self::currentAdminUser()->acls();
      if(in_array('SuperAdmin', $userACLS)){
        return true;
      }
      return false;
    }

    // USER PERMISSION METHODS
    // CHECK IF A USER HAS ADMIN PERMISSIONS
    // Returns true or false
    public static function isAdmin(){
      $userACLS = self::currentAdminUser()->acls();
      if(in_array('Admin', $userACLS)){
        return true;
      }
      return false;
    }
}    