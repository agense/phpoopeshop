<?php
class PagesController extends Controller{

	public function __construct($controller, $action){
		parent::__construct($controller, $action);
		$this->load_model('Pages');
		$this->view->setLayout('admin_default');
	}

  // SHOW A LIST OF ALL PAGES
    public function indexAction(){
      $pages = $this->PagesModel->getAll();
      $this->view->pages = $pages;
      $this->view->render('admin/pages/pages');
    }
    
  // SHOW A SINGLE
  public function showAction($id){
    $page = $this->PagesModel->findById($id);
    $page->content = Helpers::decodeContent($page->content);
    //Helpers::dnd($page->content);
    $this->view->page = $page;
    $this->view->render('admin/pages/page');
  }

  // ADD A PAGE
  public function addAction(){
    $page = new Pages(); 
    if($this->request->isPost()){   
      $this->request->csrfCheck();
      $page->assign($this->request->get());
      $page->content = Helpers::encodeContent($page->content);
      $page->slug = Helpers::createSlug($this->request->get('title'));
      // Validate Data
      $page->pageValidator();
      if($page->validationPassed()){
        if($page->save()){
          Router::redirect('admin/pages');
        }
      }
    }
  	$this->view->pageTypes = Pages::getPageTypes();
    $this->view->displayErrors = $page->getErrorMessages();
    $this->view->render('admin/pages/add');    
  }

  // EDIT A PAGE
  public function editAction($id){
    $page = $this->PagesModel->findById($id);
    $page->content = Helpers::decodeContent($page->content);
    if($this->request->isPost()){   
      $this->request->csrfCheck();
      $page->assign($this->request->get());
      $page->content = Helpers::encodeContent($page->content);
      $page->slug = Helpers::createSlug($this->request->get('title'));
      // Validate Data
      $page->pageValidator();
      if($page->validationPassed()){
        if($page->save()){
          Router::redirect('admin/pages');
        }
      }
    }
    $this->view->page = $page;
    $this->view->pageTypes = Pages::getPageTypes();
    $this->view->displayErrors = $page->getErrorMessages();
    $this->view->render('admin/pages/edit');  
  }

  // DELETE A PAGE
  public function deleteAction($id){
     $page = $this->PagesModel->findById($id);
     if($page){
        // Delete embedded page images from storage if any exist
        $content = Helpers::decodeContent($page->content);
        $images = [];
        $dom = new DOMDocument();
        $dom->loadHTML($content);
        $tags= $dom->getElementsByTagName('img');
        foreach ($tags as $tag) {
          $images[] =  $tag->getAttribute('src');
        }
        if(count($images) > 0){
          foreach($images as $img){
            $this->PagesModel->deleteEmbeddedImage($img);
          }
        }
        //Delete the page
        if($page->delete()){
          Session::addMsg('success', 'The page was deleted successfully.');
        }else{
          Session::addMsg('danger', 'The page was not deleted. Please try again.');
        }
    }
    Router::redirect('admin/pages/index');
  }

  // TOGGLE ADDING PAGE TO FOOTER MENU
  // Return a json response
  public function setInMenuItemAction(){
    if(!$this->request->isAjax()){
      Router::redirect('restricted/unauthorized');
    }else{
      $pageId = intval($this->request->get('id'));
      $page = $this->PagesModel->findById($pageId);
      if($page){
        if($page->in_menu == 0){
          $page->in_menu = 1;
        }else{
          $page->in_menu = 0;
        }  
        $results = $page->updateProperties(['in_menu']);
        if($results){
          $this->jsonResponse("success");
        }
      }
      $this->jsonResponse("error"); 
    }
  }

  // UPLOAD IMAGES FOR PAGES ADDED IN SUMMERNOTE EDITOR
  // Returns a json response
  // If upload is successful, returns file name(in an array), otherwise returns upload errors(array)
  public function uploadPageImageAction(){
    if(!$this->request->isAjax()){
      Router::redirect('restricted/unauthorized');
    }else{
      $file = Input::getFile('file');
      if(!$file){
        $this->jsonResponse(['errors' => ['File Not Found']]);
      }
      $uploader = new Uploader($this->PagesModel->uploadPath, $file, 'page_image');  
      if($uploader->upload()){
        $filename = PROOT.$this->PagesModel->uploadPath.DS.$uploader->getFileName();
        $this->jsonResponse(['url' => $filename]);
      }else{
        $errors = $uploader->getErrors();
        $this->jsonResponse(['errors' => $errors]);
      }
    }
  }

    // DELETE IMAGES FROM PAGES WHEN DELETED IN SUMMERNOTE EDITOR
    // Returns a json response
    public function deletePageImageAction(){
      if(!$this->request->isAjax()){
        Router::redirect('restricted/unauthorized');
      }else{
        $file = $this->request->get('file');
        if(!$file){
          $this->jsonResponse(['errors' => ['File Not Found']]);
        }
        if($this->PagesModel->deleteEmbeddedImage($file)){
          $this->jsonResponse(['success' => 'File Deleted']);
        }else{
          $this->jsonResponse(['errors' => ['File Not Found']]);
        }
      }
    }

}