<?php
class NotFoundController extends Controller{
	
	public function __construct($controller, $action){
		parent::__construct($controller, $action);
	}
	
	// DISPLAY NOT FOUND PAGE
	public function indexAction(){
        $this->view->render('404');
	}
}