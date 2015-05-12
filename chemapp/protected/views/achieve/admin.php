<?php
$this->breadcrumbs=array(
	'Achieves'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'开始备案','url'=>array('/achieve/begin','Purchasing[status]'=> Purchasing::STATUS_PASS_FINAL)),
	array('label'=>'正在备案','url'=>array('/achieve/admin','status'=>Achieve::STATUS_SENDING)),
	array('label'=>'完成备案','url'=>array('/achieve/admin','status'=>Achieve::STATUS_SUCCESS)),
	array('label'=>'备案失败','url'=>array('/achieve/admin','status'=>Achieve::STATUS_FAILED)),
);

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
	'dataProvider'=>$model->searchByStatus($status),
	//'filter'=>$model,
	'columns'=>array(
		//'purchasing_id',
		//'achieve_id',
		array(
			'class'=>'CLinkColumn',
			'header'=>'申购单编号',
			'labelExpression'=>'$data->purchasing_id',		//显示内容
			'linkHtmlOptions'=>array('title'=>'点击完成备案'),		//鼠标停留时显示字符框
			'urlExpression'=>'Yii::app()->controller->createUrl("update", array("id"=>$data->primaryKey,))'//显示URL
		),
		array('name'=>'timestamp','value'=>'date("Y-m-d H:i:s",$data->timestamp)'),
		'achiever',
		'note',
		array('name'=>'status','value'=>'Achieve::getStatusInfo($data->status)'),
		array(
			'class'=>'CButtonColumn',
			'header'=>'操作',
			'viewButtonImageUrl'=>array('style'=>'display:none'), 
            'template'=>'{view}',
            'buttons'=>array(
            	'view'=>array('label'=>'打印','url'=>'Yii::app()->createUrl("achieve/print",array("id"=>$data->id))','options'=>array('target'=>'_blank')),
            )
		),
	),
)); ?>
