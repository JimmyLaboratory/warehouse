<?php
$this->breadcrumbs=array(
	'Chemcats'=>array('index'),
	$model->cat_id,
);


?>

<h1>View Chemcat #<?php echo $model->cat_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'cat_id',
		'chemcat_name',
		'parent_id',
	),
)); ?>
