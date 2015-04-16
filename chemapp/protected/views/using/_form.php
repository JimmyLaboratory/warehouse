<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'using-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">标有<span class="required">*</span> 符号为必填项</p>

	<?php echo $form->errorSummary($model); ?>

        <div class="row">
                <?php
                        $userInfo = User::getInfo();
                        $using_id = isset($_POST['Using']['using_id']) ? $_POST['Using']['using_id'] :'SY'.$userInfo->department_id.'T'.date('YmdHi').mt_rand(0, 999);
                ?>
		<label for="Using_using_id" class="required">申请使用单编号</label>
			<span><?php echo $using_id ?></span>
            <input name="Using[using_id]" id="purchasing_id" type="hidden" value="<?php echo $using_id ?>" readonly="true">
        </div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'chem_id'); ?>
		<?php 
                $chemlist = Chemlist::model() -> findAll('user_id='.$userInfo->user_id.' AND status='.Chemlist::STATUS_INSTOCK);
                $chemUnits = array();
                $chemOptions = array('0'=>'请选择需要申请的化学品');
                foreach($chemlist as $chem){
                        $chemOptions[$chem->chem_id] = $chem->chem_name.'('.$chem->producer.$chem->production_date.')，剩余：'.((float)$chem->unit_package * (int)$chem->nums - (float)$chem->used).$chem->unit->unit_name;
                        $chemUnits[$chem->chem_id] = $chem->unit->unit_name;
                        $chemLeft[$chem->chem_id] = (float)$chem->unit_package * (int)$chem->nums - (float)$chem->used;
                }
                echo $form->dropDownList($model,'chem_id',$chemOptions); ?>
		<?php echo $form->error($model,'chem_id'); ?>
	</div>
        <style type="text/css">
			select { max-width: 490px; }
        </style>
        <div class="row">
		<label for="Using_user_id" class="required">申请用户</label>
			<span><?php echo $userInfo->realname ?></span>
            <input name="Using[user_id]" id="Using_user_id" type="hidden" value="<?php echo $userInfo->realname ?>"  readonly="true">			
        </div>
        <?php
        echo '<script>var units ='.  json_encode($chemUnits).';var lefts = '.json_encode($chemLeft).';</script>';
        ?>
	<div class="row">
		<?php echo $form->labelEx($model,'applyuse'); ?>
		<?php echo $form->textField($model,'applyuse'); ?><span id="apply_unit"></span>
		<?php echo $form->error($model,'applyuse'); ?>
		<span id="left-amout" style="color:#f00;font-size:87.5%;display:none"></span>
	</div>
	
        <script>
                $('#Using_chem_id').change(function()
                {
                        if(units[$(this).val()] != undefined)
                                $('#apply_unit').html(units[$(this).val()]);
                        else
                                $('#apply_unit').html('');
                });
                <?php if(isset($_GET['id'])): ?>
                        $('#Using_chem_id option[value="<?php echo $_GET['id'] ?>"]').attr('selected', 'selected');
                        $('#apply_unit').html(units[$('#Using_chem_id').val()]);
                <?php endif; ?>
                        
                $('#Using_applyuse').blur(function(){
                        if($(this).val() > lefts[$('#Using_chem_id').val()]){
                                //alert('申请使用量不可大于剩余量');
								$('#left-amout').show().html('&emsp;注意：申请使用量不应大于剩余量');
                                //$(this).val('');
                        } else {
							$('#left-amout').hide();
						}
                });
                        
        </script>
	<div class="row">
		<?php echo $form->labelEx($model,'reason'); ?>
		<?php echo $form->textArea($model,'reason',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'reason'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'use_start'); ?>
                <?php 
                $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                        'attribute'=>'Using[use_start]',
                        'language'=>'zh_cn',
                        'name'=>'Using[use_start]',
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
		<?php echo $form->error($model,'use_start'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'useway'); ?>
		<?php echo $form->dropDownList($model,'useway',  Chemlist::getUsewayOptions()); ?>
		<?php echo $form->error($model,'useway'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'junk'); ?>
		<?php echo $form->textArea($model,'junk',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'junk'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->