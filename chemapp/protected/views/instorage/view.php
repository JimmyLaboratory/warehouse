<?php
$this->breadcrumbs=array(
	'Instorages'=>array('index'),
	$model->instorage_id,
);

$this->menu=array(
	array('label'=>'查看所有入库单', 'url'=>array('admin')),
);
?>

<h1>查看入库</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'instorage_id',
		'purchasing_id',
        'user_id',
		'verifydate',
		'expired',
		'specail_note',
		'weight',
		'nums',
        'deliver_name',
        'deliver_tel',
        array(
            'name'=>'storage_id',
            'value'=>  Storage::getLevels($model->storage_id)
        ),
		'note',
		array(
            'name'=>'pics',
            'type'=>'raw',
            'value'=>CHtml::link('<img width="400px" src="upload/'.$model->pics.'" />','upload/'.$model->pics,array('target'=>'_blank'))
        ),
	),
)); ?>
