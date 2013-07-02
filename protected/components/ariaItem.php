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

class ariaItem {
	
	private $_properties = null ;
		
	public function __construct($array) {
		$this->_properties = $array ;
	}
	
	// to handle as virtual properties
	public function __get($name) {
		if($name==='primaryKey')
			return $this->_properties['gid'] ;
		else if ($name==='fileName')
			return $this->_getFilePath() ;
		else if ($name==='progress')
			return $this->_getProgress() ;
		else 
			return $this->_properties[$name] ;
	}
	
	public function __isset($property) {
		return isset($this->_properties[$property]) ;
	}
	
	private function _getProgress() {

		if ($this->totalLength>0)
			return sprintf('%.2f',($this->completedLength * 100) /  $this->totalLength);
		else
			return 0 ;
		
	}
	
	public function isPaused() {
		return ($this->status=='paused') ;
	}
	
	public function isActive() {
		return ($this->status=='active') ;
	}
	
	public function isTorrent() {
		return isset($this->bittorrent) ;
	}
	
	private function _getUri() {
		$files = $this->_properties['files'];
		$uris = array() ;
		foreach($files as $key => $file) 
			foreach($file['uris'] as $key2 => $uri) 
				$uris[] = $uri['uri'];
		
		return $uris ;
	}
		
	private function _getFilePath() {

		if ($this->isTorrent())
			return $this->bittorrent['info']['name'];
			//return 'X';

		$result = $this->_properties['files'];
		$paths = array() ;
		
		foreach($result as $key => $val)
			$paths[] = strrchr($val['path'],"/");
		
		return $paths[0] ;
	}	
}

?>
