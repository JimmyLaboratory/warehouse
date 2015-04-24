<?php
$this->breadcrumbs=array(
	'Chemcats'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'返回顶级分类', 'url'=>array('admin'),),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('chemcat-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>管理化学品分类</h1>

<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
function getName($parent_id){
        $data = Chemcat::getDropListById($parent_id);
        return array_pop($data);
}
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'chemcat-grid',
	'dataProvider'=>$model->searchByParentID($cur_parent_id),  //search()
	'filter'=>$model,
	'columns'=>array(
		//'cat_id',
		array(
			'class'=>'CLinkColumn',
			'header'=>'药品/分类名',
			'labelExpression'=>'$data->chemcat_name',		//显示内容
			'linkHtmlOptions'=>array('title'=>'点击进入下一级分类'),		//鼠标停留时显示字符框
			'urlExpression'=>'Yii::app()->controller->createUrl("admin", array("cur_parent_id"=>$data->primaryKey,))'//显示URL
		),
		array(
			'class'=>'CButtonColumn',
			'header'=>'可选操作',
			'template'=>' {delete}{update}',
			'buttons'=>array(
				'update'=>array(
					'label'=>'修改药品/分类名',
					'url'=>'Yii::app()->controller->createUrl("update", array("id"=>$data->primaryKey,))'
				)
			)
		)
	)
));
?>

<?php 
	if(isset($_GET['search'])) return;
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'chemcat-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php 
			echo "<input type=hidden name=Chemcat[parent_id] value=".$cur_parent_id.">";
		?>  
    </div>

    <div class="row">
		<?php echo '在此新建项'; ?>
		<?php echo $form->textField($model,'chemcat_name',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'chemcat_name'); ?>

		<?php echo CHtml::submitButton('提交'); ?>
	</div>
<?php $this->endWidget(); ?>