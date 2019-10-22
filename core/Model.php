<?php
class Model{
// CORE MODEL CLASS, EXTENDS THE DB CLASS FOR DB QUERY OPERATIONS.
// ALL OTHER MODEL CLASSES MUST EXTEND THE MODEL CLASS

	protected $_db, $_table, $_modelName, $_softDelete = false, $_validates = true, $_validationErrors = [];
  public $uploadPath = UPLOAD_PATH;
	public $id;

  // CONSTRUCTOR FUNCTION
  // Gets the db instance
  // Sets the table associated with the model
  // Instantiates a model
  // Sets model properties based on db columns
	public function __construct($table){
      $this->_db = DB::getInstance();
      $this->_table = $table;
      $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table))); //transforming table name to model name
      $this->setPropertiesFromDB();
	}

  // MODEL PROPERTY SETTER
  // Automatically sets the associated db table columns as properties on an instantiated model class
  private function setPropertiesFromDB(){
    if(isset($this->dbColumns)){
      foreach($this->dbColumns as $column){
         $this->{$column} = isset($this->{$column}) ? $this->{$column} : NULL;
      }
    }
  }

  // RESULT RETRIEVING METHODS

  // THE GENERAL QUERY METHOD
  // Extends the db query method, allows to perform any custom query
  // Requires as argument: an sql statement to be executed.
  // If sql statement contains any placeholders, requires an array of binding values
  // Accepts as optional argument a model class into which the results must be fetched 
  // Returns query results as an array of objets of specified model class, or standard objects if class is not passed
  protected function query($sql, $bind = [], $class = false){
    return $this->_db->query($sql, $bind, $class);
  }

  // FIND METHODS HELPER - EXCLUDES SOFT DELETED ITEMS FROM RESULTS RETURNED BY ALL FIND METHODS
  // Used to exclude the soft deleted items from search results in find methods
  // Acts as a filter for arguments array passed to the find methods.
  // Accepts the arguments array to be passed to find methods and appends the condition to exclude the soft deleted items from results
  // Returns updated arguments array
  protected function softDeleteParams($params){
    if($this->_softDelete){
        if(array_key_exists('conditions', $params)){
          if(is_array($params['conditions'])){
            $params['conditions'][] = "deleted !=1";
          }else{
            $params['conditions'].= " AND deleted != 1";
          }
        }else{
            $params['conditions'] = "deleted != 1";
        }
    }
    return $params;
  }

  // RETURN MULTIPLE DB RECORDS BASED ON CONDITIONS SET
  // Accepts an array of params which includes seach conditions with placeholders and an array of binding values
  // Returns matching results as an array of objects or an empty array if no results are returned
  // Ignores soft deleted items
  /** Usage Syntax: 
  * find([
    * 'conditions' => ['deleted = ?'], 
    * 'bind' => ['0']
  * ]);
  **/  
  public function find($params = [], $class = TRUE){
        if($class == FALSE){
          $class = FALSE;
        }else{
          $class = get_class($this);
        }
        // Include soft delete filtering
        $params = $this->softDeleteParams($params);
        // Call the db class method find, passing the table, param array and the current model name as class
        $results = $this->_db->find($this->_table, $params, $class);
        if(!$results) return [];
        return $results;
  }

  // RETURN ALL DB TABLE RECORDS
  // Returns all table records as an array of objets of the model class on the instance of which this method is being called
  // Ignores soft deleted items
  public function getAll(){
    return $this->find();
  } 

  // RETURN A SINGLE RECORD BASED ON CONDITIONS SET
  // Accepts an array of params which includes seach conditions with placeholders and an array of binding values
  // Returns the first matching result as an object of specified model class  
  // Ignores soft deleted items
  public function findFirst($params = []){
        // Include soft delete filtering
        $params = $this->softDeleteParams($params);
        $result = $this->_db->findFirst($this->_table, $params, get_class($this));
        return $result;
  }

  // RETURN A SINGLE RECORD BY RECORD ID
  // Requires as argument the records unique id, searches for the record in the db table's column called 'id'
  // Does not allow any other seach conditions except id
  // Does not allow customized name for the id column
  // Ignores soft deleted items
  // Returns the first matching result as an object of specified model class 
  public function findById($id){
      return $this->findFirst(['conditions'=>"id = ?", 'bind'=>[$id]]);
  } 

  // RETURN A SINGLE RECORD BY UNIQUE SLUG
  // Requires as argument the records unique slug(string)
  // The second argument allows to pass a custom column name for the slug column 
  // If second argument isomitted,  searches for the record in db table's column named 'slug'
  // Ignores soft deleted items
  // Returns the first matching result as an object of specified model class  
  public function findBySlug(string $slug, $customSlug = false){
      if($customSlug){
        $customSlug = Helpers::sanitize($customSlug);
        return $this->findFirst(['conditions'=>"{$customSlug} = ?", 'bind'=>[$slug]]);
      }else{
        return $this->findFirst(['conditions'=>"slug = ?", 'bind'=>[$slug]]);
      } 
  } 

  // RETURN ALL SOFT DELETED RECORDS
  // Only works on instances model classes that have the _softDelete property set to true
  // Accepts an optional id argument. If passed, this argument must be the records unique id
  // If id is passed, returns the first matching record as an objet of the model class on the instance of which this method was called
  // If id is omitted, returns an array of objets of the model class on the instance of which this method was called
  public function findDeleted($id = FALSE){
      if($this->_softDelete == TRUE){
          if($id){
            $params = ['conditions' => ['deleted = ?', 'id = ?'],'bind' => ['1', $id]];
            $results = $this->_db->findFirst($this->_table, $params, get_class($this));
          }else{
            $params = ['conditions' => ['deleted = ?'],'bind' => ['1']];
            $results = $this->_db->find($this->_table, $params, get_class($this));
          }
          if(!$results) return [];
          return $results;
      }
      return false;
  } 

  // RETURN THE COUNT OF ALL RECORDS IN SPECIFIED TABLE
  // Requires db table name as argument (being a static method, it cannot get table name from the class instance)
  // Returns number of records in specified table(integer)
  public static function itemCount($table){ 
    $obj = new self($table);
    $sql = "SELECT COUNT(*) AS 'count' FROM {$obj->_table}";
    $result = $obj->_db->countQuery($sql);
    return $result->count;
  } 
      
  // SIMPLE DATA INSERT AND UPDATE METHODS

  // INSERT DATA TO DB
  // Inserts a single record data into db table
  // Requires an associative array as argument, where each key must correspond to a db column name and each value to a value to be inserted.
  // Extends the DB classes insert method, by passing the db table name automatically, based on the loaded model class
  // Returns true on success, false otherwise
  public function insert($fields){
      if(empty($fields)) return false;
      return $this->_db->insert($this->_table, $fields);
  }

  // UPDATE DATA IN DB
  // Updates single records data in the db table
  // Requires as arguments the unique id of the record and an associative array which must contain key => value pairs of db column names and values to be inserted
  // Extends the DB classes update method, by passing the db table name automatically, based on the loaded model class
  // Returns true on success, false otherwise
  public function update($id, $fields){
      if(empty($fields) || $id == '') return false;
      return $this->_db->update($this->_table, $id, $fields);
  }

  // UPDATE SPECIFIC COLUMN DATA ONLY 
  // Updates only the specified column data of a single record
  // Requires as arguments an associative array which must contain key => value pairs of db column names and values to be inserted
  // Returns true on success, false otherwise
  public function updateProperties($properties = []){
      if(count($properties ) <= 0) return false;
      if(!$this->id) return false;
      // Gets the properties to update
      $fields = $this->getUpdateProperties($properties);
      if($this->update($this->id, $fields)){
        return true;
      }
      return false;
  }

  // SAVE RECORD DATA: EITHER CREATE A NEW RECORD OR UPDATE AN EXISTING ONE
  // Saves record data changes or adds a new record
  // Does not include validation 
  // Does not include image upload
  // Returns true on success, false otherwise
  public function save(){
    // Get only properties that correspond to columns in db
    $fields = self::getFieldData();
    // Determine if to update or insert data: check if id property exists in current object($this)
    if(property_exists($this, 'id') && $this->id != ''){
        return $this->update($this->id, $fields);
    }else{
        return $this->insert($fields);
    } 
    return false;
  }  


  // DATA INSERT AND UPDATE METHODS THAT INCLUDE DATA VALIDATION AND ASSOCIATED IMAGE UPLOAD

  // CREATE A SINGLE DB RECORD FROM CALLER OBJECT PROPERTIES WITH ASSOCIATED FILE UPLOAD (IF FILE EXISTS)
  // Inserts a single record into db using the properties of the caller object as data
  // Includes data validation
  // If the caller object has an associated image, uploads the image to the folder
  // Returns the id of inserted row on success or false otherwise
  public function create(){
    $this->validator();
    if(Input::hasFile($this->image_field) && $this->validationPassed()){
        $this->uploadFile();  
    }
    if($this->validationPassed()){
        $fields = $this->getFieldData();
        if(empty($fields)) return false;
        if($this->_db->insert($this->_table, $fields)){
          $insertedId = $this->_db->lastId();
          return $insertedId;
        }
    }
    return false;
  }

// UPDATE A SINGLE DB RECORD FROM CALLER OBJECT PROPERTIES WITH ASSOCIATED FILE UPLOAD (IF FILE EXISTS)
// Updates a single record in db table using the properties of the caller object as data
// Includes data validation
// If the request has an image file, uploads the file and associates it with objects image field.
// If any image file is already associated with the objects image field, replaces the old image file with the new one.
// Returns true on success or false otherwise
public function saveChanges(){
    $this->validator();
    // If input has a file, upload a new file. If a file exists already, delete the old file.
    if(Input::hasFile($this->image_field) && $this->validationPassed()){
        $currentFile = (isset($this->{$this->image_field})) ? $this->{$this->image_field} : '';
        if($this->uploadFile() && $currentFile != ''){
            $this->deleteFile($this->uploadPath, $currentFile);
        }   
    }
    if($this->validationPassed()){
        // Update database
        $fields = $this->getFieldData();
        if(empty($fields)) return false;
        if($this->update($this->id, $fields)){
          return true;
        }
    }
    return false;
  }
  
  // DATA DELETE METHODS

  // DELETE A SINGLE RECORD
  // Soft deletes a record if a class whose instance calls the method has the _sofDelete property as true 
  // Otherwise deletes a record from db and its associated image file from folder
  // Returns true on success, false otherwise
  public function delete($id = ''){
    if($id == '' && $this->id == '') return false;
    $id = ($id == '') ? $this->id : $id;

    if($this->_softDelete){
        return $this->update($id, ['deleted' => 1]);
    }else{
      // Delete an image associated with this record from the folder (if exists)
      if(isset($this->{$this->image_field}) && $this->{$this->image_field}){
          $this->deleteFile();
      }
      return $this->_db->delete($this->_table, $id);
    }
  }

  // DELETE A SINGLE SOFT-DELETED RECORD FROM DB (AND ITS IMAGE IF EXISTS)
  // Returns true on success, false otherwise
  public function finalDelete(){
    // Delete an image associated with this record from the folder (if exists)
    if(isset($this->{$this->image_field}) && $this->{$this->image_field}){
      $this->deleteFile();
    }
    // Delete the record from db
    if($this->_db->delete($this->_table, $this->id)){
      return true;
    }
    return false;
  }


  // FILE UPLOAD METHODS
  // Extends the Uploader class methods by associating uploaded files with current object

  // UPLOAD A SINGLE FILE TO FOLDER AND ASSOCIATE UPLOADED FILE WITH CURRENT OBJECT
  /*  Extends the Uploader class methods
      On successfull file upload, sets the current objects image_field property to the uploaded files name, 
      associating the uploaded file with the current object
      If file does not upload due to errors, retrieves error messages from the Uploader class and adds them to
      current objects errors array
      Returns true on successful file upload, false otherwise
  */
  public function uploadFile(){ 
      $file = new Uploader($this->uploadPath, $_FILES[$this->image_field], $this->image_field);
      if($file->upload()){
        $this->{$this->image_field} = $file->getFileName();
        return true;
      }else{ 
        $uploadErr = $file->getErrors(); 
        foreach($uploadErr as $error){
            $this->addErrorMessage($error[0], $error[1]);
        }
        return false;
      }
  }

  // DELETES A SINGLE FILE FROM FOLDER
  // Accepts as optional arguments the path to file to be deleted and that files name
  // If path to file is not passed as argument, uses the current object 'uploadPath' property's value as path to file
  // If filename is not passed as argument, uses the name of the file associated with the current object
  // Returns true on successful file delete, false otherwise
  public function deleteFile($path = "", $filename = ""){
      $path = $path ? $path : $this->uploadPath;
      $filename = $filename ? $filename : $this->{$this->image_field};
      if(Uploader::deleteFile($path, $filename)){
          return true;
      }
      return false;
  }

  // UPLOAD MULTIPLE FILES TO FOLDER
  // Returns an array with uploaded file names and the upload errors.
  public function uploadFiles($files, $filenamePrefix = ''){
    $result = Uploader::uploadMultiple($this->uploadPath, $files, $filenamePrefix);
    return $result;   
  }

  //RETURNS OBJECTS FEATURED IMAGE URL OR A URL FOR DEFAULT NO-IMAGE DISPLAY
    public function displayImage(){
      if($this->{$this->image_field} && file_exists(ROOT.DS.$this->uploadPath.DS.$this->{$this->image_field})){
        $imgurl =  PROOT.$this->uploadPath.DS.$this->{$this->image_field};
      }else{
        $imgurl =  PROOT.DS.'images'.DS.'no-image.jpg';
      }
      return $imgurl;
  }
    
  // MODEL CLASS HELPER METHODS
  
  // ASSIGN VALUES TO THE OBJECT DYNAMICALLY
  // Used in cotrollers to dynamically assign values from request obejct to specific object properties.
  // Requires as argument an array of key=>value pairs, where each key corresponds to the property name of the current object
  // For each key of the arguments array, finds the corresponding object property and assigns that property the value of the key form arguments array.   
  // Returns true on success, false if the arguments array if empty
  public function assign($params){
      if(!empty($params)){
          foreach($params as $key => $val){
              if(property_exists($this, $key)){
                  $this->$key = $val;
              }
            }
          return true;
      }
      return false;
  }

  // RETURN AN ARRAY OF OBJECT PROPERTIES WITH VALUES READY FOR INSERTING TO DB
  // Prepares object data for inserting to db.
  /* Extracts the properties (with values) from the object that correcpond to db columns in a table associated with
     that objects model class and removes all additional object properties do not correscpond to db table columns.
  */
  // Returns an associative array of properties with values ready to pass to the insert and update methods
  public function getFieldData(){
    $fields = [];
    $properties = Helpers::getObjectProperties($this);
    foreach($properties as $key => $value){
      if(in_array($key, $this->dbColumns)){
        $fields[$key] = Helpers::sanitize($value);
      }
    }
    return $fields;
  }
  
  // RETURN AN ARRAY OF SPECIFIED OBJECT PROPERTIES WITH VALUES TO BE UPDATED IN THE DB
  // Used to update only a few column values in a single record instead of updating the whole redords data
  // Requires an array of db column names which needs to be updated in the db, like ['price', 'discount'];
  // Extracts the required properties (with values) from the current object 
  // Returns an associative array of object properties to be updated with their values 
  // Returns all object properties corresponding to db columns if the properties array argument is empty or not passed
  public function getUpdateProperties($properties = []){
    $updateFields = [];
    $allFields = $this->getFieldData();
    if(is_array($properties) && count($properties) > 0){
      foreach( $allFields as $key => $value){
        if(in_array($key, $properties)){
          $updateFields[$key] = $value;
        }
      }
      return $updateFields;
    }else{
      return $allFields;
    }  
  }

  //SETS THE VALUES OF SPECIFIED DB COLUMNS TO NULL VALUE FOR A SINGLE RECORD
  //Requires as arguments record id and an array of column names 
  //Returns true on success, false otherwise
  protected function setNull($id, $columns = []){
    if(count($columns) <= 0 || !$id) return false;
    $updateString = "";
    foreach($columns as $column){
        $updateString .= $column.' = NULL, ';
    }
    $updateString = rtrim($updateString, ', ');
    $sql = "UPDATE {$this->_table} SET {$updateString} WHERE id = {$id} limit 1";
    if($this->_db->query($sql)){
        return true;
    }
    return false;
  }

  // VALIDATION METHODS 

  // GENERAL VALIDATOR
  // Each extending class must have its own validator() method that will override this one  
  // Incorporates all single validations into a one validation method, all validations are executed when this method is called.
  public function validator(){}

    // RUNS SINGLE VALIDATION RULE OF A SINGLE VALIDATION FIELD 
    // Each model must have its own runValidation methods that will override this one  
    // Requires as argument an instance of specific validator class
    // Sets the validation field and the error message if its returned from specific validator class
    // Sets the _validates property to false failing the validation if any errors exist in validation
    // Validation rules are set in each specific validator class 
    public function runValidation($validator){
      $key = $validator->field;
      $msg = $validator->msg;
      if(!$validator->success){  
        $this->_validates = false;
        // Get all validation errors from all custom validators
        if(!array_key_exists($key, $this->_validationErrors)){
          $this->_validationErrors[$key] = [$msg];
        }else{
          array_push($this->_validationErrors[$key], $msg);
        }
      }
    }  
  
    // RETURN VALIDATION RESULT
    // Returns true if validation passes, false otherwise
    public function validationPassed(){
      return $this->_validates;
    }
  
    //RETURN AN ARRAY OF VALIDATION ERRORS
    // Returs an array of validation errors, using the first error of each field as field error
    // Returns an empty array if there are no validation errors
    public function getErrorMessages(){
      if(!empty($this->_validationErrors)){
        $firstErrors = [];
        foreach($this->_validationErrors as $field =>$error){
          $firstErrors[$field] = $error[0];
        }
        $this->_validationErrors = $firstErrors;
      }   
      return $this->_validationErrors;
    }
  
    // SET A VALIDATION ERROR MANUALLY
    // Requires as params the validation field and the error message
    // Sets the _validates method on current object as false and adds a specified error into the validation error array
    // Returns void
    public function addErrorMessage($field, $msg){
        $this->_validates = false;
        //$this->_validationErrors[$field] = $msg;
        if(!array_key_exists($field, $this->_validationErrors)){
          $this->_validationErrors[$field] = [$msg];
        }else{
          array_push($this->_validationErrors[$field], $msg);
        }
    }
  
    /* 
    VALIDATION DOCUMENTATION:
    Define Validator:
    - Create a validator() method in each model class 
    - Add runValidation() method for each separate validation rule. All runValidation methods must be called inside() 
      a validator method
    - In each runValidation() method, instantiate a requires custom validator class, by passing as arguments the model 
      class and an assoc array with 'field' and 'msg' keys
    Validator Definition Syntax in model class:
        public function validator(){
          $this->runValidation(new ReqValidator($this, ['field'=>'name', 'msg' => 'Name is required.']));
        }
    Perform Validation:
    - To validate the request data, first call the validator() method on an object to run all validations
    - Then call the validationPassed() method on an object to get the validation result
    - To display validation errors, call the getErrorMessages() on an object
    */ 


}




