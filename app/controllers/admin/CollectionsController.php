<?php
class CollectionsController extends Controller{

	public function __construct($controller, $action){
		parent::__construct($controller, $action);
    // This instantiates a new model class of whichever model class we pass and saves it in $this->modelName property. Here we will have $this->usersModel = new Users('Users'); The argument we pass must be the model name we want to load.
		$this->load_model('Collections');
		$this->view->setLayout('admin_default');
	}

  // SHOW ALL COLLECTIONS
  public function indexAction(){
		$collections = new Collections();
    $allCollections = $this->CollectionsModel->getAll();
		$this->view->collections = $allCollections;
		$this->view->render('admin/collections/collections');
  }

  // ADD A COLLECTION
  public function addAction(){
    $collection = new Collections();
    	// Get all products
    	$products = $this->CollectionsModel->getProductList();
      $optionList = $products['options'];
      $optionListInfo = $products['info'];    
      // Handle form submission
      if($this->request->isPost()){
        	$this->request->csrfCheck();
        	$collection->assign($this->request->get());
          $collection->collection_slug = Helpers::createSlug($this->request->get('collection_name'));
             if($collection->collection_items !== "" && is_array($collection->collection_items)){
                 $collection->collection_items = implode(',', $collection->collection_items);
             }else{
                $collection->collection_items = null;
             }
        	if($collection->create()){
        		 Router::redirect('admin/collections/index');
        	};
      }
    	$this->view->displayErrors = $collection->getErrorMessages();
      $this->view->productOptions = $optionList; 
      $this->view->optionInfo = $optionListInfo;
    	$this->view->render('admin/collections/collections_add');    
  }

  // EDIT A COLLECTION
  public function editAction($id){
      $collection = $this->CollectionsModel->findById($id);
      $collectionItems = explode(',', $collection->collection_items);
      $products = $this->CollectionsModel->getProductList();
      $optionList = $products['options'];
      $optionListInfo = $products['info'];
        
      if($this->request->isPost()){
          $this->request->csrfCheck();
          $collection->assign($this->request->get());
          $collection->collection_slug = Helpers::createSlug($this->request->get('collection_name')); 
          // Stringify the array of collection items
          if($collection->collection_items !== "" && is_array($collection->collection_items)){
              $collection->collection_items = implode(',', $collection->collection_items);
          }else{
            $collection->collection_items = null;
          }
            if($collection->saveChanges()){
              Router::redirect('admin/collections/index');
            }
        }
        $this->view->displayErrors = $collection->getErrorMessages();
        $this->view->collection = $collection;
        $this->view->collectionItems = $collectionItems;
        $this->view->productOptions = $optionList; 
        $this->view->optionInfo = $optionListInfo;
        $this->view->render('admin/collections/collections_edit');  
    }

  // SOFT DELETE A COLLECTION
  public function deleteAction($id){
      $collection = $this->CollectionsModel->findById($id);
      if($collection){
          if($collection->delete()){
            Session::addMsg('success', 'The collection was deleted successfully.');
          }else{
            Session::addMsg('danger', 'The collection was not deleted. Please try again.');
          }
      }
      Router::redirect('admin/collections/index');
  }
  
  // SHOW DELETED COLLECTIONS
  public function deletedAction(){
    	$collections = $this->CollectionsModel->findDeleted();     
    	$this->view->collections = $collections;
      $this->view->render('admin/collections/collections_deleted'); 
  }

  // RESTORE DELETED COLLECTIONS
  // Return a json response
  public function restoreDeletedAction(){
      if(!$this->request->isAjax()){
        Router::redirect('restricted/unauthorized');
      }else{
       $collectionId = intval($this->request->get('id'));
       $collection = $this->CollectionsModel->findDeleted($collectionId);
       if($collection){
        $collection->deleted = 0;
        $results = $collection->updateProperties(['deleted']);
          if($results){
              return $this->jsonResponse("success");
         }
      }
      return $this->jsonResponse("error");
    } 
  }

  // DELETE SOFT DELETED COLLECTIONS
  public function finalDeleteAction(){
      $collectionId = intval($this->request->get('id'));
      $collection = $this->CollectionsModel->findDeleted($collectionId);
      if(!$collection){
        Session::addMsg('danger', 'Sorry, collection not found');   
        Router::redirect('admin/collections/deleted');
      }
      if($collection->finalDelete()){
        Session::addMsg('success', 'The collection was deleted successfully.');
        Router::redirect('admin/collections/deleted');
      }else{
        Session::addMsg('danger', 'The collection was not deleted. Please try again.');
        Router::redirect('admin/collections/deleted');
      }   
  }
}