<?php
$this->breadcrumbs=array(
	'Chemlists'=>array('admin'),
	'Create',
);

$this->menu=array(
        array('label'=>'查看所有化学品', 'url'=>array('/chemlist/admin')),
        array('label'=>'已入库化学品', 'url'=>array('/chemlist/admin','Chemlist'=>array('status'=>  Chemlist::STATUS_INSTOCK)))
);
?>

<h1>Create Chemlist</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>