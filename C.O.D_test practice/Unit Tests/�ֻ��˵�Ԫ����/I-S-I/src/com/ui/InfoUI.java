package com.ui;
//author：张毅锋、吕志鹏、李琳
import java.util.ArrayList;
import java.util.HashMap;

import com.process.News;
import android.app.TabActivity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.TabHost;
import android.widget.AdapterView.OnItemClickListener;

public class InfoUI extends TabActivity {

	private TabHost mTabHost;
	private ToolbarInitialier toolbarInitialier;
	private ListView universityNewsListView;
	private ListView schoolNewsListView;
	private ListView classNewsListView;
	private String[][] university_news;
	private String[][] school_news;
	private String[][] class_news;
	private News news;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.infoui);
		toolbarInitialier = new ToolbarInitialier(R.id.GridView_toolbar_info,this);
		toolbarInitialier.InitialtoToolbar();
		TabhostInitialize();
		ListViewInitialize();
		loadNews();
		setTabContent(university_news, universityNewsListView);
		setTabContent(school_news, schoolNewsListView);
		setTabContent(class_news, classNewsListView);

		universityNewsListView.setOnItemClickListener(new ListItemClickListener());
		schoolNewsListView.setOnItemClickListener(new ListItemClickListener());
		classNewsListView.setOnItemClickListener(new ListItemClickListener());
	}

	private SimpleAdapter getMenuAdapter(String[] listNewsTitleArray, String[] listNewsDateArray) {
		ArrayList<HashMap<String, Object>> data = new ArrayList<HashMap<String, Object>>();
		for (int i = 0; i < listNewsTitleArray.length; i++) {			
			data.add(getAPieceOfNews(listNewsTitleArray, listNewsDateArray, i));
		}
		SimpleAdapter simperAdapter = new SimpleAdapter(this, data, R.layout.list_item, 
				new String[] { "newstitle", "newsdate" }, new int[] { R.id.list_item_title, R.id.list_item_date });
		return simperAdapter;
	}
	
	private HashMap<String, Object> getAPieceOfNews(String[] listNewsTitleArray, String[] listNewsDateArray, int i) {
		HashMap<String, Object> map = new HashMap<String, Object>();
		map.put("newstitle", listNewsTitleArray[i]);
		map.put("newsdate", listNewsDateArray[i]);
		return map;
	}

	private void TabhostInitialize() {
		mTabHost = getTabHost();
		mTabHost.addTab(mTabHost.newTabSpec("tab_test1").setIndicator("学校消息").setContent(R.id.ListView_college));
		mTabHost.addTab(mTabHost.newTabSpec("tab_test2").setIndicator("学院消息").setContent(R.id.ListView_school));
		mTabHost.addTab(mTabHost.newTabSpec("tab_test3").setIndicator("班级消息").setContent(R.id.ListView_class));
		mTabHost.setCurrentTab(0);
	}

	private void ListViewInitialize() {
		universityNewsListView = (ListView) findViewById(R.id.ListView_college);
		schoolNewsListView = (ListView) findViewById(R.id.ListView_school);
		classNewsListView = (ListView) findViewById(R.id.ListView_class);
	}

	private void loadNews() {
		news = new News(InfoUI.this);
		university_news = news.getUniversityNews();
		school_news = news.getSchoolNews();
		class_news = news.getClassNews();
	}

	private void setTabContent(String[][] news, ListView tabListView) {
		String[] news_title = getNewsTitle(news);
		String[] news_date = getNewsDate(news);
		tabListView.setAdapter(getMenuAdapter(news_title, news_date));
	}

	private String[] getNewsDate(String[][] news) {
		String[] news_date = new String[8];
		for (int i = 0; i < news_date.length; i++) {
			news_date[i] = news[i][2];
		}
		return news_date;
	}

	private String[] getNewsTitle(String[][] news) {
		String[] news_title = new String[8];
		for (int i = 0; i < news_title.length; i++) {
			news_title[i] = news[i][0];
		}
		return news_title;
	}

	class ListItemClickListener implements OnItemClickListener {
		@Override
		public void onItemClick(AdapterView<?> parent, View view, int position,	long indexofnews) {
			if (parent == universityNewsListView) {
				JumpToNewsDetailPage(position, university_news);
			} else if (parent == schoolNewsListView) {
				JumpToNewsDetailPage(position, school_news);
			} else if (parent == classNewsListView) {
				JumpToNewsDetailPage(position, class_news);
			}
		}
	}

	private void JumpToNewsDetailPage(int indexofnews, String[][] news) {
		Intent intent = getNewsIntent(indexofnews, news);
		intent.setClass(this, InfoDetailUI.class);
		startActivity(intent);
		InfoUI.this.finish();
	}

	private Intent getNewsIntent(int indexofnews, String[][] news) {
		Intent intent = new Intent();
		intent.putExtra("newsTitle", news[indexofnews][0]);
		intent.putExtra("newsText", news[indexofnews][1]);
		intent.putExtra("newsDate", news[indexofnews][2]);
		return intent;
	}
}
