<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('quality_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->quality_id), array('view', 'id'=>$data->quality_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quality_name')); ?>:</b>
	<?php echo CHtml::encode($data->quality_name); ?>
	<br />


</div>