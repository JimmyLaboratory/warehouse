<?php
$this->breadcrumbs=array(
	'Chemcats'=>array('index'),
	$model->cat_id=>array('view','id'=>$model->cat_id),
	'Update',
);


?>

<h1>Update Chemcat <?php echo $model->cat_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>