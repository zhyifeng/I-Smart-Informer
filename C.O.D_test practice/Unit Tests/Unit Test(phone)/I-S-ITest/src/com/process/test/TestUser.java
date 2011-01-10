package com.process.test;

import java.io.IOException;
import java.util.ArrayList;
import java.util.Iterator;

import org.apache.http.ParseException;
import org.apache.http.client.ClientProtocolException;
import org.json.JSONException;
import org.junit.Before;
import org.junit.BeforeClass;

import android.test.ActivityInstrumentationTestCase2;
import android.test.suitebuilder.annotation.SmallTest;

import com.process.User;
import com.ui.LoginUI;

public class TestUser extends ActivityInstrumentationTestCase2<LoginUI> {
	LoginUI loginUI;
	User userTester;
	ArrayList<String> userIdList;
	Iterator<String> userIdIterator;
	ArrayList<String> userPasswordList;
	Iterator<String> userPasswordIterator;
	
	public TestUser() {
		super("com.ui.LoginUI", LoginUI.class);
	}

	@BeforeClass
	public static void setUpBeforeClass() throws Exception {
	}

	@Before
	public final void setUp() throws Exception {
		this.loginUI = getActivity();
		userIdList = new ArrayList<String>();
		addIdOfTesters(new String[]{"Lily", "asd", "sbmx", "John"});
		userIdIterator = userIdList.iterator();
		
		userPasswordList = new ArrayList<String>();
		addPasswordOfTesters(new String[]{"123", "123456", "sb", "john007"});
		userPasswordIterator = userPasswordList.iterator();
	}

	private void addIdOfTesters(final String[] ids) {
		for(int i=0; i<ids.length; i++) {
			userIdList.add(ids[i]);
		}
	}
	
	private void addPasswordOfTesters(final String[] passwords) {
		for(int i=0; i<passwords.length; i++) {
			userPasswordList.add(passwords[i]);
		}
	}

	@SmallTest
	public final void testCheckPassword() {
		rightPasswordCheck(userIdIterator, userPasswordIterator);
		wrongPasswordCheck("Lily", "1");
	}

	private void rightPasswordCheck(final Iterator<String> userIdIterator, final Iterator<String> userPasswordIterator) {
		boolean expected = false;
		while(userIdIterator.hasNext()) {
			User userTester = new User(userIdIterator.next(), userPasswordIterator.next(), loginUI);
			try {
				expected = userTester.checkPassword();
			} catch (ClientProtocolException e) {
				e.printStackTrace();
			} catch (ParseException e) {
				e.printStackTrace();
			} catch (IOException e) {
				e.printStackTrace();
			} catch (JSONException e) {
				e.printStackTrace();
			}
			assertTrue(expected);
		}
		
	}

	private void wrongPasswordCheck(final String userId, final String userPassword) {
		userTester = new User(userId, userPassword, loginUI);
		boolean expected = false;
		try {
			expected = userTester.checkPassword();
		} catch (ClientProtocolException e) {
			e.printStackTrace();
		} catch (ParseException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		} catch (JSONException e) {
			e.printStackTrace();
		}
		assertFalse(expected);
	}

	@SmallTest
	public final void testGetuniversityID() {
		ArrayList<String> actualUniversityIdList = new ArrayList<String>();
		actualUniversityIdList.add("8");
		actualUniversityIdList.add("8");
		actualUniversityIdList.add("8");
		actualUniversityIdList.add("8");
		Iterator<String> universityIdIterator = actualUniversityIdList.iterator();
		while(userIdIterator.hasNext()) {
			checkID(userIdIterator.next(), userPasswordIterator.next(), universityIdIterator.next(), "universityId");
		}
	}
	
	@SmallTest
	public final void testGetschoolID() {
		ArrayList<String> actualSchoolIdList = new ArrayList<String>();
		actualSchoolIdList.add("10");
		actualSchoolIdList.add("12");
		actualSchoolIdList.add("10");
		actualSchoolIdList.add("12");
		Iterator<String> schoolIdIterator = actualSchoolIdList.iterator();
		while(userIdIterator.hasNext()) {
			checkID(userIdIterator.next(), userPasswordIterator.next(), schoolIdIterator.next(), "schoolId");
		}
	}

	@SmallTest
	public final void testGetclassID() {
		ArrayList<String> actualClassIdList = new ArrayList<String>();
		actualClassIdList.add("11");
		actualClassIdList.add("13");
		actualClassIdList.add("11");
		actualClassIdList.add("13");
		Iterator<String> classIterator = actualClassIdList.iterator();
		while(userIdIterator.hasNext()) {
			checkID(userIdIterator.next(), userPasswordIterator.next(), classIterator.next(), "classId");
		}
	}

	@SmallTest
	public final void testGetUserID() {
		ArrayList<String> actualUserIdList = new ArrayList<String>();
		actualUserIdList.add("Lily");
		actualUserIdList.add("asd");
		actualUserIdList.add("sbmx");
		actualUserIdList.add("John");
		Iterator<String> actualUserIdIterator = actualUserIdList.iterator();
		while(userIdIterator.hasNext()) {
			checkID(userIdIterator.next(), userPasswordIterator.next(), actualUserIdIterator.next(), "userId");
		}
	}

	private void checkID(final String userId, final String userPassword, final String id, final String idType) {
		User tester = new User(userId, userPassword, loginUI);
		try {
			tester.checkPassword();
		} catch (ClientProtocolException e) {
			e.printStackTrace();
		} catch (ParseException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		} catch (JSONException e) {
			e.printStackTrace();
		}
		if(idType.equals("universityId")) {
			int actual = tester.getuniversityID();
			assertEquals(actual, Integer.parseInt(id), actual);
		}
		else if(idType.equals("schoolId")) {
			int actual = tester.getschoolID();
			assertEquals(actual, Integer.parseInt(id), actual);
		}
		else if(idType.equals("classId")) {
			int actual = tester.getclassID();
			assertEquals(id, Integer.parseInt(id), actual);
		}
		else {
			String actual = tester.getUserID();
			assertEquals(id, id, actual);
		}
	}
	
}
