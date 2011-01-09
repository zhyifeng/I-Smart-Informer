package com.ui.test;


import org.junit.Before;
import org.junit.BeforeClass;

import android.test.ActivityInstrumentationTestCase2;
import android.test.suitebuilder.annotation.SmallTest;

import com.jayway.android.robotium.solo.Solo;
import com.ui.LoginUI;

public class TestLoginUI extends ActivityInstrumentationTestCase2<LoginUI> {

	private Solo solo;
	
	public TestLoginUI() {
		super("com.ui.LoginUI", LoginUI.class);
	}

	@BeforeClass
	public static void setUpBeforeClass() throws Exception {
	}

	@Before
	public void setUp() throws Exception {
		solo = new Solo(getInstrumentation(), getActivity());
	}
	
	@SmallTest
	public void testInitialTextView() {
		boolean actual = solo.searchText("ѧ��") && solo.searchText("����");
		assertTrue(actual);
	}
	
	@SmallTest
	public void testEnterId() {
		boolean expected = true;
		solo.enterText(0, "Lily");
		boolean actual = solo.searchEditText("Lily");
		assertEquals(expected, actual);
	}
	
	@SmallTest
	public void testEnterPassword() {
		boolean expected = true;
		solo.enterText(1, "123");
		boolean actual = solo.searchEditText("123");
		assertEquals(expected, actual);
	}
	
	@SmallTest
	public void testButtonIsExist() {
		boolean expected = true;
		boolean actual = solo.searchButton("�� ¼") && solo.searchButton("�� ��");
		assertEquals(expected, actual);
	}
	
	@SmallTest
	public void testLonginButtonFuntion() {
		solo.enterText(0, "Lily");
		solo.enterText(1, "123");
		
		solo.clickOnButton("�� ¼");
		solo.assertCurrentActivity("Click Login Button", "WaitingUI");
		solo.goBackToActivity("LoginUI");
	}
	
	@SmallTest
	public void testQuitButtonFunction() {
		solo.clickOnButton("�� ��");
		boolean actual = solo.searchButton("ȷ��") && solo.searchButton("ȡ��");
		assertTrue(actual);
	}

	@Override
	protected void tearDown() throws Exception {
		try {
			solo.finalize();
		} catch (Throwable e) {
			e.printStackTrace();
		}
		
		getActivity().finish();
		super.tearDown();
	}
}
