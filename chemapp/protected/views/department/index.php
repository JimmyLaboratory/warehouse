<?php
$this->breadcrumbs=array(
	'Departments',
);

$this->menu=array(
	array('label'=>'添加新部门', 'url'=>array('create')),
	array('label'=>'部门信息管理', 'url'=>array('admin')),
);
?>

<h1>部门信息</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
