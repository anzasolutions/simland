<?php

abstract class ViewHelper
{
	protected $html;
	protected $model;
	private $profileMenu = array('profile' => 'Profil', 'gallery' => 'Galeria', 'friends' => 'Znajomi', 'districts' => 'Dzielnice', 'forum' => 'Forum', 'blog' => 'Blog', 
								 'ads' => 'Ogloszenia');
	
	public function ViewHelper($html, $model)
	{
		$this->html = $html;
		$this->model = $model;
	}
	
	public function getAvatarImage($user)
	{
		$avatarPath = PATH_PHOTOS . $user->getId() . '/avatar' . EXT_JPG;
		$image = URL_IMG . 'avatar-' . $user->getGender() . EXT_PNG;
		
		if ($user->hasAvatar() && file_exists($avatarPath))
		{
			$image = URL_PHOTOS . $user->getId() . '/avatar' . EXT_JPG;
		}
		
		return $image;
	}
	
	//TODO: to be fixed and make generic
	public function getProfileMenu($currentAction, $currentController)
	{
		$userId = $_SESSION['oUserProfile'] != null ? $_SESSION['oUserProfile']->getId() . '/' : '/';
		
		$output = '';
		$output .= $this->html->divBegin('user-tabs');
		foreach ($this->profileMenu as $link => $label)
		{
			if ($link == $currentController)
			{
				$output .= $this->html->divBegin('', 'tab-current');
				$output .= $this->html->divClosed('', 'left-current');
				$output .= $this->html->divBegin('', 'center-current');
				$output .= $this->html->divBegin('', 'bullet-blue');
			}
			else
			{
				$output .= $this->html->divBegin('', 'tab');
				$output .= $this->html->divClosed('', 'left');
				$output .= $this->html->divBegin('', 'center');
				$output .= $this->html->divBegin('', 'bullet-white');
			}
			
//			if ($link == 'profile') $link = '';
			
			$output .= $this->html->linkBegin(BASE_URL . $link . '/' . $userId) . $label . $this->html->linkEnd();
			$output .= $this->html->divEnd();
			$output .= $this->html->divEnd();
			
		
			if ($link == $currentController)
			{
				$output .= $this->html->divClosed('', 'right-current');
			}
			else
			{
				$output .= $this->html->divClosed('', 'right');
			}
			
			$output .= $this->html->divEnd();
		}
		
		$output .= $this->html->divEnd();
		return $output;
	}
	
	public function getProfileAvatar()
	{
		$output = '';
		$user = $_SESSION['oUserProfile'];
		$image = $this->getAvatarImage($user);
		$output .= $this->html->linkBegin(URL_PROFILE . $user->getId(), '', $user->getFirstname()) . $this->html->imageBegin($image);
		$output .= $this->html->imageEnd() . $this->html->linkEnd();
		return $output;
	}
}

?>