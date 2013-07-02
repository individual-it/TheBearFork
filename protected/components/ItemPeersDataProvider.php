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

	class ItemPeersDataProvider extends CArrayDataProvider {
		
		private $_items = array() ;
		private $_aria ;
		private $_gid;
		
		function __construct($gid) {
			$this->_aria = new aria2() ;
			$this->_gid = $gid;
			parent::__construct($this->getRpcData(), array('id'=>'gid'));
		}
		
		protected function fetchKeys() {
			return array_keys($this->getRpcData());
		}
		
		public function getItemCount($refresh=false) {
			return count($this->_items);
		}
		
		public function getTotalItemCount($refresh=false) {
			return count($this->_items);
		}
		
		protected function calculateTotalItemCount() {
			return count($this->_items);
		}
		
		private function getRpcData() {
			if (!sizeof($this->_items)) 
				$this->_items = $this->_aria->getPeers($this->_gid) ;
			//print'<pre>'.print_r($this->_items);	
			return $this->_items ;			
		}	
			
	}
	

?>
