package com.ui;
//author£∫’≈“„∑Ê
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;

import com.dao.DbAdapter;

public class RemindNoteEditUI extends Activity{
	private DbAdapter remindDbHelper;
    private EditText titleEditText;
    private EditText bodyEditText;
    private EditText dateEditText;
    private Button confirmButton;
    private Button resetButton;
    private Bundle remindBundle;
    private long rowid = -10;
    private String title;
    private String body;
    private String date;
    
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.remindnoteeditui);
		Initialize();
		loadAndSetRemindDate();
		confirmButton.setOnClickListener(new confirmButtonClickListener());
		resetButton.setOnClickListener(new resetButtonClickListener());
	}

	private void loadAndSetRemindDate() {
         if (remindBundle != null){
        	 loadRemindDateFromBundle();
        	 setRemindDateToEditText();
         }
	}

	private void setRemindDateToEditText() {
         titleEditText.setText(title);
         bodyEditText.setText(body);
         dateEditText.setText(date);
	}

	private void loadRemindDateFromBundle() {
		 title = remindBundle.getString(DbAdapter.KEY_TITLE);
		 body = remindBundle.getString(DbAdapter.KEY_BODY);
		 date = remindBundle.getString(DbAdapter.KEY_DATE);
		 rowid = remindBundle.getLong(DbAdapter.KEY_ROWID);
	}

	private void Initialize() {
		titleEditText = (EditText)findViewById(R.id.EditText_notetitle);
		bodyEditText = (EditText)findViewById(R.id.EditText_notebody);
		dateEditText = (EditText)findViewById(R.id.EditText_notedate);
		confirmButton = (Button)findViewById(R.id.Button_confirm);
		resetButton = (Button)findViewById(R.id.Button_notereset);
		remindBundle = getIntent().getExtras();
	}
    
	class confirmButtonClickListener implements OnClickListener{
		@Override
		public void onClick(View v) {
			remindDbHelper = new DbAdapter(RemindNoteEditUI.this);
			remindDbHelper.open();
			setRemindInfo();
			selectDbOperation(rowid);
			remindDbHelper.close();
			jumpToReminderUI();
		}
	}
	
	private void jumpToReminderUI() {
        Intent intent = new Intent();
        intent.setClass(RemindNoteEditUI.this, ReminderUI.class);
        startActivity(intent);
        RemindNoteEditUI.this.finish();
	}
	
	private void selectDbOperation(long rowid) {
		if (rowid != -10)
			updateRemindNote();
		else
			insertRemindNote();
	}	
	
	private void insertRemindNote() {
		remindDbHelper.createNote(title, body, date);
	}

	private void updateRemindNote() {
		remindDbHelper.updateNote(rowid, title, body, date);
	}

	private void setRemindInfo() {
		title = titleEditText.getText().toString();
		body = bodyEditText.getText().toString();
		date = dateEditText.getText().toString();
	}	
	
	class resetButtonClickListener implements OnClickListener{
		@Override
		public void onClick(View v) {
			titleEditText.setText("");
			bodyEditText.setText("");
			dateEditText.setText("");
		}		
	}
}
