<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'chemcat-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">标有<span class="required">*</span> 符号为必填项</p>

	<?php echo $form->errorSummary($model); ?>

		
	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php
                //if(isset($_GET['cur_parent_id']) && (int)$_GET['cur_parent_id'] > 0){
                //        //echo $form->dropDownList($model,'parent_id', Chemcat::getDropListById((int)$_GET['cur_parent_id']));
                //	echo $form->dropDownList($model,'cat_id', Chemcat::getDropList($cur_parent_id));
                //}
                //else
				//{
                //        echo $form->dropDownList($model,'cat_id', Chemcat::getDropList($cur_parent_id));
                //}
        ?>
		<?php echo $form->error($model,'parent_id'); ?>
	
		<select name="Chemcat[parent_id]" id="Chemcat_parent_id" onchange="goto(this.value);">

		<?php
			$level_list=Chemcat::getLevel($cur_parent_id);
			
			foreach($level_list as $cat_id=>$cat_name){
				echo "<option value=".$cat_id.">".$cat_name."</option>";
			}
		?>
		</select>

	<script >function goto(vv){
		//跳转网址函数
		window.localtion.href="/chemcat?r=create&cur_parent_id=".vv;
	</script>

	<div class="row">
		<?php echo $form->labelEx($model,'chemcat_name'); ?>
		<?php echo $form->textField($model,'chemcat_name',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'chemcat_name'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->