<?php
$this->breadcrumbs=array(
	'Chemlists'=>array('admin'),
	$model->chem_id,
);

$this->menu=array(
        array('label'=>'查看所有化学品', 'url'=>array('/chemlist/admin')),
        array('label'=>'已入库化学品', 'url'=>array('/chemlist/admin','Chemlist'=>array('status'=>  Chemlist::STATUS_INSTOCK))),
        array('label'=>'更改化学品归属教师', 'url'=>array('/chemlist/update','id'=>$model->chem_id), 'visible'=>  User::getInfo()->user_role == 'school')
);
?>

<h1>化学品信息</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'chem_id',
                'chem_name',
		array(
                    'name'=>'status',
                    'value'=>Chemlist::getStatusInfo($model->status)
                ),
		array(
                    'name'=>'user_id',
                    'value'=>$model->user->user_name.'【'.$model->user->realname.'】'
                ),
                array(
                    'name'=>'学院',
                    'value'=>$model->user->department->department_name
                ),
                array(
                    'name'=>'chemcat_id',
                    'value'=>  Chemcat::getLevels($model->chemcat_id)
                ),
		array(
                    'name'=>'quality_id',
                    'value'=>isset($model->quality->quality_name) ? $model->quality->quality_name : '其它'
                ),
		'quality_other',
                array(
                    'name'=>'unit_package',
                    'value'=>$model->unit_package.' '.$model->unit->unit_name
                ),
		'nums',
		//'production_date',
		'expired',
		'producer',
		array(
                    'name'=>'useway',
                    'value'=>  Chemlist::getUsewayOptions($model->useway)
                ),
                array(
                    'name'=>'supplier_id',
                    'value'=>$model->supplier->supplier_name.$model->supplier_other
                ),
		'supplier_code',
		'specail_note',
                'foundation',
		'note',
                array(
                    'name'=>'used',
                    'value'=>$model->used.$model->unit->unit_name
                ),
                array(
                    'name'=>'剩余量',
                    'value'=> $model->status == Chemlist::STATUS_INSTOCK ? ((float)$model->unit_package * (int)$model->nums - (float)$model->used).$model->unit->unit_name : '/'
                ),
                array(
                    'name'=>'storage_id',
                    'value'=>  Storage::getLevels($model->storage_id)
                ),
	),
)); ?>

<h1>采购申请信息</h1>
<?php
$purchasing = Purchasing::model()->find('chem_id='.$model->chem_id);
?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$purchasing,
	'attributes'=>array(
		'purchasing_id',
		'chem_id',
		array(
                    'name'=>'user_id',
                    'value'=>$purchasing->user->user_name.'【'.$purchasing->user->realname.'】'
                ),
                array(
                    'name'=>'学院',
                    'value'=>$purchasing->user->department->department_name
                ),
		array(
                    'name'=>'timestamp',
                    'value'=>date('Y-m-d H:i:s',$purchasing->timestamp)
                ),
                array(
                    'name'=>'status',
                    'value'=>Purchasing::getStatusInfo($purchasing->status)
                ),
                array(
                    'name'=>'information',
                    'type'=>'raw',
                    'value'=>implode('<br />',json_decode($purchasing->information,true))
                ),
	),
)); ?>


<h1>使用申请</h1>
<?php
$using = new Using;
$using -> chem_id = $model -> chem_id;
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'using-grid',
	'dataProvider'=>$using->search(),
	'filter'=>$using,
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