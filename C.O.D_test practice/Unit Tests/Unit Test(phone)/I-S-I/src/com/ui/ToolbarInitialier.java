package com.ui;
//author：张毅锋、吕志鹏
import java.util.ArrayList;
import java.util.HashMap;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.AlertDialog.Builder;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.view.Gravity;
import android.view.View;
import android.widget.AdapterView;
import android.widget.GridView;
import android.widget.ListAdapter;
import android.widget.SimpleAdapter;
import android.widget.AdapterView.OnItemClickListener;

public class ToolbarInitialier {
	private GridView toolbarGrid;
	private int toolbarID;
	private Context UIContext;
	private Builder LogoutDialogBuilder; 
	private ItemClickListener listener = new ItemClickListener();
    
	private final int TOOLBAR_ITEM_INFO = 0;// 消息
	private final int TOOLBAR_ITEM_SEARCH = 1;// 搜索
	private final int TOOLBAR_ITEM_REMINDSETTING = 2;// 提醒设置
	private final int TOOLBAR_ITEM_SYSSETTING = 3;// 账号设置
	private final int TOOLBAR_ITEM_QUIT = 4;// 退出
	
	/*--底部菜单图片--*/
	private int[] menu_toolbar_image_array = { R.drawable.menu_info,
			R.drawable.menu_search, R.drawable.menu_remindsetting,
			R.drawable.menu_syssettings, R.drawable.menu_quit };

	/*--底部菜单文字--*/
	private String[] menu_toolbar_name_array = { "消息", "搜索", "提醒", "账号", "退出" };

	public ToolbarInitialier(int toolbarId, Context context) {
		super();
		toolbarID = toolbarId;
		UIContext = context;
		toolbarGrid = (GridView) ((Activity) UIContext).findViewById(toolbarID);
	}

	public void InitialtoToolbar() {
		setToolbarAttribute();
		toolbarGrid.setOnItemClickListener(listener);
	}

	private void setToolbarAttribute() {
		toolbarGrid.setBackgroundResource(R.drawable.channelgallery_bg);// 设置背景
		toolbarGrid.setNumColumns(5);// 设置每行列数
		toolbarGrid.setGravity(Gravity.CENTER);// 位置居中
		toolbarGrid.setVerticalSpacing(10);// 垂直间隔
		toolbarGrid.setHorizontalSpacing(10);// 水平间隔
		toolbarGrid.setAdapter(getMenuAdapter());// 设置菜单Adapter
	}

	private ListAdapter getMenuAdapter() {

		SimpleAdapter simperAdapter = new SimpleAdapter(UIContext,
				getMenuData(), R.layout.item_menu, new String[] { "itemImage",
						"itemText" }, new int[] { R.id.item_image,
						R.id.item_text });
		return simperAdapter;
	}

	private ArrayList<HashMap<String, Object>> getMenuData() {
		ArrayList<HashMap<String, Object>> data = new ArrayList<HashMap<String, Object>>();
		for (int indexOfToolbarMember = 0; indexOfToolbarMember < menu_toolbar_name_array.length; indexOfToolbarMember++) {
			data.add(getMap(indexOfToolbarMember));
		}
		return data;
	}

	private HashMap<String, Object> getMap(int index) {
		HashMap<String, Object> map = new HashMap<String, Object>();
		map.put("itemImage", menu_toolbar_image_array[index]);
		map.put("itemText", menu_toolbar_name_array[index]);
		return map;

	}
    
	class ItemClickListener implements OnItemClickListener {

		@Override
		public void onItemClick(AdapterView<?> arg0, View arg1, int arg2,
				long arg3) {
			switch (arg2) {
			case TOOLBAR_ITEM_INFO:
				if (toolbarID != R.id.GridView_toolbar_info)
				   JumpToOtherActivity(InfoUI.class);
				break;
			case TOOLBAR_ITEM_SEARCH:
				if (toolbarID != R.id.GridView_toolbar_search)
				   JumpToOtherActivity(SearchUI.class);
				break;
			case TOOLBAR_ITEM_REMINDSETTING:
				if (toolbarID != R.id.GridView_toolbar_reminder)
				JumpToOtherActivity(ReminderUI.class);
				break;
			case TOOLBAR_ITEM_SYSSETTING:
				if (toolbarID != R.id.GridView_toolbar_syssetting)
					JumpToOtherActivity(SysSettingUI.class);
				break;
			case TOOLBAR_ITEM_QUIT:
				ExitSystem();
				break;
			}
		}
	}

	private void JumpToOtherActivity(Class<?> cls) {
		Intent intent = new Intent();
		intent.setClass(UIContext, cls);
		((Activity) UIContext).startActivity(intent);
		((Activity) UIContext).finish();
	}
	
	private void ExitSystem() {
		ShowExitDialog();
	}
	
	private void ShowExitDialog() {
		LogoutDialogBuilder = new AlertDialog.Builder(UIContext);
		LogoutDialogBuilder.setTitle("退出提示");
		LogoutDialogBuilder.setMessage("请问是否需要退出\n是，请按确定\n否，请按取消");
		LogoutDialogBuilder.setPositiveButton("确定", new DialogPositiveButtonListener());
		LogoutDialogBuilder.setNegativeButton("取消", null);
		LogoutDialogBuilder.show();
	}
	
	class DialogPositiveButtonListener implements DialogInterface.OnClickListener
	{
		@Override
		public void onClick(DialogInterface dialog, int which) {
			System.exit(0);
		}	
	}
}
