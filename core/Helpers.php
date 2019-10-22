<?php 
class Helpers{
// HELPER METHODS

  // DEBUGGING HELPER 
  // Dumps the data passed and stops the code execution. 
  public static function dnd($data){
      echo '<pre>';
      var_dump($data);
      echo '</pre>';
      die();
  }

  // OBJECT PROPERTIES SETTER HELPER
  // Requires an object as argument
  // Gets all the properties of the object passed as argument and returns them as an array
  // Returns an array of object properties
  public static function getObjectProperties($obj){
    return get_object_vars($obj);
  }


  // SANITIZATION AND ENCODING HELPERS

  // CODE SANITIZATION
  // Accepts a single value or an array of values
  // Returns sanitized value or array of values based on argument type 
  public static function sanitize($input){
    if(!is_array($input)){
      return htmlentities($input, ENT_QUOTES, 'UTF-8');
    }else{
      $newarr = [];
      foreach($input as $field => $value){
          $newarr[htmlentities($field,ENT_QUOTES, 'UTF-8')] = htmlentities($value,ENT_QUOTES, 'UTF-8');
      }
      return $newarr;
    }
  }

  // ENCODE TEXT CONTENT FROM SUMMERNOTE EDITOR AND REMOVE SCRIPT TAGS
  // Requires string as argument
  // Reurns encoded string 
  public static function encodeContent(string $input){
    //Remove script tags
    $clean = preg_replace('/script.*?\/script/ius', '', $input)
     ? preg_replace('/script.*?\/script/ius', '', $input)
      : $input;
      return htmlentities($clean, ENT_QUOTES, 'UTF-8');
  }

  // DECODE CODE ENCODED IN HTML ENTITIES
  // Requires encoded string as argument
  // Reurns decoded string 
  public static function decodeContent(string $input){
      return htmlspecialchars_decode(html_entity_decode(html_entity_decode($input)));
  }

  // CODE SANITIZATION FOR NUMERIC ARRAYS
  // Accepts a numeric array as argument
  // Returns sanitized numeric array
  public static function sanitizeIntvalArray($input){
    if(!is_array($input)) return false;
    $clean = [];
    foreach($input as $value){
      $clean[] = intval($value);
    }
    return $clean;
  }

  // SANITIZE AN ARRAY OF $_POST SUPERGLOBAL VALUES
  // Requires an array of $_POST superglobal values as argument
  // Returns sanitized array of values
  public static function posted_values($post){
      $sanArray = [];
      foreach($post as $key => $value){
        $sanArray[$key] = self::sanitize($value);
      }
      return $sanArray;
  }

  // ENCODE ARRAYS TO JSON FORMAT
  // Requires an array as argument
  // Returns a json encoded string
  public static function stringify($arr){
    return json_encode($arr);
  }

  // DECODE JSON/HTML_ENTITY STRINGS
  // Requires a json encoded string as argument
  // Returns a decoded version of string encoded in json and html_encoding
  public static function decode(string $string){
      $string = stripslashes(html_entity_decode($string));
      return json_decode($string);
  }


  // PRICE CALCULATION AND FORMATTING HELPERS

  // PRICE DEDUCTION CALCULATOR 
  // Requires an initial price and deduction as arguments
  // Returns a reduced price as float rounded to two decimals
  public static function countAmount($initial, $deduction){
    if(!$initial || !is_numeric($initial) || !$deduction || !is_numeric($deduction)){
      return NULL;
    }elseif($deduction == 0){
      return "0";
    }else{
      return round(($initial - $deduction), 2, PHP_ROUND_HALF_UP);
    }
  }

  // PERCENTAGE CALCULATOR
  // Used in calculating the price discount as percentage of initial price
  // Requires as arguments two float or integer values
  // Returns a numeric value (float or integer) as percentage of one value in another
  public static function countPercent($initial, $amount){
    if(!$amount || !is_numeric($amount) || $amount == 0){
      return NULL;
    }else{
      return $amount * 100 / $initial;
    }
  }

  // PRICE FORMATTING HELPER
  // Requires a numeric value as argument
  // Uses a constant set in config file for currency display
  // Returns a number formatted as price with attached currency specifier
  public static function formatPrice($price){
    return CURRENCY.'&nbsp;'.number_format($price, 2);
  }


  // DATE HELPERS

  // DATE FORMATTING HELPER
  // Requires a valid date string as argument
  // Returns a date in specified format. Return type is string
  public static function formatDate($date){
    return date( 'Y-m-d', strtotime($date));
  }

  // NEW PRODUCTS DISPLAY HELPER
  // The return value is used in database queries to find new products for new product display
  /*
   Uses a NEW_ITEMS_TRESHOLD constant set in config file as a value for the number of days for which the product 
   should be displayed as new from its upload date.
   Dynamically calculates the date that goes back from the current date the number of days set in NEW_ITEMS_TRESHOLD 
   constant.
   Formats the date calculated into a format suitable for database searches.
   Returns a formated date string
   */
  public static function getThresholdDate(){
    $now = new DateTime();
    $intervalString = 'P'.NEW_ITEMS_TRESHOLD.'D';
    $interval = new DateInterval($intervalString);
    $now->sub($interval);
    return $now->format("Y-m-d H:i:s");
  }
   
  // NEW PRODUCTS DISPLAY HELPER
  // Used in new product display to define if a specific product should be displayed as new or not
  // Checks if products upload date falls into a timeframe set for the product to be displayed as new
  // Required a valid date string as argument
  // Returns true if the upload date falls inside the timeframe set by NEW_ITEMS_THRESHOLD constant, false otherwise 
  public static function checkNew($date){
    if(!$date || ! is_string($date)) return false;
    $now = new DateTime();
    $date = new DateTime($date);
    $difference = $now->diff($date)->days;
    if($difference < NEW_ITEMS_TRESHOLD){
        return TRUE;
    }
    return FALSE;
  }

  
  // CONTENT DISPLAY HELPERS

  // GRID DISPLAY HELPER FOR CATEGORIES IN LANDING PAGE
  public static function checkOdd($number){
    if(!$number) return false;
    if(intval($number)%2){
      return true;
    }
    return false;
  }

  // GRID DISPLAY HELPER FOR CATEGORIES IN LANDING PAGE
  public static function setGrid($items, $counter){
    if(!$items || !$counter) return false;
    if(intval($items)%intval($counter) == 0){
      return true;
    }
    return false;
  }

  // SLUGS CREATOR HELPER
  // Requires a string representing a name as argument
  // Returns a slug in string format
  public static function createSlug($name){
    if(!$name || !is_string($name)) return FALSE;
      $name = trim(strtolower($name));
      // Make alphanumeric (removes all other characters)
      $name = preg_replace("/[^a-z0-9_\s-]/", "", $name);
      // Clean up multiple dashes or whitespaces
      $name = preg_replace("/[\s-]+/", " ", $name);
      // Convert whitespaces and underscore to dash
      $name = preg_replace("/[\s_]/", "-", $name);
      return $name;
  }
}