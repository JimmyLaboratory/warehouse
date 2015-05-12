<?php
$this->breadcrumbs=array(
	'Instorages'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'创建入库单', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('instorage-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>入库列表</h1>

<?php echo CHtml::link('搜索','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'instorage-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'CLinkColumn',
			'labelExpression'=>'$data->purchasing_id',
			'header'=>'采购单编号',
			'urlExpression'=>'Yii::app()->createUrl("instorage/view",array("id"=>$data->instorage_id))'
		),
		'verifydate',
		'expired',
		/*
		'weight',
		'nums',
		'storage_id',
		'note',
		'pics',
		*/
		array(
			'header'=>'操作',
			'class'=>'CButtonColumn',
			'updateButtonImageUrl'=>array('style'=>'display:none'), 
			'template'=>'{update}',
			 'buttons'=>array(
                'update' => array(
                    'label'=>'更新',
                )
            ),
		),
		
		array(
			'header'=>'操作',
			'class'=>'CButtonColumn',
			'deleteButtonImageUrl'=>array('style'=>'display:none'), 
			'template'=>'{delete}',
			 'buttons'=>array(
                'delete'=>array(
                    'label'=>'删除',
                )
            ),
		),
	),
)); ?>
