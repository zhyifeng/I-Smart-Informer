package com.ui;
//author£∫’≈“„∑Ê°¢¿Ó¡’
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.TextView;

public class InfoDetailUI extends Activity{
    private TextView newsTitle;
    private TextView newsText;
    private TextView newsDate;
    private Button remindButton;
    private Button returnButton;
    private Bundle newsBundle;
    
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.info_detail);
		Initialize();
		shownews();
		remindButton.setOnClickListener(new RemindButtonClickListener());
		returnButton.setOnClickListener(new ReturnButtonClickListener());
	}
	
	private void shownews() {
        String title = newsBundle.getString("newsTitle");
        String text = newsBundle.getString("newsText");
        String date = newsBundle.getString("newsDate");
        newsTitle.setText(title);
        newsText.setText(newsText.getText()+text);
        newsDate.setText(newsDate.getText()+date);     
	}

	private void Initialize() {
		newsTitle = (TextView)findViewById(R.id.TextView_newstitle);
		newsText = (TextView)findViewById(R.id.TextView_newsbody);
		newsDate = (TextView)findViewById(R.id.TextView_newsdate);
		remindButton = (Button)findViewById(R.id.Button_setremind);
		returnButton = (Button)findViewById(R.id.Button_return);
		newsBundle = getIntent().getExtras();
	}
    
	private void jumpToRemindEditUI(){
		Intent intent = new Intent();
		intent.setClass(InfoDetailUI.this, RemindNoteEditUI.class);
		startActivity(intent);
		InfoDetailUI.this.finish();
	}
	
	class RemindButtonClickListener implements OnClickListener{
		@Override
		public void onClick(View v) {
			jumpToRemindEditUI();
		}		
	}
	
	class ReturnButtonClickListener implements OnClickListener{
		@Override
		public void onClick(View v) {
			jumpToInfoUI();
		}		
	}
	
	private void jumpToInfoUI(){
		Intent intent = new Intent();
		intent.setClass(InfoDetailUI.this, InfoUI.class);
		startActivity(intent);
		InfoDetailUI.this.finish();
	}
}
