<?php

class PhotoHandler
{
	private $name = null;
	private $type = null;
	private $tmpName = null;
	private $error = null;
	private $size = null;
	private $randomName = null;
	
	public function PhotoHandler()
	{
		$this->initialize();
	}
	
	private function initialize()
	{
		$photoContainer = array_keys($_FILES);
		$photoId = $_FILES[$photoContainer[0]];
		
		if ($photoId != null)
		{
			$this->name = $photoId['name'];
			$this->type = $photoId['type'];
			$this->tmp_name = $photoId['tmp_name'];
			$this->error = $photoId['error'];
			$this->size = $photoId['size'];
		}
	}
	
	// TODO: require heavy refactoring
	public function addPhoto()
	{
		ini_set("memory_limit", "200000000"); // for large images so that we do not get "Allowed memory exhausted"
		// upload the file
		
		$remote_file_components = explode(".", $this->name);
		$this->setRandomName($this->generateRandomName() . '.' . strtolower($remote_file_components[1]));
		
//		echo $_POST["form_sent"];
		if ((isset($_POST["form_sent"])) && ($_POST["form_sent"] == 1))
		{
			// file needs to be jpg,gif,bmp,x-png and 4 MB max
			if (($this->type == "image/jpeg" || $this->type == "image/pjpeg" || $this->type == "image/gif" || $this->type == "image/x-png") && ($this->size < 4000000))
			{
				// some settings
				$max_upload_width = 100;
				$max_upload_height = 100;
				$max_upload_width2 = 600;
				$max_upload_height2 = 720;
				  
				// if user chosed properly then scale down the image according to user preferances
				/* if(isset($_REQUEST['max_width_box']) and $_REQUEST['max_width_box']!='' and $_REQUEST['max_width_box']<=$max_upload_width){
					$max_upload_width = $_REQUEST['max_width_box'];
				}    
				if(isset($_REQUEST['max_height_box']) and $_REQUEST['max_height_box']!='' and $_REQUEST['max_height_box']<=$max_upload_height){
					$max_upload_height = $_REQUEST['max_height_box'];
				}	 */
				
				// if uploaded image was JPG/JPEG
				if ($this->type == "image/jpeg" || $this->type == "image/pjpeg")
				{	
					$image_source = imagecreatefromjpeg($this->tmp_name);
				}		
				// if uploaded image was GIF
				if ($this->type == "image/gif")
				{	
					$image_source = imagecreatefromgif($this->tmp_name);
				}	
				// BMP doesn't seem to be supported so remove it form above image type test (reject bmps)	
				// if uploaded image was BMP
				if ($this->type == "image/bmp")
				{	
					$image_source = imagecreatefromwbmp($this->tmp_name);
				}			
				// if uploaded image was PNG
				if ($this->type == "image/x-png")
				{
					$image_source = imagecreatefrompng($this->tmp_name);
				}
		
//				$remote_file = $this->tmp_name;
//				$remote_file = $this->name;
				$remote_file = $this->getRandomName();
				imagejpeg($image_source, $remote_file, 100);
				chmod($remote_file, 0644);
				
//				return;

				// get width and height of original image
				list($image_width, $image_height) = getimagesize($remote_file);
				
				echo getimagesize($remote_file);
			
				if ($image_width>$max_upload_width || $image_height >$max_upload_height)
				{
					$proportions = $image_width/$image_height;
					
					if ($image_width>$image_height)
					{
						$new_width = $max_upload_width;
						$new_height = round($max_upload_width/$proportions);
					}		
					else
					{
						$new_height = $max_upload_height;
						$new_width = round($max_upload_height*$proportions);
					}
					
					$new_image = imagecreatetruecolor($new_width , $new_height);
					$image_source = imagecreatefromjpeg($remote_file);
					
					imagecopyresampled($new_image, $image_source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
					imagejpeg($new_image, PATH_PHOTOS . $_SESSION['oUser']->getId() . '/thumbs/' . $remote_file, 100);
//					imagejpeg($new_image, PATH_PHOTOS . $_SESSION['oUser']->getId() . '/thumbs/' . $this->getRandomName(), 100);
					
//					echo PATH_PHOTOS . $_SESSION['oUser']->getId() . '/thumbs/' . $remote_file;
					
					imagedestroy($new_image);
				}
				
				imagedestroy($image_source);

				// get width and height of original image
				list($image_width, $image_height) = getimagesize($remote_file);
				
				if ($image_width > $max_upload_width2 || $image_height > $max_upload_height2)
				{
					$proportions = $image_width / $image_height;
					
					if ($image_width >= $image_height)
					{
						$new_width = $max_upload_width2;
						$new_height = round($max_upload_width2/$proportions);
					}
					else
					{
						$new_height = $max_upload_height2;
						$new_width = round($max_upload_height2 * $proportions);
					}		
					
					$new_image = imagecreatetruecolor($new_width , $new_height);
					$image_source = imagecreatefromjpeg($remote_file);
					
					imagecopyresampled($new_image, $image_source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
					imagejpeg($new_image, PATH_PHOTOS . $_SESSION['oUser']->getId() . '/full/' . $remote_file, 100);
//					imagejpeg($new_image, PATH_PHOTOS . $_SESSION['oUser']->getId() . '/full/' . $this->getRandomName(), 100);
//					imagejpeg($new_image, 'zuzol/' . $remote_file, 100);
					
					imagedestroy($new_image);
//					imagedestroy($image_source);
				}
				else
				{
					$image_source = imagecreatefromjpeg($remote_file);
					imagejpeg($image_source, PATH_PHOTOS . $_SESSION['oUser']->getId() . '/full/' . $remote_file, 100);
				}
				
				imagedestroy($image_source);
//				header("Location: submit.php?upload_message=image uploaded&upload_message_type=success&show_image=" . $this->name);
				//exit;
				
				echo $this->tmp_name;
				unlink($remote_file);
			}
			else
			{
				throw new FileNoImageException();
			}
			
//			$dir = 'image_files/';
//			// open specified directory
//			$dirHandle = opendir($dir);
//			$total_deleted_images = 0;
//			while ($file = readdir($dirHandle))
//			{
//				// if not a subdirectory and if filename contains the string '.jpg' 
//				if (!is_dir($file))
//				{
//					// update count and string of files to be returned
//					unlink($dir.$file);
//					echo 'Deleted file <b>' . $file . '</b><br />';
//					$total_deleted_images++;
//				} 
//			} 
//			closedir($dirHandle);
//			if ($total_deleted_images == '0')
//			{
//				echo 'There ware no files uploaded there.';
//			}
//		echo '<br />Thank you.';
		}
	}
	
	/**
	 * Generate random string.
	 * Using characters and numbers. 
	 * 
	 * @author 8ennett
	 * @link http://www.astahost.com/info.php/Php-Random-Text-Generating_t2583.html
	 * @since 2010-01-29 16:20
	 * @return string
	 */
	public function generateRandomName()
	{
		$alphanum = "abcdefghijkmnpqrstuvwxyz23456789";
		$rand = substr(str_shuffle($alphanum), 0, 10);  // 5 Being the amount of letters/numbers are select from the variable alphanum
		return $rand;
	}
	
	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getType()
	{
		return $this->type;
	}

	public function setType($type)
	{
		$this->type = $type;
	}

	public function getTmpName()
	{
		return $this->tmpName;
	}

	public function setTmpName($tmpName)
	{
		$this->tmpName = $tmpName;
	}

	public function getError()
	{
		return $this->error;
	}

	public function setError($error)
	{
		$this->error = $error;
	}

	public function getSize()
	{
		return $this->size;
	}

	public function setSize($size)
	{
		$this->size = $size;
	}

	public function getRandomName()
	{
		return $this->randomName;
	}

	public function setRandomName($randomName)
	{
		$this->randomName = $randomName;
	}
}

?>