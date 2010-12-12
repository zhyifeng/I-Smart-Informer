package com.ui;
//author£∫¿Ó¡’
import android.app.Activity;
import android.os.Bundle;

public class SysSettingUI extends Activity {
	private ToolbarInitialier toolbarInitialier;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.syssettingui);
		toolbarInitialier = new ToolbarInitialier(R.id.GridView_toolbar_syssetting, this);
		toolbarInitialier.InitialtoToolbar();
	}
}
