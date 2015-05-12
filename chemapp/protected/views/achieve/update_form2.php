<div class="form">
    <form id="achieve-form" action="index.php?r=achieve/update" method="post">
    <div class="row">
        <label for="Achieve_status" class="required">
            <input size="20" maxlength="20" name="Achieve[status]" id="Achieve_status" type="radio" value="1" />备案成功
        </label>
        <label for="Achieve_status" class="required">
            <input size="20" maxlength="20" name="Achieve[status]" id="Achieve_status" type="radio" value="-1" />备案失败
        </label>
    </div>
	
    <div class="row">
		<label for="Achieve_achiever" class="required">备案编号 </label>
		<input type="text" name="Achieve[achieve_id]" />
	</div>

	<div class="row">
		<label for="Achieve_achiever" class="required">备案人 </label>
		<?php echo $model->achiever; ?>
	</div>

	<div class="row">
		<label for="Achieve_note" class="required">备注 </label>
		<?php echo $model->note; ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'achieve_info'); ?>
		<?php //备案单化学品信息在控制器中处理好传递到这里
		//$infomation="药品名:".$info['chem_name'];
		//echo '<textArea name="Achieve_info" rows=6 cols=50 id="Achieve_info" />'.$infomation."</textArea>";
		//echo $form->textArea($model,'achieve_info',array('rows'=>6, 'cols'=>50,'value'=>$info)); ?>
		<?php //echo $form->error($model,'achieve_info'); ?>
	</div>
	
	<div class="row buttons">
		<input type="submit" name="yt0" value="提交" />
	</div>

</div><!-- form -->