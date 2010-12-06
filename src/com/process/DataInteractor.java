package com.process;

import java.io.IOException;
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
import org.json.JSONException;
import org.json.JSONObject;

public class DataInteractor {
	 private JSONObject Infopackage = new JSONObject();
	 private HttpResponse re;
     private final String loginUrl = "http://10.0.2.2/json/testJson.php";
     
     public boolean SendandGetValidateRequest(String ID, String password) throws ClientProtocolException, IOException
     {
    	 Infopackage = packageUserInfo(ID,password);
    	 re = dopost(loginUrl,Infopackage);
    	 return getValiadteResult(re);
     }
    
     private boolean getValiadteResult(HttpResponse response) throws ParseException, IOException
     {
    	 String tempresult = EntityUtils.toString(response.getEntity());
		try {
			JSONObject jsonobject = new JSONObject(tempresult);
			 if (jsonobject.getString("isExist").equals("True"))
	    		 return true;
		} catch (JSONException e) {
			e.printStackTrace();
		}	
    	 return false;
     }
	private HttpResponse dopost(String Url, JSONObject infopackage) throws ClientProtocolException, IOException {

		HttpClient httpclient = new DefaultHttpClient();
	    HttpPost httppost = new HttpPost(Url);
	    httppost.setEntity(new UrlEncodedFormEntity(ChangeJsonToList(infopackage)));
		return httpclient.execute(httppost);
	}
    
	private List<NameValuePair> ChangeJsonToList(JSONObject infopackage)
	{
		Map<String, String> kvPairs = new HashMap<String, String>();
		kvPairs.put("UserInfo", infopackage.toString());
	    List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(kvPairs.size());
	    String key, value;
	    Iterator<String> itKeys = kvPairs.keySet().iterator();
	    while (itKeys.hasNext()) 
	    {
	        key = itKeys.next();
	        value = kvPairs.get(key);
	        nameValuePairs.add(new BasicNameValuePair(key, value));
	    }             
		return nameValuePairs;		
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
}
