package com.process;
//author£∫’≈“„∑Ê
import java.io.IOException;
import java.util.Map;

import org.apache.http.client.ClientProtocolException;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.content.Context;
import android.content.SharedPreferences;

public class News {
	private static final String FILE_NAME_UNIVERSITY = "UniversityNewsInfo";
	private static final String FILE_NAME_SCHOOL = "SchoolNewsInfo";
	private static final String FILE_NAME_CLASS = "ClassNewsInfo";
	private static final String NEWS_TITLE = "NewsTitle";
	private static final String NEWS_TEXT = "NewsTextt";
	private static final String NEWS_DATE = "NewsDate";
	private static final int UNIVERSITYTYPE = 1;
	private static final int SCHOOLTYPE = 2;
	private static final int CLASSYTYPE = 3;
	private String[][] newsDetailArray = new String[10][3];
	private DataInteractor interactor = new DataInteractor();
	
	private String[][] university_news = new String[20][3];
	private String[][] school_news = new String[20][3];
	private String[][] class_news = new String[20][3];
	
	private SharedPreferences.Editor newsInfoSetting;
	private Context UIcontext;

	public News(Context context) {
		UIcontext = context;
	}

	public String[][] getUniversityNews() {
		loadNewsPreferences(UNIVERSITYTYPE, FILE_NAME_UNIVERSITY);
		return university_news;
	}

	public String[][] getSchoolNews() {
		loadNewsPreferences(SCHOOLTYPE, FILE_NAME_SCHOOL);
		return school_news;
	}

	public String[][] getClassNews() {
		loadNewsPreferences(CLASSYTYPE, FILE_NAME_CLASS);
		return class_news;
	}

	public String[][] getUniversityNewsByID(int ID) {
		university_news = parseNewsFromJsonArray(getNewsByID(ID));
		saveNewsPreferences(UNIVERSITYTYPE, FILE_NAME_UNIVERSITY);
		return university_news;
	}

	public String[][] getSchoolNewsByID(int ID) {
		school_news = parseNewsFromJsonArray(getNewsByID(ID));
		saveNewsPreferences(SCHOOLTYPE, FILE_NAME_SCHOOL);
		return school_news;
	}

	public String[][] getClassNewsByID(int ID) {
		class_news = parseNewsFromJsonArray(getNewsByID(ID));
		saveNewsPreferences(CLASSYTYPE, FILE_NAME_CLASS);
		return class_news;
	}

	private JSONArray getNewsByID(int ID) {
		JSONArray newsJsonArray = new JSONArray();
		try {
			newsJsonArray = interactor.sendNewsRequest(ID);
		} catch (ClientProtocolException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		} catch (JSONException e) {
			e.printStackTrace();
		}
		return newsJsonArray;
	}

	public String[][] searchNewsByKeyWord(String keyword) {
		return parseNewsFromJsonArray(getNewsByKeyWord(keyword));
	}

	private JSONArray getNewsByKeyWord(String keyword) {
		JSONArray newsJsonArray = new JSONArray();
		try {
			newsJsonArray = interactor.sendSearchRequest(keyword);
		} catch (ClientProtocolException e) {
			e.printStackTrace();
		} catch (JSONException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}
		return newsJsonArray;
	}

	private String[][] parseNewsFromJsonArray(JSONArray jsonArray) {       // 2
		for (int i = 0; i < jsonArray.length(); i++) {
			try {
				parseAPieceOfNews(jsonArray, i);
			} catch (JSONException e) {
				e.printStackTrace();
			}		
		}
		return newsDetailArray;
	}

	private void parseAPieceOfNews(JSONArray jsonArray, int i) throws JSONException {
		String arrayresult = jsonArray.get(i).toString();
		JSONObject newsresult = new JSONObject(arrayresult);
		newsDetailArray[i][0] = newsresult.getString("title");
		newsDetailArray[i][1] = newsresult.getString("text");
		newsDetailArray[i][2] = newsresult.getString("date");
	}

	@SuppressWarnings("unchecked")
	private void loadNewsPreferences(int newsType, String file_name) {
		SharedPreferences newsinfoLoader = ((Activity) UIcontext).getSharedPreferences(file_name, Context.MODE_WORLD_READABLE);
		Map<String, String> all = (Map<String, String>) newsinfoLoader.getAll();
		int mapSize = all.size() / 3;
		for (int i = 0; i < mapSize; i++) {
			loadAPieceOfNews(getNewsArrayByType(newsType), all, i);
		}
	}
	
	private String[][] getNewsArrayByType(int newsType) {
		switch(newsType) {
		case UNIVERSITYTYPE:
			return university_news;
		case SCHOOLTYPE:
			return school_news;
		case CLASSYTYPE:
			return class_news;
		}
		return null;
	}

	private void loadAPieceOfNews(String[][] news, Map<String, String> allNews, int index) {
		news[index][0] = allNews.get(NEWS_TITLE + String.valueOf(index));
		news[index][1] = allNews.get(NEWS_TEXT + String.valueOf(index));
		news[index][2] = allNews.get(NEWS_DATE + String.valueOf(index));		
	}

	private void saveNewsPreferences(int newsType, String fileName) {
		SharedPreferences newsInfoLoader = ((Activity) UIcontext).getSharedPreferences(fileName, Context.MODE_WORLD_READABLE);
		newsInfoSetting = newsInfoLoader.edit();
		for (int i = 0; i < getNewsArrayByType(newsType).length; i++) {
			saveAPieceOfNews(getNewsArrayByType(newsType), i);
		}
		newsInfoSetting.commit();
	}
	
	private void saveAPieceOfNews(String[][] news, int index) {
		newsInfoSetting.putString(NEWS_TITLE + String.valueOf(index), news[index][0]);
		newsInfoSetting.putString(NEWS_TEXT + String.valueOf(index), news[index][1]);
		newsInfoSetting.putString(NEWS_DATE + String.valueOf(index), news[index][2]);
	}
}