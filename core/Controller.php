<?php
class Controller extends Application {
// THE MAIN CONTOLLER CLASS EXTENDED BY ALL OTHER CONTROLLERS

	protected $_controller, $_action;
	public $view, $request;
    
	// CONSTRUCTOR METHOD
	// Called by any extending controller class, which is called by the router class
	// Accepts a controller and an action method, which comes in dynamically from the router
	// Instantiates automatically an input and view classes
	public function __construct($controller, $action){
		parent::__construct();
		$this->_controller = $controller;
		$this->_action = $action;

		$this->request = new Input();
		$this->view = new View();
	}
    
	// CREATES AN OBJECT FROM THE RECEIVED MODEL CLASS
	// Accepts model name as argument
	/* Used in each controller to load corresponding model.
	Constructs model class name from received argument and instantiates an object of specified model's class.
	This allows access to this model object inside any controller, so models methods can be called inside any controller
	on this object directly without needing to instantiate a models object first.
	Syntax example to use in controllers: $this->TestModel->TestModelsMethod().
	*/
	protected function load_model($model){
		if(class_exists($model)){
           $this->{$model.'Model'} = new $model(strtolower($model));
		}
	} 
	
	// FORMAT A JSON RESPONSE WITH HEADERS 
	public function jsonResponse($response){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code(200);
        echo json_encode($response);
        exit;
	}

}