<?php
$this->breadcrumbs=array(
	'Qualities'=>array('index'),
	$model->quality_id,
);

$this->menu=array(
	array('label'=>'List Quality', 'url'=>array('index')),
	array('label'=>'Create Quality', 'url'=>array('create')),
	array('label'=>'Update Quality', 'url'=>array('update', 'id'=>$model->quality_id)),
	array('label'=>'Delete Quality', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->quality_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Quality', 'url'=>array('admin')),
);
?>

<h1>查看规格</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'quality_id',
		'quality_name',
	),
)); ?>
