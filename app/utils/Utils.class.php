<?php

//TODO: this class to be removed if no purpose to use
class Utils {
	
	public function processDate($dateIn) {
		$date = explode(' ', $dateIn);
		$time = explode(':', $date[1]);
		
		$dateObj = new DateTime();
		$dateObj->modify("-1 day");
		
		if ($date[0] == date('Y-m-d')) {
			$dateIn = 'dzi&#347;, ' . $time[0] . ':' . $time[1];
		} else if ($date[0] == $dateObj->format("Y-m-d")) {
			$dateIn = 'wczoraj, ' . $time[0] . ':' . $time[1];
		} else {
			$dateIn = $date[0] . ', ' . $time[0] . ':' . $time[1];
		}
		
		return $dateIn;
	}
	
	static function getAvatarImage($path) {
		if (file_exists($path)) {
			$list = scandir($path, 1);
			$image = $list[0];
			if ($image != '') {
				return $image;
			}
		}
	}
	
	static function getLatestAvatar($friend) {
    	$avatarsDir = $_SESSION['imgDir'] . $friend . '/';
    	$avatar = '';
    	
    	if (file_exists($avatarsDir)) {
    		$avatarsAll = array_reverse(array_slice(scandir($avatarsDir), 2));
    		$avatar = $avatarsAll[0];
    		return $avatar;
    	}
    	
    	return $avatar;
	}
	
	function convertDate($sourceDate) {
		$months = array('', 'stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 
						'lipca', 'sierpnia', 'wrze&#347;nia', 'pa&#378;dziernika', 'listopada', 'grudnia');
		$registration_date = explode(' ', $sourceDate);
		$date = $registration_date[0];
		$time = $registration_date[1];
		$divide_date = explode('-', $date);
		$year = $divide_date[0];
		$month = $divide_date[1];
		if ($month[0] == 0) {
			$month = $month[1];
		}
		$day = $divide_date[2];
		if ((strlen($day) == 2) && (substr($day, 0, 1)) == '0') {
			$day = str_replace('0', '', $day);
		}
		$divide_time = explode(':', $time);
		$hour = $divide_time[0];
		$minute = $divide_time[1];
		$second = $divide_time[2];
		$result = $day . ' ' . $months[$month] . ' ' . $year . ' o ' . $hour . ':' . $minute;
		return $result;
	}
	
	public function isLocal() {
	    if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
	        return true;
	    } else {
	        return false;
	    }
	}
	
}

?>