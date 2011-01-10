<?php
/* GroupTypes Test cases generated on: 2011-01-01 02:01:33 : 1293848013*/
App::import('Controller', 'GroupTypes');
App::import('Component', 'Session');
Mock::generate('SessionComponent');

class TestGroupTypesController extends GroupTypesController {
	var $name = 'GroupTypes';
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

class GroupTypesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.group_type');

	function startTest() {
		$this->GroupTypes =& new TestGroupTypesController();
		$this->GroupTypes->constructClasses();
		 $this->GroupTypes->Component->initialize($this->GroupTypes);
	}

	function endTest() {
		 $this->GroupTypes->Session->destroy();
		unset($this->GroupTypes);
		ClassRegistry::flush();
	}

	

	function testAdd() {
	 $this->GroupTypes->Session->write('administrator', array(
        'id' => 1,
        'name' => 'root',
		'password' => '123456',
		'exist' => '1',
		'group_id' => '6'		
    ));
	
	 $this->GroupTypes->data = array(
        'GroupType' => array(
            'id' => 5,
           'name' => 'testGroup',
        ),
        );
		
    $this->GroupTypes->params = Router::parse('/GroupTypes/add/');
    $this->GroupTypes->beforeFilter();
    $this->GroupTypes->Component->startup($this->GroupTypes);
    $this->GroupTypes->add();
 
    //assert the record was changed
    $result = $this->GroupTypes->GroupType->read(null, 5);
    $this->assertEqual($result['GroupType']['name'], 'testGroup');
 
    //assert that some sort of session flash was set.
	//$this->GroupTypes->Session->flash();
    $this->assertTrue($this->GroupTypes->Session->check('Message.flash.message'));
    $this->assertEqual($this->GroupTypes->redirectUrl, array('action' => 'index'));
	

	}

	function testEditIdnotNUll() {
	
	$this->GroupTypes->Session = new MockSessionComponent();
	$this->GroupTypes->Session->enabled = true;
	$this->GroupTypes->Session->setReturnValue('read', 1, array('administrator'));
	
    $this->GroupTypes->data = array(
        'GroupType' => array(
            'id' => 2,
           'name' => 'testGroup',
        ),
        );
	
    $this->GroupTypes->params = Router::parse('/GroupTypes/edit/2');
    $this->GroupTypes->beforeFilter();
    $this->GroupTypes->Component->startup($this->GroupTypes);
    $this->GroupTypes->edit();
 
    //assert the record was changed
    $result = $this->GroupTypes->GroupType->read(null, 2);
    $this->assertEqual($result['GroupType']['name'], 'testGroup');
  //  $this->assertEqual(Set::extract('/Tag/id', $result), array(1,2,3));
 
    //assert that some sort of session flash was set.
    $this->assertEqual($this->GroupTypes->redirectUrl, array('action' => 'index'));
	}
	
	function testEditIdEqualsNUll() {
	//ÊÇÊ²Ã´£¿
	 $this->GroupTypes->Session->write('administrator', array(
        'id' => 1,
        'name' => 'root',
		'password' => '123456',
		'exist' => '1',
		'group_id' => '6'		
    ));
    $this->GroupTypes->data = null;
    $this->GroupTypes->params = Router::parse('/GroupTypes/edit/');
    $this->GroupTypes->beforeFilter();
    $this->GroupTypes->Component->startup($this->GroupTypes);
    $this->GroupTypes->edit();
 
    //assert that some sort of session flash was set.
    $this->assertTrue($this->GroupTypes->Session->check('Message.flash.message'));
    $this->assertEqual($this->GroupTypes->redirectUrl, array('action' => 'index'));
	}

	function testDelete() {
	 $this->GroupTypes->Session->write('administrator', array(
        'id' => 1,
        'name' => 'root',
		'password' => '123456',
		'exist' => '1',
		'group_id' => '6'		
    ));
		
    $this->GroupTypes->params = Router::parse('/GroupTypes/delete/2');
    $this->GroupTypes->beforeFilter();
    $this->GroupTypes->Component->startup($this->GroupTypes);
    $this->GroupTypes->delete(2);
 
    //assert the record was changed
    $result = $this->GroupTypes->GroupType->read(null, 2);
    $this->assertEqual($result, null);
 
    //assert that some sort of session flash was set.
    $this->assertTrue($this->GroupTypes->Session->check('Message.flash.message'));
    $this->assertEqual($this->GroupTypes->redirectUrl, array('action' => 'index'));
	}
	
/*	function testIndex() {
		 $this->GroupTypes->Session->write('administrator', array(
        'id' => 1,
        'name' => 'root',
		'password' => '123456',
		'exist' => '1',
		'group_id' => '6'		
    ));
		$result = $this->testAction('/GroupTypes/index',array('return' =>'vars',  'fixturize' => true));
		debug($result);

	}

	function testView() {
	$result = $this->testAction('/GroupTypes/view/2',array('return' =>'vars',  'fixturize' => true));
	debug($result);

	}
	*/
}
?>