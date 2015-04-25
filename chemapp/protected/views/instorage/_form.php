<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'instorage-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),  
)); ?>

	<p class="note">标有<span class="required">*</span> 符号为必填项</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'purchasing_id'); ?>
		<?php 
                $purchasing_ids = Purchasing::model() -> findAll('status='.Purchasing::STATUS_PASS_FINAL.' OR status='.Purchasing::STATUS_PURCHASING);
                $purchasing_id_options = array();
                foreach($purchasing_ids as $purchasing_id){
                        $purchasing_id_options[$purchasing_id['purchasing_id']] = $purchasing_id['purchasing_id'];
                }
                echo $form->dropDownList($model,'purchasing_id',$purchasing_id_options);
                ?>
		<?php echo $form->error($model,'purchasing_id'); ?>
	</div>
        <script>
        <?php if(isset($_GET['id'])): ?>
                        $('#Instorage_purchasing_id option[value="<?php echo $_GET['id'] ?>"]').attr('selected', 'selected');
        <?php endif; ?>
        </script>
        
	<div class="row">
		<?php echo $form->labelEx($model,'verifydate'); ?>
		<?php 
                $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                        'attribute'=>'Instorage_verifydate',
                        'language'=>'zh_cn',
                        'name'=>'Instorage[verifydate]',
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
		<?php echo $form->error($model,'verifydate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'expired'); ?>
                <?php 
                $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                        'attribute'=>'Instorage_expired',
                        'language'=>'zh_cn',
                        'name'=>'Instorage[expired]',
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
		<?php echo $form->error($model,'expired'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'specail_note'); ?>
		<?php echo $form->textArea($model,'specail_note',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'specail_note'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'weight'); ?>
		<?php echo $form->textField($model,'weight'); ?>
		<?php echo $form->error($model,'weight'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nums'); ?>
		<?php echo $form->textField($model,'nums'); ?>
		<?php echo $form->error($model,'nums'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'deliver_name'); ?>
		<?php echo $form->textField($model,'deliver_name'); ?>
		<?php echo $form->error($model,'deliver_name'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'deliver_tel'); ?>
		<?php echo $form->textField($model,'deliver_tel'); ?>
		<?php echo $form->error($model,'deliver_tel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'storage_id'); ?>
                <?php 
                $stoLists = Storage::model()->findAll();
                $stoOptions = array();
                $stoOpitonShows = array();
                foreach($stoLists as $sto){
                        !isset($stoOptions[$sto->parent_id]) && $stoOptions[$sto->parent_id][0] = '请选择';
                        $stoOptions[$sto->parent_id][$sto->storage_id] = $sto->storage_name;
                }
                foreach($stoOptions as $key => $value){
                       $stoOpitonShows[$key] = $form->dropDownList($model,'storage_id',$value,array('class'=>'storage_child','child'=>':child'));
                }
                echo $form->dropDownList($model,'storage_id',$stoOptions[0],array('class'=>'storage_child','child'=>'0')); ?>
                <script>
                        var stoOpitonShows = <?php echo json_encode($stoOpitonShows) ?>;
                        $('body').delegate('.storage_child','change',function(){
                                var sto_selected = $(this).val();
                                var sto_child = $(this).attr('child');
                                $('.storage_child').each(function(){
                                        if($(this).attr('child') > sto_child){
                                                $(this).remove();
                                        }
                                });
                                sto_child++;
                                if(stoOpitonShows[sto_selected] != undefined){
                                        var stoOption = stoOpitonShows[sto_selected];
                                        stoOption = stoOption.replace(':child',sto_child);
                                        $(this).after(stoOption);
                                }
                        });
                </script>
		<?php echo $form->error($model,'storage_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pics'); ?>
		<?php echo CHtml::activeFileField($model,'pics'); ?>
		<?php echo $form->error($model,'pics'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '提交' : '保存'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->