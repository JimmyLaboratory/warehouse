<?php
$this->breadcrumbs=array(
	'Storages'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'最上一级仓库', 'url'=>array('admin')),
	array('label'=>'在这里新建一项','url'=>array('create','sid'=>isset($_GET['sid'])? $_GET['sid'] : 0)),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('storage-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>管理仓库</h1>

<?php echo CHtml::link('搜索','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'storage-grid',
	'dataProvider'=>$model->searchByParentID($sid), //修改storage类方法search()
	//'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'CLinkColumn',
			'header'=>'仓库/位置',
			'labelExpression'=>'$data->storage_name',		//显示内容
			'linkHtmlOptions'=>array('title'=>'点击进入下一级分类'),		//鼠标停留时显示字符框
			'urlExpression'=>'Yii::app()->controller->createUrl("admin", array("sid"=>$data->primaryKey,))'//显示URL
		),
		'note',
        /*array(
            'name' => 'parent_id',
            'value' => 'getName($data->parent_id)'
        ),*/
		
		array(
			'class'=>'CButtonColumn',
			'template'=>' {delete}{update}',
			'buttons'=>array(
				'update'=>array(
					'label'=>'修改仓库/架',
					'url'=>'Yii::app()->controller->createUrl("update", array("id"=>$data->primaryKey,))'
				)
			)
		),
	),
)); ?>

<?php 
/*
	if(isset($_GET['search'])) return;
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'storage-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php 
			echo "<input type=hidden name=storage[parent_id] value=".$sid.">";
		?>  
    </div>

    <div class="row">
		<?php echo '在此新建位置'; ?>
		<?php echo $form->textField($model,'storage_name',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'storage_name'); ?>
	</div>
	<div class="row">
	<?php echo '备注'; ?>
	<?php echo $form->textField($model,'note',array('size'=>60,'maxlength'=>60)); ?>
	<?php echo $form->error($model,'note'); ?>

		<?php echo CHtml::submitButton('提交'); ?>
	</div>
<?php $this->endWidget(); ?>
*/?>