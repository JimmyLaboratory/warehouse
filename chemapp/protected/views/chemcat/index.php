<?php
$this->breadcrumbs=array(
	'Chemcats',
);

$this->menu=array(
	array('label'=>'在此分类下创建子分类', 'url'=>array('create','current_id'=>isset($_GET['parent_id'])? $_GET['parent_id'] : 0)),
);
?>

<h1>管理化学品分类</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
