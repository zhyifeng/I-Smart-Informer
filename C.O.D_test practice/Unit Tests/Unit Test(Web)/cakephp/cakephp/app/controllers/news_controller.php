<?php
//author: Å£è´£¬ÁÖÃÎÏª£¬×¯×Ó˜±
class NewsController extends AppController {

	var $name = 'News';
	//var $components = array('Acl');
	//var $helpers = array('Html', 'Form');

	function index() {
		$administratorId = $this->Session->read('administrator.id');
		$this->indexRelatedNews($administratorId);
	}
	
	function indexRelatedNews($administratorId){
		$this->set('news', $this->indexRelatedNewsPaginated($administratorId));
	}
	
	function indexRelatedNewsPaginated($administratorId){
		$newsCondition = array('administrator_id' => $administratorId);
		$newsBelongedToAdministratorPaginated = $this->paginate(array($newsCondition));
		
		return $newsBelongedToAdministratorPaginated;
	}
//********************************************phone*********************************************************

function searchNewsByKeyword()
{
		$this->layout = 'blank';
		$keywords = json_decode($_POST['KeyWordInfo'],true);
		$relatedNews =  $this->News->searchNewsByKeyWord($keywords['KeyWord']);
		echo json_encode($relatedNews); 
}


function resposePhoneRequstToFindNews()
{
		$this->layout = 'blank';
		$GroupInfo = json_decode($_POST['NewsTypeInfo'],true);
		$newsAboutGroup = $this->findNewsByGroupId($GroupInfo['Newstype']);
		echo json_encode($newsAboutGroup); 
		
}
	 function findNewsByGroupId($groupId){
		$newsAddedByRelatedAdmins = array();
		$relatedAdmins = $this->findRelatedAdmins($groupId);
		$newsAddedByRelatedAdmins = $this->findNewsAddedByRelatedAdmins($relatedAdmins);
		return $newsAddedByRelatedAdmins;
		//var_dump($newsAddedByRelatedAdmins);
	}	
	private function findRelatedAdmins( $groupId )
	{
		$this->loadModel('Group');
		
		$relatedAdmins = $this->Group->Administrator->find('all', array(
														'conditions' => array(
														'group_id' => $groupId)));
		return $relatedAdmins;
	}
	
	private function findNewsAddedByRelatedAdmins($relatedAdmins)
	{
		
		$NewsAddedByAllAdmins = array();
		$IdOfAdmins = $this->retriveIdfromAdmins($relatedAdmins);
		for($adminIndex=0; $adminIndex < count($relatedAdmins); $adminIndex++)
		{
			$NewsAddedByOneAdmin = $this->findNewsAddedByOneAdmin($IdOfAdmins[$adminIndex]);
			$this->addNewsToOneArray($NewsAddedByAllAdmins,$NewsAddedByOneAdmin);
		}
		return $NewsAddedByAllAdmins;
		
		
	}	
	private function retriveIdfromAdmins($relatedAdmins)
	{
		$NumOfAdmins = count($relatedAdmins);
		$adminIds = array();
		for($adminIndex=0; $adminIndex < $NumOfAdmins; $adminIndex++)
		{
			$adminIds[$adminIndex] = $relatedAdmins[$adminIndex]["Administrator"]["id"];
		}
		return $adminIds;
	}
	private function findNewsAddedByOneAdmin($adminID)
	{
		$newsArrayByThisAdmin = $this->Group->Administrator->News->find('all', array(
															'conditions' => array('administrator_id' => $adminID ),
															'fields' => array( 'title', 'text', 'date' )
															));
		return $newsArrayByThisAdmin;
	}
	private function addNewsToOneArray(&$NewsAddedByAllAdmins,$NewsAddedByOneAdmin)
	{
		
			for($newsIndex = 0; $newsIndex < count($NewsAddedByOneAdmin); $newsIndex++)
					array_push($NewsAddedByAllAdmins,$NewsAddedByOneAdmin[$newsIndex]['News']);	
	}
//************************************************view*****************************************************	
	function view($newsId = null) {
		if($this->isNotExistNews($newsId)){
			$this->Session->setFlash(__('Invalid news', true));
			$this->redirect(array('action' => 'index'));
		}
		
		if($this->canView($newsId))
			$this->viewNews($newsId);
		else{
			$this->Session->setFlash(__('You have no right to view the news', true));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	private function isExistNews($newsId){
		$newsAllRelated = $this->News->findById($newsId);
		if($newsAllRelated != null)
			return true;
		else
			return false;
	}
	
	private function isNotExistNews($newsId){
		return !$this->isExistNews($newsId);
	}

	private function canView($newsId){
		$administrator = $this->Session->read('administrator');
		return $this->isNewsSender($administrator, $newsId);
	}
	
	private function isNewsSender($administrator, $newsId){
		$news = $this->News->findById($newsId);
		
		return $administrator['id'] == $news['News']['administrator_id'];
	}
	
	private function viewNews($newsId){
		$this->set('news', $this->News->read(null, $newsId));
	}
	//****************************************ADD******************************************************************
	function add() {
		if(!empty($this->data))
			$this->addNewsAndRedirectToProperPageIfSuccessfullyAdd();
	}
	
	private function addNewsAndRedirectToProperPageIfSuccessfullyAdd(){	
		$addSuccessfully = $this->addNewsSuccessfully();
		$this->redirectToProperPageAdd($addSuccessfully);
	}	
	
	private function addNewsSuccessfully(){
		date_default_timezone_set('PRC');
		$this->News->create(array(('title') => $this->data['News']['title'],
								  ('text') => $this->data['News']['text'],								  ('date') => date("Y-m-d H:i:s"),								  ('administrator_id') => $this->Session->read('administrator.id')
								 )
							);	
		return $this->News->save($this->data);
	}
	
	private function redirectToProperPageAdd($addSuccessfully){
		if($addSuccessfully){
			$this->Session->setFlash(__('The news has been saved', true));
			$this->redirect(array('action' => 'index'));
		}
		else
			$this->Session->setFlash(__('The news could not be saved. Please, try again.', true));
	}
	
	

//***************************************Edit*****************************************************	
	function edit($newsId = null) {
		if($this->isNotExistNews($newsId)){
			$this->Session->setFlash(__('Invalid news', true));
			$this->redirect(array('action' => 'index'));
		}
		
		if(!empty($this->data))
			$this->editNewsIfHavingRight($newsId);
		else
			$this->data = $this->News->read(null, $newsId);
	}
	
	private function editNewsIfHavingRight($newsId){
		if($this->canEdit($newsId))
			$this->editNewsAndRedirectToProperPageIfSuccesfullyEdit();
		else{
			$this->Session->setFlash(__('You have no right to edit the news', true));
			$this->redirect(array('action' => 'index'));
		}
	}

	private function canEdit($newsId){
		$administrator = $this->Session->read('administrator');
		return $this->isNewsSender($administrator, $newsId);
	}
	
	
	private function editNewsAndRedirectToProperPageIfSuccesfullyEdit(){
		$editSuccessfully = $this->editNewsSucessfully();
		$this->redirectToProperPageEdit($editSuccessfully);
	}
	
	private function editNewsSucessfully(){
		return $this->News->save($this->data);
	}
	
	private function redirectToProperPageEdit($editSuccessfully){
		if($editSuccessfully){
			$this->Session->setFlash(__('The news has been saved', true));
			$this->redirect(array('action' => 'index'));
		}
		else
			$this->Session->setFlash(__('The news could not be saved. Please, try again.', true));
	}
	
//********************************************delete*******************************************	
	function delete($newsId = null) {
		if($this->isNotExistNews($newsId)){
			$this->Session->setFlash(__('Invalid news', true));
			$this->redirect(array('action' => 'index'));
		}
		
		if($this->canDelete($newsId))
			$this->deleteNewsAndRedirectToProperPageIfSuccesfullyDelete($newsId);
		else{
			$this->Session->setFlash(__('You have no right to delete the news', true));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	private function canDelete($newsId){
		$administrator = $this->Session->read('administrator');
		return $this->isNewsSender($administrator, $newsId);
	}
	
	private function deleteNewsAndRedirectToProperPageIfSuccesfullyDelete($newsId){
		$deleteSuccessfully = $this->deleteNewsSuccessfully($newsId);
		$this->redirectToProperPageDelete($deleteSuccessfully);
	}
	
	private function deleteNewsSuccessfully($newsId){
		return $this->News->delete($newsId);
	}
	
	private function redirectToProperPageDelete($deleteSuccessfully){
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