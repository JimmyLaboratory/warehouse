<?php
$this->breadcrumbs=array(
	'Departments'=>array('index'),
	$model->department_id=>array('view','id'=>$model->department_id),
	'Update',
);

$this->menu=array(
	array('label'=>'部门信息', 'url'=>array('index')),
	array('label'=>'添加新部门', 'url'=>array('create')),
	array('label'=>'查看部门', 'url'=>array('view', 'id'=>$model->department_id)),
	array('label'=>'部门管理', 'url'=>array('admin')),
);
?>

<h1>更新部门</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>