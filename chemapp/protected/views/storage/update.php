<?php
$this->breadcrumbs=array(
	'Storages'=>array('index'),
	$model->storage_id=>array('view','id'=>$model->storage_id),
	'Update',
);

$pid=$model->parent_id;
$this->menu=array(
	array('label'=>'返回', 'url'=>array('admin','sid'=>$pid)),
);
?>

<h1>修改仓库信息</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>