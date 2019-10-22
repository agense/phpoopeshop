<?php
class DB{
// CORE DATABASE CLASS EXTENDED BY THE CORE MODEL CLASS
// PROVIDES METHODS FOR DATABASE OPERATIONS
// USES PDO CONNECTION TO MYSQL DATABASE AND SINGLETON PATTERN FOR DB CONNECTION INSTANCE
// !!! NOTE, THE USE OF THIS CLASS REQUIRES THAT THE DATABASE CREDENTIALS ARE SET IN THE config FILE.

   private static $_instance = null;
   private $_pdo, $_query = null, $_result = null, $_error = false, $_count = 0, $_lastInsertID = null;

   // INSTANTIATE THE DB CONNECTION OR DIE
   private function __construct(){
   	try{
   		$this->_pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
      $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
   	}catch(PDOException $e){
       die($e->getMessage());
   	}
   }
  
   // RETURN AN INSTANCE OF DB CLASS USING THE SINGLETON PATTERN
   public static function getInstance(){
   	  if(!isset(self::$_instance)){
   	  	self::$_instance = new DB();
   	  }
   	  return self::$_instance;
   }

   // MAIN QUERY METHOD AND QUERY PARAM BINDING
   // Requires as arguments the sql statement with placeholders and the array of params
   // Accepts as an optinal argument the name of the model class to be used as return object
   // Binds the params provided to the sql statement and performs the db query.
   // If model class is provided, fetches the results received into the model class provided, otherwise fetches the results as object
   // Assigns the results received to the _result property
   // If an error occurs, sets the _error property's value to true
   // Sets the values for $_result, $_count and $_lastInsertID properites of the class
   // Returns the object itself
   public function query($sql, $params = [], $class = false){
   	  $this->_error = false;
   	  if($this->_query = $this->_pdo->prepare($sql)){
   	    $x = 1;
   	    if(count($params)){
   	    	foreach($params as $param){
             $this->_query->bindValue($x, $param);
             $x++;
   	    	}
   	     }
   	    if($this->_query->execute()){
          if($class){
            $this->_result = $this->_query->fetchAll(PDO::FETCH_CLASS, $class);
          }else{
            $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
          }
   	    	$this->_count = $this->_query->rowCount();
          $this->_lastInsertID = $this->_pdo->lastInsertId();
   	    }else{
   	    	$this->_error = true;
   	    }
   	  }
   	 return $this;
   }  

   
  //FIND METHODS

   // HELPER FUNCTION FOR FIND METHODS
   // Reads params array and formats appropriate param string based on conditions, limit and order values if passed
   // Performs the sql query based on params given and uses the query method to set the $_result property
   // Returns true on success, false otherwise
   public function read($table, $params=[], $class){
   	$conditionStr = '';
   	$bind = [];
   	$order = '';
   	$limit = '';
   	// create a condition
   	if(isset($params['conditions'])){
   		if(is_array($params['conditions'])){
   			foreach($params['conditions'] as $condition){
            $conditionStr .= ' '.$condition.' AND';
   			}    
   	    $conditionStr = trim($conditionStr); 		
   	    $conditionStr = rtrim($conditionStr, ' AND');
   		}elseif (is_string($params['conditions'])) {
   			$conditionStr = $params['conditions'];
   		}

    if($conditionStr != ''){
    	$conditionStr = ' WHERE '.$conditionStr;
      }
   	}
   	// get the params
   	if(array_key_exists('bind', $params)){
       $bindingValues = $params['bind'];
   	}else{
       $bindingValues = [];
    }
   	// set order
   	if(array_key_exists('order', $params)){
       $order = ' ORDER BY '.$params['order'];
   	}
   	// set limit
    if(array_key_exists('limit', $params)){
       $limit = ' LIMIT '.$params['limit'];
   	}
    // construct the dynamic sql statement
    $sql = "SELECT * FROM {$table}{$conditionStr}{$order}{$limit}";
    if($this->query($sql, $bindingValues, $class)){
    	if(!count($this->_result)){
        return false;
    	}
    	return true;
    }
    return false;
   }

   // RETURN THE RESULTS FOR MULTIPLE RECORDS QUERY BASED ON PARAMS PASSED
   // Gets multiple records in specified db table based on conditions passed as params
   // Requires the table name(string) and the paremas array as arguments
   // Accepts as an optinal argument the name of the model class to be used as return object
   // Uses the read method and the results method of the current class, which returns $_result property
   // Returns $_result property, i.e. the array of results.
   public function find($table, $params=[], $class = false){
      if($this->read($table, $params, $class)){
      	  return $this->results();
      }
      return false;
   }

   // RETURN THE RESULTS FOR SINGLE RECORD QUERY BASED ON PARAMS PASSED
   // Gets a single record in specified db table based on conditions passed as params
   // Requires the table name(string) and the paremas array as arguments
   // Accepts as an optinal argument the name of the model class to be used as return object
   // Uses the read method and the first method of the current class, which gets the first row in all matched records
   // Returns a single row of results as an object.
   // If model class argument is passed, returns results as instance of that class
   public function findFirst($table, $params=[], $class = false){
      if($this->read($table, $params, $class)){
      	  return $this->first();
      }
      return false;
   }

  // RETURNS A SINGLE(FIRST) LINE FROM $_result variable. 
  // Returns single database record.  
   public function first(){
      return (!empty($this->_result)) ? $this->_result[0] : [];
   }


  // OTHER DB CRUD METHODS
   
  // INSERTS DATA INTO DB TABLE
  // Requires as arguments the db table name and an array of db fields(as a key value pair of db column name and value to be inserted)
  // Returns true on success, false otherwise
   public function insert($table, $fields = []){
        $fieldStr = '';
        $valStr = '';
        $values = [];

        foreach($fields as $field => $value){
          $fieldStr .= '`'.$field.'`,';
          $valStr .= '?,';
          $values[] = $value;
        }
        
        $fieldStr = rtrim($fieldStr, ',');
        $valStr = rtrim($valStr, ',');

        $sql = "INSERT INTO {$table} ({$fieldStr}) VALUES ({$valStr})";
        if(!$this->query($sql, $values)->error()){
        	return true;
        }
        return false;
   }

  // UPDATES DATA IN DB TABLE 
  // Unique identifier $id is a required parameter, along with db table name and an array of db fields to be updated.
  // The db fields array must contain key value pairs of db column names and values to be inserted
  // Returns true on success, false otherwise
  public function update($table, $id, $fields = []){
	   	$fieldStr = '';
	    $values = [];
	   	foreach($fields as $field => $value){
	   		$fieldStr .= ' '.$field.' =?, ';
            $values[] = $value;
	   	}
	   	$fieldStr = trim($fieldStr);   // remove spaces around
	   	$fieldStr = rtrim($fieldStr, ','); // remove last comma

	   	$sql = "UPDATE {$table} SET {$fieldStr} WHERE id = {$id} LIMIT 1";
        if(!$this->query($sql, $values)->error()){
        	return true;
        }
        return false;
  }

  // UPDATE A SINGLE COLUMN IN THE DB TABLE
  // Requires as argument the db table name, the id of the table record, the name of column to be upldated and the value to be inserted into that column
  // Returns true on success, false otherwise
   public function updateSingle($table, $id, $fieldName, $fieldValue){
      $fieldStr = "{$fieldName} = ? ";
      $sql = "UPDATE {$table} SET {$fieldStr} WHERE id = {$id} LIMIT 1";
          if(!$this->query($sql, [$fieldValue])->error()){
          return true;
      }
      return false;
   }


   // HARD DELETE METHOD
   // Deletes single record from the db table based on record id
   // Requires the db table name and the record id as arguments
   // Returns true on success, false otherwise
   public function delete($table, $id){
   $sql = "DELETE FROM {$table} WHERE id = {$id} LIMIT 1" ;
   if(!$this->query($sql)->error()){
        	return true;
        }
        return false;
   }
  
  // RETURN THE RESULTS OF ANY QUERY, I.E. $_result PROPERTY'S VALUE
  public function results(){
   	  $results = $this->_result;
      $this->_result = null;
      return $results;
  }
  
  // RESET THE _result AND _query PROPERTY VALUES TO NULL
  public function clearResult(){
      $this->_result = null;
      $this->_query = null;
  }

  // RETURN THE NUMBER OF RECORDS IN THE RESULT SET, I.E. $_count PROPERTY'S VALUE
  public function count(){
      return $this->_count;
  }
   
  // RETURN THE VALUE OF THE LAST INSERTED ID, I.E. $_lastInsertID PROPERTY'S VALUE.
  // The returned value is an integer
  public function lastId(){
   	  return $this->_lastInsertID;
  }
   
  // RETURN THE QUERY ERRORS, I.E. $_error PROPERTY'S VALUE
  // The default is false
  public function error(){
      return $this->_error;
  }

  // COUNTER QUERY METHOD
  // Used to count the number of results matching specified params
  // Requires $sql statement(string) as argument
  // Accepts the params array as second optinal argument
  // Returns the result as an object on success, false otherwise
  public function countQuery($sql, $params = false){
      $query = $this->_pdo->prepare($sql);
      $x = 1;
      if($params && count($params) > 0){
        foreach($params as $param){
          $query->bindValue($x, $param);
          $x++;
        }
      }
      if($query->execute()){
        return $query->fetch(PDO::FETCH_OBJ);
      }else{
        return false;
      }
}  

}