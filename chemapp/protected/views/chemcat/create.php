<?php
$this->breadcrumbs=array(
	'Chemcats'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'查看所有分类', 'url'=>array('index')),
        array('label'=>'返回', 'url'=>array('index','parent_id'=>isset($_GET['parent_id'])? $_GET['parent_id'] : 0)),
);
?>

<h1>添加化学品分类项</h1>

<?php echo $this->renderPartial('create_form', array('model'=>$model,'cur_parent_id'=>$cur_parent_id)); ?>