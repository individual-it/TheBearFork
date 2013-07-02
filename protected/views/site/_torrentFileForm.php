	
<div id="downloadBox">
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
	
	$form=$this->beginWidget('CActiveForm', array(
		'id'=>'torrent-item-form',
		'method'=>'POST',
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
		'action'=>CController::createUrl('item/addTorrent'),
	)); ?>

		<div id="row">
			<?php echo $form->labelEx($model,'torrentFile'); ?>
			<?php echo $form->FileField($model,'torrentFile'); ?>
			<?php echo $form->error($model,'torrentFile'); ?>
		</div>

		<div id="buttons">
			<?php echo CHtml::imageButton('images/add.png',array('title'=>'Add new download')); ?>
		</div>

	<?php $this->endWidget(); ?>
</div>	
	

