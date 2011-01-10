package com.ui.test;

import org.junit.After;
import org.junit.Before;
import org.junit.BeforeClass;

import android.test.ActivityInstrumentationTestCase2;
import android.test.suitebuilder.annotation.SmallTest;

import com.jayway.android.robotium.solo.Solo;
import com.ui.SearchUI;

public class TestSearchUI extends ActivityInstrumentationTestCase2<SearchUI> {

	private Solo solo;

	public TestSearchUI() {
		super("com.ui.SearchUI", SearchUI.class);
	}

	@BeforeClass
	public static void setUpBeforeClass() throws Exception {
	}

	@Before
	public void setUp() throws Exception {
		solo = new Solo(getInstrumentation(), getActivity());
	}

	@SmallTest
	public void testInitialization() {
		boolean actual = solo.searchText("学校") && solo.searchText("学院")
				&& solo.searchText("班级") && solo.searchButton("搜索");
		assertTrue(actual);
	}

	@SmallTest
	public void testSearchFunction() {
		solo.enterText(0, "ii");
		solo.clickOnButton("搜索");
		solo.assertCurrentActivity("Execute By Key World", "WaitingUI");
		solo.goBackToActivity("SearchUI");
	}

	@SmallTest
	public void testEnterKeyWord() {
		solo.enterText(0, "keyword");
		boolean actual = solo.searchEditText("keyword");
		assertTrue(actual);
	}
	
	@After
	public void tearDown() throws Exception {
		try {
			solo.finalize();
		} catch (Throwable e) {
			e.printStackTrace();
		}

		getActivity().finish();
		super.tearDown();
	}

}
