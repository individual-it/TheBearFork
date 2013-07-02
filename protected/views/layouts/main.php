<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
		<div class="defaultStyle" id="statHeader"> 
			<?php 
				$this->widget('CAutoLoadLabel',array(
				'loadInterval'=>Yii::app()->Setting->statUpdateInterval,
				'title'=>'Download Speed',
				'initText'=>'init..',
				'ajaxUrl'=>'setting/GetDownloadSpeed',
				)) ; 
			?>
		<img src="images/download.png" title="Download Speed"> 
			<?php 
				$this->widget('CAutoLoadLabel',array(
				'loadInterval'=>Yii::app()->Setting->statUpdateInterval,
				'title'=>'Upload Speed',
				'initText'=>'init..',
				'ajaxUrl'=>'setting/GetUploadSpeed',
				)) ; 
			?>			
		<img src="images/upload.png" title="Overall Upload Speed"></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Settings', 'url'=>array('/setting/update'),'visible'=>(!Yii::app()->user->isGuest || Yii::app()->Setting->publicChangeSetting)),
				array('label'=>'Bugs', 'url'=>'http://sourceforge.net/p/thebear/tickets/'),
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	<?php
		$flashes = Yii::app()->user->getFlashes(true) ;
		foreach($flashes as $type => $message)
			print '<div class="flash-'.$type.'">'.$message.'</div>';
	?>
	<?php echo $content; ?>

	<div id="footer">
		<a href="http://aria2.sourceforge.net/">aria2</a> web interface
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
