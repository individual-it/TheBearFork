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

	class MetaLinkFileForm extends CFormModel {
		
		public $metaLinkFile ;
		
		public function rules() {
			return array(
				array('metaLinkFile', 'required'),
				array('metaLinkFile', 'file', 'types'=>'metalink,meta4', 'wrongType'=>'Wrong file type!'),
			) ;
		}
		
		public function attributeLabels() {
			return array(
				'metaLinkFile'=>'MetaLink File',
			);
		}
		
	}	
	
?>
