<?php

/**
 * Gallery view.
 * Prepare gallery view properties for display using gallery templates.
 * 
 * @author anza
 * @since 2010-05-15
 */
class GalleryView extends View
{
	/* (non-PHPdoc)
	 * @see app/display/views/View#index()
	 */
	public function index()
	{
		parent::index();
	
		if ($this->request->hasKey('album') && !$this->request->hasKey('photo'))
		{
			$this->view->showcase = $this->helper->getPhotosForShowcase($this->request->container['album']);
			$this->view->left = 'Znajdujesz sie w albumie: ' . $this->helper->getSingleAlbumName($this->request->container['album']);
			$this->view->show('profile_photos');
		}
		else if ($this->request->hasKey('photo'))
		{
			$this->view->showcase = $this->helper->getSinglePhoto($this->request->container['photo']);
			$this->view->left = 'Znajdujesz sie w albumie: ' . $this->helper->getSingleAlbumName($this->request->container['album']);
			$this->view->right = $this->helper->getPrevious($this->request->container['album'], $this->request->container['photo']) . 
								 $this->helper->getNext($this->request->container['album'], $this->request->container['photo']);
			$this->view->show('profile_photo');
		}
		else
		{
			$this->view->showcase = $this->helper->getAlbumForShowcase();
			$this->view->show('profile_albums');
		}
	}

	/**
	 * Handles display and messages for new Photo.
	 *
	 * @return void
	 * @author anza
	 */
	public function addPhoto()
	{
		// check if any key in request is of error type
		if ($this->request->hasKey(ErrorEnum::ERROR))
		{
			// setting general error message and view style for a template
			$this->view->add_new_photo_message_class = ErrorEnum::ERROR;
			$this->view->add_new_photo_message = MessageBundle::getMessage('form.validation.field.addphoto.noimage.exists');
			
			if ($this->request->hasKey(ErrorEnum::FILENOIMAGE))
			{
				$this->view->add_new_photo_message = MessageBundle::getMessage('form.validation.field.addphoto.filenoimage');
			}
		}
		$this->view->add_to_existing_album = $this->helper->getExistingAlbumsToForm();
		$this->view->show('profile_gallery_add');
	}
}

?>