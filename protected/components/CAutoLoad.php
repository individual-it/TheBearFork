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
	
	Yii::import('zii.widgets.CWidget');
	class CAutoLoad extends CWidget {
		
		// repeat the call in loadInterval seconds
		public $loadInterval ;
		
		// the url which ajax call should be send to
		public $ajaxUrl ;
		
		// JS piece of code which will be executed after a successfull ajax call over ajaxUrl
		public $jsUpdate ;
		
		// jquery ajax
		public $ajax = null ;
		
		public function run() {
			$this->render('_CAutoLoad');
		}
		
		public function getAjax() {
			if(is_null($this->ajax)) {
#				return Yii::app()->clientScript->registerScript(
	#			"autoLoad".$this->id, 
				return CHtml::ajax(
							array(
									'url'=>CController::createUrl($this->ajaxUrl),
									'type'=>'GET',
									'dataType'=>'json',
									'success'=>'function (data) {
										if (!data.validate) alert(data.message) ;
										'.$this->jsUpdate.'
									}'
								)
						) ;
				#, CClientScript::POS_END);
			} else 
				return $this->ajax ;
		}
	}
	
?>
