<?php
$this->breadcrumbs=array(
	'Achieves'=>array('index'),
	$model->achieve_id=>array('view','id'=>$model->achieve_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Achieve', 'url'=>array('index')),
	array('label'=>'Create Achieve', 'url'=>array('create')),
	array('label'=>'View Achieve', 'url'=>array('view', 'id'=>$model->achieve_id)),
	array('label'=>'Manage Achieve', 'url'=>array('admin')),
);
?>

<h1>Update Achieve <?php echo $model->achieve_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>