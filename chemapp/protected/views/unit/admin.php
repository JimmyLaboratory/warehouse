<?php
$this->breadcrumbs=array(
	'Units'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Unit', 'url'=>array('index')),
	array('label'=>'Create Unit', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('unit-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>管理化学品单位</h1>

<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'unit-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'unit_id',
		'unit_name',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
