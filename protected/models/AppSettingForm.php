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

class AppSettingForm extends CFormModel {

	public $statUpdateInterval ;
	public $ariaHost ;
	public $ariaPort ;
	public $ariaRpcUser ;
	public $ariaRpcPasswd ;
	public $publicAddFile ;
	public $publicChangeSetting ;
	public $adminUser ;
	public $adminPass ;
	public $downloadPerPage;

	/*
	 * Artur Neumann INF www.inf.org
	* add some more settings and configured them beneeth
	*/
	public $publicUnPauseDownload;
	public $autoPauseSizeDownloads;

	private $_serializeTo = null;

	public function __construct() {
		$this->_serializeTo = 'protected'.DIRECTORY_SEPARATOR.'serialize'.DIRECTORY_SEPARATOR.'appSettingFormSerialize' ;

		if (!is_readable($this->_serializeTo)) throw new Exception('Unable to read '.$this->_serializeTo.', make sure it\'s readable!') ;

		$props = unserialize(file_get_contents($this->_serializeTo));
		foreach($this as $property => $value)
			$this->$property = (isset($props[$property])) ? $props[$property] : null;


	}

	public function rules() {
		return array(
				array(
						'statUpdateInterval,ariaHost,ariaPort, adminUser, adminPass, downloadPerPage',
						'required',
						'skipOnError'=>true,
				),
				array(
						'adminUser,adminPass',
						'length',
						'min'=>3,
				),
				array(
						'statUpdateInterval,downloadPerPage',
						'numerical',
						'min'=>0,
						'skipOnError'=>true,
				),
				array(
						'autoPauseSizeDownloads',
						'numerical',
						'min'=>0,
						'skipOnError'=>true,
				),				
				array(
						'publicAddFile,publicChangeSetting,publicUnPauseDownload',
						'boolean',
						'trueValue'=>true,
						'falseValue'=>false
				),array(
						'ariaRpcUser,ariaRpcPasswd',
						'default',
						'value'=>null,
				)
		) ;
	}

	public function attributeLabels(){
		return array(
				'statUpdateInterval'=>"Update interface in seconds",
				'ariaHost'=>'aria2 Host Address',
				'ariaPort'=>'aria2 Port Number',
				'ariaRpcUser'=>'aria2 RPC Username',
				'ariaRpcPasswd'=>'aria2 RPC Password',
				'publicAddFile'=>'Public users can add downloads',
				'publicChangeSetting'=>'Public users can modify settings',
				'downloadPerPage'=>'Number of downloads in each page',
				'publicUnPauseDownload' => 'Public users can Un-Pause downloads',
				'autoPauseSizeDownloads' => 'Pause all downloads that are bigger than this size (in bytes)'
		);
	}

	public function save() {
		$settings = Yii::app()->Setting;


			if(!$this->validate())
				return false ;

			if (is_writeable($this->_serializeTo) && ($handle = fopen($this->_serializeTo, 'wb')) && fwrite($handle, serialize($this)))
				return true ;
			else
				$this->addError(null,'Unable to write settings to .'.$this->_serializeTo.', make sure it\'s writable!');

			return false ;
		}

}
?>
