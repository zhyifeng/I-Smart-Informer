<?php
//author: еёХ╢ё╛ажцно╙ё╛в╞вс≤╠
App::import('Model', 'GroupRelation');
class StudentsController extends AppController {

	var $name = 'Students';
	var $groupRelation;
	
	function __construct()
	{
		parent:: __construct();
		$this->groupRelation = &new GroupRelation();
	}
	
	function __construct1($_groupRelation)
	{
		parent:: __construct();
		$this->groupRelation = _groupRelation;
	}
	
	function index() {
		$this->Student->recursive = 0;
		$this->set('students', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid student', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('student', $this->Student->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Student->create();
			if ($this->Student->save($this->data)) {
				$this->Session->setFlash(__('The student has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The student could not be saved. Please, try again.', true));
			}
		}
		$groups = $this->Student->Group->find('list');
		$this->set(compact('groups'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid student', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Student->save($this->data)) {
				$this->Session->setFlash(__('The student has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The student could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Student->read(null, $id);
		}
		$groups = $this->Student->Group->find('list');
		$this->set(compact('groups'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for student', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Student->delete($id)) {
			$this->Session->setFlash(__('Student deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Student was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	
	function loginFromPhone()
	{
		$this->layout = 'blank';
		if($_POST != NULL)
		{
			$studentInfoTocheck = json_decode($_POST['UserInfo'],true);
			$studentInfo = $this->getStudentInfo($studentInfoTocheck['UserID'],$studentInfoTocheck['UserPassword']);
			//if($studentInfo['isExist'] == true)
				//$this->writeStudentToSession($studentInfoTocheck['UserID'], $studentInfoTocheck['UserPassword']);
		
			echo json_encode($studentInfo); 
		}
	}
	
	private function writeStudentToSession($studentName, $studentPassword){
		$studentAllRelated = $this->Student->findByName($studentName);
		$studentFound = $studentAllRelated['Student'];
		$this->Session->write('student', $studentFound);
	}
	
	function logout(){
		$this->Session->delete('student');
	}
		
	
	 function getStudentInfo( $name, $password )
	{
		$studentInfo = array(
							'isExist' => false,
							"classId" => NULL,
							"schoolId" => NULL,
							"universityId" => NULL);
		$student = $this->findStudenthroughStudentNameAndPwd($name, $password);
		if( $student != NULL )
		{
			$studentInfo['isExist'] = true;
			$studentInfo['classId'] = $this->findClassthroughStudent($student);
			$studentInfo['schoolId'] = $this->findSchoolThroughClass($studentInfo['classId']);
			$studentInfo['universityId'] =$this->findUniversityThroughSchool($studentInfo['schoolId']);
		}							
		return $studentInfo;
		//var_dump($studentInfo);										
	}
	//return the student record if the student and pwd exist in the database, otherwise, return null
	private function findStudenthroughStudentNameAndPwd($name, $password)
	{
		$student = $this->Student->find( 'all', array(
										'conditions' => array(
										'Student.name' => $name, 'password' => $password)));
		return $student;
	}
	private function findClassthroughStudent($student)
	{
		return $student[0]["Student"]["group_id"];
	}
	private function findSchoolThroughClass($classId)
	{
		//$this->loadModel('GroupRelation');
		//$schoolId = $this->GroupRelation->findGroupOwnerId($classId);
		$schoolId = $this->groupRelation->findGroupOwnerId($classId);
		
		return $schoolId;
	}
	private function findUniversityThroughSchool($schoolId)
	{
		//$this->loadModel('GroupRelation');
		//$universityId = $this->GroupRelation->findGroupOwnerId($schoolId);
		$universityId = $this->groupRelation->findGroupOwnerId($schoolId);
		return $universityId;
	}
	
}

?>