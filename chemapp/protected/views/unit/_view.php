<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->unit_id), array('view', 'id'=>$data->unit_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit_name')); ?>:</b>
	<?php echo CHtml::encode($data->unit_name); ?>
	<br />


</div>