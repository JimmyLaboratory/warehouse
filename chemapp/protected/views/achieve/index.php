<?php
$this->breadcrumbs=array(
	'Achieves',
);

$this->menu=array(
	array('label'=>'Create Achieve', 'url'=>array('create')),
	array('label'=>'Manage Achieve', 'url'=>array('admin')),
);
?>

<h1>Achieves</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
