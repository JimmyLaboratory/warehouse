<?php	
	/*采购管理页面
	LTJ修改与2015年5月13日23:18:29
	包含审批和采购两个子项
	*/
$this->breadcrumbs=array(
	'Purchasings'=>array('admin'),
	'Manage',
);

$this->menu=array();			//TJ:声明这个是数组类型，否则可能出错		//TJ:menu是审批，menu2是采购


//TJ:menu是采购
$this->menu[]= array('label'=>'待采购', 'url'=>array('/purchasing/purchase_admin','status'=>'PURCHASING','Purchasing'=>array('status'=>  Purchasing::STATUS_ARCHIVES_SUCCESS)));
$this->menu[]=array('label'=>'采购中', 'url'=>array('/purchasing/purchase_admin','ING'=>'t','Purchasing[status]'=>  Purchasing::STATUS_PURCHASING));
$this->menu[]= array('label'=>'已采购', 'url'=>array('/purchasing/purchase_admin','Purchasing'=>array('status'=>  Purchasing::STATUS_INSTOCK)));
$this->menu[]= array('label'=>'采购终止', 'url'=>array('/purchasing/purchase_admin','Purchasing'=>array('status'=>  Purchasing::STATUS_CANCEL)));

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

<h1>采购管理</h1>
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
            'visible'=> Yii::app()->authManager->checkAccess('college',Yii::app()->user->getId()) &&
			isset($_GET['status'])||isset($_GET['ING']),
            'header'=>'操作',
            'class'=>'CButtonColumn',
            'deleteConfirmation'=>"确定要终止这个采购申请吗?",
			'deleteButtonImageUrl'=>array('style'=>'display:none'), 
            'template'=>'{delete}',
            'buttons'=>array(
                'delete'=>array(
                    'label'=>'终止',
                    'url'=>'Yii::app()->createUrl("purchasing/cancel",array("id"=>$data->purchasing_id,"uid"=>Yii::app()->user->getId(),"time"=>time(),"reason"=>""))',
					//TJ:下面是jQuery的click()函数，点击链接触发对话框要求输入终止理由，然后确定才能终止
					//缺陷是传值方式为GET，需要改为POST
                    'click'=>'function(){
							var reason=prompt("请输入终止理由","");
                            if(reason){
								$(this).attr("href",$(this).attr("href")+reason);
                            }
                            else{
								alert("终止失败：已被取消或未写理由");
								$(this).attr("href","#");
								return false;
							}
                    }'
                )
            ),
		),
		array(
            'visible'=>Yii::app()->authManager->checkAccess("teacher",Yii::app()->user->getId())&&isset($_GET['status'])&&$_GET['status']=='APPROVE',
            'header'=>'操作',
            'class'=>'CButtonColumn',
			'updateButtonImageUrl'=>array('style'=>'display:none'), 
            'template'=>'{update}',
            'buttons'=>array(
                'update' => array(
                    'label'=>'打印',
                    'options'=>array('target'=>'_blank'),
                    'url'=>'Yii::app()->createUrl("purchasing/print",array("id"=>$data->purchasing_id))',
				)
			)
        ),
		array(
            'visible'=>Yii::app()->authManager->checkAccess("college",Yii::app()->user->getId())&&isset($_GET['status'])&&$_GET['status']=='PURCHASING',
            'header'=>'操作',
            'class'=>'CButtonColumn',
			'updateButtonImageUrl'=>array('style'=>'display:none'), 
			'htmlOptions'=>array('width'=>'70'),
            'template'=>'{update}',
            'buttons'=>array(
                'update' => array(
                    'label'=>'生成采购单',
                    'options'=>array('target'=>'_blank'),
                    'url'=>'Yii::app()->createUrl("purchasing/topurchase",array("id"=>$data->purchasing_id))',
				)
			)
        ),
		array(
            'visible'=>isset($_GET['ING']),
            'header'=>'操作',
            'class'=>'CButtonColumn',
			'updateButtonImageUrl'=>array('style'=>'display:none'), 
			'htmlOptions'=>array('width'=>'70'),
            'template'=>'{update}',
            'buttons'=>array(
                'update' => array(
                    'label'=>'打印采购单',
                    'options'=>array('target'=>'_blank'),
                    'url'=>'Yii::app()->createUrl("purchasing/purchasePrint",array("id"=>$data->purchasing_id))',
				)
			)
        ),
		array(
            'visible'=>Yii::app()->authManager->checkAccess("college",Yii::app()->user->getId())&&isset($_GET['ING']),
            'header'=>'操作',
            'class'=>'CButtonColumn',
			'updateButtonImageUrl'=>array('style'=>'display:none'), 
            'template'=>'{update}',
            'buttons'=>array(
                'update' => array(
                    'label'=>'入库',
                    'options'=>array('target'=>'_blank'),
                    'url'=>'Yii::app()->createUrl("instorage/create",array("id"=>$data->purchasing_id))',
				)
			)
        ),
	),
)); ?>


<?php if(		//TJ:只有学院生成采购
	Yii::app()->authManager->checkAccess('college',Yii::app()->user->getId())
	&& (
		!isset($_GET['status']) ||
		(isset($_GET['status']) && $_GET['status'] !== 'APPROVE')
	)
): ?>
<p style="text-align:center">温馨提示：通过审批的采购，才能生成采购单！！！</p>

<?php else: ?>
<p style="text-align:center">温馨提示：只有<a href="index.php?r=purchasing/admin&Purchasing[status]=9">审批完成的采购单</a>，才能生成采购单。</p>
<?php endif; ?>