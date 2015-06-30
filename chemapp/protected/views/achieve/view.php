<?php
Yii::app()->getClientScript()->registerCssFile(Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview'.'/styles.css');
$this->breadcrumbs=array(
	'Achieves'=>array('index'),
	$model->achieve_id,
);

$this->menu=array(
	array('label'=>'备案列表', 'url'=>array('admin')),
    array('label'=>'打印备案', 'url'=>array('print','id'=>$model->purchasing_id), 'linkOptions'=>array('target'=>'_blank')),
);
?>

<h1>查看备案单信息</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'purchasing_id',
		array(
                    'name'=>'timestamp',
                    'value'=>date('Y-m-d H:i:s',$model->timestamp)
        ),
		'achiever',
		array('name'=>'status','value'=>Achieve::getStatusInfo($model->status)),
		'contractID',
		'purpose',
		'certificate',
		'document',
		array(
                    'name'=>'exp_date',
                    'value'=>date('Y-m-d H:i:s',$model->exp_date)
        ),
		'license_issuing_authority',
		'note',
	),
)); ?>
