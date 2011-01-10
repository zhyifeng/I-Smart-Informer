package com.ui;
//author：吕志鹏、李琳
import android.app.Activity;
import android.app.AlertDialog;
import android.app.AlertDialog.Builder;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.DialogInterface.OnClickListener;
import android.database.Cursor;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.SimpleCursorAdapter;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.AdapterView.OnItemLongClickListener;

import com.dao.DbAdapter;

public class ReminderUI extends Activity {
    private ListView remindlist;
    private DbAdapter remindDbHelper;
	private ToolbarInitialier toolbarInitialier;
	private Builder deleteDialogBuilder;
	private long rowId;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.reminderui);
		Initialize();
		updateDate();
		remindlist.setOnItemClickListener(new onListItemClickListener());
		remindlist.setOnItemLongClickListener(new onListItemLongClickListener());
	}
	
	private void Initialize(){
		toolbarInitialier = new ToolbarInitialier(R.id.GridView_toolbar_reminder, this);
		toolbarInitialier.InitialtoToolbar();
		remindDbHelper = new DbAdapter(ReminderUI.this);
		//remindDbHelper.open();
	}
	
    @SuppressWarnings("static-access")
	private void updateDate(){
    	remindlist = (ListView)findViewById(R.id.ListView_reminder);
    	remindDbHelper.open();
    	Cursor cursor = remindDbHelper.fetchAllNotes();
    	startManagingCursor(cursor);
    	ListAdapter adapter = new SimpleCursorAdapter(this, R.layout.list_item, cursor,
    			new String[] {remindDbHelper.KEY_TITLE, remindDbHelper.KEY_DATE}, 
    			new int[] {R.id.list_item_title, R.id.list_item_date});
    	remindlist.setAdapter(adapter);
    	remindDbHelper.close();
    }
    
    class onListItemClickListener implements OnItemClickListener{
		@Override
		public void onItemClick(AdapterView<?> parent, View view, int position,
				long rowid) {
			remindDbHelper.open();
			Cursor c = remindDbHelper.fetchAllNotes();
			c.moveToPosition(position);
			jumpToRemindEditUI(c, rowid);
		}
    }
    
    private void jumpToRemindEditUI(Cursor c, long rowid) {
		Intent intent = packageData(c, rowid);
		intent.setClass(this,RemindNoteEditUI.class);
		startActivity(intent);
		remindDbHelper.close();
		ReminderUI.this.finish();
	}  	
    
    private Intent packageData(Cursor c, long rowid) {
    	Intent intent = new Intent();
    	intent.putExtra(DbAdapter.KEY_ROWID, rowid);
    	intent.putExtra(DbAdapter.KEY_TITLE, c.getString(c.getColumnIndexOrThrow(DbAdapter.KEY_TITLE)));
    	intent.putExtra(DbAdapter.KEY_BODY, c.getString(c.getColumnIndexOrThrow(DbAdapter.KEY_BODY)));
    	intent.putExtra(DbAdapter.KEY_DATE, c.getString(c.getColumnIndexOrThrow(DbAdapter.KEY_DATE)));
		return intent;
	}

	class onListItemLongClickListener implements OnItemLongClickListener{
		@Override
		public boolean onItemLongClick(AdapterView<?> parent, View view,
				int position, long rowid) {
			rowId = rowid;
			showDeleteRemindNoteDialog();
			return false;
		}	
    }
	
	private void showDeleteRemindNoteDialog() {
		deleteDialogBuilder = new AlertDialog.Builder(ReminderUI.this);
		deleteDialogBuilder.setMessage("是否要删除此提醒信息");
		deleteDialogBuilder.setPositiveButton("确定", new DialogPositiveButtonListener());
		deleteDialogBuilder.setNegativeButton("取消", null);
		deleteDialogBuilder.show();
	}   
	
	class DialogPositiveButtonListener implements OnClickListener{
		@Override
		public void onClick(DialogInterface dialog, int which) {
			remindDbHelper.open();
			remindDbHelper.deleteNote(rowId);
			remindDbHelper.close();
			updateDate();
		}	
	}
}
