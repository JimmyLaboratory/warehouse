<?php
$this->breadcrumbs=array(
	'Outstorages'=>array('index'),
	$model->outstorage_id=>array('view','id'=>$model->outstorage_id),
	'Update',
);

$this->menu=array(
	array('label'=>'出库单列表', 'url'=>array('admin')),
	array('label'=>'创建出库单', 'url'=>array('create')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>