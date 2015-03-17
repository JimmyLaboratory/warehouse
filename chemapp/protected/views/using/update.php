<?php
$this->breadcrumbs=array(
	'Usings'=>array('index'),
	$model->using_id=>array('view','id'=>$model->using_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Using', 'url'=>array('index')),
	array('label'=>'Create Using', 'url'=>array('create')),
	array('label'=>'View Using', 'url'=>array('view', 'id'=>$model->using_id)),
	array('label'=>'Manage Using', 'url'=>array('admin')),
);
?>

<h1>Update Using <?php echo $model->using; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>