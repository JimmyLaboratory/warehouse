<?php
$this->breadcrumbs=array(
	'Purchasings'=>array('admin'),
	$model->purchasing_id=>array('view','id'=>$model->purchasing_id),
	'Update',
);


?>

<h1>Update Purchasing <?php echo $model->purchasing_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>