<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('instorage_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->instorage_id), array('view', 'id'=>$data->instorage_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('purchasing_id')); ?>:</b>
	<?php echo CHtml::encode($data->purchasing_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('verifydate')); ?>:</b>
	<?php echo CHtml::encode($data->verifydate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expired')); ?>:</b>
	<?php echo CHtml::encode($data->expired); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('specail_note')); ?>:</b>
	<?php echo CHtml::encode($data->specail_note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('weight')); ?>:</b>
	<?php echo CHtml::encode($data->weight); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('nums')); ?>:</b>
	<?php echo CHtml::encode($data->nums); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('storage_id')); ?>:</b>
	<?php echo CHtml::encode($data->storage_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pics')); ?>:</b>
	<?php echo CHtml::encode($data->pics); ?>
	<br />

	*/ ?>

</div>