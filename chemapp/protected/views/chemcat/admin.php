<?php
$this->breadcrumbs=array(
	'Chemcats'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'查看所有分类', 'url'=>array('index')),
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
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'cat_id',
		'chemcat_name',
		array(
                    'name' => 'parent_id',
                    'value' => 'getName($data->parent_id)'
                ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
