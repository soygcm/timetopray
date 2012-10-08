<?php /* @var $this Controller */ ?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	<?php //Yii::app()->clientScript->registerCoreScript('jquery'); ?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div id="site">
	<header>
		<div id="logo">
			<h1><?php echo CHtml::image('images/logo.png', Yii::app()->name); ?></h1>
		</div>

		<div id="mainmenu">
			<?php $this->widget('zii.widgets.CMenu',array(
				'items'=>array(
					array('label'=>'Home', 'url'=>array('/site/index')),
					array('label'=>'Notifications', 'url'=>array('/notifications')),
					array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
					array('label'=>'Contact', 'url'=>array('/site/contact')),
					array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
					array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
				),
			)); ?>
		</div><!-- mainmenu -->
	</header>

<div class="container" id="page">
	<section id="user">
		<div id="profile">
			<?php $this->widget('application.widgets.FacebookJS.FacebookJS'); ?>

			<?php if(!Yii::app()->user->isGuest): ?>
				
				<div class="picture">
					<?php $imageUrl = Yii::app()->facebook->getProfilePicture('normal');?>
					<img src="images/picture.png" alt="foto de perfil" style="background-image:url(<?php echo $imageUrl; ?>);">
					<?php //echo CHtml::image($imageUrl, 'ProfilePicture'); ?>
				</div>

				<h2 class="name"><?php echo Yii::app()->user->name; ?> <?php echo Yii::app()->user->apellido;?> </h1>

				<h3 class="carrera"></h3>
				<h3 class="iglesia"></h3>
				
				<section class="menu_usuario">
					
				</section>

			<?php else: ?>
    			<div id="fb_login_button">Entra usando <?php echo CHtml::image('images/facebook.png', 'Facebok'); ?></div>
			<?php endif ?>

		</div>
	</section>
	<?php echo $content; ?>
	<footer>
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</footer><!-- footer -->

</div><!-- page --></div>

</body>
</html>
