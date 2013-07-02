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

	class BJsLinkColumn extends CGridColumn {
		protected function renderDataCellContent($row, $data) {
			$url = CController::createUrl("/item/itemDetail",array("gid"=>$data->gid)) ;
			if ($data->isTorrent())
				print CHtml::link($data->fileName,'#',array('onClick'=>"getView('$url');return false")) ;
			else
				print $data->fileName ;
		}
		
		protected function renderHeaderCellContent() {
			print 'Download';
		}
	}
?>
