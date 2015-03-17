<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('outstorage_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->outstorage_id), array('view', 'id'=>$data->outstorage_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('using_id')); ?>:</b>
	<?php echo CHtml::encode($data->using_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('apply_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->apply_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('duty_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->duty_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('datetime')); ?>:</b>
	<?php echo CHtml::encode($data->datetime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />


</div>