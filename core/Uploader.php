<?php
class Uploader{
// THE FILE UPLOAD HELPER CLASS

  private $_errors = [];	
  // Properties of the files on upload 
  public $fileName, $type, $tmpLocation, $size, $fileError;	
  // Additional properties and default values
  private $fileExt, $maxSize = 1500000, $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
  // Set internally
  private $uploadPath, $finalFileName, $fullUploadPath, $customFileName;

  public $phpFileUploadErrors = array(
      1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
      2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
      3 => 'The uploaded file was only partially uploaded',
      4 => 'No file was uploaded',
      6 => 'Missing a temporary folder',
      7 => 'Failed to write file to disk.',
      8 => 'A PHP extension stopped the file upload.',
  );

  // CLASS CONSTRUCTOR 
  // Requires two arguments: file upload path and the uplaoding file data array 
  // Accepts an optional thrird argument - a custom name for the uploaded file
  // Sets the properties of the current object, requires in class methods, including file upload path and file name 
  public function __construct($path, $file = null, $customFileName = ''){
    if($file && is_array($file)){
        $this->fileName = $file['name'];
        $this->type = $file['type'];
        $this->tmpLocation = $file['tmp_name'];
        $this->fileError = $file['error'];
        $this->size = $file['size'];
        $this->customFileName = $customFileName;
        $this->fileExt = pathinfo($this->fileName, PATHINFO_EXTENSION);
        $this->setFileName();
    }
    $this->uploadPath = $path;
    $this->fullUploadPath = ROOT.DS.$this->uploadPath.DS.$this->finalFileName;
  }

  // CHANGE FILE UPLOAD CONFIGURATIONS

  // SET ALLOWED FILE EXTENSIONS
  // Requires an array of valid file extensions that will be set as allowed
  public function setAllowedExtensions($extensions = []){
    $this->allowedExtensions = $extensions;
    return $this;
  }

  // RETURN ALLOWED FILE EXTENSIONS
  public function getAllowedExtensions(){
    return $this->allowedExtensions;
  }

  // SET MAX SIZE FOR UPLOADING FILES
  public function setMaxSize($max){
    $this->maxSize = $max;
    return $this;
  }

  // RETURN MAX SIZE ALLOWED FOR UPLOADING FILES
  public function getMaxSize(){
    return $this->maxSize;
  }

  // VALIDATOR 
  // Validates file before upload
  // If any errors are found, each is added as error into the errors(array) property of this class
  // Returns true if validation passed, false otherwise 
  public function validateFile(){
    // Check uploaded errors	
    if($this->fileError){
        if(array_key_exists($this->fileError, $this->phpFileUploadErrors)){
            $this->addError(['PHP Upload Error',$this->phpFileUploadErrors[$this->fileError]]);
        }   
    }else{
        // Check if file was uploaded via the form
        if(!is_uploaded_file($this->tmpLocation)){
            $this->addError(['File Upload', "File uploading failed. Please upload the file again."]);
          }	
        // Check extension
        if(!in_array($this->fileExt, $this->allowedExtensions)){
            $allowed = implode(', ', $this->allowedExtensions);
            $this->addError(['File Extension',"Uploading this type of file is not allowed. Allowed file extensions are ".$allowed]);
          }
        // Check size
        if($this->size > $this->maxSize){
            $this->addError(['File Size',"The file size must be up to ".$this->maxSize]);
        }
        // Check if upload folder exists
        if(!file_exists($this->uploadPath)){
            $this->addError(['Admin Error',"The chosen upload directory does not exist."]);
        }
    } 
    if(!$this->_errors){
        return true;
    } 
    return false;	
  }

  // UPLOAD FILE TO A SPECIFIED FOLDER
  // Return true on success, false otherwise
  public function upload(){
    if($this->validateFile()){
      if(move_uploaded_file($this->tmpLocation, $this->fullUploadPath)){
          return true;
      }else{
          $this->addError(['Upload Error','File Upload Failed']);
          return false;
      }
    }
    return false;
  }

  // SET UPLOAD ERRORS
  // Requires one argument, the current error.
  // The error being added which be an array containing the error name and the error message
  // Adds all upload errors from validation method to the _errors property, returns nothing.
  public function addError($error){
    $this->_errors[] = $error;
  }

  // RETURN UPLOAD ERRORS ARRAY
  public function getErrors(){
      return $this->_errors;
  }

  // CONSTRUCT AND RETURN A UNIQUE NAME FOR EACH FILE
  private function setFileName(){
    if($this->customFileName !== ''){
      $prefix = $this->customFileName.'_';
      $this->finalFileName = uniqid($prefix).'.'.$this->fileExt;
    }else{
    $this->finalFileName = basename($this->fileName, ".".$this->fileExt ).md5(microtime()).'.'.$this->fileExt;
    }  
  }

  // RETURN UPLOADED FILE NAME
  public function getFileName(){
    return $this->finalFileName;
  }

  // DELETE UPLOADED FILE FROM FOLDER
  // Requires as arguments the file path(starting after the root and ending before filename) and the filename
  // Returns true on successfull file delete, false otherwise
  public static function deleteFile( string $path = '', string $filename = ''){
    if($path == '' || $filename =='' || !file_exists($path.DS.$filename)) {
        return false;
    }else{
        $fullpath = ROOT.DS.$path.DS.$filename;
        unlink($fullpath);
        return true;
    }
  }

// UPLAOD MULTIPLE FILES TO A FOLDER AT ONCE
// Requires two arguments: file upload path and the array of files to be uploaded
// The files array must contain a multidimentional array of files, where each file is an object with its upload data
// If the files array is not reformatted from standard $_FILES format to the above required format, use the formatArray function to transform it
// The array comes formatted already from ajax requests
// Returns an array with uploaded file names and the upload errors.
  public static function uploadMultiple(string $path, $files, string $filename = ''){
    $fileAry = $files;
    $filenames = array();
    $uploadErrors  = array();
    $uploadResult = array();
    
    foreach($fileAry as $file){
          $singlefile = new Uploader($path, $file, $filename);
          if($singlefile->upload()){
            $filenames[] = $singlefile->getFileName();
          }else{
            $uploadErrors[$file['name']] = $singlefile->getErrors(); 
          }
    }
    $uploadResult['upload_errors'] = $uploadErrors;
    $uploadResult['uploaded_files'] = $filenames;
    return $uploadResult;
  }

  // RETURN A TRANSFORMED $_FILES ARRAY
  // Format the $_FILES array to an array where each file is an object with its upload data attached
  // Requires the $_FILES array as argument
  public static function formatArray($files){
    $newAry = array();
    $counter = count($files['name']);
    while($counter > 0){
      $filesNewArr = array();
      foreach($files as $file => $value){
        $i = $counter-1;
        $filesNewArr[$file] = $value[$i];
        $i--;
      }  
      $newAry[] = $filesNewArr;
      $counter--;
    }
    return $newAry;
  }
}
