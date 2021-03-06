<?php
/*备案单详情页面	TJ写于2015年5月11日21:53:44
	显示备案详情并在页底显示备案成功或失败按钮
*/

$this->breadcrumbs=array(
	'Achieves'=>array('index'),
	$model->achieve_id=>array('view','id'=>$model->achieve_id),
	'Update',
);

$this->menu=array(
	array('label'=>'备案列表', 'url'=>array('admin')),
	array('label'=>'开始备案', 'url'=>array('begin')),
	array('label'=>'打印备案', 'url'=>array('print', 'id'=>$model->id),'linkOptions'=>array('target'=>'_blank')),
);
?>

<h1>备案单详情</h1>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,			//备案单
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

//用js来控制表单显示/隐藏和备案失败的提交确认
Yii::app()->clientScript->registerScript('success', "
$('.success-button').click(function(){
	$('.update_form').toggle();
	$('.fail-button').toggle();
	return false;
});
$('.fail-button').click(function(){
	if(confirm('确定备案失败'))
		return true;
	else
		return false;
});
$('.update_form form').submit(function(){
	$.fn.yiiGridView.update('achieve-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<p><?php echo CHtml::link('备案成功','#',array('class'=>'success-button')); 
		//TJ:点击”备案成功“显示下面的表单?></p>

<div class="update_form" style="display:none">
<?php //备案成功后填写证书号等信息的表单
	$this->renderPartial('update_form',array(
	'model'=>$model,
)); ?>
</div><!-- update_form -->

<p><?php echo CHtml::link('备案失败',array('fail','id'=>$model->id),array('class'=>'fail-button'));?></p>

