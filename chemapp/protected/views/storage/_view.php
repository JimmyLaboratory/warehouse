<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('storage_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->storage_id), array('view', 'id'=>$data->storage_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('storage_name')); ?>:</b>
	<?php echo CHtml::encode($data->storage_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parent_id')); ?>:</b>
	<?php $parent_name = Storage::getDropListById($data->parent_id);echo CHtml::link(CHtml::encode(array_pop($parent_name)), Yii::app()->createUrl('/storage/index',array('parent_id'=>$data->parent_id))); ?>
	<br />
        
        <b><?php echo CHtml::link(CHtml::encode('查看此仓库下属化学品摆放位置'), Yii::app()->createUrl('/storage/index',array('parent_id'=>$data->storage_id))); ?></b>


</div>