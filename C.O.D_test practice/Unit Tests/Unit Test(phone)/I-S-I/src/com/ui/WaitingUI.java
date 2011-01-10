package com.ui;
//author£∫¬¿÷æ≈Ù
import com.process.News;
import com.process.User;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.widget.ProgressBar;

public class WaitingUI extends Activity{
    private ProgressBar downloadbar;
    private User user;
    private News news;
    private Bundle keywordBundle = null;
    private String[][] newsResult = null;
    private String[] news_title = new String[10];
    private String[] news_text = new String[10];
    private String[] news_date = new String[10];
    
    @Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.waitingui);
		downloadbar = (ProgressBar)findViewById(R.id.ProgressBar01);
		downloadbar.setIndeterminate(true);
		
		user = new User(null,null,WaitingUI.this);
		news = new News(WaitingUI.this);
		keywordBundle = getIntent().getExtras();
		if (keywordBundle == null)
		{
			StartDownloadNewsThread();
		}
		else
		{
			StartSearchNewsThread(keywordBundle.getString("KeyWord"));
		}
	}
	
	private void StartDownloadNewsThread() {
		new Thread(new Runnable() {		
			@Override
			public void run() {
				downloadNews();
				JumpToOherActivity();
			}
		}).start();
	}
    
	private void StartSearchNewsThread(final String keyword){
		new Thread(new Runnable() {			
			@Override
			public void run() {
				searchNews(keyword);
				JumpToSearchResultUI();
			}
		}).start();
	}
	
	private void searchNews(String keyword) {
		newsResult = news.searchNewsByKeyWord(keyword);
		Log.v("lenth", String.valueOf(newsResult.length));
		for (int i = 0; i < newsResult.length && newsResult[i][0] != null; i++)
		{
			news_title[i] = newsResult[i][0];
			news_text[i] = newsResult[i][1];
			news_date[i] = newsResult[i][2];
		}
	}
	
	private void downloadNews() {
		news.getUniversityNewsByID(user.getuniversityID());
		news.getSchoolNewsByID(user.getschoolID());
		news.getClassNewsByID(user.getclassID());
	}
	
	private void JumpToOherActivity(){
		Intent intent = new Intent();
		intent.setClass(this, InfoUI.class);
		startActivity(intent);
		Thread.currentThread().interrupt();
		WaitingUI.this.finish();
	}
	
	private void JumpToSearchResultUI(){
		Intent intent = new Intent();
		intent.putExtra("news_title", news_title);
		intent.putExtra("news_text", news_text);
		intent.putExtra("news_date", news_date);
		intent.setClass(this, SearchResultUI.class);
		startActivity(intent);
		Thread.currentThread().interrupt();
		WaitingUI.this.finish();
	}
}
