<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/blueprint/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/blueprint/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/blueprint/ie.css" media="screen, projection" />
	<![endif]-->
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
</head>

<body>

<div id="page" class="">

	<div id="header">
		<div id="logo">
			<?php echo CHtml::encode(Yii::app()->params['appName']); ?>
			<div><?php echo Yii::app()->params['schoolHtml']; ?></div>
		</div>
		<div id="usermenu">
<?php
$msgCount = Messages::countNew();
// $this->widget('zii.widgets.CMenu',array(
$this->widget('bootstrap.widgets.BootMenu',array(
	'type'=>'pills',
	'stacked'=>false,
	'items'=>array(
		array('label'=>'Съобщения'.(($msgCount)?" ({$msgCount})":""), 'url'=>array('/messages/index'), 'visible'=>!Yii::app()->user->isGuest),
		array('label'=>'Потребители', 'url'=>array('/users/admin'), 'visible'=>((!Yii::app()->user->isGuest) && (Yii::app()->user->getState('userType')>2))),
		array('label'=>'Профил ('.Yii::app()->user->getState('userName').')', 'url'=>array('/users/view?id='.Yii::app()->user->getId()), 'visible'=>!Yii::app()->user->isGuest),
		array('label'=>'Вход', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
		array('label'=>'Изход', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
	),
));
?>
		</div><!-- usermenu -->
	</div><!-- header -->

	<div id="mainmenu">
<?php
// $this->widget('zii.widgets.CMenu',array(
$this->widget('bootstrap.widgets.BootMenu',array(
	'type'=>'tabs',
	'items'=>array(
		array('label'=>'Блог', 'url'=>array('/post/index')),
		array('label'=>'Снимки', 'url'=>array('/gallery')),
		array('label'=>'За нас', 'url'=>array('/site/page', 'view'=>'about')),
		array('label'=>'Контакти', 'url'=>array('/site/contact')),
	),
));
?>
	</div><!-- mainmenu -->
<?php
if(isset($this->breadcrumbs) && count($this->breadcrumbs)>0) {
	$this->widget('bootstrap.widgets.BootBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	)); //<!-- breadcrumbs -->
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		<?php echo Yii::app()->params['copyrightInfo']; ?>.<br/>
		All Rights Reserved.<br/>
	</div><!-- footer -->

</div><!-- page -->
<?php echo Yii::app()->params['analyticsScript']; ?>
</body>
</html>
