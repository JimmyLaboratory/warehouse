<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'chemlist-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">标有<span class="required">*</span> 符号为必填项</p>

	<?php echo $form->errorSummary($model); ?>
        <?php
        $userOptions = array();
        $users = User::model() ->findAll('user_role="teacher"');
        foreach($users as $user)
                $userOptions[$user->user_id] = $user->department->department_name.':'.$user->realname;
        ?>
	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->dropDownList($model,'user_id',$userOptions); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '提交' : '保存'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->