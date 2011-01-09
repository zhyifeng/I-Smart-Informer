package com.ui;

//author£∫’≈“„∑Ê
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;

public class SearchUI extends Activity {
	private EditText searchEditText;
	private Button searchButton;
	private ToolbarInitialier toolbarInitialier;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.searchui);
		initialize();
		searchButton.setOnClickListener(new ButtonClickListener());
	}

	private void initialize() {
		toolbarInitialier = new ToolbarInitialier(R.id.GridView_toolbar_search,
				this);
		toolbarInitialier.InitialtoToolbar();
		searchEditText = (EditText) findViewById(R.id.EditText_Search);
		searchButton = (Button) findViewById(R.id.Button_Search);
	}

	class ButtonClickListener implements OnClickListener {
		@Override
		public void onClick(View v) {
			String keyword = searchEditText.getText().toString();
			jumpToSearchProcessPage(keyword);
		}
	}

	private void jumpToSearchProcessPage(String keyword) {
		Intent intent = new Intent();
		intent.putExtra("KeyWord", keyword);
		intent.setClass(this, WaitingUI.class);
		startActivity(intent);
	}
}
