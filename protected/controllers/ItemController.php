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

class ItemController extends Controller
{

	private $_aria = null ;

	public function init() {
		parent::init() ;
		$this->_aria = new aria2() ;
	}

	public function actions()
	{
		return array(
				array('allow',
						'actions'=>array('deleteItem',
								'addUri',
								'pauseAll',
								'UnPauseAll',
								'addMetaLink',
								'addTorrent',
								'PauseItem',
								'UnPauseItem',
								'ItemDetail'),
						'users'=>array('*'),
				),
		);
	}

	public function actionAddMetaLink() {
		if (isset($_POST['MetaLinkFileForm'])) {
			/*
			 * Artur Neumann INF www.inf.org
			* see comment in actionAddUri()
			*/

			if (!Yii::app()->user->isGuest || Yii::app()->Setting->publicAddFile)
			{
				$model = new MetaLinkFileForm() ;
				$model->attributes=$_POST['MetaLinkFileForm'];
				$model->metaLinkFile=CUploadedFile::getInstance($model,'metaLinkFile');
				$validate = $model->validate() ;

				if ($validate) {
					$result=$this->_aria->addMetalink(base64_encode(file_get_contents($model->metaLinkFile->tempName))) ;
					if ($this->_aria->hasError())
					{
						$message = $this->_aria->getError() ; $type = 'error';
					}
					else
					{ 
						$message = 'Successfully Added' ; $type = 'success';
						/*
						 * Artur Neumann INF www.inf.org
						* pause the download if its bigger that the size given in autoPauseSizeDownloads
						*/
						if (Yii::app()->Setting->autoPauseSizeDownloads > 0)
						{
							$totalLength=$this->_checkTotalLength($result[0]);
													
							if ($totalLength >=  Yii::app()->Setting->autoPauseSizeDownloads || $totalLength <= 0)
							{
								$this->_aria->pause($result[0]);

								Yii::log($this->_createFileList($result[0])." has been paused because of its size",'info', __METHOD__) ;						
							}
						}						
						
						
					}
				} else
				{ $message = $model->getError('metaLinkFile') ; $type = 'error' ;
				}

				Yii::app()->user->setFlash($type,$message) ;
				$this->redirect(CController::createUrl('site/index')) ;
			}
		}
	}

	public function actionAddTorrent() {
		if (isset($_POST['TorrentFileForm'])) {
			/*
			 * Artur Neumann INF www.inf.org
			* see comment in actionAddUri()
			*/

			if (!Yii::app()->user->isGuest || Yii::app()->Setting->publicAddFile)
			{
				$model = new TorrentFileForm() ;
				$model->attributes=$_POST['TorrentFileForm'];
				$model->torrentFile=CUploadedFile::getInstance($model,'torrentFile');
				$validate = $model->validate() ;
				if ($validate) {
					$itemID=$this->_aria->addTorrent(base64_encode(file_get_contents($model->torrentFile->tempName))) ;
					
					if ($this->_aria->hasError())
					{
						$message = $this->_aria->getError() ; $type = 'error';
					}
					else
					{ 
						/*
						 * Artur Neumann INF www.inf.org
						* pause the download if its bigger that the size given in autoPauseSizeDownloads
						*/
						if (Yii::app()->Setting->autoPauseSizeDownloads > 0)
						{
							$totalLength=$this->_checkTotalLength($itemID);
						
							if ($totalLength >=  Yii::app()->Setting->autoPauseSizeDownloads || $totalLength <= 0)
							{
								$this->_aria->pause($itemID);

								Yii::log($this->_createFileList($itemID)." has been paused because of its size",'info', __METHOD__) ;
							}
						}
						$message = 'Successfully Added' ; $type = 'success';
					}
				} else
				{ $message = $model->getError('torrentFile') ; $type = 'error' ;
				}

				Yii::app()->user->setFlash($type,$message) ;
				$this->redirect(CController::createUrl('site/index')) ;
			}
		}
	}

	public function actionAddUri() {
		$model = new UriItemForm() ;
		if(Yii::app()->request->isAjaxRequest) {
			if(isset($_POST['UriItemForm'])) {

				/*
				 * Artur Neumann INF www.inf.org
				* there was no real check if the user was allowed to place the download link
				* just the form was hidden. Even if the user was not allowed to add a link he still could do it
				* e.g. with curl
				* curl --data-urlencode  'UriItemForm%5Burl%5D=<link>' http://localhost/TheBear/index.php?r=item/addUri -H "X-Requested-With: XMLHttpRequest"
				*
				* This is now the real backend check
				*/

				if (!Yii::app()->user->isGuest || Yii::app()->Setting->publicAddFile)
				{
					$model->attributes=$_POST['UriItemForm'];
					if ($model->validate()) {
							
						$itemID = $this->_aria->addUri(array($model->url)) ;
						Yii::log($model->url." has been added as a URI file",'info', __METHOD__) ;

						/*
						 * Artur Neumann INF www.inf.org
						* pause the download if its bigger that the size given in autoPauseSizeDownloads
						*/
						if (Yii::app()->Setting->autoPauseSizeDownloads > 0)
						{
							$totalLength=$this->_checkTotalLength($itemID);							

							if ($totalLength >=  Yii::app()->Setting->autoPauseSizeDownloads || $totalLength <= 0)
							{
								$this->_aria->pause($itemID);
								Yii::log($model->url." has been paused because of its size",'info', __METHOD__) ;
							}
							
							//check also the size of every follower e.g. if the URL was a meta link 
							$status=$this->_aria->tellStatus($itemID);
							foreach ($status['followedBy'] as $follower) {
								$totalLength=$this->_checkTotalLength($follower);
								if ($totalLength >=  Yii::app()->Setting->autoPauseSizeDownloads || $totalLength <= 0)
								{
									$this->_aria->pause($follower);
								
									Yii::log($this->_createFileList($follower) ." has been paused because of its size",'info', __METHOD__) ;							
								}
							}
						}


						echo CJSON::encode(array(
								"validate"=>true,
								"aria2Message"=>$arai2Message,
						)
						) ;
							
					} else {
						echo CJSON::encode(array(
								"validate"=>false,
								"errors"=>$model->getErrors()
						)) ;
					}
				}
				Yii::app()->end() ;
			}
		}
	}

	public function actionPauseAll() {

		if(Yii::app()->request->isAjaxRequest) {
			$result = $this->_aria->pauseAll() ;

			if ($result==='OK')
				$result = true ;
			else
				$result = false ;

			echo CJSON::encode(array('result'=>$result)) ;
			Yii::app()->end() ;
		}

	}

	public function actionUnPauseAll() {

		/*
		 * Artur Neumann INF www.inf.org
		* just unpause if its allowed
		*/
		if(Yii::app()->request->isAjaxRequest && (!Yii::app()->user->isGuest || Yii::app()->Setting->publicUnPauseDownload)) {
			$result = $this->_aria->unpauseAll() ;

			if ($result==='OK')
				$result = true ;
			else
				$result = false ;

			echo CJSON::encode(array('result'=>$result)) ;
			Yii::app()->end() ;
		}

	}

	public function actionPauseItem($gid) {
		if(Yii::app()->request->isAjaxRequest) {
			echo CJSON::encode(
					array(
							'result'=>$this->_aria->pause($gid),
					)
			) ;
			Yii::app()->end() ;
		}
	}

	public function actionUnPauseItem($gid) {
		/*
		 * Artur Neumann INF www.inf.org
		* just unpause if its allowed
		*/
		if(Yii::app()->request->isAjaxRequest && (!Yii::app()->user->isGuest || Yii::app()->Setting->publicUnPauseDownload)) {
			echo CJSON::encode(
					array(
							'result'=>$this->_aria->unpause($gid),
					)
			) ;
			Yii::app()->end() ;
		}
	}

	public function actionItemDetail($gid) {
		if(Yii::app()->request->isAjaxRequest) {
			$aria = new aria2() ;
			$generalModel = $aria->tellStatus($gid) ;

			echo $this->renderPartial('itemDetail',array(
					'generalModel'=>(object)$generalModel,
					'gid'=>$gid,
			),true,false);
			Yii::app()->end() ;
		}
	}

	public function actionDeleteItem($gid,$status) {
		if(Yii::app()->request->isAjaxRequest) {
			$result = null ;
			if ($status=='active')
				$result = $this->_aria->remove($gid) ;
			else if ($status==='paused')
				$result = $this->_aria->forceRemove($gid) ;
			else
				$result = $this->_aria->removeDownloadResult($gid);

			echo CJSON::encode(array('result'=>$result)) ;
			Yii::app()->end() ;
		}

	}
	
	/**
	 * returns the total length of the file
	 *
	 * @param 	int 	the aria2 item gid
	 * @return int 		the length of the file
	* @author Artur Neumann INF www.inf.org
	* 
	*/
	private function _checkTotalLength ($itemID) {
		//we have to wait a while because the totalLength is not availiable imediately after adding a download
		$max_time_to_wait = ini_get('max_execution_time');
		if ($max_time_to_wait == 0) {
			$max_time_to_wait = 10;
		} else {
			$max_time_to_wait = $max_time_to_wait / 10 * 9;
		}
		$time_waited = 0;
		$status['totalLength'] = 0;
		$status['status'] = 'active';
		
		while ($status['status'] == 'active' && $status['totalLength'] <= 0 && $time_waited < $max_time_to_wait)
		{
			$status=$this->_aria->tellStatus($itemID, array("totalLength","status"));
		}
		
		return $status['totalLength'];
	}
	
	/**
	 * creates a list (string) of the files in the aria2 item separated by space
	 *
	 * @param 	int 	the aria2 item gid
	 * @return	string 	list of files, separated by space
	 * @author Artur Neumann INF www.inf.org
	 *
	 */
	private function _createFileList($itemID) {
		$files=$this->_aria->getFiles($itemID);
		
		$filelist = "";
		for($i=0;$i!=sizeof($files);++$i) {
			$filelist .= basename($files[$i]['path']) . " ";
		}
		
		return $filelist;
	}

}
