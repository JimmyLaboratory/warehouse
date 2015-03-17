<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('using_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->using_id), array('view', 'id'=>$data->using_id)); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('applyuse')); ?>:</b>
	<?php echo CHtml::encode($data->applyuse); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reason')); ?>:</b>
	<?php echo CHtml::encode($data->reason); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('use_start')); ?>:</b>
	<?php echo CHtml::encode($data->use_start); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('useway')); ?>:</b>
	<?php echo CHtml::encode($data->useway); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('junk')); ?>:</b>
	<?php echo CHtml::encode($data->junk); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('information')); ?>:</b>
	<?php echo CHtml::encode($data->information); ?>
	<br />

	*/ ?>

</div>