<?php
        /*确认生成采购单页面
		LTJ编于2015年5月14日09:57:03
		从已备案的申购页面传来的申购单
		找出对应的申购信息，化学品信息，备案信息，合起来显示出来
		最后给出按钮确认生成采购单
		确认提交confirm参数给控制器
		后台找到对应申购单，自动添加其purchase_no(采购单编号)
		并将其状态改为采购中

		需要改进的地方是需要添加生成采购单时间记录
		*/
?>
<?php
$this->breadcrumbs=array(
	'Purchasings'=>array('admin'),
	'Manage',
);

$this->menu=array(
        array('label'=>'返回', 'url'=>array('/purchasing/purchase_admin')),
);
?>

<h1>生成采购清单</h1>



<form action="<?php echo Yii::app()->createUrl('purchasing/topurchase',array('confirm'=>'true','id'=>$id)) ?>" method="post">
</form>
    <?php if(!isset($_GET['supplier_id'])): ?>
    <div class="row">
        <label >请选择供应商：</label>
        <span>
            <?php //测试下拉菜单选择供应商
                echo CHtml::dropDownList('chooseSupplier','',$supplier->getSupplierDropListArray());
            ?>
        </span>
    </div>
    <?php 
        else :{
            $this->renderPartial('../supplier/_form',array(
                'model'=>$supplier,'id'=>$id));
        }   
        endif; 
    ?>

    <!--TJ:Ajax来通过选择框的改变自动填写表格数据 -->
    <script type="text/javascript">
    $(document).ready(function(){
        $('.form').css('id','supplierForm');
        $('#chooseSupplier > option').click(function(){
            location.href=window.location.href+"&supplier_id="+$(this).val();
        });
    });
    </script>

    <!--input type="submit" value="确认生成采购单" class="submitbutton"/ -->

</p>

<h1>备案单详情</h1>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$archive,			//备案单
	'attributes'=>array(
		'purchasing_id',
		'achiever',
		array(
			'name'=>'timestamp',
			'value'=>date('Y-m-d H:i:s',$model->timestamp)
		),
		'contractID',
		'purpose',
		'note',
	),
)); 
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
            'value'=>implode('<br />',json_decode($model->information,true))
        ),
	),
)); ?>

<br /><br />
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
		'producer',
		array(
            'name'=>'useway',
            'value'=>  Chemlist::getUsewayOptions($model->chemlist->useway)
        ),
        @array(
            'name'=>'supplier_id',
            'value'=>$model->chemlist->supplier->supplier_name.$model->chemlist->supplier_other
        ),
		'supplier_code',
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
            'value'=>CHtml::link('<img width="500px" src="upload/'.$model->chemlist->pics.'" />','upload/'.$model->chemlist->pics,array('target'=>'_blank'))
        )
	),
)); ?>
<script type="text/javascript">$('#yw2').hide(0)</script>
