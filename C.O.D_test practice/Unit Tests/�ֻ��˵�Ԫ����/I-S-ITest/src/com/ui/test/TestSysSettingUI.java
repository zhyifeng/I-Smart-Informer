package com.ui.test;

import org.junit.After;
import org.junit.Before;
import org.junit.BeforeClass;

import android.test.ActivityInstrumentationTestCase2;
import android.test.suitebuilder.annotation.SmallTest;

import com.jayway.android.robotium.solo.Solo;
import com.ui.SysSettingUI;

public class TestSysSettingUI extends
		ActivityInstrumentationTestCase2<SysSettingUI> {

	private Solo solo;

	public TestSysSettingUI() {
		super("com.ui.SysSetting", SysSettingUI.class);
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
		boolean actual = solo.searchText("原密码") && solo.searchText("新密码")
				&& solo.searchText("再次输入新密码")
				&& solo.searchButton("确定") && solo.searchButton("重置");
		assertTrue(actual);
	}
	
	@SmallTest
	public void testResetFunction(){
		solo.enterText(0, "1234");
		solo.enterText(1, "12345");
		solo.enterText(2, "12345");
		boolean actualEnter = solo.searchEditText("1234") && solo.searchEditText("12345") 
		        && solo.searchText("12345", 2);
		assertTrue(actualEnter);
		solo.clickOnButton("重置");
		boolean actual = solo.searchText("", 3);
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
