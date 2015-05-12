<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->user_id=>array('view','id'=>$model->user_id),
	'Update',
);

if(Yii::app()->authManager->checkAccess('college',Yii::app()->user->getId())){
        $this->menu=array(
                //array('label'=>'用户列表', 'url'=>array('admin')),
        );
}
else{
        $this->menu = array();
}
$this->menu[] = array('label'=>'修改用户密码', 'url'=>array('passwd', 'id'=>$model->user_id));
?>

<h1>修改用户信息</h1>

<?php echo $this->renderPartial('view', array('id'=>$model->purchasing_id)); ?>