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

	class CAutoLoadGridView extends CAutoLoad {
		
		public $jsUpdate ;
		
		public function __construct() {
			$this->jsUpdate = '$.fn.yiiGridView.update("download-grid")' ;
		}		
				
		public function init() {
			parent::init() ;
		}
		
		public function run() {
			parent::run();
			$this->render('_CAutoLoadGridView');
		}
		
		public function getModule(){
			return null ;
		}
		
	}	
	
?>
