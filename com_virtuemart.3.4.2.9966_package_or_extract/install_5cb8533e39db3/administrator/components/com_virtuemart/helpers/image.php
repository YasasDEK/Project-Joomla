<?php
/**
 * Image helper class
 *
 * This class was derived from the show_image_in_imgtag.php and imageTools.class.php files in VM.  It provides some
 * image functions that are used throughout the VirtueMart shop.
 *
 * @package	VirtueMart
 * @subpackage Helpers
 * @author Max Milbers
 * @copyright Copyright (c) 2004-2008 Soeren Eberhardt-Biermann, 2009 2018 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL 2, see COPYRIGHT.php
 */

defined('_JEXEC') or die();

class VmImage extends VmMediaHandler {


	function processAction($data){

		if(empty($data['media_action'])) return $data;
		$data = parent::processAction($data);

		if(empty($this->file_title) && !empty($file_name)) $this->file_title = $file_name;

		return $data;
	}

	function displayMediaFull($imageArgs='',$lightbox=true,$effect ="class='modal'",$description = true ){

		if(!$this->file_is_forSale){
			// Remote image URL
			if( substr( $this->file_url, 0, 4) == "http" ) {
				$file_url = $this->file_url;
				$file_alt = $this->file_title;
			} else {
				//$rel_path = str_replace('/',DS,$this->file_url_folder);
				$fullSizeFilenamePath = vRequest::filterPath(VMPATH_ROOT.'/'.$this->file_url_folder.$this->file_name.'.'.$this->file_extension);
				if (!file_exists($fullSizeFilenamePath)) {
					$file_url = $this->theme_url.'assets/images/vmgeneral/'.VmConfig::get('no_image_found');
					$file_alt = vmText::_('COM_VIRTUEMART_NO_IMAGE_FOUND').' '.$this->file_description;
				} else {
					$file_url = $this->file_url;
					$file_alt = $this->file_meta;
				}
			}
			$postText = false;
			if($description) $postText = $this->file_description;

			if(!empty($this->file_class)){
				$imageArgs = $this->filterImageArgs($imageArgs);
			}

			return $this->displayIt($file_url, $file_alt, $imageArgs,$lightbox,$effect,$postText);
		} else {
			//Media which should be sold, show them only as thumb (works as preview)
			return $this->displayMediaThumb(array('id'=>'vm_display_image'),false);
		}


	}


	public function createThumbFileUrl($width=0,$height=0){

		$file_name = $this->createThumbName($width,$height);
		if(empty($this->file_name_thumb)) {
			vmdebug('createThumbFileUrl empty file_name_thumb ',$this);
			return false;
		}
		$file_url_thumb = $this->file_url_folder_thumb.$this->file_name_thumb.'.'.$this->file_extension;


		return $file_url_thumb;
	}

	/**
	 * a small function that ensures that we always build the thumbnail name with the same method
	 */
	public function createThumbName($width=0,$height=0){

		if(empty($this->file_name)) return false;

		$dim = self::determineWH($width, $height);

		$this->file_name_thumb = $this->file_name.'_'.$dim['width'].'x'.$dim['height'];
		return $this->file_name_thumb;
	}

	public function determineWH($width,$height){

		$dim = array();
		$dim['width'] = $width;
		$dim['height'] = $height;
		if(!$width and !$height){
			$dim['width'] = VmConfig::get('img_width',90);
			$dim['height'] = VmConfig::get('img_height',90);
		}
		$dim['width'] = (int)$dim['width'];
		$dim['height'] = (int)$dim['height'];;

		return $dim;
	}

	/**
	 * This function actually creates the thumb
	 * and when it is instanciated with one of the getImage function automatically updates the db
	 *
	 * @author Max Milbers
	 * @param boolean $save Execute update function
	 * @return name of the thumbnail
	 */
	public function createThumb($width=0,$height=0) {

		if(empty($this->file_url_folder)){
			vmError('Couldnt create thumb, no directory given. Activate vmdebug to understand which database entry is creating this error');
			vmdebug('createThumb, no directory given',$this);
			return FALSE;
		}

		if(empty($this->file_name)){
			vmError('Couldnt create thumb, no name given. Activate vmdebug to understand which database entry is creating this error');
			vmdebug('createThumb, no name given',$this);
			return false;
		}

		$synchronise = vRequest::getString('synchronise',false);

		if(!VmConfig::get('img_resize_enable') || $synchronise) return;

		//now lets create the thumbnail, saving is done in this function
		$dim = self::determineWH($width, $height);
		$width = $dim['width'];
		$height = $dim['height'];

		// Don't allow sizes beyond 2000 pixels //I dont think that this is good, should be config
//		$width = min($width, 2000);
//		$height = min($height, 2000);

		$maxsize = false;
		$bgred = 255;
		$bggreen = 255;
		$bgblue = 255;

		$root = '';
		$this->file_name_thumb = $this->createThumbName($width,$height);

		if($this->file_is_forSale==0){

			$fullSizeFilenamePath = VMPATH_ROOT.'/'.$this->file_url_folder.$this->file_name.'.'.$this->file_extension;
		} else {
			$fullSizeFilenamePath = $this->file_url_folder.$this->file_name.'.'.$this->file_extension;
		}
		$fullSizeFilenamePath = vRequest::filterPath($fullSizeFilenamePath);

		$resizedFilenamePath = vRequest::filterPath(VMPATH_ROOT.'/'.$this->file_url_folder_thumb.$this->file_name_thumb.'.'.$this->file_extension);

		$this->checkPathCreateFolders(vRequest::filterPath($this->file_url_folder_thumb));

		if (file_exists($fullSizeFilenamePath)) {
			if(!file_exists($resizedFilenamePath)) {
				$createdImage = new Img2Thumb( $fullSizeFilenamePath, (int)$width, (int)$height, $resizedFilenamePath, $maxsize, $bgred, $bggreen, $bgblue );
				if(!$createdImage){
						return 0;
				}
			}
			return $this->file_url_folder_thumb.$this->file_name_thumb.'.'.$this->file_extension;
		} else {
			vmError('Couldnt create thumb, file not found '.$fullSizeFilenamePath);
			return 0;
		}

	}

	public function checkPathCreateFolders($path){

		$elements = explode(DS,$path);
		$examine = VMPATH_ROOT;

		foreach($elements as $piece){
			$examine = $examine.DS.$piece;
			if(!JFolder::exists($examine)){
				JFolder::create($examine);
				vmInfo('create folder for resized image '.$examine);
			}
		}
	}

	/**
	 * Display an image icon for the given image and create a link to the given link.
	 *
	 * @param string $link Link to use in the href tag
	 * @param string $image Name of the image file to display
	 * @param string $text Text to use for the image alt text and to display under the image.
	 */
	static public function displayImageButton($link, $imageclass, $text, $mainclass = 'vmicon48', $extra="") {
		$button = '<a title="' . $text . '" href="' . $link . '" '.$extra.'>';
		$button .= '<span class="'.$mainclass.' '.$imageclass.'"></span>';
		$button .= '<br />' . $text.'</a>';
		echo $button;

	}

}