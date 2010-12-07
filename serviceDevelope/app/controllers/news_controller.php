<?php
class NewsController extends AppController {

	var $name = 'News';
	var $components = array('Acl');
	var $helpers = array('Html', 'Form');

	function index() {
		if($this->canViewTheNewsList()){
			$administratorId = $this->Session->read('administrator.id');
			$this->indexRelatedNews($administratorId);
		}
		else{
			$this->Session->setFlash(__('You have no right to view the news listed', true));
			$this->redirect(array('controller' => 'Administrators', 'action' => 'index'));
		}
			
		//$this->News->recursive = 0;
		//$this->set('news', $this->paginate());
	}
	
	function canViewTheNewsList(){
		return $this->hasLogined() && $this->isNormalAdministrator();
	}
	
	function indexRelatedNews($administratorId){
		$this->set('news', $this->indexNewsByAdministratorIdPaginated($administratorId));
	}
	
	function hasLogined(){
		if($this->Session->read('administrator') == NULL)
			return false;
		else
			return true;
	}
	
	function isNormalAdministrator(){
		$administratorName = $this->Session->read('administrator.name');
		$administratorAro = $this->Acl->Aro->findByAlias($administratorName);
		$administratorAroParent = $this->Acl->Aro->findById($administratorAro['Aro']['parent_id']);
		
		if($administratorAroParent['Aro']['alias'] == "Normals")
			return true;
		else
			return false;
	}
	
	function indexNewsByAdministratorIdPaginated($administratorId){
		$newsCondition = array('administrator_id' => $administratorId);
		$newsBelongedToAdministratorPaginated = $this->paginate(array($newsCondition));
		
		return $newsBelongedToAdministratorPaginated;
	}

//************************************************view*****************************************************	
	function view($newsId = null) {
		if($this->canView($newsId))
			$this->viewNews($newsId);
		else{
			$this->Session->setFlash(__('Invalid news or you have no right to view the news', true));
			$this->redirect(array('action' => 'index'));
		}
	}

	function canView($newsId){
		if($this->hasLogined() && $this->isNormalAdministrator()){
			$administrator = $this->Session->read('administrator');
			return $this->isNewsSender($administrator, $newsId);
		}
		else
			return false;
	}
	
	function isNewsSender($administrator, $newsId){
		$news = $this->News->findById($newsId);
		
		return $administrator['id'] == $news['News']['administrator_id'];
	}
	
	function viewNews($newsId){
		$this->set('news', $this->News->read(null, $newsId));
	}
	//****************************************ADD******************************************************************
	function add() {
		if($this->canAdd())
			$this->addNewsAndRedirectToProperPageIfSuccessfullyAdd();
		else{
			$this->Session->setFlash(__('You have no right to add news', true));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	function canAdd(){
		return $this->isNormalAdministrator();
	}
	
	function addNewsAndRedirectToProperPageIfSuccessfullyAdd(){	
		if (!empty($this->data)) {
			$addSuccessfully = $this->addNewsSuccessfully();
			$this->redirectToProperPageAdd($addSuccessfully);
		}
		
		//$administrators = $this->News->Administrator->find('list');
		//$this->set(compact('administrators'));
	}	
	
	function addNewsSuccessfully(){
		date_default_timezone_set('PRC');
		$this->News->create(array(('title') => $this->data['News']['title'],
								  ('text') => $this->data['News']['text'],								  ('date') => date("Y-m-d H:i:s"),								  ('administrator_id') => $this->Session->read('administrator.id')
								 )
							);	
		return $this->News->save();
	}
	
	function redirectToProperPageAdd($addSuccessfully){
		if($addSuccessfully){
			$this->Session->setFlash(__('The news has been saved', true));
			$this->redirect(array('action' => 'index'));
		}
		else
			$this->Session->setFlash(__('The news could not be saved. Please, try again.', true));
	}
//***************************************Edit*****************************************************	
	function edit($newsId = null) {
		if($this->canEdit($newsId)){
			//echo "dfk";
			$this->editNewsAndRedirectToProperPageIfSuccesfullyEdit($newsId);
		}
		else{
			$this->Session->setFlash(__('Invalid news or you have no right to edit the news', true));
			$this->redirect(array('action' => 'index'));
		}
	}

	function canEdit($newsId){
		if($this->hasLogined() && $this->isNormalAdministrator()){
			$administrator = $this->Session->read('administrator');
			return $this->isNewsSender($administrator, $newsId);
		}
		else
			return false;
	}
	
	
	function editNewsAndRedirectToProperPageIfSuccesfullyEdit($newsId){
		if(!empty($this->data)){
			$editSuccessfully = $this->editNewsSucessfully();
			$this->redirectToProperPageEdit($editSuccessfully);
		}
		
		$this->data = $this->News->read(null, $newsId);
	}
	
	function editNewsSucessfully(){
		return $this->News->save($this->data);
	}
	
	function redirectToProperPageEdit($editSuccessfully){
		if($editSuccessfully){
			$this->Session->setFlash(__('The news has been saved', true));
			$this->redirect(array('action' => 'index'));
		}
		else
			$this->Session->setFlash(__('The news could not be saved. Please, try again.', true));
	}
	
//********************************************delete*******************************************	
	function delete($newsId = null) {
		
		if($this->canDelete($newsId))
			$this->deleteNewsAndRedirectToProperPageIfSuccesfullyDelete($newsId);
		else{
			$this->Session->setFlash(__('Invalid id for news or you have no right to delete the news', true));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	function canDelete($newsId){
		if($this->hasLogined() && $this->isNormalAdministrator()){
			$administrator = $this->Session->read('administrator');
			return $this->isNewsSender($administrator, $newsId);
		}
		else
			return false;
	}
	
	function deleteNewsAndRedirectToProperPageIfSuccesfullyDelete($newsId){
		$deleteSuccessfully = $this->deleteNewsSuccessfully($newsId);
		$this->redirectToProperPageDelete($deleteSuccessfully);
	}
	
	function deleteNewsSuccessfully($newsId){
		return $this->News->delete($newsId);
	}
	
	function redirectToProperPageDelete($deleteSuccessfully){
		if($deleteSuccessfully){
			$this->Session->setFlash(__('News deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		else{
			$this->Session->setFlash(__('News was not deleted', true));
			$this->redirect(array('action' => 'index'));
		}
	}
	
}
?>