<?php

/**
 * Manage PHP sessions functionality.
 * Wraps the session mechanism and improves it.
 * 
 * @author anza
 * @since 2010-01-20
 */
class Session
{
	const VALID_COOKIE_PERIOD = 3600; // 1 hour
	const UNVALID_COOKIE_PERIOD = 86400; // 1 day
    const REMEMBER_ME_PERIOD = 1209600; // 14 days
    const APPLICATION_ID = 'qLjdSKLbrWgxeEAbpvRHNgw8MADYcxVj'; // unique fingerprint of application
    const SALT = '$2a$07$elislaoreetjustodi$'; // salt of fingerprint encryption
    
    private $remembered;
    
    private static $instance;
    
    /**
     * Initializes a session before its start.
     * It's mandatory to be used always before any other call.
     * 
     * @return void
     */
    public function Session()
    {
    	$this->generateName();
    	session_start();
    	ob_start();
    }
    
    /**
     * Ensure the Session object is a singleton.
     * 
     * @return Session Only one instance.
     */
    public static function getInstance()
    {
    	if (!self::$instance)
    	{
    		self::$instance = new Session();
    	}
    	return self::$instance;
    }
    
    /**
     * Starts a session once initialized.
     * 
     * @return boolean True if just started or earlier started and validated.
     */
    public function start()
    {
    	return $this->isStarted() ? $this->validate() : $this->setStarted(true);
    }
    
    /**
     * Compare local and server (session) fingerprints.
     * If not the same the session will be destroyed.
     * 
     * @return boolean False on fingerprints mismatch.
     */
    private function validate()
    {
    	if ($this->getServerFingerprint() != $this->getLocalFingerprint())
    	{
    		$this->destroy();
    		return false;
    	}
    	return true;
    }
    
    /**
     * Clear all values from $_SESSION variable
     * 
     * @return void
     */
    public function clear()
    {
    	if (!empty($_SESSION))
    	{
    		$_SESSION = array();
    	}
    }
    
    /**
     * Destroy current session and clear all cookie entries.
     * 
     * @return void
     */
    public function destroy()
    {
    	// unset all session values
    	$this->clear();
    	
    	// unvalidate cookie data
    	if (isset($_COOKIE[session_name()]))
    	{
			setcookie(session_name(), '', time() - self::UNVALID_COOKIE_PERIOD, '/');
		}
		
		// destroy session
    	session_destroy();
    }
    
    /**
     * Check if session cookie exists:
     * 
     * 1. if session is remembered then cookie expire is extended n = 14 days,
     * 2. else session cookie is kept just for n = 1 hours.
     * 
     * The cookie expires after n time, or on demand by explicit session finish.
     * If within n time a session is restarted then cookie is extended for another n time.
     * 
     * @return void
     */
    private function saveCookie($period)
    {
		if (isset($_COOKIE[session_name()]))
		{
			if ($this->isRemembered())
			{
				$remember = self::REMEMBER_ME_PERIOD;
			}
			
			$this->setCookie($period, $remember);
		}
    }

    /**
     * Sets cookie for given period.
     * Optionally the period is extended with extra time.
     * 
     * @param $period Basic period of time during which a session is valid
     * @param $extraTime Extra amount of time exteding the basic period.
     * @return void
     */
    private function setCookie($period, $extraTime = null)
    {
    	//TODO: change last parameter (domain range) to only proper resources and not whole domain!
    	setcookie(session_name(), $_COOKIE[session_name()], time() + $period + $extraTime, '/');
    	//TODO: variable for debug only! should be removed or handled other way 
// 		$_SESSION['initTime'] = time() + $period + $extraTime;
		$_SESSION['initTime'] = time();
    }
    
    /**
     * Wrapping function of session_regenerate_id.
     * It's purpose is to provide more OO design.
     * 
     * @param boolean $delete If true the current session will be deleted.
     * @return void
     */
    public function generateId($delete = null)
    {
    	session_regenerate_id($delete);
    }
    
    /**
     * Pseudo-encryption function generating unique token for security.
     * 1. mt_rand() generates random number
     * 2. hashed using md5
     * 3. used as prefix in uniqid generation
     * 4. hashed using sha1
     * 
     * @return string Generated token.
     */
    private function generateToken()
    {
    	$token = sha1(uniqid(md5(mt_rand(), true)), true);
    	return $token;
    }
    
    /**
     * Generate and set random session name based on constant fingerprint
     * and uniquely generated id based on the fingerprint.
     * Replace default session name PHPSESSID.
     * Inspired by http://www.eyesis.ca/projects/securesession.html
     * 
     * @return void
     */
    private function generateName()
    {
        $secret = md5(uniqid(self::APPLICATION_ID));
        foreach ($_COOKIE as $key => $value)
        {
            $fingerPrintLength = strlen(self::APPLICATION_ID);
            if (substr($key, 0, $fingerPrintLength) == self::APPLICATION_ID)
            {
            	$secret = substr($key, $fingerPrintLength);
                break;
            }
        }
    	session_name(self::APPLICATION_ID . $secret);
    }
    
    /**
     * Check if a session is started
     * 
     * @return boolean True if session started
     */
    public function isStarted()
    {
        return isset($_SESSION['started']);
    }
    
    /**
     * Mark publicly session as started
     * 
     * @param boolean $started Set true to start session
     * @return boolean Always true.
     */
    public function setStarted($started)
    {
    	// stores initial session id generated on session_start() for debug only!
    	//TODO: should be removed or handle another way
    	$_SESSION['session_id'] = $_COOKIE[session_name()];
    	
    	// A user who creates a new session by logging in should be assigned a fresh session ID using the session_regenerate_id function.
    	// A hijacking user will try to set his session ID prior to login; this can be prevented if the ID regenerated at login.
    	// new session id is generated for security and used later on
    	// no hack through session id to the system is possible
    	session_regenerate_id(true);
    	
    	// assignes regenerated session id to cookie's session name
    	$_COOKIE[session_name()] = session_id();
    	
    	// saves cookie for a given period of time
    	$this->saveCookie(self::VALID_COOKIE_PERIOD);
    	
    	// establish unique fingerprint inside server SESSION
    	$this->setServerFingerprint($this->getLocalFingerprint());
    	
    	// server marker of started session
        $_SESSION['started'] = $started;
        
        return true;
    }
    
    /**
     * Generate current session fingerprint.
     * Used to authenticate system environment on which session was started.
     * 
     * @return string Encrypted fingerprint.
     */
    public function getLocalFingerprint()
    {
    	$encType = CRYPT_BLOWFISH == 1;
    	return $encType ? crypt(md5(self::APPLICATION_ID) . md5($_SERVER['HTTP_USER_AGENT']) . md5(session_id()), self::SALT) : '';
    	//TODO: if tests with crypt() will succeed and no windows hanging detected the below should be removed after sometime  
    	// return crypt(md5(self::APPLICATION_ID) . md5($_SERVER['HTTP_USER_AGENT']) . md5(session_id()));
    }
    
    /**
     * Set unique server side fingerprint.
     * Use local fingerprint as a source of a value. 
     * 
     * @param string $localFingerprint Generated local fingerprint.
     * @return void
     */
    private function setServerFingerprint($localFingerprint)
    {
    	$_SESSION['fingerprint'] = $localFingerprint;
    }
    
    /**
     * Obtain fingerprint of a current session.
     * 
     * @return string Server-side session fingerprint.
     */
    private function getServerFingerprint()
    {
    	return $_SESSION['fingerprint'];
    }
    
    /**
     * Check if session is extended for extra time.
     * 
     * @return boolean True if session is extended.
     */
    public function isRemembered()
    {
    	return $this->remembered;
    }
    
    /**
     * Set session's extension time.
     * 
     * @param boolean $remembered Extended session time value.
     * @return void
     */
    public function setRemembered($remembered)
    {
    	$this->remembered = $remembered;
    }
    
}

?>