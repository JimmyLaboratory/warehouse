<?php
$this->breadcrumbs=array(
	'Usings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'全部申请', 'url'=>array('/using/admin')),
	//array('label'=>'待审批申请', 'url'=>array('/using/admin','status'=>'APPROVE')),
    array('label'=>'可领取申请', 'url'=>array('/using/admin','status'=>'BEPICK')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('using-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>化学品使用申请</h1>

<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'using-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'CLinkColumn',
			'header'=>'申请使用单编号',
            'labelExpression'=>'$data->using_id',
            'urlExpression'=>'Yii::app()->createUrl("using/view",array("id"=>$data->using_id))',
        ),
		array(
            'name'=>'chem_id',			//药品名
            'value'=>'$data->chemlist->chem_name'
        ),
        
        array(
            'name'=>'user_id',			//申请人
            'value'=>'$data->user->realname'
        ),
		array(
            'name'=>'timestamp',
            'value'=>'date("Y-m-d H:i:s",$data->timestamp)'
        ),
		array(
            'name'=>'applyuse',			//申请使用量
            'value'=>'$data->applyuse.$data->chemlist->unit->unit_name'
        ),
		'reason',						//申请原因
		/*
		'use_start',
		'useway',
		'junk',
		'status',
		'information',
		*/
		array(
            'name'=>'status',			//审批状态
            'value'=>'Using::getStatusInfo($data->status)'
        ),
	),
)); ?>
