<?php /*
The Virtual Career Network (VCN) is an "open source, open content" workforce services and online learning delivery platform built and operated by the American Association of Community Colleges (AACC) under a grant from the Employment and Training Administration (ETA) of the United States Department of Labor (DOL).

Copyright (C) 2012 American Association of Community Colleges

This file is part of the source code for the Virtual Career Network.

The Virtual Career Network is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

The Virtual Career Network is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program.  If not, see http://www.gnu.org/licenses/.
*/ ?>

<?php
/**
* vcnFacebookMetatag()
* This class is used to hold and control the Facebook metatag information
*/
class vcnFacebookMetatag {
		
	public $title = '';
	public $url = '';
	public $imgUrl = '';
	public $description = '';
	public $type = 'website';
	public $descriptionMaxLength = 200;
	
	public function  __construct($_title, $_url, $_description='', $_imgUrl='') {
		$this->title = $_title;
		$this->url = $_url;
		$this->description = $_description;
		$this->imgUrl = $_imgUrl;
	}
	
	/**
	* getTags()
	* Gets all the Facebook metatags and returns them as a string of HTML
	*/
	public function getTags() {
	
		$_html = '<!-- Facebook metatags BEGIN -->' . PHP_EOL;
	
		if (strlen($this->description) > $this->descriptionMaxLength) {
			$_desc = $this->description;
			$_desc = wordwrap($_desc, $this->descriptionMaxLength);
			$_desc = substr($_desc, 0, strpos($_desc, "\n"));			
			$_desc = strip_tags($_desc);		
			$_desc = str_replace('"', '', $_desc);		
			$_desc = $_desc . ' ...';
		}
	
		if (!strlen($this->imgUrl)) {
			$this->imgUrl = "http://" . $_SERVER['SERVER_NAME'] . base_path() . "sites/default/files/images/vcn_logo_without_text.png";
		}
	
		$_html .= '<meta property="og:title" content="' . $this->title . '"/>' . PHP_EOL .
					  '<meta property="og:type" content="' . $this->type . '"/>' . PHP_EOL .
					  '<meta property="og:url" content="' . $this->url . '"/>' . PHP_EOL .
					  '<meta property="og:image" content="' . $this->imgUrl . '"/>' . PHP_EOL .
					  '<meta property="og:site_name" content="Virtual Career Network (Healthcare)"/>' . PHP_EOL .
					  '<meta property="fb:admins" content="' . $GLOBALS['hvcp_config_facebook_user_id'] . '"/>' . PHP_EOL .
					  '<meta property="og:description" content="' . $_desc . '"/>' . PHP_EOL;
	
		$_html .= '<!-- Facebook metatags END -->' . PHP_EOL;
	
		return $_html;
	}
	
}

/**
* vcnFacebookLike()
* This class is used to hold and control the Facebook like button
*/
class vcnFacebookLike {
	
	public $url = '';
	public $shiftTop = '15';
	public $shiftLeft = '5';
	public $width = '90';
	public $height = '21';
	
	public function  __construct($_url) {
		$this->url = urlencode($_url);
	}
	
	/**
	* getButton()
	* Generates the Facebook like button iframe code
	*/
	function getButton() {
	
		$_html = '<!-- Facebook IFRAME for Like button -->' . PHP_EOL .
			         '<iframe ' .
					 'src="//www.facebook.com/plugins/like.php?' .
					 'href=' . $this->url .
					 '&amp;send=false' .
					 '&amp;layout=button_count' .
					 '&amp;width=' . $this->width .
					 '&amp;show_faces=false' .
					 '&amp;action=like' .
					 '&amp;colorscheme=light' .
					 '&amp;font' .
					 '&amp;height=' . $this->height . '" ' .
					 'scrolling="no" ' .
					 'frameborder="0" ' .
					 'style="border:none; ' .
					 'overflow:hidden; ' .
					 'width:' . $this->width . 'px; ' .
					 'height:' . $this->height . 'px; ' .
					 'position:relative; ' .
					 'top:' . $this->shiftTop . 'px; ' .
					 'right:' . $this->shiftLeft . 'px;" ' .
					 'allowTransparency="true"' .
					 '></iframe>' . PHP_EOL;
	
		return $_html;
	}
}
