package com.dao.test;

import org.junit.After;
import org.junit.Before;
import org.junit.BeforeClass;

import android.database.Cursor;
import android.test.ActivityInstrumentationTestCase2;
import android.test.suitebuilder.annotation.SmallTest;

import com.dao.DbAdapter;
import com.ui.RemindNoteEditUI;

public class TestDbAdapter extends ActivityInstrumentationTestCase2<RemindNoteEditUI> {

	RemindNoteEditUI reminderNoteEditUi;
	DbAdapter dbAdapterTester;
	long rowIdOfANoteTested;
	
	public TestDbAdapter() {
		super("com.ui.RemindNoteEditUI", RemindNoteEditUI.class);
	}

	@BeforeClass
	public static void setUpBeforeClass() throws Exception {
	}

	@Before
	public void setUp() throws Exception {
		reminderNoteEditUi = getActivity();
		dbAdapterTester = new DbAdapter(reminderNoteEditUi);
		dbAdapterTester.open();
		rowIdOfANoteTested = dbAdapterTester.createNote("test", "test", "test");
	}
	
	@After
	public void after() {
		dbAdapterTester.close();
	}

	@SmallTest
	public void testClose() {
		dbAdapterTester.open();
		dbAdapterTester.close();
		String expected = dbAdapterTester.getTestResultFlag();
		assertEquals(expected, "close");
	}

	@SmallTest
	public void testCreateNote() {
		testCeateANoteSuccessfully("test1", "test1", "test1");
		testCeateANoteUnsuccessfully(null, "test2", "test2");
		testCeateANoteUnsuccessfully("test3", null, "test3");
		testCeateANoteUnsuccessfully("test4", "test4", null);
	}

	private void testCeateANoteSuccessfully(String title, String body, String date) {
		long expectedResult = dbAdapterTester.createNote(title, body, date);
		boolean expected = expectedResult != -1 ? true : false;
		assertTrue(expected);
	}

	private void testCeateANoteUnsuccessfully(String title, String body, String date) {
		long expectedResult = dbAdapterTester.createNote(title, body, date);
		boolean expected = expectedResult != -1 ? true : false;
		assertFalse(expected);
	}
	
	@SmallTest
	public void testDeleteNote() {
		boolean expected = dbAdapterTester.deleteNote(rowIdOfANoteTested);
		assertTrue(expected);
	}

	@SmallTest
	public void testFetchAllNotes() {
		Cursor expected = dbAdapterTester.fetchAllNotes();
		assertNotNull(expected);
	}

	@SmallTest
	public void testFetchNote() {
		Cursor expected = dbAdapterTester.fetchNote(rowIdOfANoteTested);
		assertNotNull(expected);
	}

	@SmallTest
	public void testUpdateNote() {
		updateANoteSuccessfully("newTest1", "newTest1", "newTest1");
		updateANoteUnsuccessfully("newTest1", "newTest1", "newTest1");
	}

	private void updateANoteUnsuccessfully(String title, String body, String date) {
		boolean expected = dbAdapterTester.updateNote(-1, title, body, date);
		assertFalse(expected);
	}

	private void updateANoteSuccessfully(String title, String body,	String date) {
		boolean expected = dbAdapterTester.updateNote(rowIdOfANoteTested, "newTest1", "newTest1", "newTest1");
		assertTrue(expected);
	}
	
}
