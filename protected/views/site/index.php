<?php $this->pageTitle=Yii::app()->name; ?>
		
		
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

	$this->widget('BJuiDialog') ;

	if (!Yii::app()->user->isGuest || Yii::app()->Setting->publicAddFile)
	$this->widget('CTabView',array(
					'cssFile'=>'css/jquery.yiitab.css',
					'activeTab'=>'tab1',
					'tabs'=>array(
						'tab1'=>array(
							  'title'=>'Url',
							  'view'=>'_uriItemForm',
							  'data'=>array('model'=>new UriItemForm()),
						),
						'tab2'=>array(
							  'title'=>'Torrent file',
							  'view'=>'_torrentFileForm',
							  'data'=>array('model'=>new TorrentFileForm()),
							  
						),
						'tab3'=>array(
							  'title'=>'Metalink file',
							  'view'=>'_metaLinkFileForm',
							  'data'=>array('model'=>new MetaLinkFileForm()),
							  
						),
					),
				
				)
			) ;
	
	$this->renderPartial('_gridView') ;
	$this->renderPartial('_gridMenu',array('maxDownloadLimit'=>$maxDownloadLimit, 'maxCuncDownloads'=>$maxCuncDownloads)) ;
?>

