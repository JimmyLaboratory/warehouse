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
	//'filter'=>$model,
	'columns'=>array(
		//'outstorage_id',
		array('header'=>'申请单编号', 'name'=>'using_id'),
		array('header'=>'领用人', 'name'=>'apply_user_id'),
		//'duty_user_id',  显示数字而不是人名
		array(
		'header'=>'领用时间', 'name'=>'datetime',
		'htmlOptions'=>array(//设置单元格宽度
				'width'=>'100',
			),
		),
		//'datetime',
		array(
			'class'=>'CButtonColumn',
			'header'=>'操作',
			'viewButtonImageUrl'=>array('style'=>'display:none'), 
			'template'=>'{view}',
			'buttons'=>array(
				'view'=>array(
				'label'=>'查看',
				)
			)
		),
		array(
			'class'=>'CButtonColumn',
			'header'=>'操作',
			'deleteButtonImageUrl'=>array('style'=>'display:none'), 
			'template'=>'{delete}',
			'buttons'=>array(
				'delete'=>array(
				'label'=>'删除',
				)
			)
		),
		
		array(
			'class'=>'CButtonColumn',
			'header'=>'操作',
			'updateButtonImageUrl'=>array('style'=>'display:none'), 
			'template'=>'{update}',
			'buttons'=>array(
				'update'=>array(
				'label'=>'修改',
				)
			)
		),
	),
)); ?>
