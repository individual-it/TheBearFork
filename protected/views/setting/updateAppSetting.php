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
		'id'=>'app-setting-form',
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>true,
));


?>

<?php echo $form->errorSummary($model); ?>
<h3>The Bear</h3>

<div class="row">
	<?php echo $form->labelEx($model,'statUpdateInterval'); ?>
	<div id="input">
		<?php echo $form->textField($model,'statUpdateInterval',array('size'=>4,'maxlength'=>4)); ?>
	</div>
	<?php echo $form->error($model,'statUpdateInterval'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'downloadPerPage'); ?>
	<div id="input">
		<?php echo $form->textField($model,'downloadPerPage',array('size'=>4,'maxlength'=>4)); ?>
	</div>
	<?php echo $form->error($model,'downloadPerPage'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'ariaHost'); ?>
	<div id="input">
		<?php echo $form->textField($model,'ariaHost',array('size'=>40)); ?>
	</div>
	<?php echo $form->error($model,'ariaHost'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'ariaPort'); ?>
	<div id="input">
		<?php echo $form->textField($model,'ariaPort',array('size'=>5,'maxlength'=>5)); ?>
	</div>
	<?php echo $form->error($model,'ariaPort'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'ariaRpcUser'); ?>
	<div id="input">
		<?php echo $form->textField($model,'ariaRpcUser',array('size'=>40)); ?>
	</div>
	<?php echo $form->error($model,'ariaRpcUser'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'ariaRpcPasswd'); ?>
	<div id="input">
		<?php echo $form->textField($model,'ariaRpcPasswd',array('size'=>40)); ?>
	</div>
	<?php echo $form->error($model,'ariaRpcPasswd'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'adminUser'); ?>
	<div id="input">
		<?php echo $form->textField($model,'adminUser',array('size'=>10)); ?>
	</div>
	<?php echo $form->error($model,'adminUser'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'adminPass'); ?>
	<div id="input">
		<?php echo $form->textField($model,'adminPass',array('size'=>10)); ?>
	</div>
	<?php echo $form->error($model,'adminPass'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'publicAddFile'); ?>
	<div id="input">
		<?php echo $form->radioButtonList($model,'publicAddFile',array(true=>'Yes',false=>'No'), 
				array('separator'=>' ][ ','labelOptions'=>array('style'=>'display:inline'))); ?>
	</div>
	<?php echo $form->error($model,'publicAddFile'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'publicChangeSetting'); ?>
	<div id="input">
		<?php echo $form->radioButtonList($model,'publicChangeSetting',array(true=>'Yes',false=>'No'), 
				array('separator'=>' ][ ','labelOptions'=>array('style'=>'display:inline'))); ?>
	</div>
	<?php echo $form->error($model,'publicChangeSetting'); ?>
</div>

<?php 
/*
 * Artur Neumann INF www.inf.org
* add some more settings
*/
?>
<div class="row">
	<?php echo $form->labelEx($model,'publicUnPauseDownload'); ?>
	<div id="input">
		<?php echo $form->radioButtonList($model,'publicUnPauseDownload',array(true=>'Yes',false=>'No'), 
				array('separator'=>' ][ ','labelOptions'=>array('style'=>'display:inline'))); ?>
	</div>
	<?php echo $form->error($model,'publicUnPauseDownload'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'autoPauseSizeDownloads'); ?>
	<div id="input">
		<?php echo $form->textField($model,'autoPauseSizeDownloads',array('size'=>10)); ?>
	</div>
	<?php echo $form->error($model,'autoPauseSizeDownloads'); ?>
</div>


<div class="row buttons">
	<?php echo CHtml::submitButton('Save'); ?>
</div>

<?php $this->endWidget(); ?>
