<?php
$this->breadcrumbs=array(
	'Suppliers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'供应商', 'url'=>array('index')),
	array('label'=>'管理供应商', 'url'=>array('admin')),
);
?>

<h1>创建供应商</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>