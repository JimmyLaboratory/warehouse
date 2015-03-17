<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('achieve_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->achieve_id), array('view', 'id'=>$data->achieve_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timestamp')); ?>:</b>
	<?php echo CHtml::encode($data->timestamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('achiever')); ?>:</b>
	<?php echo CHtml::encode($data->achiever); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('achieve_info')); ?>:</b>
	<?php echo CHtml::encode($data->achieve_info); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />


</div>