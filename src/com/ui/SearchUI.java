package com.ui;

import java.util.ArrayList;
import java.util.HashMap;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.Gravity;
import android.view.View;
import android.widget.AdapterView;
import android.widget.GridView;
import android.widget.SimpleAdapter;
import android.widget.Toast;
import android.widget.AdapterView.OnItemClickListener;

public class SearchUI extends Activity{
	private GridView toolbarGrid; 
	
	 /*-- Toolbar�ײ��˵�ѡ���±�--*/
	private final int TOOLBAR_ITEM_INFO = 0;// ��Ϣ
	private final int TOOLBAR_ITEM_SEARCH = 1;// ����
	private final int TOOLBAR_ITEM_REMINDSETTING = 2;// ��������
	private final int TOOLBAR_ITEM_SYSSETTING = 3;// �˺�����
	private final int TOOLBAR_ITEM_QUIT = 4;// �˳�
	
	/*--�ײ��˵�ͼƬ--*/
	int[] menu_toolbar_image_array = {R.drawable.menu_info, R.drawable.menu_search,
			R.drawable.menu_remindsetting, R.drawable.menu_syssettings, R.drawable.menu_quit};
	
	/*--�ײ��˵�����--*/
	String[] menu_toolbar_name_array = {"��Ϣ", "����", "����", "�˺�", "�˳�"};
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.searchui);
		
		// �����ײ��˵� Toolbar
		toolbarGrid = (GridView) findViewById(R.id.GridView_toolbar);
		toolbarGrid.setBackgroundResource(R.drawable.channelgallery_bg);// ���ñ���
		toolbarGrid.setNumColumns(5);// ����ÿ������
		toolbarGrid.setGravity(Gravity.CENTER);// λ�þ���
		toolbarGrid.setVerticalSpacing(10);// ��ֱ���
		toolbarGrid.setHorizontalSpacing(10);// ˮƽ���
		toolbarGrid.setAdapter(getMenuAdapter(menu_toolbar_name_array,
				menu_toolbar_image_array));// ���ò˵�Adapter
		/** �����ײ��˵�ѡ�� **/
		toolbarGrid.setOnItemClickListener(new OnItemClickListener() {
			public void onItemClick(AdapterView<?> arg0, View arg1, int arg2,
					long arg3) {
				Toast.makeText(SearchUI.this,
						menu_toolbar_name_array[arg2], Toast.LENGTH_SHORT)
						.show();
				switch (arg2) {
				case TOOLBAR_ITEM_INFO:
					break;
				case TOOLBAR_ITEM_SEARCH:

					break;
				case TOOLBAR_ITEM_REMINDSETTING:

					break;
				case TOOLBAR_ITEM_SYSSETTING:

					break;
				case TOOLBAR_ITEM_QUIT:
					android.os.Process.killProcess(android.os.Process.myPid()); 
					break;
				}
			}
		});
	}
    
	/**
	 * ����˵�Adapter
	 * 
	 * @param menuNameArray
	 *            ����
	 * @param imageResourceArray
	 *            ͼƬ
	 * @return SimpleAdapter
	 */
	private SimpleAdapter getMenuAdapter(String[] menuNameArray,
			int[] imageResourceArray) {
		ArrayList<HashMap<String, Object>> data = new ArrayList<HashMap<String, Object>>();
		for (int i = 0; i < menuNameArray.length; i++) {
			HashMap<String, Object> map = new HashMap<String, Object>();
			map.put("itemImage", imageResourceArray[i]);
			map.put("itemText", menuNameArray[i]);
			data.add(map);
		}
		SimpleAdapter simperAdapter = new SimpleAdapter(this, data,
				R.layout.item_menu, new String[] { "itemImage", "itemText" },
				new int[] { R.id.item_image, R.id.item_text });
		return simperAdapter;
	}
}
