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

	Yii::import('zii.widgets.jui.CJuiDialog');
	class BJuiDialog extends CJuiDialog {
		
		private $dialogID = 'myDialog' ;
		
		public function init()
		{
			$this->setID($this->dialogID) ;
			$this->options = array(
						'title'=>'Download Setting',
						'autoOpen'=>false,
						'modal'=>true,
						'width'=>650,
		    			'height'=>'500',
					) ;
			$this->htmlOptions = array('style'=>'font-size:0.8em;')	 ;
			
			if (!Yii::app()->clientScript->isScriptRegistered('getView', CClientScript::POS_END))
			{
				Yii::app()->clientScript->registerScript('getView',
	
								"function getView(requestUrl)
								{
								".CHtml::ajax(array(
										'url'=>"js:requestUrl",
										'data'=> "js:$(this).serialize()",
										'type'=>'post',
										'dataType'=>'html',
										'success'=>'function (data){$("#'.$this->dialogID.'").html(data);$("#'.$this->dialogID.'").dialog("open")}'
										))." ;
							 
								return false ;
								}",
														CClientScript::POS_END);
			}
			parent::init() ;
		}
	}

?>
