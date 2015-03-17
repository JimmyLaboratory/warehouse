<?php
$this->breadcrumbs=array(
	'Chemlists'=>array('admin'),
	'Manage',
);

$this->menu=array(
        array('label'=>'查看所有化学品', 'url'=>array('/chemlist/admin')),
        array('label'=>'已入库化学品', 'url'=>array('/chemlist/admin','Chemlist'=>array('status'=>  Chemlist::STATUS_INSTOCK)))
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('chemlist-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>查看化学品</h1>

<p>
这里显示的是属于你的化学品，单击<img src="/warehouse/chemapp/assets/de002d6/gridview/update.png" alt="申请使用">申请使用你的药品，同时你还可以在输入框中输入信息进行筛选。
</p>

<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'chemlist-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
                'chem_name',
                array(
                    'name'=>'status',
                    'value'=>'Chemlist::getStatusInfo($data->status)'
                ),
		array(
                    'name'=>'user_id',
                    'value'=>'$data->user->realname."(".$data->user->department->department_name.")"'
                ),
                array(
                    'name'=>'used',
                    'header'=>'剩余量',
                    'value'=>'$data->status == Chemlist::STATUS_INSTOCK ? ((float)$data->unit_package * (int)$data->nums - (float)$data->used).$data->unit->unit_name : "/"'
                ),
                array(
                    'name'=>'storage_id',
                    'value'=>  'Storage::getLevels($data->storage_id)'
                ),
		//'chemcat_id',
		//'quality_id',
		//'quality_other',
		/*
		'unit_package',
		'unit_id',
		'nums',
		//'production_date',
		'expired',
		'producer',
		'useway',
		'supplier_id',
		'supplier_code',
		'supplier_other',
		'specail_note',
		'note',
		'used',
		'storage_id',
		*/
		array(
			'visible'=>Yii::app()->authManager->checkAccess('teacher',Yii::app()->user->getId()),
			'class'=>'CButtonColumn',
                        'header' => '操作',  
                        'template'=>'{view}{update}', 
                        'updateButtonLabel'=>'申请使用',
                        'updateButtonUrl'=>'$data->status != Chemlist::STATUS_INSTOCK ? "javascript:alert(\"化学品未处于在库状态，不能申请\")" : Yii::app()->createUrl("using/create",array("id"=>$data->chem_id))'
		),
                array(
                        'visible'=>!Yii::app()->authManager->checkAccess('teacher',Yii::app()->user->getId()),
			'class'=>'CButtonColumn',
                        'header' => '操作',  
                        'template'=>'{view}'
               ),
	),
)); ?>
