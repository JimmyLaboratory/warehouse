<?php
$this->breadcrumbs=array(
	'Chemlists'=>array('admin'),
	$model->chem_id,
);

$this->menu=array(
        array('label'=>'所有化学品', 'url'=>array('/chemlist/admin')),
        array('label'=>'库存化学品', 'url'=>array('/chemlist/admin','Chemlist'=>array('status'=>  Chemlist::STATUS_INSTOCK))),
        array('label'=>'更改化学品归属教师', 'url'=>array('/chemlist/update','id'=>$model->chem_id), 'visible'=>  User::getInfo()->user_role == 'school')
);
?>

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


<h1 onclick="$(this).next().toggle(0)">化学品信息<span style="font-size:50%"> （点击展开 / 收起）</span></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
        'chem_name',
		array(
            'name'=>'status',       //药品名
            'value'=>Chemlist::getStatusInfo($model->status)
        ),
		array(
            'name'=>'user_id',      //用户名
            'value'=>$model->user->user_name.'【'.$model->user->realname.'】'
        ),
        array(
            'name'=>'学院',         //单位名
            'value'=>$model->user->department->department_name
        ),
        array(
            'name'=>'chemcat_id',   //所属分类
            'value'=>  Chemcat::getLevels($model->chemcat_id)
        ),
		array(
            'name'=>'quality_id',   //质量(优质/顶级)
            'value'=>isset($model->quality->quality_name) ? $model->quality->quality_name : '其它'
        ),
		'quality_other',
        array(
            'name'=>'unit_package', //单位(克/千克)
            'value'=>$model->unit_package.' '.$model->unit->unit_name
        ),
		'nums',                     //数量
		//'production_date',
		'expired',                  //保质期
		'producer',                 //生产商
		array(                      //用途
            'name'=>'useway',
            'value'=>  Chemlist::getUsewayOptions($model->useway)
        ),
        array(                      //使用目的
            'name'=>'使用目的',
            'value'=> $model->purpose
        ),
        /*array(        //供应商bug待修复,如果供应商为空则error
            'name'=>'supplier_id',
            'value'=>''//$model->supplier->supplier_name//.$model->supplier_other
        ),*/
		'supplier_code',            //供应商ID
		'specail_note',             //特殊说明
        'foundation',               //数据测量依据
		'note',                       //备注
        array(
            'name'=>'used',         //已用
            'value'=>$model->used.$model->unit->unit_name
        ),
        array(
            'name'=>'剩余量',
            'value'=> $model->status == Chemlist::STATUS_INSTOCK ? ((float)$model->unit_package * (int)$model->nums - (float)$model->used).$model->unit->unit_name : '/'
        ),
        array(
            'name'=>'storage_id',   //存储仓库
            'value'=>  Storage::getLevels($model->storage_id)
        ),
	),
)); ?>

<h1 onclick="$(this).next().toggle(0)">采购申请信息<span style="font-size:50%"> （点击展开 / 收起）</span></h1>
<?php
$purchasing = Purchasing::model()->find('chem_id='.$model->chem_id);
?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$purchasing,
	'attributes'=>array(
		'purchasing_id',
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
