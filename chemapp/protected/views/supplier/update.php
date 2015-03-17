<?php
$this->breadcrumbs=array(
	'Suppliers'=>array('index'),
	$model->supplier_id=>array('view','id'=>$model->supplier_id),
	'Update',
);

$this->menu=array(
	array('label'=>'供应商', 'url'=>array('index')),
	array('label'=>'创建供应商', 'url'=>array('create')),
	array('label'=>'查看此供应商', 'url'=>array('view', 'id'=>$model->supplier_id)),
	array('label'=>'管理供应商', 'url'=>array('admin')),
);
?>

<h1>修改供应商信息</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>