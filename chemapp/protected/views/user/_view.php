<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->user_id), array('view', 'id'=>$data->user_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_name')); ?>:</b>
	<?php echo CHtml::encode($data->user_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('realname')); ?>:</b>
	<?php echo CHtml::encode($data->realname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_role')); ?>:</b>
	<?php echo CHtml::encode($data->user_role); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('department_id')); ?>:</b>
	<?php echo CHtml::encode($data->dname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cardno')); ?>:</b>
	<?php echo CHtml::encode($data->cardno); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('tel_long')); ?>:</b>
	<?php echo CHtml::encode($data->tel_long); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tel_short')); ?>:</b>
	<?php echo CHtml::encode($data->tel_short); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tel_office')); ?>:</b>
	<?php echo CHtml::encode($data->tel_office); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lock')); ?>:</b>
	<?php echo CHtml::encode($data->lock); ?>
	<br />

	*/ ?>

</div>