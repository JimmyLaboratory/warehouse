<?php
$this->breadcrumbs=array(
	'Chemcats'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'返回顶级分类', 'url'=>array('admin'),),
	array('label'=>'在此分类下添加子分类/药品', 'url'=>array('create','cur_parent_id'=>isset($_GET['cur_parent_id'])? $_GET['cur_parent_id'] : 0)),
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
<?php //echo "<p>上级分类：".$parent_name."</p>"; ?>

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
			'name'=>'chemcat_name',
			'type'=>'html',
			//'url'=>'Yii::app()->controller->createUrl("admin", array("cur_parent_id"=>$data->primaryKey))'
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>' {view}{delete}{update}',
			'buttons'=>array(
				'view'=>array(
					'label'=>'查看子分类',
					'url'=>'Yii::app()->controller->createUrl("admin", array("cur_parent_id"=>$data->primaryKey,))'
					),
				'update'=>array(
					'label'=>'修改药品/分类名',
					'url'=>'Yii::app()->controller->createUrl("update", array("id"=>$data->primaryKey,))'
				)
			)
		)
	)
));
?>
