<?php
$this->breadcrumbs=array(
	'Units'=>array('index'),
	$model->unit_id=>array('view','id'=>$model->unit_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Unit', 'url'=>array('index')),
	array('label'=>'Create Unit', 'url'=>array('create')),
	array('label'=>'View Unit', 'url'=>array('view', 'id'=>$model->unit_id)),
	array('label'=>'Manage Unit', 'url'=>array('admin')),
);
?>

<h1>修改化学品单位</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>