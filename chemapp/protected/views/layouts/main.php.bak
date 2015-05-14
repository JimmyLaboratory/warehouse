<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="zh_cn" />

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
		<h1 id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></h1>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'首页', 'url'=>array('/site/index')),
				array('label'=>'采购申请', 'url'=>array('/purchasing/apply'),
					'visible'=>
					Yii::app()->authManager->checkAccess('teacher',Yii::app()->user->getId()) && !Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId()) &&
					!Yii::app()->authManager->checkAccess('secure',Yii::app()->user->getId()) 
				),
				array('label'=>'采购管理', 'url'=>array('/purchasing/admin','status'=>'APPROVE'),'visible'=>
					Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId()) ||
					Yii::app()->authManager->checkAccess('secure',Yii::app()->user->getId()) ||
					Yii::app()->authManager->checkAccess('college',Yii::app()->user->getId())
				),
				//array('label'=>'使用申请', 'url'=>array('/using/create'),'visible'=>Yii::app()->authManager->checkAccess('teacher',Yii::app()->user->getId())),
				array('label'=>'使用管理', 'url'=>array('/using/admin','status'=>'APPROVE'),'visible'=>
					Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId()) ||
					Yii::app()->authManager->checkAccess('college',Yii::app()->user->getId())
					),

				//array('label'=>'采购单', 'url'=>array('/purchasing/no'),'visible'=>Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId())),
				
				//array('label'=>'入库', 'url'=>array('/instorage/admin'/*,'Purchasing[status]'=>  Purchasing::STATUS_PURCHASING*/),'visible'=>Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId())),
				
				array('label'=>'备案', 'url'=>array('/achieve/admin'),'visible'=>Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId())),
				
				/*array(
					'label'=>'出库',
					'url'=>array('/outstorage/create'),
					'visible'=>Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId())
				),*/
				
				array('label'=>'出入库', 'url'=>array(''),'visible'=>Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId())),
				
				array('label'=>'查看申领化学品',
					'url'=>array('/chemlist/admin&Chemlist[status]=3'),
					'visible'=>Yii::app()->authManager->checkAccess('teacher',Yii::app()->user->getId())
				),
				array(
					'label'=>'化学品库',
					'url'=>array('/chemlist/admin'),
					'visible'=>!Yii::app()->user->isGuest && !Yii::app()->authManager->checkAccess('teacher',Yii::app()->user->getId())
				),
				
				array('label'=>'系统管理', 'url'=>array('/site/admin'),'visible'=>Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId())),
				
				array('label'=>'用户管理', 'url'=>array('/user'),'visible'=>
					//Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId()) ||
					Yii::app()->authManager->checkAccess('college',Yii::app()->user->getId())||
					Yii::app()->authManager->checkAccess('secure',Yii::app()->user->getId())
					),
				array('label'=>'修改信息', 'url'=>array('/user/update','id'=>User::getInfo() ? User::getInfo()->user_id : ''),'visible'=>!Yii::app()->user->isGuest),
				
				
				array('label'=>'登录', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'退出 ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		<a href="http://chemlab.szu.edu.cn/">深圳大学化学教学实验中心</a>制作 2006-<?php echo date('Y'); ?> &copy;版权所有<br/>
		深圳市南山区深圳大学实验楼P416 邮编：518060 电话：0755-26534573 传真：0755-26536141<br/>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
