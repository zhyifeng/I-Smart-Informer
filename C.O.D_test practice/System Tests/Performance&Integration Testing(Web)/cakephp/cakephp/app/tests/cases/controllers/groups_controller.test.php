<?php
/* Groups Test cases generated on: 2011-01-01 16:01:22 : 1293899482*/
App::import('Controller', 'Groups');
App::import('Component', 'Session');
Mock::generate('SessionComponent');
class TestGroupsController extends GroupsController {
	var $name = 'Groups';
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
 
    function render($action = null, $layout = null, $file = null) {
        $this->renderedAction = $action;
    }
 
    function _stop($status = 0) {
        $this->stopped = $status;
    }
}

class GroupsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.group', 'app.group_type', 'app.administrator', 'app.news', 'app.student');

	function startTest() {
		$this->Groups =& new TestGroupsController();
		$this->Groups->constructClasses();
		 $this->Groups->Component->initialize($this->Groups);
	}

	function endTest() {
	$this->Groups->Session->destroy();
		unset($this->Groups);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {
	$this->Groups->Session->write('administrator', array(
        'id' => 1,
        'name' => 'root',
		'password' => '123456',
		'exist' => '1',
		'group_id' => '6'		
    ));
	
	 $this->Groups->data = array(
        'Group' => array(
            'id' => 5,
           'name' => 'testGroup',
        ),
        );
		
    $this->Groups->params = Router::parse('/Groups/add/');
    $this->Groups->beforeFilter();
    $this->Groups->Component->startup($this->Groups);
    $this->Groups->add();
 
    //assert the record was changed
    $result = $this->Groups->Group->read(null, 5);
    $this->assertEqual($result['Group']['name'], 'testGroup');
 
    //assert that some sort of session flash was set.
	//$this->GroupTypes->Session->flash();
    $this->assertTrue($this->Groups->Session->check('Message.flash.message'));
    $this->assertEqual($this->Groups->redirectUrl, array('action' => 'index'));
	}

	function testEditIdnotNUll() {
	
	$this->Groups->Session = new MockSessionComponent();
	$this->Groups->Session->enabled = true;
	$this->Groups->Session->setReturnValue('read', 1, array('administrator'));
	
    $this->Groups->data = array(
        'Group' => array(
            'id' => 6,
           'name' => 'testGroup',
		   'groupType_id' => '2',
        ),
        );
	
    $this->Groups->params = Router::parse('/Groups/edit/2');
    $this->Groups->beforeFilter();
    $this->Groups->Component->startup($this->Groups);
    $this->Groups->edit();
 
    //assert the record was changed
    $result = $this->Groups->Group->read(null, 6);
    $this->assertEqual($result['Group']['name'], 'testGroup');
 
    //assert that some sort of session flash was set.
    $this->assertEqual($this->Groups->redirectUrl, array('action' => 'index'));
	}

	function testDelete() {
	$this->Groups->Session->write('administrator', array(
        'id' => 1,
        'name' => 'root',
		'password' => '123456',
		'exist' => '1',
		'group_id' => '6'		
    ));
		
    $this->Groups->params = Router::parse('/Groups/delete/6');
    $this->Groups->beforeFilter();
    $this->Groups->Component->startup($this->Groups);
    $this->Groups->delete(6);
	}


}
?>