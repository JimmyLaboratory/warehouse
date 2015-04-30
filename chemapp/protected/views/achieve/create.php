<?php
$this->breadcrumbs=array(
	'Achieves'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'列出备案', 'url'=>array('admin')),
);
?>

<h1>新建备案单</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'purchasing'=>$purchasing)); ?>