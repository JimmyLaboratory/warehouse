<?php
$this->breadcrumbs=array(
	'Storages',
);

$this->menu=array(
	array('label'=>'添加仓库', 'url'=>array('create','current_id'=>isset($_GET['parent_id'])? $_GET['parent_id'] : 0)),
);
?>

<h1>查看仓库</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
