<?php

/**
 * Taking care of gallery processing.
 * 
 * @author anza
 * @since 2010-05-15
 */
class GalleryController extends Controller
{
	private $allowedActions = array('addphoto');
	
	// controller's main method
	public function execute()
	{
		// creates Profile User for viewing
		// TODO: it's recommended to make it more generic handled by other controllers?
		$this->createProfileUser();
		
		// checking whether user profile contains 3 actions in URL
		if ($this->isActionInteger(0) && sizeof($this->actions) < 4)
		{
			// all actions must be of integer type
			foreach ($this->actions as $number => $action)
			{
				if (!$this->isActionInteger($number))
				{
					die ('404 Not Found');
					return false;
				}
			}
		}
		else
		{
			// does the logged in user can execute provided action?
			$this->validateActions($this->allowedActions, 0);
		}
		
		$this->dispatch($this->currentAction);
		
		new GalleryView($this->registry, $this->currentAction, $this->model);
	}
	
	/* (non-PHPdoc)
	 * @see app/controllers/Controller#index()
	 */
	public function index()
	{
		$albumNo = $this->convertToInt(isset($this->actions[1]) ? $this->actions[1] : '');
		$photoNo = $this->convertToInt(isset($this->actions[2]) ? $this->actions[2] : '');
		
		if ($photoNo == 0)
		{
			if ($albumNo != 0)
			{
				$this->actions[1] = $albumNo;
				$this->request->container['album'] = $albumNo;
			}
		}
		else
		{
			$this->actions[2] = $photoNo;
			$this->request->container['photo'] = $photoNo;
			$this->request->container['album'] = $albumNo;
		}
	}
	
	/**
	 * Controlls adding a new Photo to Album.
	 *
	 * @return unknown_type
	 * @author anza
	 */
	public function addPhoto()
	{
		// object processing photo file
		$photo = new PhotoHandler();
		
		// checking whether adding new photo form has bee sent
		if ($this->request->hasKey(NewPhotoEnum::FORM_SENT))
		{
			// error message is prepared to be sent by default
			$this->request->container[ErrorEnum::ERROR] = ErrorEnum::ERROR;
			
			// process will continue if the file is not empty 
			if ($photo->getSize() > 0)
			{
				try
				{
					// enum containing request fields with values is created
					$request = new NewPhotoEnum($this->request->container);
					
					// file is stored on the server
					$photo->addPhoto();
					
					// Image is persisted in database 
					$this->model->addPhoto($photo, $request);
					
					// error message is removed once all is ok
					unset($this->request->container[ErrorEnum::ERROR]);
				}
				catch (FileNoImageException $e)
				{
					$this->request->container[ErrorEnum::FILENOIMAGE] = '';
				}
				catch (Exception $e)
				{
					$this->request->container[ErrorEnum::ERROR] = '';
				}
				
				// return to main page of gallery
				$this->redirectTo('gallery/');
			}
		}
	}
}

?>