<div class="form">

<?php	//[[TJ]]这是创建备案单的信息填写表单
			/*LTJ编写于2015年5月11日18:19:17
----------------------------------------------------
			需要填写的有：
			备案人（经办人）
			购销合同号（选填）
			购买用途
			备注（选填）
			-------------------------------
			隐藏添加：
			备案时间
			申购编号
*/
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'achieve-form',
	'enableAjaxValidation'=>false,
)); ?>
	<p class="note">标有<span class="required">*</span> 符号为必填项</p>
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'purchasing_id'); 
				   echo $model->purchasing_id ;//显示申购单编号（不可改）
				   echo $form->hiddenField($model,'purchasing_id');?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'achiever');	//备案人（必填）?>
		<?php echo $form->textField($model,'achiever',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'achiever'); ?>
	</div>
<!--	TJ:这里去掉然后在提交检查中去掉状态参数必填的检查，直接在创建备案的控制器中设置状态
	<div class="row">
		<?php echo $form->hiddenField($model,'status',array('value'=>Achieve::STATUS_SENDING)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
-->
	<div class="row">
		<?php //隐藏域的元素，这些在备案成功后填写 ?>
		<?php 
			 echo $form->hiddenField($model,'certificate',array('value'=>'null'));
			 echo $form->hiddenField($model,'document',array('value'=>'null'));
			 echo $form->hiddenField($model,'exp_date',array('value'=>'null'));
			 echo $form->hiddenField($model,'license_issuing_authority',array('value'=>'null'));
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contractID'); ?>
		<?php echo $form->textField($model,'contractID',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'purpose'); ?>
		<?php echo $form->textField($model,'purpose',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'purpose'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton( '提交' ); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->