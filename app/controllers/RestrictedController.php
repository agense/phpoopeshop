<?php
class RestrictedController extends Controller{
	
	public function __construct($controller, $action){
		parent::__construct($controller, $action);
	}
	
	// DISPLAY RESCTRICTED ACCESS PAGE
	public function indexAction(){
        $this->view->render('restricted/index');
	}

	// DISPLAY UNAUTHORIZED ACTION PAGE 
	public function unauthorizedAction(){
		$this->view->render('restricted/unauthorized');
	}
}