<?php
/* Students Test cases generated on: 2011-01-01 06:01:05 : 1293864965*/
App::import('Controller', 'Students');
App::import('Model', 'GroupRelation');
Mock::generate('GroupRelation');
App::import('Component', 'Session');
Mock::generate('SessionComponent');

class TestStudentsController extends StudentsController {
	var $autoRender = false;
	
	function __construct1($_groupRelation)
	{
		parent:: __construct1($_groupRelation);
	}
	
	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class StudentsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.student', 'app.group', 'app.group_type','app.group_relation', 'app.administrator', 'app.news');

	function startTest() {
	//	$this->Students =& new TestStudentsController();
	//	$this->Students->constructClasses();
	}

	function endTest() {
		unset($this->Students);
		ClassRegistry::flush();
	}


	function testAdd() {
		$this->Students =& new TestStudentsController();
		$this->Students->constructClasses();
		
	$this->Students->Session = new MockSessionComponent();
	$this->Students->Session->enabled = true;
	$this->Students->Session->setReturnValue('read', 1, array('administrator'));
	
	 $this->Students->data = array(
        'Student' => array(
            'id' => 5,
           'name' => 'ss',
		   'password'=>'123456',
		   'group_id' => '6'
        ),
        );
		
    $this->Students->params = Router::parse('/Student/add/');
    $this->Students->beforeFilter();
    $this->Students->Component->startup($this->Student);
    $this->Students->add();
 
  
    $result = $this->Students->Student->read(null, 5);
    $this->assertEqual($result['Student']['name'], 'ss');
	$this->assertEqual($result['Student']['password'], '123456');
 
 
    $this->assertEqual($this->Students->redirectUrl, array('action' => 'index'));
	

	}

	function testEdit() {
	
	$this->Students =& new TestStudentsController();
	$this->Students->constructClasses();
		
	$this->Students->Session = new MockSessionComponent();
	$this->Students->Session->enabled = true;
	$this->Students->Session->setReturnValue('read', 1, array('administrator'));
	
	 $this->Students->data = array(
        'Student' => array(
            'id' => 3,
           'name' => 'ss',
		   'password'=>'123456',
		   'group_id' => '6'
        ),
        );
		
    $this->Students->params = Router::parse('/Student/edit/');
    $this->Students->beforeFilter();
    $this->Students->Component->startup($this->Student);
    $this->Students->edit();
 
    //assert the record was changed
    $result = $this->Students->Student->read(null, 3);
    $this->assertEqual($result['Student']['name'], 'ss');
	$this->assertEqual($result['Student']['password'], '123456');
 
    //assert that some sort of session flash was set.
    $this->assertEqual($this->Students->redirectUrl, array('action' => 'index'));

	}

	function testDelete() {
	
		$this->Students =& new TestStudentsController();
		$this->Students->constructClasses();
		
		$this->Students->Session = new MockSessionComponent();
		$this->Students->Session->enabled = true;
		$this->Students->Session->setReturnValue('read', 1, array('administrator'));
		
		 $this->Students->data = array(
			'Student' => array(
				'id' => 5,
			   'name' => 'ss',
			   'password'=>'123456',
			   'group_id' => '6'
			),
			);
		//make sure that the initial data is empty
		$result = $this->Students->Student->read(null, 5);		
		$this->assertEqual($result['Student']['name'], null);
		
		$this->Students->params = Router::parse('/Student/add/');
		$this->Students->beforeFilter();
		$this->Students->Component->startup($this->Student);
		$this->Students->add();
	 
		//make sure that the data has been inserted into the table
		$result = $this->Students->Student->read(null, 5);
		$this->assertEqual($result['Student']['name'], 'ss');
		
		$this->Students->delete(5);
		
		//make sure that the data has already been deleted.
		$result = $this->Students->Student->read(null, 5);
		$this->assertEqual($result['Student']['name'], null);
		
		
	
	

	}

	/*
	function test_findStudenthroughStudentNameAndPwd_existData()
	{
		
		$groupRelation = &new MockGroupRelation();
		$groupRelation->enabled = true;
		$groupRelation->setReturnValue('findGroupOwnerId', 111);
		$id = $groupRelation->findGroupOwnerId(5);
		debug($id);
		$this->Students =& new TestStudentsController($groupRelation);
		$this->Students->constructClasses();
		
		$name = 'niulu';
		$pwd = '111111';
		
		$studentInfoResult = $this->Students->getStudentInfo($name,$pwd);
		debug($studentInfoResult);
	//	$this->Student->Component->startup($this->Student);
	
	 
		//assert the record was changed
	//	$result = $this->Student->GroupType->read(null, 2);
	//	$this->assertEqual($result['GroupType']['name'], 'testGroup');
	  //  $this->assertEqual(Set::extract('/Tag/id', $result), array(1,2,3));
	 
		//assert that some sort of session flash was set.
		//$this->assertEqual($this->Student->redirectUrl, array('action' => 'index'));
	}
	*/


}
?>