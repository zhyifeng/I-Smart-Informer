package com.ui;

import java.io.IOException;

import org.apache.http.client.ClientProtocolException;

import com.process.UserValidator;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.AlertDialog.Builder;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

public class LoginUI extends Activity {
	private Button loginButton;
	private Button ExitButton;
    private Builder LogoutDialogBuilder; 
    private EditText userIDEditText;
    private EditText PasswordEditText;
    private String userID;
    private String userPassword;
    
    /** Called when the activity is first created. */
	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.loginui);

		loginButton = (Button) findViewById(R.id.LoginButt);
		ExitButton = (Button) findViewById(R.id.CancelButt);
		userIDEditText = (EditText)findViewById(R.id.EditID);
		PasswordEditText = (EditText)findViewById(R.id.EditPassword);
		userID = userIDEditText.getText().toString();
		userPassword = PasswordEditText.getText().toString();
		
		loginButton.setOnClickListener(new ButtonListener());
		ExitButton.setOnClickListener(new ButtonListener());
	}
	
	
	private void JumpToOtherActivity()
	{
		Intent intent = new Intent();
		intent.setClass(LoginUI.this, InfoUI.class);
		startActivity(intent);
		LoginUI.this.finish();
	}
	
	private void ExitSystem() {
		ShowExitDialog();
	}
	
	private void ShowExitDialog() {
		LogoutDialogBuilder = new AlertDialog.Builder(LoginUI.this);
		LogoutDialogBuilder.setTitle("退出提示");
		LogoutDialogBuilder.setMessage("请问是否需要退出\n是，请按确定\n否，请按取消");
		LogoutDialogBuilder.setPositiveButton("确定", new DialogPositiveButtonListener());
		LogoutDialogBuilder.setNegativeButton("取消", null);
		LogoutDialogBuilder.show();
	}
	
	private void DisplayErrorMessage() {
		Toast.makeText(this, "用户名或密码错误", Toast.LENGTH_SHORT).show();
	}	
	
	class ButtonListener implements OnClickListener
	{
		@Override
		public void onClick(View v) {
		   if (v == loginButton)
		   {
			   UserValidator validator = new UserValidator();
			   try {
				if (validator.checkpassword(userID, userPassword))
					   JumpToOtherActivity();
				   else
					   DisplayErrorMessage();
			} catch (ClientProtocolException e) {
				e.printStackTrace();
			} catch (IOException e) {
				e.printStackTrace();
			}
		   }
		   if (v == ExitButton)
			   ExitSystem();
		}
	}
	
	class DialogPositiveButtonListener implements DialogInterface.OnClickListener
	{
		@Override
		public void onClick(DialogInterface dialog, int which) {
			System.exit(0);
		}	
	}
}