<div class="form">
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
	'id'=>'aria2-item-setting-form',
	'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
)); 
?>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo CHtml::label($model->getSwitch('bt_max_peers'), false,array('id'=>'switch')); ?>
		<?php echo $form->labelEx($model,'bt_max_peers'); ?>
		<div id="input">
		<?php echo $form->textField($model,'bt_max_peers',array('size'=>7,'maxlength'=>7)); ?>
		</div>
		<?php echo $form->error($model,'bt_max_peers'); ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::label($model->getSwitch('bt_request_peer_speed_limit'), false,array('id'=>'switch')); ?>
		<?php echo $form->labelEx($model,'bt_request_peer_speed_limit'); ?>
		<div id="input">
		<?php echo $form->textField($model,'bt_request_peer_speed_limit',array('size'=>7,'maxlength'=>7)); ?>
		</div>
		<?php echo $form->error($model,'bt_request_peer_speed_limit'); ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::label($model->getSwitch('max_download_limit'), false,array('id'=>'switch')); ?>
		<?php echo $form->labelEx($model,'max_download_limit'); ?>
		<div id="input">
		<?php echo $form->textField($model,'max_download_limit',array('size'=>7,'maxlength'=>7)); ?>
		</div>
		<?php echo $form->error($model,'max_download_limit'); ?>
	</div>
	
	<div class="row">
		<?php echo CHtml::label($model->getSwitch('max_upload_limit'), false,array('id'=>'switch')); ?>
		<?php echo $form->labelEx($model,'max_upload_limit'); ?>
		<div id="input">
		<?php echo $form->textField($model,'max_upload_limit',array('size'=>7,'maxlength'=>7)); ?>
		</div>
		<?php echo $form->error($model,'max_upload_limit'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::button('Save',array(
											'onclick'=>CHtml::ajax(array(
																	"url"=>CController::createUrl("/setting/itemSettingUpdate",
																		array('gid'=>$model->gid)
																	),
																	"type"=>"post",
																	"data"=>'js:$("#aria2-item-setting-form").serialize()',
																	"dataType"=>"json",
																	"success"=>'js:function(data){if(!data.validate){$("#myDialog").html(data.div)} else {$("#myDialog").dialog("close")} ;return false;}',
																	)
																).';return false;',
										)
								); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
