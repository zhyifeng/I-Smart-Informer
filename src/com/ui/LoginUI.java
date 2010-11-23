package com.ui;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;

public class LoginUI extends Activity {
	private Button mLogin;
	private Button mExit;
    /** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.loginui);
        
        mLogin = (Button)findViewById(R.id.LoginButt);
        mExit = (Button)findViewById(R.id.CancelButt);
        mLogin.setOnClickListener(new OnClickListener() {
			
			public void onClick(View v) {
				// TODO Auto-generated method stub
				Intent intent = new Intent();
				intent.setClass(LoginUI.this, InfoUI.class);
				startActivity(intent);
			}
		});
        
       mExit.setOnClickListener(new OnClickListener() {
			
			public void onClick(View v) {
				// TODO Auto-generated method stub
				System.exit(0);
			}
		});
    }
}