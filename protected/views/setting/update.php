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

/*
 * Artur Neumann INF www.inf.org
* there was no real check if the user was allowed to see / change the setting
* just the link was hidden. Even if the user was not allowed to change the settings he still could do it via:
* http://<host>/TheBear/index.php?r=setting/update
*
* This is now the backend check not to display or save the settings
*/
if (Yii::app()->user->isGuest && !Yii::app()->Setting->publicChangeSetting)
{
	die("no permission");
}

?>

<div class="form">
	
	<h2>Global Settings</h2>
	

	<?php 
		
			try {
			
				$appModel = Yii::app()->Setting ;
				if (isset($_POST['AppSettingForm'])) {
					$appModel->attributes = $_POST['AppSettingForm'];
					if($appModel->save()) {
						Yii::app()->user->setFlash('success','Saved!');
						$this->refresh() ;
					} else 
						$this->renderPartial('updateAppSetting',array('model'=>$appModel)) ;
				} else
					$this->renderPartial('updateAppSetting',array('model'=>$appModel)) ; 

			} catch (Exception $e) {
				print $e->getMessage() ;
			}
			
			try {
				$aria2Model = new Aria2SettingForm() ;
				if (isset($_POST['Aria2SettingForm'])) {
					$aria2Model->attributes = $_POST['Aria2SettingForm'];
					if($aria2Model->save()) {
						Yii::app()->user->setFlash('success','Saved!');
						$this->refresh() ;
					} else 
						$this->renderPartial('updateAria2Setting',array('model'=>$aria2Model)) ;
				} else
					$this->renderPartial('updateAria2Setting',array('model'=>$aria2Model)) ;
					
			} catch (Exception $e) {
				print $e->getMessage() ;
			}
		
	?>

</div><!-- form -->
