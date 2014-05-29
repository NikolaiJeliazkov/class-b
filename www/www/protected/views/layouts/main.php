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
			<div><a href="http://www.41ou.com/">41 ОУ "Св. Патриарх Евтимий"</a></div>
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
		Copyright &copy; <?php echo date('Y'); ?> by <?php echo CHtml::encode(Yii::app()->name); ?>.<br/>
		All Rights Reserved.<br/>
	</div><!-- footer -->

</div><!-- page -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-51466807-1', 'class-b.net');
  ga('send', 'pageview');
</script>
</body>
</html>
