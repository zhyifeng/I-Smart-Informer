<?php  
class AppController extends Controller{   
	function checkIfHasLogined(){
		if ($this->hasNotLogined())  {  
			$this->Session->setFlash(__('Please login!', true));
			$this->redirect('/administrators/login');
			exit();   
		}
	}
	
	function hasLogined(){
		if($this->Session->read('administrator') == NULL)
			return false;
		else
			return true;
	}
	
	function hasNotLogined(){
		return !$this->hasLogined();
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
	
	function isNormalAdministrator(){
		return !$this->isSuperAdministrator();
	}
	
	function notDoingLogin(){
		return $this->params['action'] != "login";
	}
	
	function beforefilter(){
		if($this->notDoingLogin())
			$this->checkIfHasLogined();
	}
}   
?>