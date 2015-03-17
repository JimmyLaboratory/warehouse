<?php
$this->breadcrumbs=array(
	'Achieves'=>array('index'),
	'Manage',
);

/*$this->menu=array(
	array('label'=>'无'),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('achieve-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>备案单列表</h1>

<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'achieve-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'achieve_id',
		array('name'=>'timestamp','value'=>'date("Y-m-d H:i:s",$data->timestamp)'),
		'achiever',
		'note',
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{view}'
		),
	),
)); ?>
