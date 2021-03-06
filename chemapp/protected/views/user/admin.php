<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);

$this->menu=array(
	array(
		'label'=>'创建用户', 'url'=>array('create'), 'visible'=>
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
<?php echo CHtml::link('搜索','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'CLinkColumn',
			'header'=>'用户名',
			'labelExpression'=>'$data->user_name',
			'urlExpression'=>'Yii::app()->createUrl("user/view",array("id"=>$data->user_id))'
		),
		'realname',
		'user_role',
		'dname',
        array(
            'name'=>'lock',
            'value'=>'User::showLock($data->lock)'
        ),
		array(
            'class'=>'CLinkColumn',
            'header'=>'操作',
		
            'label'=>'修改',
            'urlExpression'=>'Yii::app()->createUrl("user/update",array("id"=>$data->user_id))',
        ),
		array(
			//'visible'=>Yii::app()->authManager->checkAccess("college",Yii::app()->user->getId())&&isset($_GET['ING']),
			'header'=>'操作',
			'class'=>'CButtonColumn',
			'deleteButtonImageUrl'=>array('style'=>'display:none'), 
			'template'=>'{delete}',
			'buttons'=>array(
				'delete' => array(
					'label'=>'删除',
					'url'=>'Yii::app()->createUrl("user/delete",array("id"=>$data->user_id))',
				)
			)
		)
	),
)); ?>
