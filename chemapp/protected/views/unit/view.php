<?php
$this->breadcrumbs=array(
	'Units'=>array('index'),
	$model->unit_id,
);

$this->menu=array(
	array('label'=>'List Unit', 'url'=>array('index')),
	array('label'=>'Create Unit', 'url'=>array('create')),
	array('label'=>'Update Unit', 'url'=>array('update', 'id'=>$model->unit_id)),
	array('label'=>'Delete Unit', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->unit_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Unit', 'url'=>array('admin')),
);
?>

<h1>查看化学品单位</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'unit_id',
		'unit_name',
	),
)); ?>
