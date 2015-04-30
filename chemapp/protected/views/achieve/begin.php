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

<h1>审批通过可备案申购列表</h1>

<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->render('../purchasing/_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'purchasing-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		//'purchasing_id',
        array(
            'class'=>'CLinkColumn',
            'header'=>'申购编号',
            'labelExpression'=>'$data->purchasing_id',
            'urlExpression'=>'Yii::app()->createUrl("achieve/create",array("pid"=>$data->purchasing_id))',
        ),
		array(
            'name'=>'user_id',
            'value'=>'$data->user->realname'
        ),
		array(
            'name'=>'timestamp',
            'value'=>'date("Y-m-d H:i:s",$data->timestamp)'
        ),
		array(
            'name'=>'status',
            'value'=>'Purchasing::getStatusInfo($data->status)'
        ),
		//'information',
		array(
            'visible'=>Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId()) ||
                        Yii::app()->authManager->checkAccess('college',Yii::app()->user->getId()),
            'header'=>'操作',
            'class'=>'CButtonColumn',
            'deleteConfirmation'=>"确定要终止这个采购申请吗?",
            'template'=>'{update}{delete}',
            'buttons'=>array(
                'update' => array(
                    'label'=>'入库',
                    'visible'=>'Yii::app()->authManager->checkAccess("school",Yii::app()->user->getId())',
                    'options'=>array('target'=>'_blank'),
                    'url'=>'Yii::app()->createUrl("instorage/create",array("id"=>$data->purchasing_id))',
                ),
            )
        ),
	),
)); ?>
