package com.ui;

import android.app.Activity;
import android.os.Bundle;

public class SearchUI extends Activity {

	private ToolbarInitialier toolbarInitialier;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.searchui);
		toolbarInitialier = new ToolbarInitialier(R.id.GridView_toolbar_search,this);
		toolbarInitialier.InitialtoToolbar();
	}

}
