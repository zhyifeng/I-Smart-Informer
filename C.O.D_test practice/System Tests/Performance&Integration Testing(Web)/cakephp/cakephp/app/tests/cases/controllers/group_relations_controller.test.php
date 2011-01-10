<?php
/* GroupRelations Test cases generated on: 2011-01-02 07:01:42 : 1293954642*/
App::import('Controller', 'GroupRelations');
App::import('Component', 'Session');
Mock::generate('SessionComponent');
class TestGroupRelationsController extends GroupRelationsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class GroupRelationsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.group_relation', 'app.group', 'app.group_type', 'app.administrator', 'app.news', 'app.student');

	function startTest() {
		$this->GroupRelations =& new TestGroupRelationsController();
		$this->GroupRelations->constructClasses();
		 $this->GroupRelations->Component->initialize($this->GroupRelations);
	}

	function endTest() {
		 $this->GroupRelations->Session->destroy();
		unset($this->GroupRelations);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {
	 $this->GroupRelations->Session->write('administrator', array(
        'id' => 1,
        'name' => 'root',
		'password' => '123456',
		'exist' => '1',
		'group_id' => '6'		
    ));
	
	 $this->GroupRelations->data = array(
        'GroupRelation' => array(
            'id' => 5,
           'groupOwner_id' => 10,
		   'groupOwned_id' => 9,
        ),
        );
		
    $this->GroupRelations->params = Router::parse('/GroupRelations/add/');
    $this->GroupRelations->beforeFilter();
    $this->GroupRelations->Component->startup($this->GroupRelations);
    $this->GroupRelations->add();
 
    //assert the record was changed
    $result = $this->GroupRelations->GroupRelation->read(null, 5);
    $this->assertEqual($result['GroupRelation']['groupOwner_id'], 10);
 
    //assert that some sort of session flash was set.
	//$this->GroupRelations->Session->flash();
    $this->assertTrue($this->GroupRelations->Session->check('Message.flash.message'));
    $this->assertEqual($this->GroupRelations->redirectUrl, array('action' => 'index'));
	}

	function testIsValidRelationOtherwiseSetError() {

	}

	function testEditIdnotNull() {
	$this->GroupRelations->Session = new MockSessionComponent();
	$this->GroupRelations->Session->enabled = true;
	$this->GroupRelations->Session->setReturnValue('read', 1, array('administrator'));
	
    $this->GroupRelations->data = array(
        'GroupRelation' => array(
            'id' => 6,
           'groupOwner_id' => 10,
		   'groupOwned_id' => 9,
        ),
        );
	
    $this->GroupRelations->params = Router::parse('/GroupRelations/edit/2');
    $this->GroupRelations->beforeFilter();
    $this->GroupRelations->Component->startup($this->GroupRelations);
    $this->GroupRelations->edit();
 
    //assert the record was changed
    $result = $this->GroupRelations->GroupRelation->read(null, 6);
    $this->assertEqual($result['GroupRelation']['groupOwner_id'], 10);
 
    //assert that some sort of session flash was set.
    $this->assertEqual($this->GroupRelations->redirectUrl, array('action' => 'index'));
	}

	function testDelete() {
	$this->GroupRelations->Session->write('administrator', array(
        'id' => 1,
        'name' => 'root',
		'password' => '123456',
		'exist' => '1',
		'group_id' => '6'		
    ));
	
	$this->GroupRelations->data = array(
        'GroupRelation' => array(
            'id' => 6,
           'groupOwner_id' => 10,
		   'groupOwned_id' => 9,
        ),
        );
	$this->GroupRelations->add();
	
		
    $this->GroupRelations->params = Router::parse('/GroupRelations/delete/6');
    $this->GroupRelations->beforeFilter();
    $this->GroupRelations->Component->startup($this->GroupRelations);
    $this->GroupRelations->delete(6);
	}

}
?>