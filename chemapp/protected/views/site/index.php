<?php $this->pageTitle=Yii::app()->name; ?>

<h1>欢迎使用 <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<p>&nbsp;</p>

<div class="narrowPage">
<?php 
if(Yii::app()->user->isGuest):
        echo '<p>请使用你的帐户及密码登录系统</p>';
		echo '<script type="text/javascript">
		<!--
			location.href = "index.php?r=site/login"
		//-->
		</script>';
else:
        //echo '<p>',Yii::app()->user->getName(),'，您好，请从导航栏选择您需要的操作。</p>';
		echo '<p><strong style="font-size:1.2em">',User::getInfo()->realname,'</strong> 您好，请从导航栏选择您需要的操作。</p>';
		echo '<p>您当前的身份是：<i>',User::getInfo()->roleName,'</i></p>';
		echo '<p>如果您首次使用化学品，请先<a href="index.php?r=purchasing/apply"><b>申请采购</b></a>，</p>';
		echo '<p>如果您的化学品仍有库存，可从<a href="index.php?r=chemlist/admin"><b>查看化学品</b></a>中选择使用。</p>';
endif;
?>
</div>
