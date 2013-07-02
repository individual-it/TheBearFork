<div id="gridMenu">
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
					Yii::app()->request->baseUrl.'/css/gridMenu.css', 'screen, projection') ;

?>
<div id="buttons">
<?php

		$widgetData = array(
			'htmlOptions'=>array('class'=>'menu'),
			'encodeLabel'=>false,
			'items'=>array(
				array('label'=>CHtml::imageButton('images/refresh.png',array('title'=>'Refresh','OnClick'=>'updateGrid();'))),
				array('label'=>CHtml::image('images/pause.png',null,array('title'=>'Pause all downloads')), 
						'linkOptions'=>array(
						'onClick'=>CHtml::ajax(
							array(
									'url'=>CController::createUrl("item/pauseAll"),
									'type'=>'POST',
									'dataType'=>'json',
									'success'=>'function (data) {
										if (!data.result) alert(\'Unable to pause all downloads!\') ;
										updateGrid() ;
									}'
								)
						)
					), 
					'url'=>array('#')
				),
				
));	

/*
 * Artur Neumann INF www.inf.org
* just show the unpause pause button if its allowed
*/
if (!Yii::app()->user->isGuest || Yii::app()->Setting->publicUnPauseDownload)
{
	array_push($widgetData['items'], 
							array('label'=>CHtml::image('images/play.png',null,array('title'=>'UnPause all downlaods')), 
												'linkOptions'=>array(
												'onClick'=>CHtml::ajax(
													array(
															'url'=>CController::createUrl("item/unPauseAll"),
															'type'=>'POST',
															'dataType'=>'json',
															'success'=>'function (data) {
																if (!data.result) alert(\'Unable to un pause all downloads!\') ;
																else updateGrid() ;
															}'
														)
												)
											), 
											'url'=>array('#')
										));
}

$this->widget('zii.widgets.CMenu',$widgetData);

?>
</div>
	<div id="configs">
		<div id="row" style="float:left;margin-right:5px">
			<?php echo CHTml::label('Max Dls','concurr')?>:
			<?php 
			/*
			 * Artur Neumann INF www.inf.org
			* make the field read-only if the user is not allowed to change it
			*/
			$htmlOptions = array('size'=>'1');
			if (Yii::app()->user->isGuest && !Yii::app()->Setting->publicChangeSetting)
			{	
				$htmlOptions['readonly']='readonly';
			}
			
			echo CHtml::textField('concurr',$maxCuncDownloads,$htmlOptions);?>
		</div>
		<div id="button">
			<?php 
			/*
			 * Artur Neumann INF www.inf.org
			* don't show the button if the user is not allowed to change
			*/
			if (!Yii::app()->user->isGuest || Yii::app()->Setting->publicChangeSetting)
				
			{
			echo CHtml::imageButton('images/accept.png',array(
													'title'=>'Set Number of Cuncurrent Downloads',
													'onClick'=>CHtml::ajax(
																array(
																		'url'=>CController::createUrl("setting/SetMaxConcurrentDownloads"),
																		'data'=>array('value'=>'js:$("#concurr").val()'),
																		'type'=>'GET',
																		'dataType'=>'json',
																		'success'=>'function (data) {
																			if (!data.validate) alert(data.message) ;
																			updateParameter("'.CController::createUrl("setting/GetMaxConcurrentDownloads").'","concurr");
																		}'
																	)
															)
													));

			}
?>
		</div>
	
		<div id="row" style="float:left;margin-right:5px">
			<?php echo CHtml::label('Speed','downloadSpeed')?>:
			<?php 
			/*
			 * Artur Neumann INF www.inf.org
			* make the field read-only if the user is not allowed to change it
			*/
			$htmlOptions = array('size'=>'2');
			if (Yii::app()->user->isGuest && !Yii::app()->Setting->publicChangeSetting)
			{			
				$htmlOptions['readonly']='readonly';
			}
			echo CHtml::textField('downloadSpeed',$maxDownloadLimit,$htmlOptions);
			
			?>
		</div>
		<div id="button">

			<?php 
			/*
			 * Artur Neumann INF www.inf.org
			* don't show the button if the user is not allowed to change
			*/
				if (!Yii::app()->user->isGuest || Yii::app()->Setting->publicChangeSetting)	
				{
						
					echo CHtml::imageButton('images/accept.png',array(
															'title'=>'Set Maximum Download Speed',
															'onClick'=>CHtml::ajax(
																	array(
																			'url'=>CController::createUrl("setting/SetMaxOverAllDownloadLimit"),
																			'data'=>array('value'=>'js:$("#downloadSpeed").val()'),
																			'type'=>'GET',
																			'dataType'=>'json',
																			'success'=>'function (data) {
																				if (!data.validate) alert(data.message) ;
																				updateParameter("'.CController::createUrl("setting/GetMaxOverAllDownloadLimit").'","downloadSpeed");
				}'
																		)
																)
															));
	
				}
				?>
		</div>
	</div>
</div>

</div>
