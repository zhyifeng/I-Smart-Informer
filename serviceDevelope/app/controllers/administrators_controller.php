<?php
class AdministratorsController extends AppController {

	var $name = 'Administrators';
	var $components = array('Acl');

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
	
	function doLogin($administratorName, $administratorPassword){
		if($this->canLogin($administratorName, $administratorPassword)){
			$this->writeAdministratorToSession($administratorName);
			$this->redirectToProperPageAfterLogin();
		}
		else
			$this->Session->setFlash(__('Invalid login, please check your username and password', true));
	}
	
	function canLogin($administratorName, $administratorPassword){
		if($this->isExistAdministratorByName($administratorName)){
			$administratorFound = $this->getAdministratorByName($administratorName);
			return $this->isPasswordCorrect($administratorFound, $administratorPassword);
		}
		else
			return false;
	}
	
	function isExistAdministratorByName($administratorName){
		$administratorAllRelated = $this->Administrator->findByName($administratorName);
		$administratorFound = $administratorAllRelated['Administrator'];
		
		if($administratorFound != null)
			return $administratorFound['exist'];
		else
			return false;
	}
	
	function getAdministratorByName($administratorName){
		$administratorFoundAllRelated = $this->Administrator->findByName($administratorName);
		$administratorFound = $administratorFoundAllRelated['Administrator'];
		return $administratorFound;
	}
	
	function isPasswordCorrect($administratorChecked, $administratorPassword){
		return $administratorChecked['password'] == $administratorPassword;
	}
	
	function redirectToProperPageAfterLogin(){
		if($this->isSuperAdministrator())
			$this->redirect(array('action' => 'index'));
		else
			$this->redirect(array('controller' => 'news', 'action' => 'index'));
	}
	
	
	function writeAdministratorToSession($administratorName){
		$administratorGot = $this->getAdministratorByName($administratorName);
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
		return $this->isSuperAdministrator();
	}
	

	
	function indexAdministrators(){
		$this->Administrator->recursive = 0;
		$this->set('administrators', $this->indexAdministratorPaginated());
	}
	
	function indexAdministratorPaginated(){
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
			
		if($this->canView())
			$this->viewAdministrator($administratorId);
		else{
			$this->Session->setFlash(__('You have no right to view administrators', true));
			$this->redirect(array('controller' => 'News', 'action' => 'index'));
		}
	}

	function canView(){
		return $this->isSuperAdministrator();
	}
	
	function isExistAdministrator($administratorId){
		$administratorFoundAllRelated = $this->Administrator->findById($administratorId);
		$administratorFound = $administratorFoundAllRelated['Administrator'];
		
		if($administratorFound != null)
			return $administratorFound['exist'];
		else
			return false;
	}
	
	function isNotExistAdministrator($administratorId){
		return !$this->isExistAdministrator($administratorId);
	}
	
	function viewAdministrator($administratorId){
		$this->set('administrator', $this->Administrator->read(null, $administratorId));
	}
	
//************************************************add*******************************************************	
	function add() {
		if(!empty($this->data))
			$this->doAdd();
	
		$groups = $this->Administrator->Group->find('list');
		$this->set(compact('groups'));
	}
	
	function doAdd(){
		if($this->canAdd())
			$this->addAdministratorAndRedirectToProperPageIfSuccessfullyAdd();
		else{
			$this->Session->setFlash(__('You have no right to add administrator', true));
			$this->redirect(array('controller' => 'News', 'action' => 'index'));
		}
	}
	
	function canAdd(){
		return $this->isSuperAdministrator();
	}
	
	function addAdministratorAndRedirectToProperPageIfSuccessfullyAdd(){
		$addSuccessfully = $this->addAdministratorSuccessfully();
		$this->redirectToProperPageAdd($addSuccessfully);
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
	
	function redirectToProperPageAdd($addSuccessfully){
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
			$this->doEdit($administratorId);
		else
			$this->data = $this->Administrator->read(null, $administratorId);
		
		$groups = $this->Administrator->Group->find('list');
		$this->set(compact('groups'));	
	}
	
	function doEdit($administratorId){
		if($this->canEdit()){
			$this->editAdministratorAndRedirectToProperPageIfSuccesfullyEdit($administratorId);
		}
		else{
			$this->Session->setFlash(__('You have no right to edit the administrator', true));
			$this->redirect(array('controller' => 'News', 'action' => 'index'));
		}
	}
	
	function canEdit(){
		return $this->isSuperAdministrator();
	}
	
	function editAdministratorAndRedirectToProperPageIfSuccesfullyEdit($administratorId){
		$editSuccessfully = $this->editAdministratorSucessfully();
		$this->redirectToProperPageEdit($editSuccessfully);
	}
	
	function editAdministratorSucessfully(){
		return $this->Administrator->save($this->data);
	}
	
	function redirectToProperPageEdit($editSuccessfully){
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
		
		if($this->canDelete())
			$this->deleteAdministratorAndRedirectToProperPageIfSuccesfullyDelete($administratorId);
		else{
			$this->Session->setFlash(__('You have no right to delete the administrator', true));
			$this->redirect(array('controller' => 'News', 'action' => 'index'));
		}
	}
	
	function canDelete(){
		return $this->isSuperAdministrator();
	}
	
	function deleteAdministratorAndRedirectToProperPageIfSuccesfullyDelete($administratorId){
		$deleteSuccessfully = $this->deleteAdministratorSuccessfully($administratorId);
		$this->redirectToProperPageDelete($deleteSuccessfully);
	}
	
	//ĞŞ¸Äexist
	function deleteAdministratorSuccessfully($administratorId){
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
	
	function redirectToProperPageDelete($deleteSuccessfully){
		if($deleteSuccessfully){
			$this->Session->setFlash(__('Administrator deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		else{
			$this->Session->setFlash(__('Administrator was not deleted', true));
			$this->redirect(array('action' => 'index'));
		}
	}
	//*************************************************Modify self**************************************
	function modifySelf(){
		if(!empty($this->data))
			$this->doModify();
		else
			$this->data = $this->Administrator->read(null, ($this->Session->read('administrator'))['id']);
			
		$groups = $this->Administrator->Group->find('list');
		$this->set(compact('groups'));
	}
	
	function doModify(){
		if($this->theTwoPasswordsMatch()){
			$success = $this->modifySuccessfully();
			$this->redirectToProperPageModify($success);
		}
		else
			$this->Session->setFlash(__('The two passwords do not match. Try again.', true));
	}
	
	function theTwoPasswordsMatch(){
		return $this->data['Administrator']['password'] == $this->data['Administrator']['passwordConfirm'];
	}
	
	function modifySuccessfully(){
		return $this->Administrator->save($this->data);
	}
	
	function redirectToProperPageModify($success){
		if($success){
			$this->Session->setFlash(__('Successfully modify info of you', true));
			$this->redirect('action' => 'index');
		}
		else
			$this->Session->setFlash(__('Fail to modify info of you, please try again', true));
	}
	
}
?>