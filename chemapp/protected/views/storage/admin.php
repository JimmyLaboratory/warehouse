<?php
$this->breadcrumbs=array(
	'Storages'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Storage', 'url'=>array('index')),
	array('label'=>'Create Storage', 'url'=>array('create')),
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

<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php

function getName($parent_id){
        $data = Storage::getDropListById($parent_id);
        return array_pop($data);
}
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'storage-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'storage_id',
		'storage_name',
		'note',
                array(
                    'name' => 'parent_id',
                    'value' => 'getName($data->parent_id)'
                ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
