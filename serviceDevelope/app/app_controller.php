<?php  
class AppController extends Controller{ 
	var $components = array('Acl', 'Session');
  
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
		//$this->set('administratora', $this->params);
		return $this->params['action'] != "login";
	}
	
	function doingWhatSuperAdministratorCanDo(){
		//$this->set('administratora', $this->params);
		return ($this->params['controller'] == 'administrators' && $this->params['action'] != 'login') || $this->params['controller'] == 'group_types'
				|| $this->params['controller'] == 'groups' || $this->params['controller'] == 'group_relations'
				|| $this->params['controller'] == 'students';
	}
	
	function doingWhatNormalAdministratorCanDo(){
		return $this->params['controller'] == 'news'
				//|| ($this->params['controller'] == 'administrator' && $this->params['action'] == 'modifySelf')
				|| ($this->params['controller'] == 'administrators' && $this->params['action'] == 'logout')
				;
	}
	
	function checkIfSuperAdministrator(){
		if(!$this->isSuperAdministrator()){
			$this->Session->setFlash(__('You have no right to access this action.', true));
			$this->redirect(array('controller' => 'News', 'action' => 'index'));
		}
	}
	
	function checkIfNormalAdministrator(){
		if(!$this->isNormalAdministrator()){
			$this->Session->setFlash(__('You have no right to access this action.', true));
			$this->redirect(array('controller' => 'Administrators', 'action' => 'index'));
		}
	}
	
	function beforefilter(){
		if($this->notDoingLogin())
			$this->checkIfHasLogined();
		
		if($this->doingWhatSuperAdministratorCanDo() && !$this->doingWhatNormalAdministratorCanDo()){
			//$this->set('administratora', $this->params);
			$this->checkIfSuperAdministrator();
		}
		
		if($this->doingWhatNormalAdministratorCanDo() && !$this->doingWhatSuperAdministratorCanDo())
			$this->checkIfNormalAdministrator();
	}
}   
?>