<?php
$this->breadcrumbs=array(
	'Usings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'使用申请单列表', 'url'=>array('admin')),
);
?>

<h1>使用申请表</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>