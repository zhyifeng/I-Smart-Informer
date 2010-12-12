package com.dao;
///author:李琳
import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

public class DbAdapter {
	public static final String KEY_TITLE = "title";
    public static final String KEY_BODY = "body";
    public static final String KEY_DATE = "date";
    public static final String KEY_ROWID = "_id";

    /**
     * 表及属性
     */
    private static final String DATABASE_CREATE =
            "create table remindnotes (_id integer primary key autoincrement, "
                    + "title text not null, body text not null, date text not null);";

    private static final String DATABASE_NAME = "reminddata";
    private static final String DATABASE_TABLE = "remindnotes";
    private static final int DATABASE_VERSION = 2;

    private final Context mCtx;
    private DatabaseHelper mDbHelper;
    private SQLiteDatabase mDb;
    
    private static class DatabaseHelper extends SQLiteOpenHelper {

        DatabaseHelper(Context context) {
            super(context, DATABASE_NAME, null, DATABASE_VERSION);
        }

        @Override
        public void onCreate(SQLiteDatabase db) {
        	//add your code，可使用execSQL();	
        	db.execSQL(DATABASE_CREATE);
        }

        @Override
        public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
         //add your code，可使用execSQL();
        	db.execSQL("Drop Table if Exits remindnotes");
        }
    }
    
    public DbAdapter(Context ctx) {
        this.mCtx = ctx;
    }
    
    public DbAdapter open() throws SQLException {
    	//add your code
    	mDbHelper = new DatabaseHelper(mCtx);
    	mDb = mDbHelper.getWritableDatabase();
        return this;
    }
    
    public void close() {
    	//add your code	
    	mDbHelper.close();
    }

    public long createNote(String title, String body, String date) {
    	//add your code
    	ContentValues initialValues = new ContentValues();
    	initialValues.put(KEY_TITLE, title);
    	initialValues.put(KEY_BODY, body);
    	initialValues.put(KEY_DATE, date);
		return mDb.insert(DATABASE_TABLE, KEY_ROWID, initialValues);	
    }
    
    public boolean deleteNote(long rowId) {
    	//add your code	
		return mDb.delete(DATABASE_TABLE, KEY_ROWID+"="+rowId, null) > 0;  
    }


    public Cursor fetchAllNotes() {
    	//add your code	
		return mDb.query(DATABASE_TABLE, new String[] {KEY_ROWID,KEY_TITLE,KEY_BODY,KEY_DATE}, null, null, null, null, null);
    }


    public Cursor fetchNote(long rowId) throws SQLException {
    	//add your code	
    	Cursor mCursor = mDb.query(true, DATABASE_TABLE, new String[] {KEY_ROWID,KEY_TITLE,KEY_BODY,KEY_DATE},
    			KEY_ROWID + "=" + rowId, null, null, null, null, null);
    	if (mCursor != null)
    	{
    		mCursor.moveToFirst();
    	}
		return mCursor;
    }
   
    public boolean updateNote(long rowId, String title, String body, String date) {
    	//add your code
    	ContentValues args = new ContentValues();
    	args.put(KEY_TITLE, title);
    	args.put(KEY_BODY, body);
    	args.put(KEY_DATE, date);
		return mDb.update(DATABASE_TABLE, args, KEY_ROWID + "=" + rowId, null) > 0;		
    }
}
