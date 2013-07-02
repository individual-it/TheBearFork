	
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
	
	Yii::app()->clientScript->registerCssFile(
					Yii::app()->request->baseUrl.'/css/downloadBox.css', 'screen, projection') ;
	
	Yii::app()->clientScript->registerScript(
			"addUri", 
			'function addUri()
				{ '.CHtml::ajax(array(
				'url'=>CController::createUrl('item/addUri'), 
				'data'=>array('UriItemForm[url]'=>'js:$("#UriItemForm_url").val()'),
				'type'=>'POST',
				'dataType'=>'json',
				'success'=>'function (data){
					if (data.validate) {
						updateGrid();
					} else {
						var x = data.errors ;
						$.each(x, function(key, val) {
								var id = "#ItemForm_"+key+"_em_" ;
								alert(val[0]);
							})
					}
				}'
    		)).' return false; }', 
			CClientScript::POS_END);	
	
	
	/*
	 * Artur Neumann INF www.inf.org
	* don't show any parameters in the form action url
	*/
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'uri-item-form',"action"=>Yii::app()->request->baseUrl . "/"
	)); 

	?>

		<div id="row">
			<?php echo $form->labelEx($model,'url'); ?>
			<?php echo $form->textField($model,'url'); ?>
			<?php echo $form->error($model,'url'); ?>
		</div>

		<div id="buttons">
			<?php echo CHtml::imageButton('images/add.png',array('title'=>'Add new download','onClick'=>'addUri(); return false;')); ?>
		</div>

	<?php $this->endWidget(); ?>
</div>	
	

