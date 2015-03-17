<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">标有<span class="required">*</span> 符号为必填项</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_name'); ?>
		<?php echo $form->textField($model,'user_name',array('size'=>20,'maxlength'=>60,'readonly'=>$model->isNewRecord ? '' : 'true')); ?>
		<?php echo $form->error($model,'user_name'); ?>
	</div>
        <?php if($model->isNewRecord): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>20,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
        <?php endif; ?>
	<div class="row">
		<?php echo $form->labelEx($model,'realname'); ?>
		<?php echo $form->textField($model,'realname',array('size'=>20,'maxlength'=>20,
                'readonly'=>Yii::app()->authManager->checkAccess('teacher',Yii::app()->user->getId()) ? 'readonly' : '')); ?>
		<?php echo $form->error($model,'realname'); ?>
	</div>
        
        <?php
        if(!Yii::app()->authManager->checkAccess('teacher',Yii::app()->user->getId())){
        ?>
	<div class="row">
		<?php echo $form->labelEx($model,'user_role'); ?>
		<?php 
                if(Yii::app() -> authManager -> checkAccess('college',Yii::app()->user->getId())){
                        echo $form->dropDownList($model,'user_role',  array('teacher'=>'教师'));//学院用户只能创建教师角色
                }
                else{
                        echo $form->dropDownList($model,'user_role',  User::getRoleOptions());
                }
                ?>
		<?php echo $form->error($model,'user_role'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'department_id'); ?>
		<?php 
                if(Yii::app() -> authManager -> checkAccess('college',Yii::app()->user->getId())){
                        echo $form->dropDownList($model,'department_id', Department::getUserOption());//学院用户只能创建本单位教师
                }
                else{
                        echo $form->dropDownList($model, 'department_id', Department::getOptions());
                }
                ?>
		<?php echo $form->error($model,'department_id'); ?>
	</div>
        <?php } ?>
        
	<div class="row">
		<?php echo $form->labelEx($model,'cardno'); ?>
		<?php echo $form->textField($model,'cardno',array('size'=>20,'maxlength'=>30,
                'readonly'=>Yii::app()->authManager->checkAccess('teacher',Yii::app()->user->getId()) ? 'readonly' : '')); ?>
		<?php echo $form->error($model,'cardno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tel_long'); ?>
		<?php echo $form->textField($model,'tel_long',array('size'=>20,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'tel_long'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tel_short'); ?>
		<?php echo $form->textField($model,'tel_short'); ?>
		<?php echo $form->error($model,'tel_short'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tel_office'); ?>
		<?php echo $form->textField($model,'tel_office',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'tel_office'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>20,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>
        
        <?php
        if(!Yii::app()->authManager->checkAccess('teacher',Yii::app()->user->getId())){
        ?>
	<div class="row">
		<?php echo $form->labelEx($model,'lock'); ?>
		<?php echo $form->dropDownList($model,'lock',array('-1'=>'帐户有效','1'=>'帐户被冻结')); ?>
		<?php echo $form->error($model,'lock'); ?>
	</div>
        <?php
        }
        ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->