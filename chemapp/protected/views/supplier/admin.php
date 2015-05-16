<?php
$this->breadcrumbs=array(
	'Suppliers'=>array('index'),
	'Manage',
);

$this->menu=array(
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
	//'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'supplier_name',
			'htmlOptions'=>array('width'=>'100'),
		),
		'contact',
		'tel',
		'com_tel',
		array(
			'name'=>'所属学院',
			'value'=>'$data->user->dname',
			'htmlOptions'=>array('width'=>'100'),
		),
		/*'note',
		*/
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
