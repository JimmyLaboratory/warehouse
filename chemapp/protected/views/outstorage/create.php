<?php
$this->breadcrumbs=array(
	'Outstorages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'出库单列表', 'url'=>array('admin')),
	array('label'=>'创建出库单', 'url'=>array('create')),
);
?>

<h1>出库记录</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>