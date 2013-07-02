<?php 

/*  The Bear - a giant downlaoder

Copyright (C) 2011 Behdad Kh.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

http://sourceforge.net/projects/thebear/

*/

class UriItemForm extends CFormModel {

	public $url;

	public function init()
	{
			
		/*
		 * Artur Neumann INF www.inf.org
		 * set the URL to the value passed trough $_GET['url']
		*/
		$this->url = Yii::app()->input->xssClean(Yii::app()->request->getParam("url"));
	}

	public function rules() {
		return array(
				array('url', 'required'),
				array('url', 'url'),
		) ;
	}

	public function attributeLabels() {
		return array(
				'url'=>'Download Url',
		);
	}

	public function isTorrent() {
		return strstr($this->url, ".torrent") ;
	}

}

?>
