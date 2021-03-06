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
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/css.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<h1 id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></h1>
	</div><!-- header -->

	<div class="newcontainer">
		<?php 

		$this->widget('zii.widgets.CMenu',array(
			'activeCssClass'=>'',
			 'htmlOptions'=>array('class'=>'menu'),
			'items'=>array(
				
				array('label'=>'首页', 'url'=>array('/site/index'),),
				array('label'=>'采购申请', 'url'=>'#',
					'submenuOptions'=>array('class'=>'submenu'),
					'visible'=>
					Yii::app()->authManager->checkAccess('teacher',Yii::app()->user->getId()),
					'items'=>array(
						array('label'=>'开始申请', 'url'=>array('/purchasing/apply')),
						array('label'=>'申购中', 'url'=>array('/purchasing/admin','status'=>'MOVING')),
						array('label'=>'被拒申请', 'url'=>array('/purchasing/admin','Purchasing'=>array('status'=>  Purchasing::STATUS_REJECT))),
						array('label'=>'全部申请', 'url'=>array('/purchasing/admin'))					
						),
				),
				array('label'=>'申购管理', 'url'=>'#','submenuOptions'=>array('class'=>'submenu'),'visible'=>
					Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId()) ||
					Yii::app()->authManager->checkAccess('secure',Yii::app()->user->getId()) ||
					Yii::app()->authManager->checkAccess('college',Yii::app()->user->getId()),
					'items'=>array(
						array('label'=>'待审申请', 'url'=>array('/purchasing/admin&status=APPROVE')),
						array('label'=>'已审申请', 'url'=>array('/purchasing/admin&status=PASS')),
						array('label'=>'被拒申请', 'url'=>array('/purchasing/admin','Purchasing'=>array('status'=>  Purchasing::STATUS_REJECT))),
						array('label'=>'全部申请', 'url'=>array('/purchasing/admin'))					
						),
				),
				array('label'=>'采购管理', 'url'=>'#','submenuOptions'=>array('class'=>'submenu'),'visible'=>
					Yii::app()->authManager->checkAccess('college',Yii::app()->user->getId()),
					'items'=>array(
						array('label'=>'新建采购', 'url'=>array('/purchasing/purchase_admin','status'=>'PURCHASING','Purchasing'=>array('status'=>Purchasing::STATUS_ARCHIVES_SUCCESS))),
						array('label'=>'采购中', 'url'=>array('/purchasing/purchase_admin','ING'=>'t','Purchasing'=>array('status'=>Purchasing::STATUS_PURCHASING ))),
						array('label'=>'采购完毕', 'url'=>array('/purchasing/purchase_admin','Purchasing'=>array('status'=>Purchasing::STATUS_INSTOCK))),			
						),
				),
				/* array('label'=>'采购管理', 'url'=>array('/purchasing/admin2'),'visible'=>
					Yii::app()->authManager->checkAccess('college',Yii::app()->user->getId())
				), */
				//array('label'=>'使用申请', 'url'=>array('/using/create'),'visible'=>Yii::app()->authManager->checkAccess('teacher',Yii::app()->user->getId())),
				array('label'=>'使用管理', 'url'=>'#','submenuOptions'=>array('class'=>'submenu'),'visible'=>
					Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId()) ||
					Yii::app()->authManager->checkAccess('college',Yii::app()->user->getId()),
					'items'=>array(
						array('label'=>'待审申请', 'url'=>array('/using/admin&status=APPROVE')),
						array('label'=>'已审申请', 'url'=>array('/using/admin&status=PASS')),
						array('label'=>'全部申请', 'url'=>array('/using/admin')),				
						),
					),

				//array('label'=>'采购单', 'url'=>array('/purchasing/no'),'visible'=>Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId())),
				
				//array('label'=>'入库', 'url'=>array('/instorage/admin'/*,'Purchasing[status]'=>  Purchasing::STATUS_PURCHASING*/),'visible'=>Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId())),
				
				array('label'=>'备案', 'url'=>'#','submenuOptions'=>array('class'=>'submenu'),'visible'=>
				Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId()),
				'items'=>array(
						array('label'=>'开始备案', 'url'=>array('/achieve/begin','Purchasing[status]'=> Purchasing::STATUS_PASS_FINAL)),
						array('label'=>'正在备案', 'url'=>array('/achieve/admin','status'=>Achieve::STATUS_SENDING)),
						array('label'=>'备案成功', 'url'=>array('/achieve/admin','status'=>Achieve::STATUS_SUCCESS)),
						array('label'=>'备案失败', 'url'=>array('/achieve/admin','status'=>Achieve::STATUS_FAILED)),						
						),
					),
				array('label'=>'出入库', 'url'=>'#','submenuOptions'=>array('class'=>'submenu'),
				'visible'=>Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId()),
					'items'=>array(
						array('label'=>'入库', 'url'=>array('/instorage/admin')),
						array('label'=>'出库', 'url'=>array('/outstorage/admin')),					
						),
				),
				
				array('label'=>'查看申领化学品',
					'url'=>'#','submenuOptions'=>array('class'=>'submenu'),
					'visible'=>Yii::app()->authManager->checkAccess('teacher',Yii::app()->user->getId()),
					'items'=>array(
						array('label'=>'所有化学品', 'url'=>array('/chemlist/admin')),
						array('label'=>'库存化学品', 'url'=>array('/chemlist/admin','Chemlist'=>array('status'=>  Chemlist::STATUS_INSTOCK))),					
						),
				),
				array(
					'label'=>'化学品库',
					'url'=>'#','submenuOptions'=>array('class'=>'submenu'),
					'visible'=>!Yii::app()->user->isGuest && !Yii::app()->authManager->checkAccess('teacher',Yii::app()->user->getId()),
					'items'=>array(
						array('label'=>'入库', 'url'=>array('/instorage/admin'),'visible'=>Yii::app()->authManager->checkAccess('college',Yii::app()->user->getId())),
						array('label'=>'出库', 'url'=>array('/outstorage/admin'),'visible'=>Yii::app()->authManager->checkAccess('college',Yii::app()->user->getId())),
						array('label'=>'所有化学品', 'url'=>array('/chemlist/admin')),
						array('label'=>'库存化学品', 'url'=>array('/chemlist/admin','Chemlist'=>array('status'=>  Chemlist::STATUS_INSTOCK))),					
						array('label'=>'管理仓库', 'url'=>array('/storage/admin'),'visible'=>Yii::app()->authManager->checkAccess('college',Yii::app()->user->getId())),
						),
				),
				
				array(
					'label'=>'系统管理', 
					'url'=>'#','submenuOptions'=>array('class'=>'submenu'),
					'visible'=>Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId()),
					'items'=>array(
						array('label'=>'用户管理', 'url'=>array('/user')),
						array('label'=>'学院部门管理', 'url'=>array('/department')),
						array('label'=>'供应商管理', 'url'=>array('/supplier')),
						array('label'=>'仓库管理', 'url'=>array('/storage/admin')),
						array('label'=>'化学品分类管理', 'url'=>array('/chemcat/admin')),					
						),
				),
				array('label'=>'供货商管理', 'url'=>'#','submenuOptions'=>array('class'=>'submenu'),
				'visible'=>Yii::app()->authManager->checkAccess('college',Yii::app()->user->getId()),
				'items'=>array(
						array('label'=>'管理供应商', 'url'=>array('/supplier/admin')),
						array('label'=>'创建供应商', 'url'=>array('/supplier/create')),			
						),
				),
				
				array('label'=>'用户管理', 'url'=>'#','submenuOptions'=>array('class'=>'submenu'),
					'visible'=>
					Yii::app()->authManager->checkAccess('college',Yii::app()->user->getId()),
					'items'=>array(
						array('label'=>'管理用户', 'url'=>array('/user')),
						array('label'=>'创建用户', 'url'=>array('/user/create')),			
						),
					),
				array(
					'label'=>'用户('.Yii::app()->user->name.')',
					'url'=>'#',
					'submenuOptions'=>array('class'=>'submenu'),
					'visible'=>!Yii::app()->user->isGuest ,
					'items'=>array(
						array('label'=>'修改用户信息','url'=>array('/user/update','id'=>User::getInfo() ? User::getInfo()->user_id : '')),	
						array('label'=>'退出', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
						),
				),
				array('label'=>'登录', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
			),
		)); ?>
	</div><!-- mainmenu -->

<div class ="huanchongdai">
</div>
	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		<a href="http://chemlab.szu.edu.cn/">深圳大学化学教学实验中心</a>制作 2006-<?php echo date('Y'); ?> &copy;版权所有<br/>
		深圳市南山区深圳大学实验楼P416 邮编：518060 电话：0755-26534573 传真：0755-26536141<br/>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
