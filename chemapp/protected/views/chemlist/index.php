<?php
$this->breadcrumbs=array(
	'Chemlists',
);

$this->menu=array(
        array('label'=>'查看所有化学品', 'url'=>array('/chemlist/admin')),
        array('label'=>'已入库化学品', 'url'=>array('/chemlist/admin','Chemlist'=>array('status'=>  Chemlist::STATUS_INSTOCK)))
);
?>

<h1>Chemlists</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
