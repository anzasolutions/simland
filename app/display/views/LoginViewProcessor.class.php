<?php

class LoginViewProcessor extends LoginView
{
	/*
 
	This class could be used as a helper to provide support to particular 'real' view class
	
	Currently 'real' view methods responsible only for data display are mixed with methods preparing data to be used by the 'real' view methods.
	
	Currently a view is a type of class which prepares display. Using it also to manipulate view data can be confusing. This is an issue now to be resolved.
	
	That's why each view could contain its own helper which will obtain, manipulate and return value to be used by the 'real' view methods.
	
	It seems reasonable if a helper is extended from its particular parent view.
	
	*/
}

?>