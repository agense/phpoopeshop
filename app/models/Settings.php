<?php
class Settings{
	protected $contactSettingsfile = SETTINGS_FOLDER."contact_settings.json";
   protected $socialMediaSettingsfile = SETTINGS_FOLDER."social_media_settings.json";
   protected $errors = [];
	public $contact_info;
	public $social_media;


   // RETURNS THE ERRORS PROPERTY ON THE CURRENT SETTINGS OBJECT
	public function getErrors(){
		return $this->errors;
	}

   // ADD AN ERROR TO CURRENT SETTINGS CLASS OBJECT
   // Requies an error as an argument
	protected function addError($error){
        $this->errors[] = $error;
	}
    
   // CONTACT SETTINGS

   // RETURN CURRENT CONTCAT SETTINGS
   // Get the contents from the contact settings file.
   // Returns the settings data as object or false on error
	public function getContactSettings(){
		try{
			$settings = file_get_contents($this->contactSettingsfile);
 		   $this->contact_info = json_decode($settings);
		   return $this->contact_info;
		}catch(Exception $e){
            $this->addError($e->getMessage());
            return false;
		}
	}

   // UPDATE CONTACT SETTINGS
   // Requires an object containing the settings data as argument.
   // Writes updated settings into a file as JSON.
   // Returns true on successful settings file rewrite, false otherwise.
   public function setContactInfo($data){
      $this->errors = [];
     	
     $this->contact_info = new stdClass();
     if($data['email'] !== ""){
     	$this->contact_info->email = Helpers::sanitize($data['email']);
     }
     if($data['second_email'] !== ""){
     	$this->contact_info->second_email = Helpers::sanitize($data['second_email']);
     }
     if($data['phone'] !== ""){
     	$this->contact_info->phone = Helpers::sanitize($data['phone']);
     }
     if($data['second_phone'] !== ""){
     	$this->contact_info->second_phone = Helpers::sanitize($data['second_phone']);
     }
     if($data['address'] !== ""){
     	$this->contact_info->address = Helpers::sanitize($data['address']);
     }
     if($data['city'] !== ""){
     	$this->contact_info->city = Helpers::sanitize($data['city']);
     }
     if($data['region'] !== ""){
     	$this->contact_info->region = Helpers::sanitize($data['region']);
     }
     if($data['country'] !== ""){
     	$this->contact_info->country = Helpers::sanitize($data['country']);
     }
     if($data['postal_code'] !== ""){
     	$this->contact_info->postal_code = Helpers::sanitize($data['postal_code']);
     }
     $this->contact_info = json_encode($this->contact_info);
     if(!file_exists($this->contactSettingsfile)){
     	$this->addError("There was an error. Settings cannot be updated.");
        return false;
     }else{
        // Write json data into  file
	    if(file_put_contents($this->contactSettingsfile, $this->contact_info)){
	 	   return true;
	    }else{
           $this->addError("There was an error. Settings cannot be updated.");
           return false;
	    }
     }
    }
    
   // SOCIAL MEDIA SETTINGS

   // RETURN CURRENT SOCIAL MEDIA SETTINGS
   // Get the contents from the contact settings file.
   // Returns the settings data as object or false on error.
    public function getSocialMediaSettings(){
		try{
			$settings = file_get_contents($this->socialMediaSettingsfile);
 		    $this->social_media = json_decode($settings);
		    return $this->social_media;
		}catch(Exception $e){
            $this->addError($e->getMessage());
            return false;
		}
	}

   // UPDATE SOCIAL MEDIA SETTINGS
   // Requires an object containing the settings data as argument.
   // Writes updated settings into a file as JSON.
   // Returns true on successful settings file rewrite, false otherwise.
	public function setSocialMediaSettings($data){
	 $this->errors = [];
     	
     $this->social_media = new stdClass();
     if($data['facebook'] !== ""){
     	$this->social_media->facebook = Helpers::sanitize($data['facebook']);
     }
     if($data['instagram'] !== ""){
     	$this->social_media->instagram = Helpers::sanitize($data['instagram']);
     }
     if($data['twitter'] !== ""){
     	$this->social_media->twitter = Helpers::sanitize($data['twitter']);
     }
     if($data['pinterest'] !== ""){
     	$this->social_media->pinterest = Helpers::sanitize($data['pinterest']);
     }
     if($data['gplus'] !== ""){
     	$this->social_media->gplus = Helpers::sanitize($data['gplus']);
     }
     if($data['youtube'] !== ""){
     	$this->social_media->youtube = Helpers::sanitize($data['youtube']);
     }
     if($data['tumblr'] !== ""){
     	$this->social_media->tumblr = Helpers::sanitize($data['tumblr']);
     }
     $this->social_media = json_encode($this->social_media);

     if(!file_exists($this->socialMediaSettingsfile)){
     	$this->addError("There was an error. Settings cannot be updated.");
        return false;
     }else{
        // Write json data into  file
	    if(file_put_contents($this->socialMediaSettingsfile, $this->social_media)){
	 	   return true;
	    }else{
           $this->addError("There was an error. Settings cannot be updated.");
           return false;
	    }
     }
	}
}