<?php
/* Administrators Test cases generated on: 2011-01-01 06:01:08 : 1293862688*/
App::import('Controller', 'Administrators');

class TestAdministratorsController extends AdministratorsController {
	//var $name = 'Administrators';
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
	
	/*function render($action = null, $layout = null, $file = null) {
        $this->renderedAction = $action;
    }
 
    function _stop($status = 0) {
        $this->stopped = $status;
    }*/
}

class AdministratorsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.administrator', 'app.group', 'app.group_type', 'app.student', 'app.news');

	function startTest() {
		$this->Administrators =& new TestAdministratorsController();
		$this->Administrators->constructClasses();
		$this->Administrators->Component->initialize($this->Administrators);
	}

	function endTest() {
		$this->Administrators->Session->destroy();
		unset($this->Administrators);
		ClassRegistry::flush();
	}

	function testSuperAdministratorSucessfullyLoginAndWriteTheSession() {
		$this->Administrators->data = array(
			'Administrator' => array(
				'name' => 'root',
				'password' => '123456'
			)
		);
		
		$this->Administrators->login();
		
		$resultOfSession = $this->Administrators->Session->read('administrator');
		
		$expectedOfSession = array(
			'id' => 1,
			'name' => 'root',
			'password' => '123456',
			'exist' => '1',
			'group_id' => '6'
			);
			
		$this->assertEqual($resultOfSession, $expectedOfSession); 
	}
	
	function testNormalAdministratorSucessfullyLoginAndWriteTheSession() {
		$this->Administrators->data = array(
			'Administrator' => array(
				'name' => 'google',
				'password' => '123456'
			)
		);
		
		$this->Administrators->login();
		
		$resultOfSession = $this->Administrators->Session->read('administrator');
		
		$expectedOfSession = array(
			'id' => 14,
			'name' => 'google',
			'password' => '123456',
			'exist' => '1',
			'group_id' => '6'
			);
			
		$this->assertEqual($resultOfSession, $expectedOfSession); 
	}
	
	function testSuperAdministratorSuccessfullyLoginAndRedirectToAdministratorIndex(){
		$this->Administrators->data = array(
			'Administrator' => array(
				'name' => 'root',
				'password' => '123456'
			)
		);
		
		$this->Administrators->login();
		
		$result = $this->Administrators->redirectUrl;
		$expected = array('action' => 'index');
		$this->assertEqual($result, $expected);
	}
	
	function testNormalAdministratorSuccessfullyLoginAndRedirectToNewsIndex(){
		$this->Administrators->data = array(
			'Administrator' => array(
				'name' => 'google',
				'password' => '123456'
			)
		);
		
		$this->Administrators->login();
		
		$result = $this->Administrators->redirectUrl;
		$expected = array('controller' => 'news', 'action' => 'index');
		//debug($result);
		$this->assertEqual($result, $expected);
	}
	
	function testUnsuccessfullyLoginBecauseOfAdministratorNotExistInDataBase(){
		$this->Administrators->data = array(
			'Administrator' => array(
				'name' => 'ufo',
				'password' => '123456'
			)
		);
		
		$this->Administrators->login();
		$this->assertEqual($this->Administrators->Session->read('administrator'), null);
		//$this->assertTrue($this->Administrators->Session->check('Message.flash.message'));
	}
	
	function testUnsuccessfullyLoginBecauseOfWrongPassword(){
		$this->Administrators->data = array(
			'Administrator' => array(
				'name' => 'root',
				'password' => '123'
			)
		);
		
		$this->Administrators->login();
		$this->assertEqual($this->Administrators->Session->read('administrator'), null);
		//$this->assertTrue($this->Administrators->Session->check('Message.flash.message'));
	}
	
	function testUnsuccessfullyLoginBecauseAdministratorStatusInDataBaseIsNotExist(){
		$this->Administrators->data = array(
			'Administrator' => array(
				'name' => 'wa',
				'password' => '123456'
			)
		); 
				$this->Administrators->login();
		$this->assertEqual($this->Administrators->Session->read('administrator'), null);
	}
	
	function testUnsuccessfullyLoginBecauseHasLogin(){
		$administrator = array(
			'id' => '1',
			'name' => 'root',
			'password' => '123456',
			'exist' => '1',
			'group_id' => '6'
		);
		$this->Administrators->Session->write('administrator', $administrator);
		
		$this->Administrators->login();
		
		$this->assertTrue($this->Administrators->Session->check('Message.flash.message'));
	}
		
	function testLogoutAndClearSession() {
		$administrator = array(
			'id' => '1',
			'name' => 'root',
			'password' => '123456',
			'exist' => '1',
			'group_id' => '6'
		);
		$this->Administrators->Session->write('administrator', $administrator);
		
		$this->Administrators->logout();
		
		$result = $this->Administrators->Session->read('administrator');
		$this->assertEqual($result, null);
	}
	
	function testLogoutAndRedirectToLogin(){
		$administrator = array(
			'id' => '1',
			'name' => 'root',
			'password' => '123456',
			'exist' => '1',
			'group_id' => '6'
		);
		$this->Administrators->Session->write('administrator', $administrator);
		
		$this->Administrators->logout();
		
		$this->assertEqual($this->Administrators->redirectUrl, array('action' => 'login'));
	}

	function testView() {

	}

	function testViewAdministrator() {

	}

	function testAddSuccessfully() {
		$this->Administrators->data = array(
			'Administrator' => array(
				'id' => '99',
				'name' => 'unix',
				'password' => '123456',
				'group_id' => '4'
			)
		);

		$this->Administrators->add();
		
		$result = $this->Administrators->Administrator->read(null, 99);
		$this->assertEqual($result['Administrator']['name'], 'unix');
			
	}
	
	function testAddUnsuccessfullyBecauseOfRepeatName(){
		$this->Administrators->data = array(
			'Administrator' => array(
				'name' => 'root',
				'password' => '123456',
				'group_id' => '4'
			)
		);
		
		$this->Administrators->add();
		
		$this->assertTrue($this->Administrators->Session->check('Message.flash.message'));
	}
			
	function testEditAdministratorSuccessfully() {
		$this->Administrators->data = array(
			'Administrator' => array(
				'id' => '1',
				'name' => 'root',
				'password' => 'I am root',
				'group_id' => '4'
			)
		);
		
		$this->Administrators->edit(1);
		
		$resultAllRelated = $this->Administrators->Administrator->read(null, 1);
		$result = $resultAllRelated['Administrator'];
		$expected = array(
				'id' => '1',
				'name' => 'root',
				'password' => 'I am root',
				'exist' => '1',
				'group_id' => '4'
				);
		
		$this->assertEqual($result, $expected);
	}
	
	function testEditWithNullId(){
		$this->Administrators->edit();
		$this->assertTrue($this->Administrators->Session->check('Message.flash.message'));
	}
	
	function testEditWithIdNotExist(){
		$this->Administrators->data = array(
			'Administrator' => array(
				'id' => '9999',
				'name' => 'root',
				'password' => 'I am root',
				'group_id' => '4'
			)
		);
		
		$this->Administrators->edit(9999);
		
		$this->assertTrue($this->Administrators->Session->check('Message.flash.message'));
	}
	
	function testDeleteSuccessfully() {
		$this->Administrators->delete(1);
		
		$resultAllRelated = $this->Administrators->Administrator->read(null, 1);
		$result = $resultAllRelated['Administrator']['exist'];
		
		$this->assertEqual($result, 0);
	}
	
	function testDeleteWithIdNull(){
		$this->Administrators->delete();
		$this->assertTrue($this->Administrators->Session->check('Message.flash.message'));
	}
	
	function testDeleteWithIdNotExist(){
		$this->Administrators->delete(99999);
		$this->assertTrue($this->Administrators->Session->check('Message.flash.message'));
	}

	function testModifySelfSuccessfully() {
		$administrator = array(
			'id' => '1',
			'name' => 'root',
			'password' => '123456',
			'exist' => '1',
			'group_id' => '6'
		);
		$this->Administrators->Session->write('administrator', $administrator);
		
		$this->Administrators->data = array(
			'Administrator' => array(
				'id' => '1',
				'name' => 'root',
				'password' => 'I am root',
				'passwordConfirm' => 'I am root',
				'group_id' => '4'
			)
		);
		
		$this->Administrators->ModifySelf();
		
		$resultAllRelated = $this->Administrators->Administrator->read(null, 1);
		$result = $resultAllRelated['Administrator'];
		$expected = array(
			'id' => '1',
			'name' => 'root',
			'password' => 'I am root',
			'exist' => '1',
			'group_id' => '4'
		);
		
		$this->assertEqual($result, $expected);
	}
	
	function testModifySelfUnsuccessfullyBecausePasswordNotMatch(){
		$administrator = array(
			'id' => '1',
			'name' => 'root',
			'password' => '123456',
			'exist' => '1',
			'group_id' => '6'
		);
		$this->Administrators->Session->write('administrator', $administrator);
		
		$this->Administrators->data = array(
			'Administrator' => array(
				'id' => '1',
				'name' => 'root',
				'password' => 'I am root',
				'passwordConfirm' => 'I am ro',
				'group_id' => '4'
			)
		);
		
		$this->Administrators->ModifySelf();
		
		$resultAllRelated = $this->Administrators->Administrator->read(null, 1);
		$result = $resultAllRelated['Administrator'];
		$expected = array(
			'id' => '1',
			'name' => 'root',
			'password' => '123456',
			'exist' => '1',
			'group_id' => '6'
		);
		
		$this->assertEqual($result, $expected);
	}

}
?>