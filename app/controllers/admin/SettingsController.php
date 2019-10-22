<?php
class SettingsController extends Controller{
	public function __construct($controller, $action){
		parent::__construct($controller, $action);

		$this->load_model('Settings');
		$this->view->setLayout('admin_default');
	}

	// UPDATE CONTACT INFO SETTINGS
	public function contactInfoAction(){
		$settings = new Settings();
		$contactSettings = $settings->getContactSettings();
		 if($this->request->isPost()){
            $this->request->csrfCheck();
            if($settings->setContactInfo($this->request->get())){
               Session::addMsg('success', 'Settings have been saved.');
               Router::redirect('admin/settings/contactInfo');
            }else{
               Session::addMsg('danger', $settings->getErrors()[0]);
               Router::redirect('admin/settings/contactInfo');
            }  
        }
		$this->view->settings = $contactSettings;
		$this->view->render('admin/settings/contact-info');
	}

	// UPDATE SOCIAL MEDIA SETTINGS
	public function socialMediaAction(){
		$settings = new Settings();
		$socialMediaSettings = $settings->getSocialMediaSettings();

		if($this->request->isPost()){
            $this->request->csrfCheck();
        	if($settings->setSocialMediaSettings($this->request->get())){
               Session::addMsg('success', 'Settings have been saved.');
               Router::redirect('admin/settings/socialMedia');
            }else{
               Session::addMsg('danger', $settings->getErrors()[0]);
               Router::redirect('admin/settings/socialMedia');
            } 
        }
		$this->view->settings = $socialMediaSettings;
		$this->view->render('admin/settings/social-media');
	}
}	