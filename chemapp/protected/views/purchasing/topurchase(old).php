<?php
$this->breadcrumbs=array(
	'Purchasings'=>array('admin'),
	'Manage',
);

$this->menu=array(
        array('label'=>'查看所有', 'url'=>array('/purchasing/admin')),
	array('label'=>'查看待审批项', 'url'=>array('/purchasing/admin','status'=>'APPROVE')),
	array('label'=>'查看审批完成项', 'url'=>array('/purchasing/admin','Purchasing[status]'=>  Purchasing::STATUS_PASS_FINAL)),
        array('label'=>'查看采购清单', 'url'=>array('/purchasing/admin','Purchasing[status]'=>  Purchasing::STATUS_PURCHASING)),
        array('label'=>'查看被拒绝的采购项', 'url'=>array('/purchasing/admin','Purchasing'=>array('status'=>  Purchasing::STATUS_REJECT))),
);
?>

<h1>生成采购清单</h1>

<p>
请确认以下采购申请将生成至采购清单中<br />
<form action="<?php echo Yii::app()->createUrl('purchasing/topurchase',array('confirm'=>'true')) ?>" method="post">
<input type="hidden" name="ids" value="<?php echo $ids ?>" />
采购清单编号：<input type="text" name="purchasing_no" value="<?php echo 'CG'.date('YmdHi').mt_rand(0, 999) ?>" />
<input type="submit" value="确认生成以下采购申请至采购清单" />
</form>
</p>

<?php
        $criteria = new CDbCriteria;
        $criteria ->addInCondition('purchasing_id', explode(',',$ids));
        $criteria ->compare('status', Purchasing::STATUS_PASS_FINAL);
        $dataProvider = new CActiveDataProvider($model, array(
                                'criteria'=>$criteria,
                        ));
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'purchasing-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
		'purchasing_id',
		array(
                    'name'=>'user_id',
                    'value'=>'$data->user->realname'
                ),
                array(
                    'name'=>'user_id',
                    'value'=>'$data->user->department->department_name'
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
                        'visible'=>Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId()),
                        'header'=>'操作',
			'class'=>'CButtonColumn',
                        'template'=>'{view}{update}',
                        'buttons'=>array(
                                'view' => array(
                                    'label'=>'查看',
                                    'options'=>array('target'=>'_blank'),
                                ),
                                'update' => array(
                                    'label'=>'入库',
                                    'options'=>array('target'=>'_blank'),
                                    'url'=>'Yii::app()->createUrl("instorage/create",array("id"=>$data->purchasing_id))',
                                ),
                            ),
		),
                array(
                        'visible'=>!Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId()),
                        'header'=>'操作',
			'class'=>'CButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array(
                                'view' => array(
                                    'label'=>'查看',
                                    'options'=>array('target'=>'_blank'),
                                ),
                            ),
		)
	),
)); ?>
