<?php
$this->breadcrumbs=array(
	'Outstorages',
);

$this->menu=array(
	array('label'=>'出库单列表', 'url'=>array('admin')),
	array('label'=>'创建出库单', 'url'=>array('create')),
);
?>

<h1>出库</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
