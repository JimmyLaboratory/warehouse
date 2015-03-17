<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('purchasing_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->purchasing_id), array('view', 'id'=>$data->purchasing_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chem_id')); ?>:</b>
	<?php echo CHtml::encode($data->chem_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timestamp')); ?>:</b>
	<?php echo CHtml::encode($data->timestamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('information')); ?>:</b>
	<?php echo CHtml::encode($data->information); ?>
	<br />


</div>