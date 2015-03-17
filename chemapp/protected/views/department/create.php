<?php
$this->breadcrumbs=array(
	'Departments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'部门信息', 'url'=>array('index')),
	array('label'=>'部门管理', 'url'=>array('admin')),
);
?>

<h1>添加新部门</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>