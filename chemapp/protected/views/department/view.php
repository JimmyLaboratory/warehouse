<?php
$this->breadcrumbs=array(
	'Departments'=>array('index'),
	$model->department_id,
);

$this->menu=array(
	array('label'=>'部门信息', 'url'=>array('index')),
	array('label'=>'添加新部门', 'url'=>array('create')),
	array('label'=>'更新部门', 'url'=>array('update', 'id'=>$model->department_id)),
	array('label'=>'删除部门', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->department_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'部门管理', 'url'=>array('admin')),
);
?>

<h1>查看部门 #<?php echo $model->department_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'department_id',
		'department_name',
	),
)); ?>
