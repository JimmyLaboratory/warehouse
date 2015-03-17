<?php
$this->breadcrumbs=array(
	'Storages'=>array('index'),
	$model->storage_id=>array('view','id'=>$model->storage_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Storage', 'url'=>array('index')),
	array('label'=>'Create Storage', 'url'=>array('create')),
	array('label'=>'View Storage', 'url'=>array('view', 'id'=>$model->storage_id)),
	array('label'=>'Manage Storage', 'url'=>array('admin')),
);
?>

<h1>修改仓库信息</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>