package com.ui;
//author£∫’≈“„∑Ê
import java.util.ArrayList;
import java.util.HashMap;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.AdapterView.OnItemClickListener;

public class SearchResultUI extends Activity{
	private String[] news_title = new String[10];
    private String[] news_text = new String[10];
    private String[] news_date = new String[10];
    private Bundle newsBundle;
    private ListView resultlist;
    
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.searchresultui);
		loadNewsInfo();
		
		resultlist = (ListView)findViewById(R.id.ListView_searchresult);
		resultlist.setAdapter(getMenuAdapter(news_title, news_date));
		
		resultlist.setOnItemClickListener(new ItemClickListener());
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
	
	private void loadNewsInfo(){
		newsBundle = getIntent().getExtras();
		news_title = newsBundle.getStringArray("news_title");
		news_text = newsBundle.getStringArray("news_text");
		news_date = newsBundle.getStringArray("news_date");
	}
	
	class ItemClickListener implements OnItemClickListener{
		@Override
		public void onItemClick(AdapterView<?> arg0, View arg1, int arg2,
				long arg3) {
           		jumpToNewsDetailPage(arg2);	
		}		
	}
	
	private void jumpToNewsDetailPage(int index){
		Intent intent = new Intent();
		intent.setClass(this, InfoDetailUI.class);
		intent.putExtra("newsTitle", news_title[index]);
		intent.putExtra("newsText", news_text[index]);
		intent.putExtra("newsDate", news_date[index]);
		startActivity(intent);
	}
}
