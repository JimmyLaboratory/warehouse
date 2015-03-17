<?php
$this->breadcrumbs=array(
	'Storages'=>array('index'),
	$model->storage_id,
);

$this->menu=array(
	array('label'=>'List Storage', 'url'=>array('index')),
	array('label'=>'Create Storage', 'url'=>array('create')),
	array('label'=>'Update Storage', 'url'=>array('update', 'id'=>$model->storage_id)),
	array('label'=>'Delete Storage', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->storage_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Storage', 'url'=>array('admin')),
);
?>

<h1>查看仓库</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'storage_id',
		'storage_name',
		'note',
		'parent_id',
	),
)); ?>
