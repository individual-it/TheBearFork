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

class SettingController extends Controller
{
	
	private $_aria ;
	
	public function init() {
		parent::init();
		Yii::log($this->getViewPath(),'info',__METHOD__);
	}
	
	public function actions()
	{
		return array(
			array('allow', 
				'actions'=>array('update',
								 'SetMxConcurrentDownloads',
								 'SetMaxOverAllDownloadLimit',
								 'GetMaxConcurrentDownloads',
								 'GetMaxOverAllDownloadLimit',
								 'GetDownloadSpeed',
								 'GetUploadSpeed',
								 'ItemSettingUpdate',
								 ),
				'users'=>array('*'),
			),
		);
	}
	
	public function actionGetDownloadSpeed() {
		if(Yii::app()->request->isAjaxRequest) {
			$this->_aria = new aria2() ;
			
			$result = Util::byteToHR($this->_aria->getGlobalStat('downloadSpeed')) ;
			$validate = !$this->_aria->hasError() ;
			$message = $this->_aria->getError() ;
			$result = array('validate'=>$validate,'message'=>$message,'result'=>$result) ;
			
			echo CJSON::encode($result) ;
			Yii::app()->end() ;
		}
	}
	
	public function actionGetUploadSpeed() {
		if(Yii::app()->request->isAjaxRequest) {
			$this->_aria = new aria2() ;
			
			$result = Util::byteToHR($this->_aria->getGlobalStat('uploadSpeed')) ;
			$validate = !$this->_aria->hasError() ;
			$message = $this->_aria->getError() ;
			$result = array('validate'=>$validate,'message'=>$message,'result'=>$result) ;
			
			echo CJSON::encode($result) ;
			Yii::app()->end() ;
		}
	}
	
	public function actionGetMaxConcurrentDownloads() {
		if(Yii::app()->request->isAjaxRequest) {
			$this->_aria = new aria2() ;
			
			$result = $this->_aria->getGlobalOption('max-concurrent-downloads') ;
			$validate = !$this->_aria->hasError() ;
			$message = $this->_aria->getError() ;
			$result = array('validate'=>$validate,'message'=>$message,'result'=>$result) ;
			
			echo CJSON::encode($result) ;
			Yii::app()->end() ;
		}
	}
	
	public function actionSetMaxConcurrentDownloads($value) {
		/*
		 * Artur Neumann INF www.inf.org
		* check if user is allowed to change settings
		*/
		if(Yii::app()->request->isAjaxRequest && (!Yii::app()->user->isGuest || Yii::app()->Setting->publicChangeSetting)) {
			$this->_aria = new aria2() ;
			
			$result = $this->_aria->setGlobalOption('max-concurrent-downloads',$value) ;
			$validate = !$this->_aria->hasError() ;
			$message = $this->_aria->getError() ;
			$result = array('validate'=>$validate,'message'=>$message,'result'=>$result) ;
			
			echo CJSON::encode($result) ;
			Yii::app()->end() ;
		}
	}
	
	public function actionGetMaxOverAllDownloadLimit() {
		if(Yii::app()->request->isAjaxRequest) {
			$this->_aria = new aria2() ;
			
			$result = $this->_aria->getGlobalOption('max-overall-download-limit') ;
			$validate = !$this->_aria->hasError() ;
			$message = $this->_aria->getError() ;
			$result = Util::byteToHR($result) ;
			$result = array('validate'=>$validate,'message'=>$message,'result'=>$result) ;
			
			echo CJSON::encode($result) ;
			Yii::app()->end() ;
		}
	}
	
	public function actionSetMaxOverAllDownloadLimit($value) {
		/*
		 * Artur Neumann INF www.inf.org
		* check if user is allowed to change settings
		*/
		if(Yii::app()->request->isAjaxRequest && (!Yii::app()->user->isGuest || Yii::app()->Setting->publicChangeSetting)) {
			$this->_aria = new aria2() ;
			
			$result = $this->_aria->setGlobalOption('max-overall-download-limit',Util::HRToByte($value)) ;
			$validate = !$this->_aria->hasError() ;
			$message = $this->_aria->getError() ;
			$result = array('validate'=>$validate,'message'=>$message,'result'=>$result) ;
			
			echo CJSON::encode($result) ;
			Yii::app()->end() ;
		}
	}
	
	public function actionUpdate() {	
		$this->render('update');
	}
	
	public function actionItemSettingUpdate($gid) {
		$model = new Aria2ItemSettingForm($gid) ;
		
		if(Yii::app()->request->isAjaxRequest) {
			if (isset($_POST['Aria2ItemSettingForm'])) {
				$model->attributes=$_POST['Aria2ItemSettingForm'];
				if($model->save())
					echo CJSON::encode(array('validate'=>true));
				else 
					echo CJSON::encode(array('div'=>$this->renderPartial('updateAria2ItemSetting',array('model'=>$model),true,false),
											'validate'=>false));
				
				Yii::app()->end() ; 
			} else
				
			$this->renderPartial('updateAria2ItemSetting',array('model'=>$model)) ;
			
		} 
	}
	
	public function actionError() {
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}
}
