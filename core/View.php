<?php
// THE CORE VIEW CLASS USED TO RENDER THE VIEWS FROM CONTROLLERS

class View {
	protected $_head, $_body, $_siteTitle = SITE_TITLE, $_outputBuffer, $_layout = DEFAULT_LAYOUT;

	public function __construct(){}

	// THE MAIN METHOD CALLED IN CONTROLLERS TO RENDER A VIEW
	// Requires as argument the path(string) to a view file, starting from the views folder, not including it
	// Example view render call in controller method: $this->view->render('admin/login');
	public function render($viewName){
		$viewArr = explode('/', $viewName);
		$viewStr = implode(DS, $viewArr);
		if(file_exists(ROOT.DS.'app'.DS.'views'.DS.$viewStr.'.php')){
           include(ROOT.DS.'app'.DS.'views'.DS.$viewStr.'.php');
           include(ROOT.DS.'app'.DS.'views'.DS.'layouts'.DS.$this->_layout.'.php');     
		}else{
			die('The view \"'.$viewName.'\"does not exist.');
		}
	}

	// RETURNS THE CONTENT TYPE 
	// Requires as argument the content type (either head or body)
	// This method must be called in the layout files to include the dynamic views into it
	// Example: $this->content('body'); - will include the body of each view inside the layout file.
	public function content($type){
		if($type == 'head'){
			return $this->_head;
		}elseif($type == 'body'){
			return $this->_body;
		}else{
			return false;
		}
	}

	// SETS THE STRAT OF OUTPUT BUFFER FOR CONTENT RENDERING
	// Requires as argument the content type (either head or body)
	// This method must be called in every view before the start of the content, like this: $this->start('head');
	public function start($type){
        $this->_outputBuffer = $type;
         ob_start();
	}

	// SETS THE END OF OUTPUT BUFFER FOR CONTENT RENDERING AND RENDERS THE CONTENT
	// This method must be called in every view after the end of the content, like this: $this->end();
	public function end(){
        if($this->_outputBuffer == 'head'){
        	$this->_head = ob_get_clean();
        }elseif($this->_outputBuffer == 'body'){
            $this->_body = ob_get_clean();
        }else{
        	die("You must first run the start method.");
        }
	}

	// SETS THE LAYOUT IN THE CONTROLLER FOR THE DISPLAY OF THE VIEWS RENDERED BY THAT CONTROLLER
	// Requires as argument the path(string) to a layout file, starting from the layouts folder, not including it
	// Example - set layout call in controller's constrictor: $this->view->setLayout('admin_default');
	public function setLayout($path){
        $this->_layout = $path;
	}
    
	// SET THE TITLE FOR SPECIFIC PAGE
	// Requires the title(string) as argument
	// Called in each view to set the title for the page that view contains
	public function setSiteTitle($title){
        $this->_siteTitle = $title;
	}

	// RETURN THE DYNAMICALLY SET TITLE OF SPECIFIC PAGE
	// Called in layout files head part, inside the title tag
	public function siteTitle(){
		return $this->_siteTitle;
	}

	// INSERT PARTIAL FILES INTO THE VIEWS 
	/*
	Requires two arguments: 
	   	- A folder in which the 'partials' folder resides, if exists. If the partials folder is located directly in the views folder, pass an empty string.
		- The name of the partials file, without the extension.
		Example - include a partial in the view: $this->partial('admin', 'category_modal'); 
	
	- Accepts an additional third argument, allowing to pass variables from the view to the partial view being included.
	Example - include a partial in the view passing variables: 
	$this->partial('', 'grid-products', ['products' => $this->products ]);
	*/
	public function partial($group, $partial, $variables = false){
		$path = ROOT.DS.'app'.DS.'views'.DS.$group.DS.'partials'.DS.$partial.'.php';
		if(file_exists($path)){
           // Extract the variables to a local namespace
		   if($variables){
           		extract($variables);
		   }	
           include $path;
         }
	}

	// RETURN A JSON ENCODED ARRAY OF OBJECTS
	// Requires a php object or array as argument 
	// Accepts a second argument defining if the first arguemnt is an object(false, the default), or an array of objects(true)
	// Called in the views to pass data from php to javascript (for modals dynamic content display) without making ajax calls
	// Returns json encoded object or array
	public function objtoJson($obj, $multilevel = false){
	  if(!(is_array($obj) || is_object($obj))) return false;
	  $arr = [];	
      foreach($obj as $item => $value){
      	if(!is_array($value)){
      		$arr[$item] = "{$value}";
      	}else{
      		if($multilevel){
            $arr[$item] = $value; 
            }   
      }
     }
     return json_encode($arr);
   }
}
