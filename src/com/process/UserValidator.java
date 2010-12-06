package com.process;

import java.io.IOException;

import org.apache.http.client.ClientProtocolException;

public class UserValidator {
    DataInteractor interactor = new DataInteractor();
    
	public boolean checkpassword(String name, String password) throws ClientProtocolException, IOException
	{
		return interactor.SendandGetValidateRequest(name, password);		
	}
}
