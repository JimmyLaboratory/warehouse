<?php
$this->breadcrumbs=array(
	'Chemlists'=>array('admiin'),
	'Create',
);

$this->menu=array(
	array('label'=>'查看化学品', 'url'=>array('/chemlist/admin')),
        array('label'=>'查看采购申请列表', 'url'=>array('/purchasing/admin'))
);
?>

<h1>采购申请表</h1>

<?php echo $this->renderPartial('_apply', array('model'=>$model)); ?>