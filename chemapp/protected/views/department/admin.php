<?php
$this->breadcrumbs=array(
	'Departments'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'部门信息', 'url'=>array('index')),
	array('label'=>'添加新部门', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('department-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>部门信息管理</h1>

<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'department-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'department_id',
		'department_name',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
