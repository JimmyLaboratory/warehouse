<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('cat_id')); ?>:</b>
        <?php echo CHtml::encode($data->cat_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chemcat_name')); ?>:</b>
	<?php echo CHtml::encode($data->chemcat_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parent_id')); ?>:</b>
	<?php $parent_name = Chemcat::getDropListById($data->parent_id);echo CHtml::link(CHtml::encode(array_pop($parent_name)), Yii::app()->createUrl('/chemcat/index',array('parent_id'=>$data->parent_id))); ?>
	<br />
        
        <b><?php echo CHtml::link(CHtml::encode('查看此分类的下属分类'), Yii::app()->createUrl('/chemcat/index',array('parent_id'=>$data->cat_id))); ?></b>


</div>