package com.process.test;

import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;
import java.util.Map.Entry;

import org.apache.http.ParseException;
import org.apache.http.client.ClientProtocolException;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import org.junit.Before;
import org.junit.BeforeClass;

import android.test.AndroidTestCase;
import android.test.suitebuilder.annotation.SmallTest;

import com.process.DataInteractor;

public class TestDataInteractor extends AndroidTestCase {

	DataInteractor dataInteractor;
	HashMap<String, String> userTesters;
	Iterator<?> userTestersIterator;
	ArrayList<Integer> newsTypes;
	Iterator<Integer> newsTypesIteractor;
	ArrayList<String> keyWords;
	Iterator<String> keyWordsIteractor;
	
	@BeforeClass
	public static void setUpBeforeClass() throws Exception {
	}

	@Before
	public void setUp() throws Exception {
		initializeUsersTesters();
		initializeNewsTypesList();
		initializeKeyWords();
	}

	private void initializeUsersTesters() {
		userTesters = new HashMap<String, String>();
		userTesters.put("Lily", "123");
		userTesters.put("asd", "123456");
		userTesters.put("sbmx", "sb");
		userTesters.put("John", "john007");
		dataInteractor = new DataInteractor();
		userTestersIterator = userTesters.entrySet().iterator();
	}

	private void initializeNewsTypesList() {
		int[] newsTpyesArray = {2, 3, 4};
		newsTypes = new ArrayList<Integer>();
		for(int i=0; i<newsTpyesArray.length; i++) {
			newsTypes.add(new Integer(newsTpyesArray[i]));
		}
		newsTypesIteractor = newsTypes.iterator();
	}
	
	private void initializeKeyWords() {
		String[] keyWordsArray = {"vdf", "IE1", "fg", "aaaa", "bb", "cc", "dd"};
		keyWords = new ArrayList<String>();
		for(int i=0; i<keyWordsArray.length; i++) {
			keyWords.add(keyWordsArray[i]);
		}
		keyWordsIteractor = keyWords.iterator();
	}


	@SmallTest
	public void testSendandGetValidateRequest() {
		JSONObject expected;
		while(userTestersIterator.hasNext()) {
			@SuppressWarnings("unchecked")
			Map.Entry<String, String> oneUserTester = (Entry<String, String>) userTestersIterator.next();
			try {
				expected = dataInteractor.SendandGetValidateRequest(oneUserTester.getKey(), oneUserTester.getValue());
				assertNotNull(expected);
			} catch (ClientProtocolException e) {
				e.printStackTrace();
			} catch (ParseException e) {
				e.printStackTrace();
			} catch (IOException e) {
				e.printStackTrace();
			} catch (JSONException e) {
				e.printStackTrace();
			}
		}
	}

	@SmallTest
	public void testSendNewsRequest() {
		JSONArray expected;
		while(newsTypesIteractor.hasNext()) {
			try {
				expected = dataInteractor.sendNewsRequest(newsTypesIteractor.next().intValue());
				assertNotNull(expected);
			} catch (ClientProtocolException e) {
				e.printStackTrace();
			} catch (IOException e) {
				e.printStackTrace();
			} catch (JSONException e) {
				e.printStackTrace();
			}
		}
	}

	@SmallTest
	public void testSendSearchRequest() {
		JSONArray expected;
		while(keyWordsIteractor.hasNext()) {
			try {
				expected = dataInteractor.sendSearchRequest(keyWordsIteractor.next());
				assertNotNull(expected);
			} catch (ClientProtocolException e) {
				e.printStackTrace();
			} catch (JSONException e) {
				e.printStackTrace();
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
	}
}
