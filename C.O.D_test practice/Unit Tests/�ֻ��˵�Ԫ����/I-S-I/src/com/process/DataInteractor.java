package com.process;
//author£∫’≈“„∑Ê
import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.ParseException;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.util.Log;

public class DataInteractor {
	private static final String USERINFO = "UserInfo";
	private static final String NEWSTYPEINFO = "NewsTypeInfo";
	private static final String KEYWORDINFO = "KeyWordInfo";
	private JSONObject infoPackage = new JSONObject();
	private JSONObject newsTypePackage = new JSONObject();
	private JSONObject keyWordPackage = new JSONObject();
	private HttpResponse re;
	private final String loginUrl = "http://10.0.2.2/cakephp/students/loginfromphone";
	private final String NewsUrl = "http://10.0.2.2/cakephp/news/resposePhoneRequstToFindNews";
	private final String SearchUrl = "http://10.0.2.2/cakephp/news/searchNewsByKeyword";

	public JSONObject SendandGetValidateRequest(String ID, String password)
			throws ClientProtocolException, IOException, ParseException, JSONException {
		infoPackage = packageUserInfo(ID, password);
		re = doPost(loginUrl, infoPackage, USERINFO);
		return getValiadteResult(re);
	}

	private JSONObject getValiadteResult(HttpResponse response)
			throws ParseException, IOException, JSONException {
		String tempresult = EntityUtils.toString(response.getEntity());
		Log.v("tempresuly", tempresult);
		JSONObject jsonobject = new JSONObject(tempresult);
		return jsonobject;
	}

	private HttpResponse doPost(String Url, JSONObject infoPackage,	String jsonType)//1
			throws ClientProtocolException, IOException {
		HttpClient httpClient = new DefaultHttpClient();
		HttpPost httpPost = getHttpPost(Url, infoPackage, jsonType);
		return httpClient.execute(httpPost);
	}

	private HttpPost getHttpPost(String Url, JSONObject infoPackage, String jsonType) 
			throws UnsupportedEncodingException {
		HttpPost httpPost = new HttpPost(Url);
		httpPost.setEntity(new UrlEncodedFormEntity(changeJsonToList(infoPackage, jsonType)));
		return httpPost;
	}
	
	private List<NameValuePair> changeJsonToList(JSONObject infopackage, String jsonType) {		
		List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(getKVPairsSize(infopackage, jsonType));
		Iterator<String> itKeys = getKVPairs(infopackage, jsonType).keySet().iterator();
		while (itKeys.hasNext()) {
			nameValuePairs.add(getANameValuePair(infopackage, jsonType, itKeys.next()));
		}
		return nameValuePairs;
	}
	
	private int getKVPairsSize(JSONObject infopackage, String jsonType) {
		Map<String, String> kvPairs = getKVPairs(infopackage, jsonType);
		return kvPairs.size();
	}
	
	private BasicNameValuePair getANameValuePair(JSONObject infopackage, String jsonType, String key) {
		Map<String, String> kvPairs = getKVPairs(infopackage, jsonType);
		String value = kvPairs.get(key);	
		return new BasicNameValuePair(key, value);
	}
	
	private Map<String, String> getKVPairs(JSONObject infopackage, String jsonType) {
		Map<String, String> kvPairs = new HashMap<String, String>();
		kvPairs.put(jsonType, infopackage.toString());
		return kvPairs;
	}

	private JSONObject packageUserInfo(String ID, String password) {
		JSONObject _Infopackage = new JSONObject();
		try {
			_Infopackage.put("UserID", ID);
			_Infopackage.put("UserPassword", password);
		} catch (JSONException e) {
			e.printStackTrace();
		}
		return _Infopackage;
	}

	public JSONArray sendNewsRequest(int newstype)
			throws ClientProtocolException, IOException, JSONException {
		newsTypePackage = packageNewsType(newstype);
		re = doPost(NewsUrl, newsTypePackage, NEWSTYPEINFO);
		return getNewsFromServer(re);
	}

	public JSONArray sendSearchRequest(String keyword) 
			throws JSONException, ClientProtocolException, IOException {
		keyWordPackage = packageKeyWord(keyword);
		re = doPost(SearchUrl, keyWordPackage, KEYWORDINFO);
		return getNewsFromServer(re);
	}

	private JSONArray getNewsFromServer(HttpResponse response) throws ParseException, IOException, JSONException {
		String reponseInStringFormat = getResonseInStringFormat(response);
		JSONArray jsonNewsArray = new JSONArray(reponseInStringFormat);
		return jsonNewsArray;
	}

	private String getResonseInStringFormat(HttpResponse response) throws ParseException, IOException {		
		return EntityUtils.toString(response.getEntity());
	}

	private JSONObject packageNewsType(int newstype) throws JSONException {
		JSONObject _NewsTypepackage = new JSONObject();
		_NewsTypepackage.put("Newstype", newstype);
		return _NewsTypepackage;
	}

	private JSONObject packageKeyWord(String keyword) throws JSONException {
		JSONObject _KeyWordpackage = new JSONObject();
		_KeyWordpackage.put("KeyWord", keyword);
		return _KeyWordpackage;
	}
}
