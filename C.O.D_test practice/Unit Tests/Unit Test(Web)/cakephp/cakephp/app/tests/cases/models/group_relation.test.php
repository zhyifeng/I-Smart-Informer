<?php
/* GroupRelation Test cases generated on: 2011-01-01 09:01:13 : 1293874453*/
App::import('Model', 'GroupRelation');

class GroupRelationTestCase extends CakeTestCase {
	var $fixtures = array('app.group_relation', 'app.group', 'app.group_type', 'app.administrator', 'app.news', 'app.student');

	function startTest() {
		$this->GroupRelation =& ClassRegistry::init('GroupRelation');
	}

	function endTest() {
		unset($this->GroupRelation);
		ClassRegistry::flush();
	}

	function testFindGroupOwner() {
	
	 $data = array(
        'GroupRelation' => array(
            'groupOwner_id' => 8,
            'groupOwned_id' => 6,
        ),
        );
		$this->GroupRelation->save($data);
		$id = $this->GroupRelation->findGroupOwnerId(6);
		$this->assertEqual($id, 8);

	}

}
?>