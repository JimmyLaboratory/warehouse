<?php
$this->breadcrumbs=array(
	'Outstorages'=>array('index'),
	$model->outstorage_id,
);

$this->menu=array(
	array('label'=>'出库单列表', 'url'=>array('admin')),
	array('label'=>'创建出库单', 'url'=>array('create')),
);
?>

<h1>查看出库信息</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'outstorage_id',
		'using_id',
		'apply_user_id',
		'duty_user_id',
		'datetime',
		'note',
	),
)); ?>
