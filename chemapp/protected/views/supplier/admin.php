<?php
$this->breadcrumbs=array(
	'Suppliers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'供应商', 'url'=>array('index')),
	array('label'=>'创建供应商', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('supplier-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>管理供应商</h1>

<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'supplier-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'supplier_id',
		'supplier_name',
		'website',
		'email',
		'contact',
		'tel',
		'person',
		'personaltel',
		/*'note',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
