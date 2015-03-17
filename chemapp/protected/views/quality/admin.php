<?php
$this->breadcrumbs=array(
	'Qualities'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Quality', 'url'=>array('index')),
	array('label'=>'Create Quality', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('quality-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>管理规格</h1>

<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'quality-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'quality_id',
		'quality_name',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
