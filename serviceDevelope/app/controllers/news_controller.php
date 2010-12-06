<?php
class NewsController extends AppController {

	var $name = 'News';
	var $components = array('Acl');
	var $helpers = array('Html', 'Form');

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
		$newsCondition = array('administrator_id' => $administratorId);
		$newsBelongedToAdministratorPaginated = $this->paginate(array($newsCondition));
		
		return $newsBelongedToAdministratorPaginated;
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid news', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('news', $this->News->read(null, $id));
	}

	function add() {
		if($this->isNormalAdministrator())
			$this->addNewsAndRedirctToProperPageIfSuccess();
		else
			$this->Session->setFlash(__('You have no right to add news', true));
	}
	
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
	}	
	
	function edit($id = null) {
		if($this->canEdit($id))
			$this->editNewsAndRedirctToProperPageIfSuccess($id);
		else
			$this->Session->setFlash(__('You have no right to edit news', true));
	}

	function canEdit($newsId){
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
	
	function delete($id = null) {
		
		if($this->canDelete($id))
			$this->deleteNewsAndRedirctToProperPageIfSuccess($id);
		else
			$this->Session->setFlash(__('You have no right to delete news', true));
	}
	
	function canDelete($newsId){
		if($this->hasLogined() && $this->isNormalAdministrator()){
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