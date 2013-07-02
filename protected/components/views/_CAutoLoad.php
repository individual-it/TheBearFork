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

	Yii::app()->clientScript->registerScript(
			"autoLoad".$this->id, 
			'setInterval(function(){'.$this->getAjax().'},'.($this->loadInterval*1000).');', 
	CClientScript::POS_END);


	Yii::app()->clientScript->registerScript(
			"updateParameter", 
			'function updateParameter(url,id) {
				'.CHtml::ajax(
							array(
									'url'=>'js:url',
									'type'=>'POST',
									'dataType'=>'json',
									'success'=>'function (data) {
										if (!data.validate) alert(\'Unable to update property!\') ;
										$("#"+id).val(data.result);
									}'
								)
						).'
			}', 
			CClientScript::POS_END);
	Yii::app()->clientScript->registerScript(
			"updateGrid", 
			'function updateGrid() {setTimeout(function(){$.fn.yiiGridView.update("download-grid")},1000);return false;}', 
	CClientScript::POS_END);
?>
