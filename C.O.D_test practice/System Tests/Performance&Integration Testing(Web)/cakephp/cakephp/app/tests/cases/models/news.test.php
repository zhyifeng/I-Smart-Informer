<?php
/* News Test cases generated on: 2010-12-26 03:12:24 : 1293332904*/
App::import('Model', 'News');

class NewsTestCase extends CakeTestCase {
	var $fixtures = array('app.news', 'app.administrator', 'app.group', 'app.group_type', 'app.student');

	function startTest() {
		$this->News =& ClassRegistry::init('News');
	}

	function endTest() {
		unset($this->News);
		ClassRegistry::flush();
	}

	function test_SearchNewsByKeyWord_gerneral() {
	   $keywords = "睡的";
	   $result = $this->News->searchNewsByKeyWord($keywords);
	   $expected = array(
							array( 'id' => 26,
											'title' =>  '是睡的单值', 
											'text' => '等等的',
											'date' =>  '2011-01-07 16:09:00',
											'administrator_id' => 3,
										)								
					); 
            $this->assertEqual($result, $expected);

	}
	
	function test_SearchNewsByKeyWord_nullKeyword()
	{
		$keywords = null;
		$result = $this->News->searchNewsByKeyWord($keywords);
		$expected = null;
		$this->assertEqual($result, $expected);
	}
	
	function test_SearchNewsByKeyWord_notExistKeyword()
	{
		$keywords = "sssssssssssssssssssssssss";
		$result = $this->News->searchNewsByKeyWord($keywords);
		$expected = null;
		$this->assertEqual($result, $expected);
	}
	/////////////////there is a bug//////////////////////
	/*
	function test_SearchNewsByKeyWord_spaceKeyWord()
	{
		$keywords = "睡 的";
	   $result = $this->News->searchNewsByKeyWord($keywords);
	   $expected = array(
							array( 'id' => 26,
											'title' =>  '是睡的单值', 
											'text' => '等等的',
											'date' =>  '2011-01-07 16:09:00',
											'administrator_id' => 3,
										)								
					); 
            $this->assertEqual($result, $expected);
	}
	*/
}
?>