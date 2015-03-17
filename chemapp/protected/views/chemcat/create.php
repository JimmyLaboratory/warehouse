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

<h1>管理化学品分类</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>