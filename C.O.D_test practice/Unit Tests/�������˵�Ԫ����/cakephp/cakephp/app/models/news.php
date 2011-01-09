<?php
class News extends AppModel {
	var $name = 'News';
	var $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'text' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'administrator_id' => array(
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
		'Administrator' => array(
			'className' => 'Administrator',
			'foreignKey' => 'administrator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	function searchNewsByKeyWord( $key )
	{
	///////////////////after test///////////////////////////////////////
		if($key == "")
		  return null;
	//////////////////////////////////////////////////////////////////	  
			$sql = "SELECT * FROM news WHERE title LIKE '%".$key."%' LIMIT 10";
			$fondNews = $this->query($sql);
			$NumOfResult = count($fondNews);	
			$results = array();
			$NewsIndex=0;
			while($NewsIndex < $NumOfResult)
			{
				$results[$NewsIndex] = $fondNews[$NewsIndex]['news'];
				$NewsIndex++;
			}
			return $results;
	}
}
?>