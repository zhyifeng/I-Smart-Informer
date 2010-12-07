<?php
class AdministratorsController extends AppController {

	var $name = 'Administrators';
	var $components = array('Acl');

	function login(){
		if($this->canLogin()){
			$this->writeAdministratorToSession();
			$this->redirectToProperPageIfsuccessfullyLogin();
		}
		else
			$this->Session->setFlash(__('Invalid login, please check your username and password or logout first if you have logined', true));
	}
	
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
		$administratorFound = $this->getAdministratorByNameFromLogin();
		if($administratorFound != null)
			return $administratorFound['exist'];
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
	
	function redirectToProperPageIfSuccessfullyLogin(){
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
	//*******************************************************logout*****************************************
	
	function logout(){
		$this->clearAdministratorInSession();
		$this->redirectToProperPageLogout();
	}
	
	function clearAdministratorInSession(){
		$this->Session->delete('administrator');
	}
	
	function redirectToProperPageLogout(){
		$this->redirect(array('action' => 'login'));
	}//***************************************************index***********************************************
	function index() {
		if($this->canViewAdministratorList())
			$this->indexAdministrators();
		else{
			$this->Session->setFlash(__('You have no right to view the administrator list', true));
			$this->redirect(array('action' => 'logout'));
		}
	}

	function canViewAdministratorList(){
		return $this->hasLogined() && $this->isSuperAdministrator();
	}
	
	function indexAdministrators(){
		$this->Administrator->recursive = 0;
		$this->set('administrators', $this->paginate());
	}
		//************************************************view***************************************************
	function view($administratorId = null) {
		if($this->canView($administratorId))
			$this->viewAdministrator($administratorId);
		else{
			$this->Session->setFlash(__('Invalid administrator or you have no right to view administrators', true));
			$this->redirect(array('controller' => 'News', 'action' => 'index'));
		}
	}

	function canView($administratorId){
		return $this->hasLogined() && $this->isSuperAdministrator() && $this->isExistAdministrator($administratorId);
	}
	
	function isExistAdministrator($administratorId){
		$administratorFoundAllRelated = $this->Administrator->findById($administratorId);
		$administratorFound = $administratorFoundAllRelated['Administrator'];
		
		if($administratorFound != null)
			return $administratorFound['exist'];
		else
			return false;
	}
	
	function viewAdministrator($administratorId){
		$this->set('administrator', $this->Administrator->read(null, $administratorId));
	}
	
//************************************************add*******************************************************	
	function add() {
		if($this->canAdd())
			$this->addAdministratorAndRedirectToProperPageIfSuccessfullyAdd();
		else{
			$this->Session->setFlash(__('You have no right to add administrator', true));
			$this->redirect(array('controller' => 'News', 'action' => 'index'));
		}
	}
	
	function canAdd(){
		return $this->hasLogined() && $this->isSuperAdministrator();
	}
	
	function addAdministratorAndRedirectToProperPageIfSuccessfullyAdd(){
		if (!empty($this->data)){
			$addSuccessfully = $this->addAdministratorSuccessfully();
			$this->redirectToProperPageAdd($addSuccessfully);
		}
		
		$groups = $this->Administrator->Group->find('list');
		$this->set(compact('groups'));
	}
	
	function addAdministratorSuccessfully(){
		$this->Administrator->create(array(('name') => $this->data['Administrator']['name'],
										   ('password') => $this->data['Administrator']['password'],
										   ('exist') => true,
										   ('group_id') => $this->data['Administrator']['group_id']
										   )
							        );	
		$success = $this->Administrator->save();
		if($success)
			$this->addNewAdministratorToAro($this->data['Administrator']['name']);
	
		return $success;
	}
	
	function addNewAdministratorToAro($administratorName){
		$parent = $this->Acl->Aro->findByAlias('Normals');
		$administratorFound = $this->getAdministratorByName($administratorName);
		
		$this->Acl->Aro->create(array(('alias') => $administratorName,
									  ('model') => 'Administrator',
					                  ('foreign_key') => $administratorFound['id'],
					                  ('parent_id') => $parent['Aro']['id']
									 )
				               );
		$this->Acl->Aro->save();
	}
	
	function getAdministratorByName($administratorName){
		$administratorFoundAllRelated = $this->Administrator->findByName($administratorName);
		$administratorFound = $administratorFoundAllRelated['Administrator'];
	}
	
	function redirectToProperPageAdd($addSuccessfully){
		if($addSuccessfully){
			$this->Session->setFlash(__('The administrator has been saved', true));
			$this->redirect(array('action' => 'index'));
		}
		else
			$this->Session->setFlash(__('The administrator could not be saved. Please, try again.', true));
	}//*******************************************edit*****************************************

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