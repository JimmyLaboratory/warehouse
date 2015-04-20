<?php
$this->breadcrumbs=array(
	'Chemcats'=>array('index'),
	$model->cat_id=>array('view','id'=>$model->cat_id),
	'Update',
);


?>

<h1>修改分类/药品名 </h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>