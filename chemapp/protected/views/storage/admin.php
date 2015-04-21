<?php
$this->breadcrumbs=array(
	'Storages'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'显示所有仓库', 'url'=>array('admin')),
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
	'dataProvider'=>$model->searchByParentID($sid), //修改storage类方法search()
	'filter'=>$model,
	'columns'=>array(
		//'storage_id',
		'storage_name',
		'note',
        /*array(
            'name' => 'parent_id',
            'value' => 'getName($data->parent_id)'
        ),*/
		array(
			'class'=>'CButtonColumn',
			'template'=>' {view}{delete}{update}',
			'buttons'=>array(
				'view'=>array(
					'label'=>'查看下层仓库',
					'url'=>'Yii::app()->controller->createUrl("admin", array("sid"=>$data->primaryKey,))'
					),
				'update'=>array(
					'label'=>'修改仓库/架',
					'url'=>'Yii::app()->controller->createUrl("update", array("id"=>$data->primaryKey,))'
				)
			)
		),
	),
)); ?>
