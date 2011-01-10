<?php
/* News Test cases generated on: 2011-01-01 10:01:18 : 1293877818*/
App::import('Controller', 'News');

class TestNewsController extends NewsController {
	var $name = 'News';
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

class NewsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.news', 'app.administrator', 'app.group', 'app.group_type', 'app.student');

	function startTest() {
		$this->News =& new TestNewsController();
		$this->News->constructClasses();
		$this->News->Component->initialize($this->News);
	}

	function endTest() {
		$this->News->Session->destroy();
		unset($this->News);
		ClassRegistry::flush();
	}

	function testSearchNewsByKeyword() {

	}
	
	function testFindNewsByGroupIdSuccessfully(){
	
		$result = $this->News->findNewsByGroupId(11);
		$expected = array(
			array('title' => 'Hello_tester', 'text' => 'Hello world', 'date' => '2011-01-01 21:50:57'),
			array('title' => 'Hi_tester', 'text' => 'Hi, world', 'date' => '2011-01-01 21:51:17')
		);
		
		$this->assertEqual($result, $expected);
		
	}		

	function testResposePhoneRequstToFindNews() {

	}

	function testView() {

	}

	function testAddSuccessfully() {
	
		$this->News->Session->write('administrator', array(
			'id' => 1,
			'name' => 'root',
			'password' => '123456',
			'exist' => '1',
			'group_id' => '6'		
			)
		);
		
		$this->News->data = array(
			'News' => array(
				'id' => '99',
				'title' => 'she',
				'text' => 'so beautiful',
				'date' => '2010-12-10 23:34:51',
				'administrator_id' => '20'
			)
		);
		
		$this->News->params = Router::parse('/News/add/');
		$this->News->beforeFilter();
		$this->News->Component->startup($this->News);
		$this->News->add();
		
		$resultAllRelated = $this->News->News->read(null, 99);
		$result = $resultAllRelated['News'];
		$expected = array(
				'id' => '99',
				'title' => 'she',
				'text' => 'so beautiful',
				'date' => '2010-12-10 23:34:51',
				'administrator_id' => '20'
			);
		
		$this->assertEqual($result, $expected);
	}

	function testEditIdnotNUll() {
	
	 $this->News->Session->write('administrator', array(
        'id' => 1,
        'name' => 'root',
		'password' => '123456',
		'exist' => '1',
		'group_id' => '6'		
    ));
	
    $this->News->data = array(
        'News' => array(
          'id' => '1',
		'title' => 'testGroup',
		'text' => 'dsf',
		'date' => '2010-12-04 05:08:00',
		'administrator_id' => '1'
        ),
        );
	
    $this->News->params = Router::parse('/News/edit/1');
    $this->News->beforeFilter();
    $this->News->Component->startup($this->News);
    $this->News->edit(1);
 
    //assert the record was changed
    $result = $this->News->News->read(null, 1);
    $this->assertEqual($result['News']['title'], 'testGroup');
 
    //assert that some sort of session flash was set.
    $this->assertEqual($this->News->redirectUrl, array('action' => 'index'));
	}

	function testDeleteSuccessfully() {
		$this->News->Session->write('administrator', array(
			'id' => 1,
			'name' => 'root',
			'password' => '123456',
			'exist' => '1',
			'group_id' => '6'		
			)
		);
	
		$this->News->delete(1);
		
		$result = $this->News->News->read(null, 1);
		
		$this->assertEqual($result, null);
	}
	
	function testDeleteWithIdNull(){
		$this->News->delete();
		$this->assertTrue($this->News->Session->check('Message.flash.message'));
	}
	
	function testDeleteWithIdNotExist(){
		$this->News->delete(99999);
		$this->assertTrue($this->News->Session->check('Message.flash.message'));
	}

}
?>