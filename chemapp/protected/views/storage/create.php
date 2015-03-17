<?php
$this->breadcrumbs=array(
	'Storages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'查看所有仓库', 'url'=>array('index')),
        //array('label'=>'返回', 'url'=>array('index','parent_id'=>isset($_GET['parent_id'])? $_GET['parent_id'] : 0)),
);
?>

<h1>创建仓库</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>