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
        //if(Purchasing::check(100))
			//echo "good";
		//echo '<p>',Yii::app()->user->getName(),'，您好，请从导航栏选择您需要的操作。</p>';
		echo '<p><strong style="font-size:1.2em">',User::getInfo()->realname,'</strong> 您好，请从导航栏选择您需要的操作。</p>';
		
		if((User::getInfo()->roleName)=='学校'){
		echo '<p>您当前的身份是：<i>',User::getInfo()->roleName,'</i></p>';		
		
		if(Purchasing::check('2') or Purchasing::check('3') ){
			echo CHtml::link('您有需要审批的采购申请',array('purchasing/admin&status=APPROVE'));
			echo '<br>';
			echo '<br>';}
		else
			echo '<p>您暂时没有需要审批的采购申请</p>';
				
		if(Using::check('2')){
			echo CHtml::link('您有需要审批的使用申请',array('using/admin&status=APPROVE'));
			echo '<br>';
			echo '<br>';}
		else
			echo '<p>您暂时没有需要审批的使用申请</p>';
		
		}
		
		else if((User::getInfo()->roleName)=='保卫处'){
		echo '<p>您当前的身份是：<i>',User::getInfo()->roleName,'</i></p>';	
			
		if(Purchasing::check('2') or Purchasing::check('4'))
			echo CHtml::link('您有需要审批的采购申请',array('purchasing/admin&status=APPROVE'));
		else
			echo '<p>您暂时没有需要审批的采购申请</p>';
		}
		
		else if((User::getInfo()->roleName)=='学院'){
		
		echo '<p>您当前的身份是：<i>',User::getInfo()->roleName,'</i></p>';		
		if(Purchasing::check('1') or Purchasing::check('3') or Purchasing::check('4') ){
			echo CHtml::link('您有需要审批的采购申请',array('purchasing/admin&status=APPROVE'));
			echo '<br>';
			echo '<br>';}
		
		else
			echo '<p>您暂时没有需要审批的采购申请</p>';
		
		if(Using::check('1') or Using::check('3')){
			echo CHtml::link('您有需要审批的使用申请',array('using/admin&status=APPROVE'));
			echo '<br>';
			echo '<br>';}
		else
			echo '<p>您暂时没有需要审批的使用申请</p>';
		}
		
		else if((User::getInfo()->roleName)=='教师'){
		
		echo '<p>您当前的身份是：<i>',User::getInfo()->roleName,'</i></p>';
		//echo '<p>如果您首次使用化学品，请先<a href="index.php?r=purchasing/apply"><b>申请采购</b></a>，</p>';
		echo '如果您首次使用化学品，请先';
		echo CHtml::link('<b>申请采购</b>',array('purchasing/apply'));
		echo '<br>';
		echo '<br>';
		
		//echo '<p>如果您的化学品仍有库存，可从<a href="index.php?r=chemlist/admin"><b>查看化学品</b></a>中选择使用。</p>';
		echo '如果您的化学品仍有库存，可从';
		echo CHtml::link('<b>查看化学品</b>',array('chemlist/admin'));
		echo '中选择使用。';
		}
endif;
?>
</div>
