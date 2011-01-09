package com.ui.test;


import java.util.ArrayList;

import org.junit.After;
import org.junit.Before;
import org.junit.BeforeClass;

import android.test.ActivityInstrumentationTestCase2;
import android.test.suitebuilder.annotation.SmallTest;
import android.widget.GridView;
import android.widget.ListView;

import com.jayway.android.robotium.solo.Solo;
import com.ui.InfoUI;

public class TestInfoUI extends ActivityInstrumentationTestCase2<InfoUI> {

	private Solo solo;
	
	public TestInfoUI() {
		super("com.ui.InfoUI", InfoUI.class);
	}

	@BeforeClass
	public static void setUpBeforeClass() throws Exception {
	}

	@Before
	public void setUp() throws Exception {
		solo = new Solo(getInstrumentation(), getActivity());
	}

	@SmallTest
	public void testListViewExist() {
		ArrayList<ListView> infoListView = solo.getCurrentListViews();
		assertTrue(!infoListView.isEmpty());
	}
	
	@SmallTest
	public void testGridViewExist() {
		ArrayList<GridView> menuGridView = solo.getCurrentGridViews();
		assertTrue(!menuGridView.isEmpty());
	}
	
	@SmallTest
	public void testListViewFunction() {
		solo.clickOnText("ii");
		solo.assertCurrentActivity("Click List Item", "InfoDetailUI");
	}
	
	@SmallTest
	public void testGridViewFunction() {
		String[] GridViewItems = new String[]{"À—À˜", "Ã·–—", "’À∫≈", "œ˚œ¢"};
		String[] uis = new String[]{"SearchUI", "ReminderUI", "SysSettingUI", "InfoUI"};
		for(int i=0; i<GridViewItems.length; i++) {
			solo.clickOnText(GridViewItems[i]);
			solo.assertCurrentActivity("Click List Item", uis[i]);
		}
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
