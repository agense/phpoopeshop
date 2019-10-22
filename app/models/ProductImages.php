<?php 
class ProductImages Extends Model{
	protected $dbColumns = [
    'id', 
    'product_id',
    'product_image'
  ];
	public $uploadPath = UPLOAD_PATH.'product_images';
	public $filenamePrefix = "product";
	protected $uploadedImages = NULL;
  protected $uploadErrors = NULL;

	public function __construct(){
		$table = 'product_images';
		parent::__construct($table);
	}

  // SAVE MULTIPLE PRODUCT IMAGES FOR SINGLE PRODUCT TO FOLDER AND THEIR URLS TO DB 
  // Requires two arguments: product id and the files array
  // Return the object itself. Additional methods can be called following this object.
  public function saveFiles($productId, $files){
        $this->uploadErrors = NULL;
        $this->uploadedImages = NULL;
        $uploaddata = [];

        // Get the result from file uploader
        $res = $this->uploadFiles($files, $this->filenamePrefix);

        // Upload files to database
        if($res["uploaded_files"] && is_array($res["uploaded_files"])){  
          $i = 0;    
          foreach($res["uploaded_files"] as $file){
            $fields = [
              'product_id' => $productId,
              'product_image' => $file
            ];
            if($this->insert($fields)){
                $imgid = $this->_db->lastId();
                $uploaddata[$i]['id'] = $imgid;
                $uploaddata[$i]['product_image'] = $file;
            }
            $i++;
          }
          $this->uploadedImages = $uploaddata;
        }
        // If errors exist, return errors
        if($res["upload_errors"]){
          $this->uploadErrors =  $res["upload_errors"];;
        }
        return $this;
  }

  // RETURN UPLOADED IMAGES
  // Returns an array of uploaded files where image id is the key, and image source is the value
  public function get_uploaded_files(){
    return $this->uploadedImages;
  }  

  // RETURN UPLOAD ERRORS RECEIVED BY THE UPLOADER CLASS
  public function get_upload_errors(){
    return $this->uploadErrors;
  }  

  // RETURN UPLOAD ERRORS FORMATTED AS HTML MESSAGE
  public function get_formatted_errors(){
    $msg = "<strong>Upload failed for files: </strong><br />";
    foreach($this->uploadErrors as $errKey => $errVal){     
          $msg .= "<strong>".$errKey. "</strong><br/>";
          foreach($errVal as $err){
              $msg .= "- ".$err[1].". <br/>"; 
          }
    }
    return $msg;
  }      

  // RETURN AN ARRAY OF IMAGES FOR SINGLE PRODUCT BY PRODUCT ID
  // Requires product id as argument
  // Returns an array of objects of product_images class
  public function findProductImages($productId){
    $sql = "SELECT * FROM product_images WHERE product_id = ?";
    $bind = [intval($productId)];
    $images = $this->query($sql, $bind)->results(); 
    return $images;
  }

  // RETURN AN ARRAY OF IMAGE URLS FOR SINGLE PRODUCT BY PRODUCT ID
  // Requires product id as argument
  // Returns an array of urls for single product images. Used in product image sliders.
  public function getImageSources($productId){
    $images= self::findProductImages($productId);
    $imgArr = [];
    foreach($images as $image){
      $imgArr[] = $image->product_image;
    }
    return $imgArr;
  }

  // DELETE A SINGLE PRODUCT IMAGE FROM FOLDER AND ITS URL FROM DB
  // Requires image id as argument
  // Returns true on success, false otherwise
  public function deleteImage($imgId){
    $image = $this->findById($imgId);
    if($image){
      if($this->deleteFile($this->uploadPath, $image->product_image)){
        //delete file from product images table table
        $this->_db->delete($this->_table, $imgId);
        return true;
      } 
    }
    return false;
  }
}
