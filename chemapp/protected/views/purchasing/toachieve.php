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

<h1>生成备案单</h1>

<p>
请确认以下采购申请将生成至备案单中，并请输入备案人以及备注<br />
<form action="<?php echo Yii::app()->createUrl('purchasing/toachieve',array('confirm'=>'true')) ?>" method="post">
<input type="hidden" name="ids" value="<?php echo $ids ?>" />
备案单编号：<input type="textField" name="avhieve_id" value="<?php echo 'AR'.date('YmdHi').mt_rand(0, 999) ?>" />
备案人：<input type="textField" name="achiever" value="" />
备注：<input type="textField" name="note" value="" />
<input type="submit" value="确认生成以下采购申请至备案单" />
</form>
</p>

<?php
        $criteria = new CDbCriteria;
        $criteria ->addInCondition('purchasing_id', explode(',',$ids));
        $criteria ->addInCondition('status', array(Purchasing::STATUS_PASS_FINAL , Purchasing::STATUS_PURCHASING));
        $dataProvider = new CActiveDataProvider($model, array(
                                'criteria'=>$criteria,
                        ));
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'purchasing-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
		array(
                    'name'=>'chem_id',
                    'header'=>'化学品名称',
                    'value'=>'$data->chemlist->chem_name'
                ),
                array(
                    'name'=>'chem_id',
                    'header'=>'规格',
                    'value'=>'$data->chemlist->quality_id != -1 ? $data->chemlist->quality->quality_name : $data->chemlist->quality_other'
                ),
		array(
                    'name'=>'chem_id',
                    'header'=>'包装',
                    'value'=>'$data->chemlist->unit_package.$data->chemlist->unit->unit_name'
                ),
		array(
                    'name'=>'chem_id',
                    'header'=>'数量',
                    'value'=>'$data->chemlist->nums'
                ),
		array(
                    'name'=>'chem_id',
                    'header'=>'使用方向',
                    'value'=>'Chemlist::getUsewayOptions($data->chemlist->useway)'
                ),
		array(
                    'name'=>'chem_id',
                    'header'=>'备注',
                    'value'=>'$data->chemlist->note'
                )
	),
)); ?>
