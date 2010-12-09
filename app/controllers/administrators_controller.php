<?php
class AdministratorsController extends AppController {

	var $name = 'Administrators';
	var $components = array('Acl');

	function canLogin(){
		if($this->hasLogined())
			return false;
	
		if($this->isLoginNotNull() && $this->isTheAdministratorExist()){
			$administratorFound = $this->getAdministratorByNameFromLogin();
			return $this->isPasswordCorrect($administratorFound);
		}
		else
			return false;
	}
	
	function hasLogined(){
		if($this->Session->read('administrator') == NULL)
			return false;
		else
			return true;
	}
	
	function isLoginNotNull(){
		return $this->data['Administrator']['name'] != "" && $this->data['Administrator']['password'] != "";
	}
	
	function isTheAdministratorExist(){
		$administratorFoundAllRelated = $this->getAdministratorByNameFromLogin();
		if(!empty($administratorFoundAllRelated))
			return true;
		else
			return false;
	}
	
	function getAdministratorByNameFromLogin(){
		$administratorFoundAllRelated = $this->Administrator->findByName($this->data['Administrator']['name']);
		$administratorFound = $administratorFoundAllRelated['Administrator'];
		return $administratorFound;
	}
	
	function isPasswordCorrect($administratorChecked){
		return $administratorChecked['password'] == $this->data['Administrator']['password'];
	}
	
	function redirectToProperPageLogin(){
		if($this->isSuperAdministrator())
			$this->redirect(array('action' => 'index'));
		else
			$this->redirect(array('controller' => 'news', 'action' => 'index'));
	}
	
	function isSuperAdministrator(){
		$administratorName = $this->Session->read('administrator.name');
		$administratorAro = $this->Acl->Aro->findByAlias($administratorName);
		$administratorAroParent = $this->Acl->Aro->findById($administratorAro['Aro']['parent_id']);
		
		if($administratorAroParent['Aro']['alias'] == "Supers")
			return true;
		else
			return false;
	}
	
	function writeAdministratorToSession(){
		$administratorGot = $this->getAdministratorByNameFromLogin();
		$this->Session->write('administrator', $administratorGot);
	}
	
	function login(){
		if($this->canLogin()){
			$this->writeAdministratorToSession();
			$this->redirectToProperPageLogin();
			
			//$this->set('administratora', $this->Session->read('administrator'));
		}
		else
			$this->set('error', true);
	}
	
	function logout(){
		$this->clearAdministratorInSession();
		$this->redirectToProperPageLogout();
	}
	
	function clearAdministratorInSession(){
		$this->Session->delete('administrator');
	}
	
	function redirectToProperPageLogout(){
		$this->redirect(array('action' => 'login'), null, true);
	}
	
	function index() {
		if($this->Session->read('administrator')){
			$this->Administrator->recursive = 0;
			$this->set('administrators', $this->paginate());
		}
		else
			$this->redirect(array('action' => 'login'), null, true);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid administrator', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('administrator', $this->Administrator->read(null, $id));
	}

	function add() {
		if($this->Acl->check($this->Session->read('administrator'), 'controllers/Administrators/add')){
		if (!empty($this->data)) {
			$this->Administrator->create();
			if ($this->Administrator->save($this->data)) {
			
				$parent = $this->Acl->Aro->findByAlias('Normals');
				$this->Acl->Aro->create(array(
					'alias' => $this->data['Administrator']['name'],
					'model' => 'Administrator',
					'foreign_key' => $this->Administrator->id,
					'parent_id' => $parent['Aro']['id'])
				);
				$this->Acl->Aro->save();
				
				
				$this->Session->setFlash(__('The administrator has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The administrator could not be saved. Please, try again.', true));
			}
		}
		$groups = $this->Administrator->Group->find('list');
		$this->set(compact('groups'));
		}
		else{
			$this->Session->setFlash('Dead!');
			$this->redirect(array('action' => 'index'), null, true);
			}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid administrator', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Administrator->save($this->data)) {
				$this->Session->setFlash(__('The administrator has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The administrator could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Administrator->read(null, $id);
		}
		$groups = $this->Administrator->Group->find('list');
		$this->set(compact('groups'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for administrator', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Administrator->delete($id)) {
			$this->Session->setFlash(__('Administrator deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Administrator was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	

}
?>