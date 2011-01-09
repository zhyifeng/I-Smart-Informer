package com.allTest;

import junit.framework.Test;
import junit.framework.TestSuite;

import com.dao.test.TestDbAdapter;
import com.process.test.TestDataInteractor;
import com.process.test.TestNews;
import com.process.test.TestUser;

//@RunWith(Suite.class)
//@Suite.SuiteClasses({TestDbAdapter.class, TestDataInteractor.class, TestNews.class, TestUser.class})

public class TestSuit {

	public static Test suite() {
		TestSuite suite = new TestSuite("TestSuite Test");
//		suite.addTestSuite(TestDbAdapter.class);
//		suite.addTestSuite(TestDataInteractor.class);
//		suite.addTestSuite(TestNews.class);
//		suite.addTestSuite(TestUser.class);
		return suite;
	}
	
}