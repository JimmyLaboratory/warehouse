<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('chem_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->chem_id), array('view', 'id'=>$data->chem_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chemcat_id')); ?>:</b>
	<?php echo CHtml::encode($data->chemcat_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quality_id')); ?>:</b>
	<?php echo CHtml::encode($data->quality_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quality_other')); ?>:</b>
	<?php echo CHtml::encode($data->quality_other); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit_package')); ?>:</b>
	<?php echo CHtml::encode($data->unit_package); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('unit_id')); ?>:</b>
	<?php echo CHtml::encode($data->unit_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nums')); ?>:</b>
	<?php echo CHtml::encode($data->nums); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('production_date')); ?>:</b>
	<?php echo CHtml::encode($data->production_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expired')); ?>:</b>
	<?php echo CHtml::encode($data->expired); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('producer')); ?>:</b>
	<?php echo CHtml::encode($data->producer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('useway')); ?>:</b>
	<?php echo CHtml::encode($data->useway); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_id')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_code')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_other')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_other); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('specail_note')); ?>:</b>
	<?php echo CHtml::encode($data->specail_note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('used')); ?>:</b>
	<?php echo CHtml::encode($data->used); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('storage_id')); ?>:</b>
	<?php echo CHtml::encode($data->storage_id); ?>
	<br />

	*/ ?>

</div>