package com.process.test;

import java.util.ArrayList;
import java.util.Iterator;

import org.junit.Before;
import org.junit.BeforeClass;

import android.test.ActivityInstrumentationTestCase2;
import android.test.suitebuilder.annotation.SmallTest;

import com.process.News;
import com.process.User;
import com.ui.WaitingUI;

public class TestNews extends ActivityInstrumentationTestCase2<WaitingUI> {
	
	WaitingUI waitingUI;
	User userTester;
	News newsTester;
	String[] keyWords = {"vdf", "IE1", "fg", "aaaa", "bb", "cc", "dd"};
	
	public TestNews() {
		super("com.ui.WaitingUI", WaitingUI.class);
	}


	@BeforeClass
	public static void setUpBeforeClass() throws Exception {
	}

	@Before
	public void setUp() throws Exception {
		waitingUI = getActivity();
		userTester = new User("Lily", "123", waitingUI);
		userTester.checkPassword();
		newsTester = new News(waitingUI);
	}

	@SmallTest
	public void testGetUniversityNews() {
		 String[][] expected = newsTester.getUniversityNews();
		 assertNotNull(expected);
	}

	@SmallTest
	public void testGetSchoolNews() {
		 String[][] expected = newsTester.getSchoolNews();
		 assertNotNull(expected);
	}

	@SmallTest
	public void testGetClassNews() {
		 String[][] expected = newsTester.getClassNews();
		 assertNotNull(expected);
	}

	@SmallTest
	public void testGetUniversityNewsByID() {
		String[][] expected = newsTester.getUniversityNewsByID(userTester.getuniversityID());
		assertNotNull(expected);
	}

	@SmallTest
	public void testGetSchoolNewsByID() {
		String[][] expected = newsTester.getSchoolNewsByID(userTester.getuniversityID());
		assertNotNull(expected);
	}

	@SmallTest
	public void testGetClassNewsByID() {
		String[][] expected = newsTester.getClassNewsByID(userTester.getuniversityID());
		assertNotNull(expected);
	}

	@SmallTest
	public void testSearchNewsByKeyWord() {
		ArrayList<String> keyWordsList = getKeyWordsList();
		Iterator<String> keyWordListIterator = keyWordsList.iterator();
		while(keyWordListIterator.hasNext()) {
			assertNotNull(keyWordListIterator.next());
		}
	}

	private ArrayList<String> getKeyWordsList() {
		ArrayList<String> keyWordsList = new ArrayList<String>();
		for(int i=0; i<keyWords.length; i++) {
			keyWordsList.add(keyWords[i]);
		}
		return keyWordsList;
	}	
}
