<?php
/* GroupType Fixture generated on: 2010-12-26 03:12:54 : 1293332994 */
class GroupTypeFixture extends CakeTestFixture {
	var $name = 'GroupType';
	var $import = array('model' => 'GroupType', 'records' => true);

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 15, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

}
?>