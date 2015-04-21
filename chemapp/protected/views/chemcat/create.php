<?php
$this->breadcrumbs=array(
	'Chemcats'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'查看所有分类', 'url'=>array('admin')),
	array('label'=>'返回', 'url'=>array('admin','cur_parent_id'=>isset($_GET['cur_parent_id'])? $_GET['cur_parent_id'] : 0)),
);
?>

<h1>添加化学品分类项</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'cur_parent_id'=>$cur_parent_id)); ?>