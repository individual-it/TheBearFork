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

	$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'formatter'=>new BFormatter(),
			'attributes'=>array(
				'status',
				'infoHash',
				'connections',
				array(
					'label'=>'Piece length',
					'type'=>'raw',
					'value'=>$model->pieceLength,
				),
				array(
					'label'=>'Announce URI',
					'type'=>'array',
					'value'=>$model->bittorrent['announceList'],
				),
				array(
					'label'=>'Name',
					'type'=>'raw',
					'value'=>$model->bittorrent['info']['name'],
				),
				array(
					'label'=>'Piece length',
					'type'=>'raw',
					'value'=>Util::byteToHR($model->pieceLength),
				),
				array(
					'label'=>'Number of Seeders',
					'type'=>'raw',
					'value'=>$model->numSeeders,
				),
				array(
					'label'=>'Number of Pieces',
					'type'=>'raw',
					'value'=>$model->numPieces,
				),
				array(
					'label'=>'Download Directory',
					'type'=>'raw',
					'value'=>$model->dir
				),
			)
    	) 
    );
?>
