<?php
$this->breadcrumbs=array(
	'Purchasings'=>array('admin'),
	'Manage',
);

$this->menu[]=array('label'=>'待审批的申请', 'url'=>array('/purchasing/admin','status'=>'APPROVE'));

if(Yii::app()->authManager->checkAccess('teacher',Yii::app()->user->getId()))
$this->menu=array(
    //教师用户查看采购申请的左边快捷链接
    array('label'=>'审批完成的申请', 'url'=>array('/purchasing/admin','Purchasing[status]'=> Purchasing::STATUS_PASS_FINAL)),
    array(
        'label'=>'开始新的申购',
        'url'=>array('/purchasing/apply'),
    ),
);
if(Yii::app()->authManager->checkAccess('college',Yii::app()->user->getId()))
$this->menu=array(
    //学院用户查看申请采购页面左边快捷链接
    array('label'=>'学院审批完成的申请', 'url'=>array('/purchasing/admin','Purchasing[status]'=> Purchasing::STATUS_PASS_FIRST)),
);
if(Yii::app()->authManager->checkAccess('secure',Yii::app()->user->getId()))
$this->menu=array(
    //保卫处用户查看...
    array('label'=>'保卫处审批完成的申请', 'url'=>array('/purchasing/admin','Purchasing[status]'=> Purchasing::STATUS_PASS_SECURE)),
);
if(Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId()))
$this->menu=array(
    //学校用户查看申请采购页面左边快捷链接 
    array('label'=>'学校审批完成的申请', 'url'=>array('/purchasing/admin','Purchasing[status]'=> Purchasing::STATUS_PASS_SCHOOL)),
);
$this->menu[]=array('label'=>'最终审批完成的申请', 'url'=>array('/purchasing/admin','Purchasing[status]'=> Purchasing::STATUS_PASS_FINAL));
$this->menu[]=array('label'=>'采购中', 'url'=>array('/purchasing/admin','Purchasing[status]'=>  Purchasing::STATUS_PURCHASING));
$this->menu[]= array('label'=>'被拒申请', 'url'=>array('/purchasing/admin','Purchasing'=>array('status'=>  Purchasing::STATUS_REJECT)));
$this->menu[]= array('label'=>'所有申请', 'url'=>array('/purchasing/admin'));

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('purchasing-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>查看采购申请</h1>
<!--
<p>
你可以在这里查看到所有采购申请，单击<img src="assets/de002d6/gridview/view.png" alt="申请使用">可以进行审批和查看详细的采购单信息。
</p>
-->
<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'purchasing-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
        array(
            'class'=>'CCheckBoxColumn',
            'selectableRows'=>'10',
            'visible'=>Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId())
        ),
		//'purchasing_id',
        array(
            'class'=>'CLinkColumn',
            'header'=>'申购编号',
            'labelExpression'=>'$data->purchasing_id',
            'urlExpression'=>'Yii::app()->createUrl("purchasing/view",array("id"=>$data->purchasing_id, "refer"=>"purchase"))',
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
                'delete'=>array(
                    'label'=>'终止',
                    'visible'=>'Yii::app()->authManager->checkAccess("college",Yii::app()->user->getId())',
                    'url'=>'Yii::app()->createUrl("purchasing/cancel",array("id"=>$data->purchasing_id))',
                    /*'click'=>'function(){
                        var reason=prompt("请输入终止理由","");
                        if(confirm("确定终止"))
                            if(reason){
                                var ExportForm = document.createElement("FORM");  
                                document.body.appendChild(ExportForm);  
                                ExportForm.method = "POST";  
                                var newElement = document.createElement("input");  
                                newElement.setAttribute("reason", "sn");  
                                newElement.setAttribute("type", "hidden");  
                                ExportForm.appendChild(newElement);  
                                newElement.value = reason;  
                                ExportForm.action = $(this).url;  
                                ExportForm.submit(); 
                            }
                            else
                                alert("no reason");
                    }'*/
                )
            ),
		),
	),
)); ?>


<?php if(
	Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId())
	&& (
		!isset($_GET['status']) ||
		(isset($_GET['status']) && $_GET['status'] !== 'APPROVE')
	)
): ?>
<p style="text-align:center">温馨提示：通过审批的采购，才能生成采购单！！！</p>
<!--

<div>操作选中项<select class="handerSelection"><option value="0">请选择操作</option><option value="1">生成备案单</option><option value="2">生成采购单</option><option value="3">打印采购单</option></select></div>
<form method="post" id="hander" action=""><input type="hidden" id="ids" name="ids"></input></form>
 <script>
        $(function(){
                $('.handerSelection').change(function(){
                        if($(this).val() == '0') return false;
                        if($(this).val() == '1'){
                                //生成备案单
                                $('#hander').attr('action','index.php?r=purchasing/toachieve');
                                var ids = '';
                                $('[name="purchasing-grid_c0[]"]:checked').each(function(){
                                        ids += $(this).val()+',';
                                })
                                $('#ids').val(ids);
                                $('#hander').submit();
                        }
                        if($(this).val() == '2'){
                                //生成采购单
                                $('#hander').attr('action','index.php?r=purchasing/topurchase');
                                var ids = '';
                                $('[name="purchasing-grid_c0[]"]:checked').each(function(){
                                        ids += $(this).val()+',';
                                })
                                $('#ids').val(ids);
                                $('#hander').submit();
                        }
                        if($(this).val() == '3'){
                                //生成采购单
                                $('#hander').attr('action','index.php?r=purchasing/purchasePrint');
                                var ids = '';
                                $('[name="purchasing-grid_c0[]"]:checked').each(function(){
                                        ids += $(this).val()+',';
                                })
                                $('#ids').val(ids);
                                $('#hander').submit();
                        }
                });
        });
</script>
-->
<?php else: ?>
<p style="text-align:center">温馨提示：只有<a href="index.php?r=purchasing/admin&Purchasing[status]=9">审批完成的采购单</a>，才能生成采购单。</p>
<?php endif; ?>