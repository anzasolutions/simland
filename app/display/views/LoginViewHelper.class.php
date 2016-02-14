<?php

/**
 * Helper of LoginView class.
 * Prepares elements to be displayed in LoginView.
 * 
 * @author anza
 */
class LoginViewHelper extends ViewHelper
{
	//TODO: requires deep refactoring ?
	public function getLatestLogin()
	{
		$users = $this->model->getLatestLogin();
		
		$output = '';
		foreach ($users as $user)
		{
			$id = $user->isOnline() ? GenderEnum::WOMAN : '';
			
			$image = $this->getAvatarImage($user);
			
			$output .= $this->html->divBegin('', 'id' . $id) . $this->html->linkBegin(URL_PROFILE . $user->getId(), '', $user->getFirstname()) . $this->html->imageBegin($image);
			$output .= $this->html->imageEnd() . $this->html->linkEnd() . $this->html->divEnd();
		}
		
		return $output;
	}
	
	public function generateRandomNumberSet()
	{
		$min = 0;
		$max = 10;
		$values = array();
		
		while (sizeof($values) < $max)
		{
			$value = mt_rand($min, $max);
			if (in_array($value, $values)) continue;
			array_push($values, $value);
		}
		return $values;
	}
	
	//TODO: requires deep refactoring
	public function getLatestPhotoAdded()
	{
		$images = $this->model->getLatestPhotoAdded();
		shuffle($images);
//		echo sizeof($images);
		
//		$rand = $this->generateRandomNumberSet();
		
//		print_r($this->generateRandomNumberSet());
		
//		$mix = array_combine($rand, $images);
//		arsort($mix);
		
//		print_r($mix);
		
//		print_r($images);
//		echo sizeof($images);
		
//		print_r($images);
		
//		echo $images[0][1][0];
		
//		while ($user = $this->model->db->result->fetch_object())
//		{
//			$userPath = PATH_PHOTOS . $user->user_id . '/thumbs/';
//			$image = URL_PHOTOS . $user->user_id . '/thumbs/';
//			
//            if (file_exists($userPath . $user->filename))
//            {
//            	$image .= $user->filename;
//            }
//            
////            $date = new DateTime($user->added);
////            $dateAdded = $date->format('Y-m-d H:i');
//            $dateAdded = Date::getNow();
//			
//			$output .= $this->html->divBegin('', 'photo_frame') . $this->html->spanClosed();
//			$output .= $this->html->linkBegin(URL_PROFILE . $user->user_id, '', $user->description) . $this->html->imageBegin($image) . $this->html->imageEnd() . $this->html->linkEnd();
//			$output .= $this->html->divBegin() . $this->html->linkBegin(URL_PROFILE . $user->user_id, '', $user->description, 'tooltip') . $user->firstname . ' ' . $user->lastname . $this->html->linkEnd();
//			$output .= $this->html->divBegin('', 'photo_frame_date') . $dateAdded . $this->divEnd();
//			$output .= $this->html->divEnd() . $this->html->divEnd();
//		}

		$output = '';
		foreach ($images as $key => $row)
		{
			$image = $row[0];
			$user = $row[1];
			
			$userPath = PATH_PHOTOS . $user->getId() . '/thumbs/';
			$photo = URL_PHOTOS . $user->getId() . '/thumbs/';
			
            if (file_exists($userPath . $image->getFilename()))
            {
            	$photo .= $image->getFilename();
            }
            
			$output .= $this->html->divBegin('', 'photo_frame') . $this->html->spanClosed();
			$output .= $this->html->linkBegin(URL_PROFILE . $user->getId() . '/gallery/'  . $image->getAlbum() . '/' . $image->getNumber(), '', $image->getDescription()) . $this->html->imageBegin($photo) . $this->html->imageEnd() . $this->html->linkEnd();
			$output .= $this->html->divBegin() . $this->html->linkBegin(URL_PROFILE . $user->getId(), '', $image->getDescription(), 'tooltip') . $user->getFirstname() . ' ' . $user->getLastname() . $this->html->linkEnd();
			$output .= $this->html->divBegin('', 'photo_frame_date') . Date::convert($image->getAdded(), 'd.m.Y H:i') . $this->html->divEnd();
			$output .= $this->html->divEnd() . $this->html->divEnd();
			
			if ($key == 9) break;
		}
		
		return $output;
	}
	
	/*public function getLatestComments()
	{
		$this->model->getLatestComments();
		
		while ($user = $this->model->db->result->fetch_object())
		{
			$id = $user->online ? 4 : 3;
			$userPath = PATH_IMG_USER . $user->user_id . '/';
			$image = URL_IMG_USER;
			$getAvatar = Utils::getAvatarImage($userPath);
			
            if ($user->avatar && file_exists($userPath . $getAvatar))
            {
                $image .= $user->user_id . '/' . $getAvatar;
            }
            else
            {
            	$gender = $user->gender == 'k' ? '-woman' : null;
            	$image .= 'user-default' . $gender . '.png';
            }
			
			$output .= $this->divBegin('', 'id' . $id) . $this->linkBegin(URL_PROFILE . $user->user_id, $user->name, 'tooltip') . $this->imageBegin($image);
			$output .= $this->imageEnd() . $this->linkEnd() . $this->divEnd();
			$output .= $this->divBegin('', 'comment-front') . $this->linkBegin(URL_PROFILE . $user->user_id, $user->name) . $user->comment;
			$output .= $this->linkEnd() . $this->divEnd();
		}
		
		return $output;
	}
	
	public function getLatestBlogs()
	{
		$this->model->getLatestBlogs();
		
		while ($user = $this->model->db->result->fetch_object())
		{
			$output .= $this->divBegin('', 'latest-blogs-user') . $this->linkBegin(URL_PROFILE . $user->user_id) . $user->name;
			$output .= $this->linkEnd() . $this->divEnd();
			$output .= $this->divBegin('', 'latest-blogs-subject') . $this->linkBegin(URL_PROFILE . $user->user_id) . $user->subject;
			$output .= $this->linkEnd() . $this->divEnd();
			$output .= $this->divClosed('separator4');
		}
		
		return $output;
	}*/
}

?>