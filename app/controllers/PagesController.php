<?php
class PagesController extends Controller {
	public function __construct($controller, $action){
		parent:: __construct($controller, $action);
        
		$this->view->setLayout('default');
        $this->load_model('Pages');
	}
   
	// SHOW SINGLE PAGE BY SLUG
	public function showAction($slug){
		$page = $this->PagesModel->findBySlug($slug);
		if(!$page){
			Router::redirect('notFound/index');
		  }
		$page->content = Helpers::decodeContent($page->content);
		$this->view->page = $page;
        $this->view->render('pages/page');
	}
}	
