<?php
$this->breadcrumbs=array(
	'Purchasings'=>array('admin'),
	'Create',
);


?>

<h1>Create Purchasing</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>