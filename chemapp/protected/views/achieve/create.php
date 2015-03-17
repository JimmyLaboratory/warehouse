<?php
$this->breadcrumbs=array(
	'Achieves'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Achieve', 'url'=>array('index')),
	array('label'=>'Manage Achieve', 'url'=>array('admin')),
);
?>

<h1>Create Achieve</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>