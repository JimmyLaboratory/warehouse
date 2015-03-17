<?php
$this->breadcrumbs=array(
	'Outstorages'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'出库单列表', 'url'=>array('admin')),
	array('label'=>'创建出库单', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('outstorage-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>出库列表</h1>
<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'outstorage-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'outstorage_id',
		array('header'=>'申请单编号', 'name'=>'using_id'),
		array('header'=>'领用人', 'name'=>'apply_user_id'),
		'duty_user_id',
		'datetime',
		'note',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
