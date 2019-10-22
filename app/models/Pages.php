<?php 
class Pages extends Model{ 
  public $uploadPath = UPLOAD_PATH.'page_images';
  protected $dbColumns = [
    'id',
    'title', 
    'slug', 
    'intro', 
    'content', 
    'page_type', 
    'in_menu'
  ];
  protected $page_types = [
      "Standard Page" => 1,
      "Terms & Conditions" => 2
  ];

  public function __construct(){
      $table = 'pages';
      parent::__construct($table);
	}  

  // RETURN PAGES TYPES PROPERTY
  public static function getPageTypes(){
      $self = new static;
      return $self->page_types;
  }

  // RETURN CURRENT OBEJCTS PAGE TYPE FROM PAGE TYPE PROPERTIES
  public function getPageType(){
      foreach($this->page_types as $key => $value){
        if($this->page_type == $value){
            return $key;
        }
      }
  }
  
  // RETURN PAGES FOR FOOTER BY PAGE TYPE
  // Requires page type as argument
  // Returns an array of objects of Page class
  public static function getStandardPages($type){
      $type = intval($type);
      $self = new static;
      return $self->find(['conditions'=>['page_type = ?', 'in_menu'], 'bind' =>["{$type}", 1]]);    
  }

	// VALIDATOR
	// Perform validation when creating/updating pages
      public function pageValidator(){
      $this->runValidation(new ReqValidator($this, ['field'=>'title', 'msg' => 'Title is required.']));
      $this->runValidation(new UniqueValidator($this, ['field'=>'title', 'msg' => 'This title already exists. Page titles must be unique']));
      $this->runValidation(new MaxValidator($this, ['field'=>'title', 'rule'=>80, 'msg' => 'Title must be less than 80 characters']));
      $this->runValidation(new AlphaNumValidator($this, ['field'=>'title', 'msg' => 'Title can only contain letters, numbers and spaces']));
      if(isset($this->intro)){
        $this->runValidation(new MaxValidator($this, ['field'=>'intro', 'rule'=>200, 'msg' => 'Intro must be less than 200 characters']));
      }
      $this->runValidation(new ReqValidator($this, ['field'=>'content', 'msg' => 'Content is required.']));
      $this->runValidation(new ReqValidator($this, ['field'=>'page_type', 'msg' => 'Page type is required.']));
      $this->runValidation(new NumericValidator($this, ['field'=>'page_type', 'msg' => 'Page type is incorrect.']));
  }

  // DELETE IMAGE
  // Requires as argument full image url
  // Deletes the image from folder
  // Returns true on success, false otherwise
  public function deleteEmbeddedImage(string $src){
    if(!$src) return false;
    if(strrchr($src, '\\')){
      $fileArr = explode('\\', $src);
    }else{
      $fileArr = explode('/', $src);
    }
    $filename = array_reverse($fileArr)[0];
    $path = $this->uploadPath.DS;
    if(Uploader::deleteFile($path, $filename)){
      return true;
    }else{
      return false;
    }
  }

}