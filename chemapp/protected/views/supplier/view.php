<?php
$this->breadcrumbs=array(
	'Suppliers'=>array('index'),
	$model->supplier_id,
);

$this->menu=array(
	array('label'=>'供应商', 'url'=>array('index')),
	array('label'=>'创建供应商', 'url'=>array('create')),
	array('label'=>'修改供应商信息', 'url'=>array('update', 'id'=>$model->supplier_id)),
	array('label'=>'删除这个供应商', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->supplier_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'管理供应商', 'url'=>array('admin')),
);
?>

<h1>查看供应商信息</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'supplier_id',
		'supplier_name',
		'website',
		'email',
		'contact',
		'tel',
		'person',
		'personaltel',
		'note',
	),
)); ?>
