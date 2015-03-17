<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'管理用户', 'url'=>array('admin')),
);
?>

<h1>创建用户</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>