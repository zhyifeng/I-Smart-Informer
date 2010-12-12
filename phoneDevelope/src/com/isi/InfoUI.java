package com.ui;

import android.app.TabActivity;
import android.os.Bundle;
import android.widget.TabHost;

public class InfoUI extends TabActivity{
	
    TabHost mTabHost;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		 setContentView(R.layout.infoui);
		
		 mTabHost = getTabHost();
		    
		 mTabHost.addTab(mTabHost.newTabSpec("tab_test1").setIndicator("TAB 1").setContent(R.id.textview1));
		 mTabHost.addTab(mTabHost.newTabSpec("tab_test2").setIndicator("TAB 2").setContent(R.id.textview2));
		 mTabHost.addTab(mTabHost.newTabSpec("tab_test3").setIndicator("TAB 3").setContent(R.id.textview3));
		    
		 mTabHost.setCurrentTab(0);

	}
    
}
