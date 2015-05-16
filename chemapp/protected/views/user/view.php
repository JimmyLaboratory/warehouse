<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->user_id,
);

$this->menu=array(
	array('label'=>'修改用户信息', 'url'=>array('update', 'id'=>$model->user_id)),
);
?>

<h1>查看用户信息<?php //echo $model->user_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		'user_name',
		'realname',
		'user_role',
		'dname',
		'cardno',
		'tel_long',
		'tel_short',
		'tel_office',
		'email',
		'note',
		array(
            'name'=>'lock',
            'value'=>User::showLock($model->lock)
        ),
	),
)); ?>
