<?php

$this->breadcrumbs=array(
	'Purchasings'=>array('admin'),
	$model->purchasing_id,
);

$this->menu=array(
	array('label'=>'取消申请', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->purchasing_id),'confirm'=>'你确定取消这个申请吗?'),'visible'=>Yii::app()->authManager->checkAccess('teacher',Yii::app()->user->getId()) && ($model->status == Purchasing::STATUS_APPLY)),
    array('label'=>'打印表格', 'url'=>array('print','id'=>$model->purchasing_id), 'linkOptions'=>array('target'=>'_blank'), 'visible'=> Yii::app()->authManager->checkAccess('teacher',Yii::app()->user->getId())),
);
?>

<?php
if(Yii::app() -> authManager -> checkAccess('school',Yii::app()->user->getId()) && ($model->status == Purchasing::STATUS_PASS_FINAL || $model->status == Purchasing::STATUS_PURCHASING)):
?>
<h1>审批通过后取消采购申请</h1>
<div class="form">
        <form id="cancel-form" action="index.php?r=purchasing/cancel&id=<?php echo $model->purchasing_id ?>" method="post">
        <div class="row">
                <label for="Purchasing_information" class="required">操作人： </label>	
                <input type="textField" name="Purchasing[person]" value="" /><br />
                <label for="Purchasing_information" class="required">取消采购原因 </label>	
                <textarea rows="2" cols="50" name="Purchasing[reason]" id="Purchasing_information"></textarea>			
        </div>
        <div class="row buttons">
		<input type="submit" name="yt0" value="确认取消采购">	</div>
        </form>
</div>
<script>
        $(function(){
                $('#cancel-form').submit(function(){
                        if(confirm('您确认取消该采购单吗？')) return true;
                        else return false;
                });
        })
</script>
<?php
endif;
?>


<br /><br />
<h1>采购申请信息</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'purchasing_id',
		array(
            'name'=>'user_id',
            'value'=>$model->user->user_name.'【'.$model->user->realname.'】'
        ),
        array(
            'name'=>'学院',
            'value'=>$model->user->dname
        ),
		array(
            'name'=>'timestamp',
            'value'=>date('Y-m-d H:i:s',$model->timestamp)
        ),
        array(
            'name'=>'status',
            'value'=>Purchasing::getStatusInfo($model->status)
        ),
        array(
            'name'=>'information',
            'type'=>'raw',
            'value'=>implode('<br />',array_reverse(json_decode($model->information,true)))//array_reverse为倒置数组函数
        ),
	),
)); ?>

<br /><br />
<h1 onclick="$(this).next().toggle(0)">化学品信息<span style="font-size:50%"> （点击展开 / 收起）</span></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model->chemlist,
	'attributes'=>array(
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
            'value'=>$model->chemlist->user->dname
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
		array(
            'name'=>'useway',
            'value'=>  Chemlist::getUsewayOptions($model->chemlist->useway)
        ),
		'specail_note',
        'foundation',
		'note',
		'used',
        array(
            'name'=>'剩余量',
            'value'=> $model->chemlist->status == Chemlist::STATUS_INSTOCK ? ((float)$model->chemlist->unit_package * (int)$model->chemlist->nums - (float)$model->chemlist->used).$model->chemlist->unit->unit_name : '/'
        ),
		array(
            'name'=>'storage_id',
            'value'=>  Storage::getLevels($model->chemlist->storage_id)
        ),
        array(
            'name'=>'url',          //药品介绍网址
            'type'=>'url',
            'url'=>'$model->chemlist->url'
        ),
        array(
            'name'=>'pics',         //药品样图
            'type'=>'raw',
            'value'=>CHtml::link('<img width="300px" src="upload/'.$model->chemlist->pics.'" />','upload/'.$model->chemlist->pics,array('target'=>'_blank'))
        )
	),
)); ?>
<script type="text/javascript">$('#yw1').hide(0)</script>

<?php
if( ($model->status == Purchasing::STATUS_APPLY && Yii::app() -> authManager -> checkAccess('college',Yii::app()->user->getId())) ||
    ( ($model->status == Purchasing::STATUS_PASS_FIRST || $model->status == Purchasing::STATUS_PASS_SCHOOL) && Yii::app() -> authManager -> checkAccess('secure',Yii::app()->user->getId())) ||
    ( ($model->status == Purchasing::STATUS_PASS_FIRST || $model->status == Purchasing::STATUS_PASS_SECURE) && Yii::app() -> authManager -> checkAccess('school',Yii::app()->user->getId()))
        ):
?>

<br></br>

<h1>审批操作</h1>
<div class="form">
    <form id="purchasing-form" action="index.php?r=purchasing/approve&id=<?php echo $model->purchasing_id ?>" method="post">
    <div class="row">
        <label for="Purchasing_purchasing_id" class="required">
            <input size="20" maxlength="20" name="Purchasing[approve]" id="Purchasing_purchasing_id" type="radio" value="1"  checked="checked"/>同意采购
        </label>
        <label for="Purchasing_chem_id" class="required">
            <input name="Purchasing[approve]" id="Purchasing_chem_id" type="radio" value="-1" />拒绝采购
        </label>
    </div>

    <div class="row">
        <label>录入人：</label>
        <input type="textField" name="Purchasing[inputer]" value="<?php echo User::getInfo()->realname; ?>" /><br />
        <label>审批人：</label>
        <input type="textField" name="Purchasing[person1]" value="" /><br />
        
        <label for="Purchasing_information" class="required">审批意见：</label>
        <textarea rows="2" cols="50" name="Purchasing[reason1]" id="Purchasing_information"></textarea>
    </div>
    <!--<div class="row">
                    审批人1：<input type="textField" name="Purchasing[person1]" value="" /><br />
        <label for="Purchasing_information" class="required">审批意见1 </label> 
                    <textarea rows="2" cols="50" name="Purchasing[reason1]" id="Purchasing_information"></textarea>         
            </div>-->
                    
 
            <div class="row" style="display:none">
                    审批人3：<input type="textField" name="Purchasing[person3]" value="" /><br />
        <label for="Purchasing_information" class="required">审批意见3 </label> 
                    <textarea rows="2" cols="50" name="Purchasing[reason3]" id="Purchasing_information"></textarea>         
            </div>

    <div class="row buttons" style="text-align:center">
        <input type="submit" name="yt0" value="提交">
    </div>
</form>
</div>
<?php endif; ?>
