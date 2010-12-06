package com.ui;

import java.util.ArrayList;
import java.util.HashMap;
import android.app.TabActivity;
import android.os.Bundle;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.TabHost;

public class InfoUI extends TabActivity {

	private TabHost mTabHost;
	private ToolbarInitialier toolbarInitialier;

	/*--�ײ��˵�ͼƬ--*/
	int[] menu_toolbar_image_array1 = { R.drawable.menu_info,
			R.drawable.menu_search, R.drawable.menu_remindsetting,
			R.drawable.menu_syssettings, R.drawable.menu_quit,
			R.drawable.menu_info, R.drawable.menu_search,
			R.drawable.menu_remindsetting, R.drawable.menu_syssettings,
			R.drawable.menu_quit ,R.drawable.menu_quit};

	/*--�ײ��˵�����--*/
	String[] menu_toolbar_name_array1 = { "��Ϣ", "����", "����", "�˺�", "�˳�", "��Ϣ",
			"����", "����", "�˺�", "�˳�" ,"�˳�"};

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.infoui);

		mTabHost = getTabHost();

		mTabHost.addTab(mTabHost.newTabSpec("tab_test1").setIndicator("ѧУ")
				.setContent(R.id.ListView_college));
		mTabHost.addTab(mTabHost.newTabSpec("tab_test2").setIndicator("ѧԺ")
				.setContent(R.id.ListView_school));
		mTabHost.addTab(mTabHost.newTabSpec("tab_test3").setIndicator("�༶")
				.setContent(R.id.ListView_class));

		mTabHost.setCurrentTab(0);
		toolbarInitialier = new ToolbarInitialier(R.id.GridView_toolbar_info,
				this);
		toolbarInitialier.InitialtoToolbar();

		// �趨ѧУ��ǩ�µ����ݸ�ʽ
		ListView mListCollege = (ListView) findViewById(R.id.ListView_college);
		mListCollege.setAdapter(getMenuAdapter(menu_toolbar_name_array1,
				menu_toolbar_image_array1));

		// �趨ѧԺ��ǩ�µ����ݸ�ʽ
		ListView mListSchool = (ListView) findViewById(R.id.ListView_school);
		mListSchool.setAdapter(getMenuAdapter(menu_toolbar_name_array1,
				menu_toolbar_image_array1));

		// �趨�༶��ǩ�µ����ݸ�ʽ
		ListView mListClass = (ListView) findViewById(R.id.ListView_class);
		mListClass.setAdapter(getMenuAdapter(menu_toolbar_name_array1,
				menu_toolbar_image_array1));
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
