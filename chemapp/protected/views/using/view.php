<?php
$this->breadcrumbs=array(
	'Usings'=>array('index'),
	$model->using_id,
);

$this->menu=array(
	array('label'=>'取消申请', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->using_id),'confirm'=>'你确定取消这个申请吗?'),'visible'=>($model->status == Using::STATUS_APPLY)),
        array('label'=>'打印表格', 'url'=>array('print','id'=>$model->using_id), 'linkOptions'=>array('target'=>'_blank'), 'visible'=> Yii::app()->authManager->checkAccess('teacher',Yii::app()->user->getId())),
);
?>

<?php
if( ($model->status == Using::STATUS_APPLY && Yii::app() -> authManager -> checkAccess('college',Yii::app()->user->getId())) ||
    ($model->status == Using::STATUS_APPROVE_FIRST && Yii::app() -> authManager -> checkAccess('school',Yii::app()->user->getId()))
        ):
?>
<h1>审批操作</h1>
<div class="form">
        <form id="purchasing-form" action="index.php?r=using/approve&id=<?php echo $model->using_id ?>" method="post">

	<div class="row">
		<label for="Using_using_id" class="required">
			<input name="Using[approve]" id="Using_using_id" type="radio" value="1" />同意使用
		</label>
		<label for="Using_chem_id" class="required">
			<input name="Using[approve]" id="Using_chem_id" type="radio" value="-1" />拒绝使用
		</label>
	</div>

	<div class="row">
		<label>审批人：</label>
		<input type="textField" name="Using[person1]" value="<?php echo User::getInfo()->realname; ?>" /><br />
		<label for="Using_information" class="required">审批意见 </label>		
		<textarea rows="2" cols="50" name="Using[reason1]" id="Using_information"></textarea>			
	</div>

	<!-- <div class="row">
                审批人1：<input type="textField" name="Using[person1]" value="" /><br />
		<label for="Using_information" class="required">审批意见1 </label>		
                <textarea rows="2" cols="50" name="Using[reason1]" id="Using_information"></textarea>			
        </div> -->
                
        <div class="row" style="display:none">
                审批人2：<input type="textField" name="Using[person2]" value="" /><br />
		<label for="Using_information" class="required">审批意见2 </label>		
                <textarea rows="2" cols="50" name="Using[reason2]" id="Using_information"></textarea>			
        </div>
                
        <div class="row" style="display:none">
                审批人3：<input type="textField" name="Using[person3]" value="" /><br />
		<label for="Using_information" class="required">审批意见3 </label>		
                <textarea rows="2" cols="50" name="Using[reason3]" id="Using_information"></textarea>			
        </div>

	<div class="row buttons" style="text-align:center">
		<input type="submit" name="yt0" value="审批">	</div>
</form>
</div>
<?php endif; ?>

<br /><br />

<h1 onclick="$(this).next().toggle(0)">使用申请单详细<span style="font-size:50%"> （点击展开 / 收起）</span></h1>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'using_id',
		array(
                    'name'=>'chem_id',
                    'value'=>$model->chemlist->chem_name
                ),
                array(
                    'name'=>'user_id',
                    'value'=>$model->user->user_name.'【'.$model->user->realname.'】'
                ),
                array(
                    'name'=>'timestamp',
                    'value'=>date('Y-m-d H:i:s',$model->timestamp)
                ),
                array(
                    'name'=>'applyuse',
                    'value'=>$model->applyuse.$model->chemlist->unit->unit_name
                ),
		'reason',
		'use_start',
		array(
                    'name'=>'useway',
                    'value'=>  Chemlist::getUsewayOptions($model->useway)
                ),
		'junk',
                array(
                    'name'=>'status',
                    'value'=>  Using::getStatusInfo($model->status)
                ),
		array(
                    'name'=>'information',
                    'type'=>'raw',
                    'value'=>implode('<br />',json_decode($model->information,true))
                ),
	),
)); ?>


<h1 onclick="$(this).next().toggle(0)">化学品信息<span style="font-size:50%"> （点击展开 / 收起）</span></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model->chemlist,
	'attributes'=>array(
		'chem_id',
                'chem_name',
		array(
                    'name'=>'status',
                    'value'=>Chemlist::getStatusInfo($model->chemlist->status)
                ),
		array(
                    'name'=>'user_id',
                    'value'=>$model->chemlist->user->user_name.'【'.$model->user->realname.'】'
                ),
                array(
                    'name'=>'学院',
                    'value'=>$model->chemlist->user->department->department_name
                ),
                array(
                    'name'=>'chemcat_id',
                    'value'=>  Chemcat::getLevels($model->chemlist->chemcat_id)
                ),
		array(
                    'name'=>'quality_id',
                    'value'=>isset($model->chemlist->quality->quality_name) ? $model->chemlist->quality->quality_name : '其它'
                ),
		'quality_other',
                array(
                    'name'=>'unit_package',
                    'value'=>$model->chemlist->unit_package.' '.$model->chemlist->unit->unit_name
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
                    'value'=>$model->chemlist->supplier->supplier_name.$model->chemlist->supplier_other
                ),
		'supplier_code',
		'specail_note',
                'foundation',
		'note',
		'used',
		array(
                    'name'=>'storage_id',
                    'value'=>  Storage::getLevels($model->chemlist->storage_id)
                ),
	),
)); ?>


<h1 onclick="$(this).next().toggle(0)">采购申请详细<span style="font-size:50%"> （点击展开 / 收起）</span></h1>
<?php
$purchasing = Purchasing::model()->find('chem_id='.$model->chemlist->chem_id);
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
                    'value'=>implode('<br />',array_reverse(json_decode($purchasing->information,true)))
                ),
	),
)); ?>