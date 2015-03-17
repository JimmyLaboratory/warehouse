<?php
$this->breadcrumbs=array(
	'Suppliers',
);

$this->menu=array(
	array('label'=>'创建供应商', 'url'=>array('create')),
	array('label'=>'管理供应商', 'url'=>array('admin')),
);
?>

<h1>供应商</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
