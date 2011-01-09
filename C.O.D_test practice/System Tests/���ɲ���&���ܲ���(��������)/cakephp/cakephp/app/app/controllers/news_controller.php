<?php
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
		$keywords = json_decode($_POST['SearchInfo']);
		$relatedNews =  $this->News->searchNewsByKeyWord($keywords);
		echo json_encode($relatedNews); 
}


function resposePhoneRequstToFindNews()
{
		$this->layout = 'blank';
		$GroupInfo = json_decode($_POST['NewsTypeInfo'],true);
		$newsAboutGroup = $this->findNewsByGroupId($GroupInfo['Newstype']);
		echo json_encode($newsAboutGroup); 
		//echo var_dump($GroupInfo);
		
}
function findNewsByGroupId($groupId){
	//	$groupId = '6';
		$this->loadModel('Group');
		
		$administratorArray = $this->Group->Administrator->find('all', array(
														'conditions' => array(
														'group_id' => $groupId)));
		$adminNumInThisGroup = count($administratorArray);
		
		$adminIdArray = array();
		$adminIndex=0;
		while($adminIndex < $adminNumInThisGroup)
		{
			$adminIdArray[$adminIndex] = $administratorArray[$adminIndex]["Administrator"]["id"];
			$adminIndex++;
		}
		
		$newsNum = 0;
		$adminIndex=0;
		$newsArrayInThisGroup = array();
		while($adminIndex < $adminNumInThisGroup)
		{
			$newsArrayByThisAdmin = $this->Group->Administrator->News->find('all', array(
															'conditions' => array(
															'administrator_id' => $adminIdArray[$adminIndex]),
															'fields' => array( 'title', 'text', 'date' )
															));
			$newsNumFromThisAdmin = count($newsArrayByThisAdmin);
			$newsIndex = 0;
			while($newsIndex < $newsNumFromThisAdmin)
			{
				$newsArrayInThisGroup[$newsIndex + $newsNum] = $newsArrayByThisAdmin[$newsIndex]["News"];
				$newsIndex++;
			}
			$newsNum += $newsNumFromThisAdmin;
			$adminIndex++;
		}
		
		//echo var_dump($newsArrayInThisGroup);
		return $newsArrayInThisGroup;
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
	
	function isExistNews($newsId){
		$newsAllRelated = $this->News->findById($newsId);
		if($newsAllRelated != null)
			return true;
		else
			return false;
	}
	
	function isNotExistNews($newsId){
		return !$this->isExistNews($newsId);
	}

	function canView($newsId){
		$administrator = $this->Session->read('administrator');
		return $this->isNewsSender($administrator, $newsId);
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
		if(!empty($this->data))
			$this->addNewsAndRedirectToProperPageIfSuccessfullyAdd();
	}
	
	function addNewsAndRedirectToProperPageIfSuccessfullyAdd(){	
		$addSuccessfully = $this->addNewsSuccessfully();
		$this->redirectToProperPageAdd($addSuccessfully);
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
		if($this->isNotExistNews($newsId)){
			$this->Session->setFlash(__('Invalid news', true));
			$this->redirect(array('action' => 'index'));
		}
		
		if(!empty($this->data))
			$this->editNewsIfHavingRight($newsId);
		else
			$this->data = $this->News->read(null, $newsId);
	}
	
	function editNewsIfHavingRight($newsId){
		if($this->canEdit($newsId))
			$this->editNewsAndRedirectToProperPageIfSuccesfullyEdit();
		else{
			$this->Session->setFlash(__('You have no right to edit the news', true));
			$this->redirect(array('action' => 'index'));
		}
	}

	function canEdit($newsId){
		$administrator = $this->Session->read('administrator');
		return $this->isNewsSender($administrator, $newsId);
	}
	
	
	function editNewsAndRedirectToProperPageIfSuccesfullyEdit(){
		$editSuccessfully = $this->editNewsSucessfully();
		$this->redirectToProperPageEdit($editSuccessfully);
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
	
	function canDelete($newsId){
		$administrator = $this->Session->read('administrator');
		return $this->isNewsSender($administrator, $newsId);
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