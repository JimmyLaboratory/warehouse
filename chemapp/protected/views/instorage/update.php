<?php
$this->breadcrumbs=array(
	'Instorages'=>array('index'),
	$model->instorage_id=>array('view','id'=>$model->instorage_id),
	'Update',
);

$this->menu=array(
	array('label'=>'查看所有入库单', 'url'=>array('admin')),
);
?>

<h1>修改入库信息</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>