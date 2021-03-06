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
    
    $this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'item-peers-grid',
						'dataProvider'=>new ItemPeersDataProvider($gid) ,
						'enableSorting'=>false,
						'enablePagination'=>false,
						'selectableRows'=>false,
						'emptyText'=>'No Peers Connected',
						'columns'=>array(
							'amChoking',
							array(
								'name'=>'Download Speed',
								'type'=>'raw',
								'value'=>'Util::byteToHR($data["downloadSpeed"])',
							),
							array(
								'name'=>'Upload Speed',
								'type'=>'raw',
								'value'=>'Util::byteToHR($data["uploadSpeed"])',
							),
							'ip',
							'peerChoking',
							array(
								'name'=>'peerId',
								'type'=>'html',
								'value'=>'urldecode($data["peerId"])'
							),
							'port',
							'seeder',
						)
					)
			);
			
?>
