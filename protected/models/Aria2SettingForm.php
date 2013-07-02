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
	
	class Aria2SettingForm extends CFormModel {
		
		//public $allow_overwrite ;
		//public $always_resume ;
		//public $conf_path ;
		//public $auto_file_renaming;
		//public $dir;
		//public $file_allocation;
		
		// FTP
		//public $ftp_pasv;
		//public $ftp_reuse_connection;
		//public $ftp_type;
		
		public $max_concurrent_downloads;
		//public $max_connection_per_server;
		//public $max_download_limit;
		public $max_overall_download_limit;
		public $max_overall_upload_limit;
		
		private $_aria ;
		
		public function __construct() {
			$this->_aria = new aria2() ;
			$attr=$this->_aria->getGlobalOptions() ;
			foreach($this as $property => $val) 
				if (isset($attr[$this->getSwitch($property,false)]))
					$this->$property=$attr[$this->getSwitch($property,false)] ;
				else
					$this->$property=null;
		}
		
		public function rules() {
			return array(
				array(
					'max_concurrent_downloads,
					 max_overall_download_limit,
					 max_overall_upload_limit',
					'numerical',
					'min'=>0 
						/*
						 * Artur Neumann INF www.inf.org
						* if 0 means unrestricted, we need to be able to put in 0, so min is 0 not 1
						*/
				),
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
			
			$reuslt=$this->_aria->changeGlobalOption($options);

			if ($this->_aria->hasError()) {
				$this->addError(null, $this->_aria->getError()) ;
				return false ;
			} else
				return true ;
			
			return false ;
		}
		
		public function attributeLabels(){
		
			return array(
				'allow_overwrite'=>"Restart download from scratch if the corresponding control file doesn’t exist",
				'always_resume'=>"If true is given, aria2 always tries to resume download and if resume is not possible, aborts download",
				'conf_path'=>'The configuration file path',
				'auto_file_renaming'=>' Rename file name if the same file already exists. This option works only in HTTP(S)/FTP download',
				'dir'=>'The directory to store the downloaded file',
				'file_allocation'=>"Specify file allocation method",
				'ftp_pasv'=>"Use the passive mode in FTP",
				'ftp_reuse_connection'=>'Reuse connection in FTP',
				'ftp_type'=>'Set FTP transfer type',
				'max_concurrent_downloads'=>'Set maximum number of parallel downloads for every static (HTTP/FTP) URI, torrent and metalink',
				'max_connection_per_server'=>'The maximum number of connections to one server for each download',
				'max_download_limit'=>'Set max download speed per each download in bytes/sec. 0 means unrestricted. You can append K or M(1K = 1024, 1M = 1024K)',
				'max_overall_download_limit'=>"Set max overall download speed in bytes/sec. 0 means unrestricted. You can append K or M(1K = 1024, 1M = 1024K)",
				'max_overall_upload_limit'=>"Set max overall upload speed in bytes/sec. 0 means unrestricted. You can append K or M(1K = 1024, 1M = 1024K)",
			);
			
		}
		
	}	
	
?>
