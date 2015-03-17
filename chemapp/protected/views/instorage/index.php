<?php
$this->breadcrumbs=array(
	'Instorages',
);

$this->menu=array(
	array('label'=>'查看所有入库单', 'url'=>array('admin')),
);
?>

<h1>入库</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
