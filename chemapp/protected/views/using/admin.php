<?php
$this->breadcrumbs=array(
	'Usings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'显示所有申请', 'url'=>array('/using/admin')),
	array('label'=>'只显示待审批的', 'url'=>array('/using/admin','status'=>'APPROVE')),
        array('label'=>'只显示待领取的', 'url'=>array('/using/admin','status'=>'BEPICK')),
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
	'filter'=>$model,
	'columns'=>array(
		'using_id',
		array(
                    'name'=>'chem_id',
                    'value'=>'$data->chemlist->chem_name'
                ),
                array(
                    'name'=>'status',
                    'value'=>'Using::getStatusInfo($data->status)'
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
                    'name'=>'applyuse',
                    'value'=>'$data->applyuse.$data->chemlist->unit->unit_name'
                ),
		'reason',
		/*
		'use_start',
		'useway',
		'junk',
		'status',
		'information',
		*/
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array(
                                'view' => array(
                                    'label'=>'查看',
                                    'options'=>array('target'=>'_blank'),
                                ),
                            ),
		),
	),
)); ?>
