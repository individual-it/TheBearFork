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
	'id'=>'aria2-setting-form',
	'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
)); 
?>

	<?php echo $form->errorSummary($model); ?>
	<h3>aria2</h3>
	
	<div class="row">
		<?php echo CHtml::label($model->getSwitch('max_concurrent_downloads'), false,array('id'=>'switch')); ?>
		<?php echo $form->labelEx($model,'max_concurrent_downloads'); ?>
		<div id="input">
		<?php echo $form->textField($model,'max_concurrent_downloads',array('size'=>4,'maxlength'=>4)); ?>
		</div>
		<?php echo $form->error($model,'max_concurrent_downloads'); ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::label($model->getSwitch('max_overall_download_limit'), false,array('id'=>'switch')); ?>
		<?php echo $form->labelEx($model,'max_overall_download_limit'); ?>
		<div id="input">
		<?php echo $form->textField($model,'max_overall_download_limit',array('size'=>4,'maxlength'=>4)); ?>
		</div>
		<?php echo $form->error($model,'max_overall_download_limit'); ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::label($model->getSwitch('max_overall_upload_limit'), false,array('id'=>'switch')); ?>
		<?php echo $form->labelEx($model,'max_overall_upload_limit'); ?>
		<div id="input">
		<?php echo $form->textField($model,'max_overall_upload_limit',array('size'=>4,'maxlength'=>4)); ?>
		</div>
		<?php echo $form->error($model,'max_overall_upload_limit'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Save'); ?>
	</div>

<?php $this->endWidget(); ?>

