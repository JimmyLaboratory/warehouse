<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('department_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->department_id), array('view', 'id'=>$data->department_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('department_name')); ?>:</b>
	<?php echo CHtml::encode($data->department_name); ?>
	<br />


</div>