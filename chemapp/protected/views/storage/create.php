<?php
$this->breadcrumbs=array(
	'Storages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'查看所有仓库', 'url'=>array('admin')),
    array('label'=>'返回', 'url'=>array('admin','sid'=>isset($_GET['sid'])? $_GET['sid'] : 0)),
);
?>

<h1>创建仓库</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'sid'=>$sid)); ?>