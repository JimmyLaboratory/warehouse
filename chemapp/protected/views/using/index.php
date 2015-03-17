<?php
$this->breadcrumbs=array(
	'Usings',
);

$this->menu=array(
	array('label'=>'Create Using', 'url'=>array('create')),
	array('label'=>'Manage Using', 'url'=>array('admin')),
);
?>

<h1>Usings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
