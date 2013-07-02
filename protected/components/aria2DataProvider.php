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


	class aria2DataProvider extends CArrayDataProvider {
		
		private $_items = array() ;
		private $_aria ;
		
		function __construct($config=null) {
			$this->_aria = new aria2() ;
			
			if(is_null($config))
				$config = array(
							'sort'=>array(
								'attributes'=>array(
									 'gid',
										),
									),
							'pagination'=>array(
								'pageSize'=>Yii::app()->Setting->downloadPerPage
							),
						) ;
			parent::__construct($this->getRpcData(), $config);
		}
		
		protected function fetchKeys() {
			return array_keys($this->getRpcData());
		}
		
		private function getRpcData() {
			if (!sizeof($this->_items))
				$this->_items = $this->_aria->getItemList() ;
			
			return $this->_items ;			
		}	
			
	}
	

?>
