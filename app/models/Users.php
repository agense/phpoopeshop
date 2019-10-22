<?php
class Users extends Model{
	private $_isLoggedIn, $_sessionName, $_cookieName, $_confirm;
	public static $currentLoggedInUser = null;
  public $dbColumns = [
    'id', 
    'username', 
    'email', 
    'password', 
    'fname', 
    'lname', 
    'phone', 
    'address', 
    'city', 
    'region', 
    'postal_code', 
    'country', 
    'acl', 
    'deleted'
  ];
  public $deleted = 0;

  public function __construct($user=''){
      $table = 'users';
      parent::__construct($table);
      $this->_sessionName = CURRENT_USER_SESSION_NAME;
      $this->_cookieName = REMEMBER_ME_COOKIE_NAME;
      $this->_softDelete = true;

    // If user id or username is passed as argument, find users data from db
      if($user != ''){
      	if(is_int($user)){
      		$u = $this->_db->findFirst('users', ['conditions'=>'id = ?', 'bind'=>[$user]], 'Users');
      	}else{
      		$u = $this->_db->findFirst('users', ['conditions'=>'username = ?', 'bind'=>[$user]], 'Users');
      	}
      	if($u){
      		foreach($u as $key => $val){
      			$this->$key = $val;
      		}
      	}
      } 
  }
    
  // RETURN USER DATA BY USERNAME
  // Requires username as argument
  // Returns void
  public function findByUsername($username){
      return $this->findFirst(['conditions'=>'username = ?', 'bind'=>[$username]]);
  }

  // RETURN CURRENT LOGGED IN USER
  // If user does not exist, but users login session data exists, create and return a user
  public static function currentUser(){
      /* 
       Check if the currentLoggedInUser property is set, if it is, we return it.
       If currentLoggedInUser property is not set, check if users session data exists, if it does,
       set the currentLoggedInUser property to the logged in user using data from the sessions value.
       When we log in the user, we set the session using predefined session name and users id as session value. 
       so if session exists, there is a logged in user.
       */
      if(!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)){//CURRENT_USER_SESSION_NAME holds the id of the user in the db
          $u = new Users((int)Session::get(CURRENT_USER_SESSION_NAME));
          self::$currentLoggedInUser = $u;
      }
      return self::$currentLoggedInUser;
  }
 
  // USER LOGIN 
  // Logs the user in by setting a session using users login data.
  /* If remember me argument is true, set the automatic login cookie and save it in the db 
  along with the users user agent.
  */
  public function login($rememberMe = false){
        Session::set($this->_sessionName, $this->id);
        if($rememberMe){
          // $hash is used as cookie value and user_session value in the user_sessions table
        	$hash = md5(uniqid() + rand(0,100));
        	$user_agent = Session::uagent_no_version();
        	Cookie::set($this->_cookieName, $hash, REMEMBER_COOKIE_EXPIRY);
        	$fields = ['user_session'=>$hash, 'user_agent'=>$user_agent, 'user_id'=>$this->id];
        	$this->_db->query("DELETE FROM user_sessions WHERE user_id = ? AND user_agent = ?", [$this->id, $user_agent]);
        	$this->_db->insert('user_sessions', $fields);
        }
  }

  // LOG THE USER IN USING THE AUTOMATIC LOGIN COOKIE
  /* 
  The value of the cookie corresponds to the user_session value in the db user_sessions table.
  Get the value from the cookie and find that value in the database's user_sessions table. 
  Extract the users id from the $hash value in user_session table and log the user in automatically. 
  User_agent value allows to only perform automatic login if a returning user uses the same 
  browser they used to log in.
  */
  public static function cookieLogin(){
    $userSession = UserSessions::getUserFromCookie();
      if($userSession && $userSession->user_id != ''){ 
        // Create a new user class object, from the id of the user found
        $user = new self((int)$userSession->user_id); 
          if(isset($user)){
             $user->login();
             return $user;
          }
        }
      return false;
  }

  // USER LOGOUT FUNCTIONALITY
  /*
  Delete users session.
  If the cookie for automatic login exists in db for current user, remove that cookie from broswer 
  and the record of the hash associated with taht cookie from the db.
  */
  public function logout(){
      $userSession = UserSessions::getUserFromCookie();
      if($userSession) $userSession->delete();
      // Delete the session
      Session::delete(CURRENT_USER_SESSION_NAME);

      // If cookie exists, delete the cookie
      if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)){
         Cookie::delete(REMEMBER_ME_COOKIE_NAME); 
      }
      // Set currentLoggedInUser to null
      self::$currentLoggedInUser = null;
    }
    
  // RETURN THE LOGGEN IN USERS ACCESS PERMISSIONS(ARRAY)
  // Get the logged in users permissions from the database table(acl column)  
  // Returns an array of the loggein in uers access permissions
  public function acls(){
      if(empty($this->acl)) return [];
      return json_decode($this->acl, true);
  }

 // VALIDATORS
 // USES THE VALIDATION CLASSES
 /* 
  Calls the runValidation method of the parent class(model class) passing as argument a new instance/object
  of the required validator class, like: runValidation(new MinValidator($model, $params)); 
  To the new instance of required validator class, i.e. validator object, we pass as arguments required 
  validation fields, i.e. 'field', 'rules' and 'msg', which are all transformed to validator object's
  properties by the constructor of the parent class of each validator class, i.e. CustomValidator Class.
  Upon creation of new validator object, i.e. here, the  CustomValidator Class constructor will call each 
  validators class runValidation(); which returns true or false, and based on that, stes the validator 
  objects property $success to be true or false.
  The core model class then checks the validator objects success property, and if it returns false,
  resets the current objects _validate property to false, and also extracts errors from validator object
  to the current object, i.e. the objetc being validated. The validated object is not the same as validator
  object, i.e. the validation object can be users class object, contacts class object etc, i.e. it is an 
  objetc of the class which we instantiate from the form in the controller. It is passed to the validator
  class as $this/$model property. The validator object is the object of validator class, and its a
  separate object.   
  */

  // USER REGISTRATION VALIDATOR
	// Perform validation when creating new users
   public function validator(){
    // Validate first name 
    $this->runValidation(new ReqValidator($this, ['field'=>'fname', 'msg' => 'First name is required.']));
    $this->runValidation(new MaxValidator($this, ['field'=>'fname', 'rule'=>150, 'msg' => 'First name must be less than 150 characters']));
    $this->runValidation(new AlphaValidator($this, ['field'=>'fname', 'msg' => 'First name can only contain letters and spaces']));
    
    // Validate last name 
    $this->runValidation(new ReqValidator($this, ['field'=>'lname', 'msg' => 'Last name is required.']));
    $this->runValidation(new MaxValidator($this, ['field'=>'lname', 'rule'=>150, 'msg' => 'Last name must be less than 150 characters']));
    $this->runValidation(new AlphaValidator($this, ['field'=>'lname', 'msg' => 'Last name can only contain letters and spaces']));
    
    // Validate email
    $this->runValidation(new ReqValidator($this, ['field'=>'email', 'msg' => 'Email is required.']));
    $this->runValidation(new EmailValidator($this, ['field'=>'email', 'msg' => 'Email address is invalid.']));
    $this->runValidation(new MaxValidator($this, ['field'=>'email', 'rule'=>150, 'msg' => 'Email must be less than 150 characters']));

    // Validate username
    $this->runValidation(new ReqValidator($this, ['field'=>'username', 'msg' => 'Username is required.']));
    $this->runValidation(new MinValidator($this, ['field'=>'username', 'rule'=> 6, 'msg' => 'Username must be at least 6 characters']));
    $this->runValidation(new MaxValidator($this, ['field'=>'username', 'rule'=>150, 'msg' => 'Username must be less than 150 characters']));

    // Check if username is unique in the database table
     $this->runValidation(new UniqueValidator($this, ['field'=>'username', 'msg' => 'This username already exists. Please choose another username.']));

    // Validate password
     $this->runValidation(new ReqValidator($this, ['field'=>'password', 'msg' => 'Password is required.']));
     $this->runValidation(new MinValidator($this, ['field'=>'password', 'rule'=> 6, 'msg' => 'Password must be at least 6 characters']));
     $this->runValidation(new MaxValidator($this, ['field'=>'password', 'rule'=>150, 'msg' => 'Password must be less than 150 characters']));
    
    // Validate password match with confirm password 
     $this->runValidation(new FieldMatchValidator($this, ['field'=>'password', 'rule'=>$this->_confirm, 'msg' => 'Your passwords do not match.']));
   }


  // USER LOGIN VALIDATOR
	// Perform validation when users submits login form
  public function loginValidator(){
     $this->runValidation(new ReqValidator($this, ['field'=>'username', 'msg' => 'Username is required.']));
     $this->runValidation(new ReqValidator($this, ['field'=>'password', 'msg' => 'Password is required.']));
  }
  

  // USER DATA UPDATE VALIDATOR
	// Perform validation when updating user data
  public function updateValidator(){
    // Validate fname and lname
    $this->runValidation(new ReqValidator($this, ['field'=>'fname', 'msg' => 'First name is required.']));
    $this->runValidation(new MaxValidator($this, ['field'=>'fname', 'rule'=>150, 'msg' => 'First name must be less than 150 characters']));

    $this->runValidation(new ReqValidator($this, ['field'=>'lname', 'msg' => 'Last name is required.']));
    $this->runValidation(new MaxValidator($this, ['field'=>'lname', 'rule'=>150, 'msg' => 'Last name must be less than 150 characters']));

    // Validate email
    $this->runValidation(new ReqValidator($this, ['field'=>'email', 'msg' => 'Email is required.']));
    $this->runValidation(new EmailValidator($this, ['field'=>'email', 'msg' => 'Email address is invalid.']));
    $this->runValidation(new MaxValidator($this, ['field'=>'email', 'rule'=>150, 'msg' => 'Email must be less than 150 characters']));

    // Validate Username
    $this->runValidation(new ReqValidator($this, ['field'=>'username', 'msg' => 'Username is required.']));
    $this->runValidation(new MinValidator($this, ['field'=>'username', 'rule'=> 6, 'msg' => 'Username must be at least 6 characters']));
    $this->runValidation(new MaxValidator($this, ['field'=>'username', 'rule'=>150, 'msg' => 'Username must be less than 150 characters']));

    // Validate password if exists
    if(isset($this->password)){
     $this->runValidation(new ReqValidator($this, ['field'=>'password', 'msg' => 'Password is required.']));
     $this->runValidation(new MinValidator($this, ['field'=>'password', 'rule'=> 6, 'msg' => 'Password must be at least 6 characters']));
     $this->runValidation(new MaxValidator($this, ['field'=>'password', 'rule'=>150, 'msg' => 'Password must be less than 150 characters']));
    // Validate password match with confirm password 
     $this->runValidation(new FieldMatchValidator($this, ['field'=>'password', 'rule'=>$this->_confirm, 'msg' => 'Your passwords do not match.']));
     }

     // Validate Phone if exists
     if(isset($this->phone)){
     $this->runValidation(new MinValidator($this, ['field'=>'phone', 'rule'=> 8, 'msg' => 'Password must be at least 8 characters']));
     $this->runValidation(new MaxValidator($this, ['field'=>'phone', 'rule'=>15, 'msg' => 'Phone must be less than 15 characters']));
     }
    // Validate Address if exists
    if(isset($this->address)){
     $this->runValidation(new MaxValidator($this, ['field'=>'address', 'rule'=>255, 'msg' => 'Address must be less than 255 characters']));
     }
    // Validate City if exists
    if(isset($this->city)){
     $this->runValidation(new MaxValidator($this, ['field'=>'city', 'rule'=>35, 'msg' => 'City must be less than 35 characters']));
     }
    // Validate Region if exists
    if(isset($this->region)){
     $this->runValidation(new MaxValidator($this, ['field'=>'region', 'rule'=>50, 'msg' => 'Region must be less than 50 characters']));
     }
    // Validate Postal Code if exists
    if(isset($this->postal_code)){
     $this->runValidation(new MaxValidator($this, ['field'=>'postal_code', 'rule'=>10, 'msg' => 'Postal code must be less than 10 characters']));
     }
    // Validate Country if exists
    if(isset($this->country)){
     $this->runValidation(new MaxValidator($this, ['field'=>'country', 'rule'=>60, 'msg' => 'Country name must be less than 60 characters']));
     }

  }
  
// USER REGISTRATION AND LOGIN HELPER METHODS

  // PRIVATE PROPERTY SETTER METHOD 
  // Sets the value of the _confirm property     
  public function setConfirm($value){
    $this->_confirm = $value;
  }
  
  // PRIVATE PROPERTY GETTER METHOD 
  // Gets the value of the _confirm property  
  public function getConfirm(){
     return $this->_confirm;
  }

  // HELPER METHOD FOR PASSWORD HASHING
  public function hashPassword(){
    $this->password = password_hash($this->password, PASSWORD_DEFAULT);
  }

}