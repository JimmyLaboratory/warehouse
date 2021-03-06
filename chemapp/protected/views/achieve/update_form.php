<div class="form">

<?php	//[[TJ]]这是创建备案单的信息填写表单
			/*备案成功表单
			LTJ编写于2015年5月11日21:58:29
----------------------------------------------------
			需要填写的有：
			证书号
			公文号
			有效期
			发证机关
			-------------------------------
			隐藏添加：
			备案成功时间(还未加上)
*/
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'achieve-form',
	'enableAjaxValidation'=>false,
)); ?>
	<p class="note">标有<span class="required">*</span> 符号为必填项</p>
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'certificate');	//备案证书号?>
		<?php echo $form->textField($model,'certificate',array('value'=>'','size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'certificate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'document'); ?>
		<?php echo $form->textField($model,'document',array('value'=>'','size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'document'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'exp_date'); ?>
                <?php 
                $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                        'attribute'=>'Achieve_exp_date',
                        'language'=>'zh_cn',
                        'name'=>'Achieve[exp_date]',
                        'options'=>array(
                                'showAnim'=>'fold',
                                'showOn'=>'both',
                                'buttonImage'=>Yii::app()->request->baseUrl.'/images/datepicker.jpg',
                                'buttonImageOnly'=>true,
                                'dateFormat'=>'yy-mm-dd',
                        ),
                        'htmlOptions'=>array(
                                'style'=>'height:18px',
                        ),
                ));?>
		<?php echo $form->error($model,'exp_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'license_issuing_authority'); ?>
		<?php echo $form->textField($model,'license_issuing_authority',array('value'=>'','size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'license_issuing_authority'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('保存'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->