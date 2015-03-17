<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'创建用户', 'url'=>array('create'), 'visible'=>
            Yii::app()->authManager->checkAccess('school',Yii::app()->user->getId()) || 
            Yii::app()->authManager->checkAccess('college',Yii::app()->user->getId())
            ),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>管理用户</h1>


<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'user_id',
		'user_name',
		'realname',
		'user_role',
		array(
                    'name'=>'department_id',
                    'value'=>'$data->department->department_name'
                ),
		/*
		'cardno',
		'tel_long',
		'tel_short',
		'tel_office',
		'email',
		'note',
		'lock',
		*/
		array(
                    'visible'=>!Yii::app()->authManager->checkAccess('secure',Yii::app()->user->getId()),
			'class'=>'CButtonColumn',
                        'template'=>'{view}', 
		),
	),
)); ?>
