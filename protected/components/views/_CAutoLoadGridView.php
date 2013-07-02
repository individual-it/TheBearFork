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
try {
	$dataProvider = new aria2DataProvider() ;
	$widgetData = array(
			'id'=>'download-grid',
			'dataProvider'=>$dataProvider,
			'enableSorting'=>false,
			'enablePagination'=>true,
			'selectableRows'=>false,
			'columns'=>array(
					array(
							'name'=>'ID',
							'value'=>'$data->gid'
					),
					array(
							'name'=>'Status',
							'type'=>'html',
							'value'=>'CHtml::image("images/".$data->status.".png",ucfirst($data->status),array("title"=>ucfirst($data->status)))',
					),
					array(
							'class'=>'BJsLinkColumn',
					),
					array(
							'name'=>'Download Speed',
							'value'=>'round($data->downloadSpeed / 1024)." KB"'
					),
					array(
							'name'=>'Progress',
							'value'=>'$data->progress." %"'
					),
					array(
							'name'=>'Size',
							'value'=>'Util::byteToHR($data->totalLength)'
					),
					array(
							'name'=>'Uploaded',
							'value'=>'Util::byteToHR($data->uploadLength)'
					),
					array(
							'class'=>'CButtonColumn',
							'deleteButtonUrl'=>'CController::createUrl("/Item/deleteItem",array("gid"=>$data->gid,"status"=>$data->status))',
							'deleteButtonImageUrl'=>'images/delete.png',
							'buttons'=>array(
									'setting'=>array(
											'label'=>'Download Settings',
											'imageUrl'=>'images/setting.png',
											'url'=>'CController::createUrl("/setting/ItemSettingUpdate",array("gid"=>$data->gid))',
											'click'=>"function(){getView($(this).attr('href'));return false;}",
									),
									'pause'=>array(
											'label'=>'Pause Download',
											'imageUrl'=>'images/pause.png',
											'url'=>'CController::createUrl("/Item/pauseItem",array("gid"=>$data->gid))',
											'click'=>'function() {'.CHtml::ajax(array("url"=>"js:$(this).attr('href')","type"=>"post","success"=>"function(){updateGrid();return false;}")).';return false;}',
											'visible'=>'!$data->isPaused()'
									),
							),
					),
			),
	);
		
	/*
	 * Artur Neumann INF www.inf.org
	* just show the unpause pause button if its allowed
	*/
	if (!Yii::app()->user->isGuest || Yii::app()->Setting->publicUnPauseDownload)
	{
		$widgetData['columns'][7]['buttons']['unpause'] = array(
				'label'=>'UnPause Download',
				'imageUrl'=>'images/play.png',
				'url'=>'CController::createUrl("/Item/unPauseItem",array("gid"=>$data->gid))',
				'click'=>'function() {'.CHtml::ajax(array("url"=>"js:$(this).attr('href')","type"=>"post","success"=>"function(){updateGrid();return false;}")).';return false;}',
				'visible'=>'$data->isPaused()'
		);
		
		$widgetData['columns'][7]['template'] = '{unpause} {pause} {setting} {delete}';
	} 
	else
	{
		$widgetData['columns'][7]['template'] = '{pause} {setting} {delete}';
	}
		
	$this->widget('zii.widgets.grid.CGridView',$widgetData) ;
} catch (Exception $e)	{
	print $e->getMessage() ;
}
?>
