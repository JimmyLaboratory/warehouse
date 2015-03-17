<?php
$this->breadcrumbs=array(
	'Instorages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'查看所有入库单', 'url'=>array('admin')),
);
?>

<h1>化学品入库</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>