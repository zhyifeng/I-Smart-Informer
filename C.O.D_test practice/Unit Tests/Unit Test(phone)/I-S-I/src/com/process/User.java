package com.process;
//author：吕志鹏
import java.io.IOException;
import org.apache.http.ParseException;
import org.apache.http.client.ClientProtocolException;
import org.json.JSONException;
import org.json.JSONObject;
import android.app.Activity;
import android.content.Context;
import android.content.SharedPreferences;
import android.util.Log;

public class User {
	private static final String FILE_NAME = "UserInfo";
	private static final String USERID = "UserID";
	private static final String UNIVERSITYID = "UniversityID";
	private static final String SCHOOLID = "SchoolID";
	private static final String CLASSID = "ClassID";
	private DataInteractor interactor = new DataInteractor();
	private String userID;
	private String userPassword;
	private int universityID;
	private int schoolID;
	private int classID;
	private Context context;
	private JSONObject Result;

	public User(String ID, String password, Context context) {
		this.context = context;
		if (ID == null || password == null)
			loadUserInfoPreferences();
		else {
			userID = ID;
			userPassword = password;
		}
	}

	public boolean checkPassword() throws ClientProtocolException,	// 只要是牵涉User 的测试都要手动调用它
			ParseException, IOException, JSONException {
		boolean checkresult = isCorrectPassword(userID, userPassword);
		if (checkresult)
			setUserInfo();										    //
		return checkresult;
	}

	private void setUserInfo() throws JSONException {
		universityID = Result.getInt("universityId");
		schoolID = Result.getInt("schoolId");
		classID = Result.getInt("classId");
		saveUserInfoPreferences();
	}

	private boolean isCorrectPassword(String name, String password)
			throws ClientProtocolException, ParseException, IOException,
			JSONException {
//		Log.v("info2", name + " " + password);
		Result = interactor.SendandGetValidateRequest(name, password);
		Log.v("result", String.valueOf(Result));
		return Result.getBoolean("isExist");
	}

	public int getuniversityID() {
		System.out.println("universityID:" + universityID);
		return universityID;
	}

	public int getschoolID() {
		System.out.println("schoolId:" + schoolID);
		return schoolID;
	}

	public int getclassID() {
		System.out.println("classId:" + classID);
		return classID;
	}

	public String getUserID() {
		System.out.println("userId:" + userID);
		return userID;
	}

	private void loadUserInfoPreferences() {
		SharedPreferences userinfoLoader = ((Activity) context).getSharedPreferences(FILE_NAME, Context.MODE_WORLD_READABLE);
		userID = userinfoLoader.getString(USERID, "");
		universityID = userinfoLoader.getInt(UNIVERSITYID, 0);
		schoolID = userinfoLoader.getInt(SCHOOLID, 0);
		classID = userinfoLoader.getInt(CLASSID, 0);
	}

	private void saveUserInfoPreferences() {
		SharedPreferences userinfoLoader = ((Activity) context).getSharedPreferences(FILE_NAME, Context.MODE_WORLD_READABLE);
		SharedPreferences.Editor userinfoSetting = userinfoLoader.edit();
		userinfoSetting.putString(USERID, userID);
		userinfoSetting.putInt(UNIVERSITYID, universityID);
		userinfoSetting.putInt(SCHOOLID, schoolID);
		userinfoSetting.putInt(CLASSID, classID);
		userinfoSetting.commit();
	}
}
