<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'outstorage-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">标有<span class="required">*</span> 符号为必填项</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'using_id'); ?>
		<?php 
                $usinglist = Using::model() -> findAll('status='.Using::STATUS_APPROVE_FINAL);
                $usingOptions = array('0'=>'请选择申请单号');
                foreach($usinglist as $using){
                        $usingOptions[$using->using_id] = $using->using_id.'('.$using->chemlist->chem_name.')';
                }
                echo $form->dropDownList($model,'using_id',$usingOptions); ?><span id="seedetail"></span>
		<?php echo $form->error($model,'using_id'); ?>
	</div>
        
        <script>
                $('#Outstorage_using_id').change(function()
                {
                        $('#seedetail').html('<a target="_blank" href="index.php?r=using/view&id='+$(this).val()+'">查看此申请单详细</a>');
                });
        </script>
        
	<div class="row">
		<?php echo $form->labelEx($model,'apply_user_id'); ?>
		<?php echo $form->textField($model,'apply_user_id'); ?>
		<?php echo $form->error($model,'apply_user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'duty_user_id'); ?>
		<?php echo $form->textField($model,'duty_user_id',array('value'=>Yii::app()->user->getId())); ?>
		<?php echo $form->error($model,'duty_user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'datetime'); ?>
                <?php 
                $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                        'attribute'=>'Outstorage[datetime]',
                        'language'=>'zh_cn',
                        'name'=>'Outstorage[datetime]',
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
                )); ?>
		<?php echo $form->error($model,'datetime'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'duty_user_id'); ?>
		<?php echo $form->textField($model,'duty_user_id',array('value'=>Yii::app()->user->getId())); ?>
		<?php echo $form->error($model,'duty_user_id'); ?>
	</div>
        
        <div class="row">
		<label for="Outstorage_datetime" class="required">化学品是否已经耗尽 <span class="required">*</span></label>
		<?php echo $form->dropDownList($model,'note',array('0'=>'未耗尽','1'=>'已耗尽'),array('name'=>'useover')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->