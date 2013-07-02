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

	class Aria2ItemSettingForm extends CFormModel {
		
		
		public $bt_max_peers;
		public $max_download_limit;
		public $max_upload_limit;
		public $bt_request_peer_speed_limit;
		
		private $_gid ;		
		private $_aria ;
		
		public function __construct($gid) {
			$this->_aria = new aria2() ;
			$this->_gid = $gid ;
			$attr=$this->_aria->getOption($this->gid) ;
			foreach($this as $property => $val) 
				if (isset($attr[$this->getSwitch($property,false)]))
					$this->$property=$attr[$this->getSwitch($property,false)] ;
		}
		
		public function rules() {
			return array(
				array(
					'bt_max_peers',
					'numerical',
					'min'=>0
				),
				array(
					'bt_request_peer_speed_limit,max_download_limit,max_upload_limit',
					'match',
					'pattern'=>'/^[0-9]+[(M)|(K)]{0,1}$/',
					'allowEmpty'=>true,
					'message'=>'Value should be in : 1024 or 10K or 100M format'
				)
			) ;
		}
		
		public function getSwitch($property,$prefix=true) {
			$return = str_replace('_','-',$property) ;
			if ($prefix) 
				$return = '--'.$return ;
			return $return ;
		}
		
		public function save() {
			if(!$this->validate()) 
				return false ;
			
			$options = array() ;
			foreach($this as $property => $val)
				$options[$this->getSwitch($property,false)]=$val;
			
			$result=$this->_aria->changeOption(strval($this->_gid),$options);
			Yii::log(print_r($result,true),'info',__METHOD__);
			if ($this->_aria->hasError()) {
				$this->addError(null, "aria2: ".$this->_aria->getError()) ;
				return false ;
			}
			
			return true ;
		}
		
		public function getGid() {
			return $this->_gid;
		}
		
		public function attributeLabels(){
		
			return array(
				'bt_request_peer_speed_limit'=>'If the whole download speed of every torrent is lower than SPEED, aria2 temporarily increases the number of peers to try for more download speed',
				'bt_max_peers'=>'Specify the maximum number of peers per torrent. 0 means unlimited',
				'max_download_limit'=>'Set max download speed per each download in bytes/sec. 0 means unrestricted. You can append K or M(1K = 1024, 1M = 1024K)',
				'max_upload_limit'=>"Set max upload speed per each torrent in bytes/sec. 0 means unrestricted. You can append K or M(1K = 1024, 1M = 1024K)",
			);
			
		}
		
	}	
	
?>
