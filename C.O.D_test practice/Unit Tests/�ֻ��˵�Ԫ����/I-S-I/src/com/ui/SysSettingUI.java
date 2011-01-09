package com.ui;
//author£∫¿Ó¡’
import android.app.Activity;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;

public class SysSettingUI extends Activity {
	private ToolbarInitialier toolbarInitialier;
    private EditText oldpasswordEdit;
    private EditText newpasswordEdit;
    private EditText newpasswordagainEdit;
    private Button resetButton;
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.syssettingui);
		toolbarInitialier = new ToolbarInitialier(R.id.GridView_toolbar_syssetting, this);
		toolbarInitialier.InitialtoToolbar();
		oldpasswordEdit = (EditText)findViewById(R.id.EditText_oldPassWord);
		newpasswordEdit = (EditText)findViewById(R.id.EditText_newPassWord);
		newpasswordagainEdit = (EditText)findViewById(R.id.EditText_newPassWordagain);
		resetButton = (Button)findViewById(R.id.Button_reset);
		
		resetButton.setOnClickListener(new OnClickListener() {
			@Override
			public void onClick(View v) {
				oldpasswordEdit.setText("");
				newpasswordEdit.setText("");
				newpasswordagainEdit.setText("");
			}
		});
	}
}
