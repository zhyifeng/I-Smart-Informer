<?php
//author: ÁÖÃÎÏª
class AdministratorsController extends AppController {

	var $name = 'Administrators';
	//var $components = array('Acl');

	function login(){
		//$this->set('administratora', $this->params);
		if($this->hasLogined()){
			$this->Session->setFlash(__('You have logined. Please logout before you login.', true));
			return;
		}
		if(!empty($this->data)){
			$administratorName = $this->data['Administrator']['name'];
			$administratorPassword = $this->data['Administrator']['password'];
			$this->doLogin($administratorName, $administratorPassword);
		}
	}
	
	private function doLogin($administratorName, $administratorPassword){
		//echo "Hi,boy";
		if($this->canLogin($administratorName, $administratorPassword)){
			$this->writeAdministratorToSession($administratorName);
			$this->redirectToProperPageAfterLogin();
		}
		else
			$this->Session->setFlash(__('Invalid login, please check your username and password', true));
	}
	
	private function canLogin($administratorName, $administratorPassword){
		if($this->isExistAdministratorByName($administratorName)){
			$administratorFound = $this->getAdministratorByName($administratorName);
			return $this->isPasswordCorrect($administratorFound, $administratorPassword);
		}
		else
			return false;
	}
	
	private function isExistAdministratorByName($administratorName){
		$administratorAllRelated = $this->Administrator->findByName($administratorName);
		$administratorFound = $administratorAllRelated['Administrator'];
		
		if($administratorFound != null)
			return $administratorFound['exist'];
		else
			return false;
	}
	
	private function getAdministratorByName($administratorName){
		$administratorFoundAllRelated = $this->Administrator->findByName($administratorName);
		$administratorFound = $administratorFoundAllRelated['Administrator'];
		return $administratorFound;
	}
	
	private function isPasswordCorrect($administratorChecked, $administratorPassword){
		return $administratorChecked['password'] == $administratorPassword;
	}
	
	private function redirectToProperPageAfterLogin(){
		if($this->isSuperAdministrator())
			$this->redirect(array('action' => 'index'));
		else
			$this->redirect(array('controller' => 'news', 'action' => 'index'));
	}
	
	
	private function writeAdministratorToSession($administratorName){
		$administratorGot = $this->getAdministratorByName($administratorName);
		$this->Session->write('administrator', $administratorGot);
	}
	//*******************************************************logout*****************************************
	
	function logout(){
		$this->clearAdministratorInSession();
		$this->redirectToProperPageLogout();
	}
	
	private function clearAdministratorInSession(){
		$this->Session->delete('administrator');
	}
	
	private function redirectToProperPageLogout(){
		$this->redirect(array('action' => 'login'));
	}//***************************************************index***********************************************
	function index() {
		$this->indexAdministrators();
	}

	private function indexAdministrators(){
		$this->Administrator->recursive = 0;
		$this->set('administrators', $this->indexAdministratorPaginated());
	}
	
	private function indexAdministratorPaginated(){
		$administrator = $this->Session->read('administrator');
		$condition = array('Administrator.exist' => true, 'Administrator.id <>' => $administrator['id']);
		return $this->paginate(array($condition));
	}
		//************************************************view***************************************************
	function view($administratorId = null) {
		if($this->isNotExistAdministrator($administratorId)){
			$this->Session->setFlash(__('Invalid administrator', true));
			$this->redirect(array('action' => 'index'));
		}
			
		$this->viewAdministrator($administratorId);
	}
	
	private function isExistAdministrator($administratorId){
		$administratorFoundAllRelated = $this->Administrator->findById($administratorId);
		$administratorFound = $administratorFoundAllRelated['Administrator'];
		
		if($administratorFound != null)
			return $administratorFound['exist'];
		else
			return false;
	}
	
	private function isNotExistAdministrator($administratorId){
		return !$this->isExistAdministrator($administratorId);
	}
	
	function viewAdministrator($administratorId){
		$this->set('administrator', $this->Administrator->read(null, $administratorId));
	}
	
//************************************************add*******************************************************	
	function add() {
		if(!empty($this->data))
			$this->addAdministratorAndRedirectToProperPageIfSuccessfullyAdd();
			
		$this->listGroupNameInView();
	}
	
	private function listGroupNameInView(){
		$groups = $this->Administrator->Group->find('list');
		$this->set(compact('groups'));
	}
	
	private function addAdministratorAndRedirectToProperPageIfSuccessfullyAdd(){
		$addSuccessfully = $this->addAdministratorSuccessfully();
		$this->redirectToProperPageAdd($addSuccessfully);
	}
	
	private function addAdministratorSuccessfully(){
		$this->Administrator->create(array(	
										   ('name') => $this->data['Administrator']['name'],
										   ('password') => $this->data['Administrator']['password'],
										   ('exist') => true,
										   ('group_id') => $this->data['Administrator']['group_id']
										   )
							        );	
		$success = $this->Administrator->save($this->data);
		if($success)
			$this->addNewAdministratorToAro($this->data['Administrator']['name']);
	
		return $success;
	}
	
	private function addNewAdministratorToAro($administratorName){
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
	
	private function redirectToProperPageAdd($addSuccessfully){
		if($addSuccessfully){
			$this->Session->setFlash(__('The administrator has been saved', true));
			$this->redirect(array('action' => 'index'));
		}
		else
			$this->Session->setFlash(__('The administrator could not be saved. Please, try again.', true));
	}//*******************************************edit*****************************************

	function edit($administratorId = null) {
		if($this->isNotExistAdministrator($administratorId)){
			$this->Session->setFlash(__('Invalid administrator', true));
			$this->redirect(array('action' => 'index'));
		}
		
		if(!empty($this->data))
			$this->editAdministratorAndRedirectToProperPageIfSuccesfullyEdit($administratorId);
		else
			$this->data = $this->Administrator->read(null, $administratorId);
		
		$this->listGroupNameInView();	
	}
	
	private function editAdministratorAndRedirectToProperPageIfSuccesfullyEdit($administratorId){
		$editSuccessfully = $this->editAdministratorSucessfully();
		$this->redirectToProperPageEdit($editSuccessfully);
	}
	
	private function editAdministratorSucessfully(){
		return $this->Administrator->save($this->data);
	}
	
	private function redirectToProperPageEdit($editSuccessfully){
		if($editSuccessfully){
			$this->Session->setFlash(__('The administrator has been saved', true));
			$this->redirect(array('action' => 'index'));
		}
		else
			$this->Session->setFlash(__('The administrator could not be saved. Please, try again.', true));
	}

	//*************************************************delete***********************************
	function delete($administratorId = null) {
		if($this->isNotExistAdministrator($administratorId)){
			$this->Session->setFlash(__('Invalid administrator', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$this->deleteAdministratorAndRedirectToProperPageIfSuccesfullyDelete($administratorId);
	}
	
	private function deleteAdministratorAndRedirectToProperPageIfSuccesfullyDelete($administratorId){
		$deleteSuccessfully = $this->deleteAdministratorSuccessfully($administratorId);
		$this->redirectToProperPageDelete($deleteSuccessfully);
	}
	
	private function deleteAdministratorSuccessfully($administratorId){
		$administratorAllRelated = $this->Administrator->findById($administratorId);
		if($administratorAllRelated != null){
			$administrator = $administratorAllRelated['Administrator'];
			$this->Administrator->set($administrator);
			$this->Administrator->set(array('exist' => false));
			return $this->Administrator->save();
		}
		else
			return false;
	}
	
	private function redirectToProperPageDelete($deleteSuccessfully){
		if($deleteSuccessfully){
			$this->Session->setFlash(__('Administrator deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		else{
			$this->Session->setFlash(__('Administrator was not deleted', true));
			$this->redirect(array('action' => 'index'));
		}
	}
	//*************************************************Modify self**************************************	function modifySelf(){
		if(!empty($this->data))
			$this->doModify();
		else
			$this->data = $this->Administrator->read(null, $this->Session->read('administrator.id'));
			
		$this->listGroupNameInView();
	}
	
	private function doModify(){
		if($this->theTwoPasswordsMatch()){
			$success = $this->modifySuccessfully();
			$this->redirectToProperPageModify($success);
		}
		else
			$this->Session->setFlash(__('The two passwords do not match. Try again.', true));
	}
	
	private function theTwoPasswordsMatch(){
		return $this->data['Administrator']['password'] == $this->data['Administrator']['passwordConfirm'];
	}
	
	private function modifySuccessfully(){
		return $this->Administrator->save($this->data);
	}
	
	private function redirectToProperPageModify($success){
		if($success){
			$this->Session->write('administrator.password', $this->data['Administrator']['password']);
			$this->Session->setFlash(__('Successfully modify info of you', true));
			$this->redirect(array('action' => 'index'));
		}
		else
			$this->Session->setFlash(__('Fail to modify info of you, please try again', true));
	}
	
}
?>