<?php
class GroupRelation extends AppModel {
	var $name = 'GroupRelation';
	var $validate = array(
		'groupOwner_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'groupOwned_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'GroupOwner' => array(
			'className' => 'Group',
			'foreignKey' => 'groupOwner_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'GroupOwned' => array(
			'className' => 'Group',
			'foreignKey' => 'groupOwned_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function findGroupOwnerId($groupowned_id)
	{
		$groupOwner = $this->find( 'all', array(
									'conditions' => array(
										'groupOwned_id' => $groupowned_id),
									 'fields' => array('groupOwner_id') ));									 
		return $groupOwner[0]["GroupRelation"]["groupOwner_id"];
	}
}
?>