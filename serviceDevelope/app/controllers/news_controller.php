<?php
class NewsController extends AppController {

	var $name = 'News';
	var $components = array('Acl');
	var $helpers = array('ddd', 'Form');

	function index() {
		if($this->hasLogined() && $this->isNormalAdministrator()){
			$administrator = $this->Session->read('administrator');
			$newsBelongedToAdministratorPaginated = $this->getNewsByAdministratorIdPaginated($administrator['id']);
			$this->set('news', $newsBelongedToAdministratorPaginated);
		}
		else
			$this->set('error', true);
			
		//$this->News->recursive = 0;
		//$this->set('news', $this->paginate());
	}
	
<<<<<<< HEAD
	function canViewTheNewsList(){
		return $this->isNormalAdministrator();
	}
	
	function indexRelatedNews($administratorId){
		$this->set('news', $this->indexNewsByAdministratorIdPaginated($administratorId));
	}
	
	function indexNewsByAdministratorIdPaginated($administratorId){
=======
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
	
	function getNewsByAdministratorIdPaginated($administratorId){
>>>>>>> 96abf9e5b4a20863b7e8ea09f0fe350d593479dc
		$newsCondition = array('administrator_id' => $administratorId);
		$newsBelongedToAdministratorPaginated = $this->paginate(array($newsCondition));
		
		return $newsBelongedToAdministratorPaginated;
	}

<<<<<<< HEAD
//************************************************view*****************************************************	
	function view($newsId = null) {
		if($this->isNotExistNews($newsId)){
			$this->Session->setFlash(__('Invalid news', true));
			$this->redirect(array('action' => 'index'));
		}
		
		if($this->canView($newsId))
			$this->viewNews($newsId);
		else{
			$this->Session->setFlash(__('Invalid news or you have no right to view the news', true));
=======
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid news', true));
>>>>>>> 96abf9e5b4a20863b7e8ea09f0fe350d593479dc
			$this->redirect(array('action' => 'index'));
		}
		$this->set('news', $this->News->read(null, $id));
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

<<<<<<< HEAD
	function canView($newsId){
		if($this->isNormalAdministrator()){
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
		if(!empty($this->data))
			$this->doAdd();
	}
	
	function doAdd(){
		if($this->canAdd())
			$this->addNewsAndRedirectToProperPageIfSuccessfullyAdd();
		else{
=======
	function add() {
		if($this->isNormalAdministrator())
			$this->addNewsAndRedirctToProperPageIfSuccess();
		else
>>>>>>> 96abf9e5b4a20863b7e8ea09f0fe350d593479dc
			$this->Session->setFlash(__('You have no right to add news', true));
	}
	
<<<<<<< HEAD
	function addNewsAndRedirectToProperPageIfSuccessfullyAdd(){	
		$addSuccessfully = $this->addNewsSuccessfully();
		$this->redirectToProperPageAdd($addSuccessfully);
=======
	function addNewsAndRedirctToProperPageIfSuccess(){
		if (!empty($this->data)) {
			$this->News->create();
			if ($this->News->save($this->data)) {
				$this->Session->setFlash(__('The news has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The news could not be saved. Please, try again.', true));
			}
		}
		$administrators = $this->News->Administrator->find('list');
		$this->set(compact('administrators'));
>>>>>>> 96abf9e5b4a20863b7e8ea09f0fe350d593479dc
	}	
	
	function edit($id = null) {
		if($this->canEdit($id))
			$this->editNewsAndRedirctToProperPageIfSuccess($id);
		else
<<<<<<< HEAD
			$this->Session->setFlash(__('The news could not be saved. Please, try again.', true));
	}
//***************************************Edit*****************************************************	
	function edit($newsId = null) {
		if($this->isNotExistNews($newsId)){
			$this->Session->setFlash(__('Invalid news', true));
			$this->redirect(array('action' => 'index'));
		}
		
		if(!empty($this->data))
			$this->doEdit($newsId);
		else
			$this->data = $this->News->read(null, $newsId);
	}
	
	function doEdit($newsId){
		if($this->canEdit($newsId))
			$this->editNewsAndRedirectToProperPageIfSuccesfullyEdit();
		else{
			$this->Session->setFlash(__('You have no right to edit the news', true));
			$this->redirect(array('action' => 'index'));
		}
=======
			$this->Session->setFlash(__('You have no right to edit news', true));
>>>>>>> 96abf9e5b4a20863b7e8ea09f0fe350d593479dc
	}

	function canEdit($newsId){
		if($this->isNormalAdministrator()){
			$administrator = $this->Session->read('administrator');
			return $this->isNewsSender($administrator, $newsId);
		}
		else
			return false;
	}
	
<<<<<<< HEAD
	
	function editNewsAndRedirectToProperPageIfSuccesfullyEdit(){
		$editSuccessfully = $this->editNewsSucessfully();
		$this->redirectToProperPageEdit($editSuccessfully);
	}
	
	function editNewsSucessfully(){
		return $this->News->save($this->data);
=======
	function isNewsSender($administrator, $newsId){
		$news = $this->News->findById($newsId);
		
		return $administrator['id'] == $news['News']['administrator_id'];
>>>>>>> 96abf9e5b4a20863b7e8ea09f0fe350d593479dc
	}
		
	
	function editNewsAndRedirctToProperPageIfSuccess($id){
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid news', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->News->save($this->data)) {
				$this->Session->setFlash(__('The news has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The news could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->News->read(null, $id);
		}
		$administrators = $this->News->Administrator->find('list');
		$this->set(compact('administrators'));
	}
	
<<<<<<< HEAD
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
=======
	function delete($id = null) {
		
		if($this->canDelete($id))
			$this->deleteNewsAndRedirctToProperPageIfSuccess($id);
		else
			$this->Session->setFlash(__('You have no right to delete news', true));
>>>>>>> 96abf9e5b4a20863b7e8ea09f0fe350d593479dc
	}
	
	function canDelete($newsId){
		if($this->isNormalAdministrator()){
			$administrator = $this->Session->read('administrator');
			return $this->isNewsSender($administrator, $newsId);
		}
		else
			return false;
	}
	
	function deleteNewsAndRedirctToProperPageIfSuccess($id){
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for news', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->News->delete($id)) {
			$this->Session->setFlash(__('News deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('News was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>