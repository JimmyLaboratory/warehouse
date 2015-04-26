<div class="form">
<script type="text/javascript">
<!--
jQuery(document).ready(function(){
	var sp = document.getElementById('Chemlist_supplier_id');
	var elem = document.createElement('option');
	elem.value = 0;
	elem.text = '其它供应商';
	sp.add(elem, null);
	var other = $('.row:has(#Chemlist_supplier_other)');
	other.hide();
	sp.onchange = function() {
		if (sp.selectedIndex+1 == sp.length) other.show();
		else other.hide();
	};
});
//-->
</script>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'chemlist-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),  
)); ?>

	<p class="note">标有<span class="required">*</span> 符号为必填项</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
                <?php
                        $userInfo = User::getInfo();
                        $purchasing_id = isset($_POST['Chemlist']['purchasing_id']) ? $_POST['Chemlist']['purchasing_id'] :'SG'.$userInfo->department_id.'T'.date('YmdHi').mt_rand(0, 999);
                ?>
		<label for="Chemlist_purchasing_id" class="required">申购单编号</label>
				<span><?php echo $purchasing_id ?></span>
                <input name="Chemlist[purchasing_id]" id="purchasing_id" type="hidden" value="<?php echo $purchasing_id ?>" readonly="true">
        </div>

	<div class="row">
		<label for="Chemlist_user_id" class="required">申购用户</label>
			<span><?php echo $userInfo->realname ?></span>
                <input name="Chemlist[user_id]" id="Chemlist_user_id" type="hidden" value="<?php echo $userInfo->realname ?>" readonly="true">			
        </div>

	<div class="row">
		<?php echo $form->labelEx($model,'chemcat_id'); ?>
		<?php 
                $catLists = Chemcat::model()->findAll();
                $catOptions = array();
                $catOpitonShows = array();
                foreach($catLists as $cat){
                        !isset($catOptions[$cat->parent_id]) && $catOptions[$cat->parent_id][0] = '请选择';
                        $catOptions[$cat->parent_id][$cat->cat_id] = $cat->chemcat_name;
                }
                foreach($catOptions as $key => $value){
                       $catOpitonShows[$key] = $form->dropDownList($model,'chemcat_id',$value,array('class'=>'chemcat_child','child'=>':child'));
                }
                echo $form->dropDownList($model,'chemcat_id',$catOptions[0],array('class'=>'chemcat_child','child'=>'0')); ?>
		</div>
		<?php echo $form->error($model,'chemcat_id'); ?>
                <script>
                        var catOptionShows = <?php echo json_encode($catOpitonShows) ?>;
                        $('body').delegate('.chemcat_child','change',function(){
                                var cat_selected = $(this).val();
                                var cat_child = $(this).attr('child');
                                $('.chemcat_child').each(function(){
                                        if($(this).attr('child') > cat_child){
                                                $(this).remove();
                                        }
                                });
                                if($(this).val() == 0) return true;
                                cat_child++;
                                if(catOptionShows[cat_selected] != undefined){
                                        var catOption = catOptionShows[cat_selected];
                                        catOption = catOption.replace(':child',cat_child);
                                        if(cat_child == 1){
                                                catOption = '<div class="row"><label class="chemcat_child" child="1">类：</label>'+catOption+'</div>'
                                        }
                                        else if(cat_child == 2){
                                                catOption = '<div class="row"><label class="chemcat_child" child="2">项：</label>'+catOption+'</div>'
												console.log($(this).next());
                                        }
                                        else if(cat_child == 3){
                                                catOption = '<div class="row"><label class="chemcat_child" child="3">名：</label>'+catOption+'</div>';
                                        }
                                        $(this).after(catOption);
                                }
                                else{
                                        $('#Chemlist_chem_name').val($(this).find('option:selected').text());
                                }
                        });
                </script>
                
	<!-- </div> -->

        <div class="row">
		<?php echo $form->labelEx($model,'chem_name'); ?>
		<?php echo $form->textField($model,'chem_name',array('size'=>60/*,'readonly'=>'true'*/)); ?>
		<?php echo $form->error($model,'chem_name'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'quality_id'); ?>
                <?php
                $qualities = Quality::model()->findAll();
                $quality_options = array(''=>'请选择');
                foreach($qualities as $quality)
                        $quality_options[$quality['quality_id']] = $quality['quality_name'];
                $quality_options['-1'] = '其它';
                ?>
		<?php echo $form->dropDownList($model,'quality_id', $quality_options); ?>
                <?php echo $form->textField($model,'quality_other',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'quality_id'); ?>
	</div>
        <script>
                $(function(){
                        $('#Chemlist_quality_other').hide();
                        $('#Chemlist_quality_id').change(function(){
                                if($(this).val() == '-1') $('#Chemlist_quality_other').show();
                                else $('#Chemlist_quality_other').hide();
                        });
                });
        </script>

	<div class="row">
		<?php echo $form->labelEx($model,'unit_package'); ?>
		<?php echo $form->textField($model,'unit_package'); ?>
                
                <?php 
                $units = Unit::model()->findAll();
                $unit_options = array(''=>'请选择');
                foreach($units as $unit)
                        $unit_options[$unit['unit_id']] = $unit['unit_name'];
                echo $form->dropDownList($model,'unit_id',$unit_options); 
                ?>
                
		<?php echo $form->error($model,'unit_package'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nums'); ?>
		<?php echo $form->textField($model,'nums'); ?>
		<?php echo $form->error($model,'nums'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'expired'); ?>
		<?php echo $form->textField($model,'expired'); ?>（例：3年）
		<?php echo $form->error($model,'expired'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'producer'); ?>
		<?php echo $form->textField($model,'producer',array('size'=>60,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'producer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'useway'); ?>
		<?php echo $form->dropDownList($model,'useway',  Chemlist::getUsewayOptions()); ?>
		<?php echo $form->error($model,'useway'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'supplier_id'); ?>
		<?php 
                $suppliers = Supplier::model()->findAll();
                $supplier_options = array('0'=>'请选择');
                foreach($suppliers as $supplier)
                        $supplier_options[$supplier['supplier_id']] = $supplier['supplier_name'];
                echo $form->dropDownList($model,'supplier_id',$supplier_options); ?>
		<?php echo $form->error($model,'supplier_id'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'supplier_other'); ?>
		<?php echo $form->textField($model,'supplier_other',array('size'=>60,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'supplier_other'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'supplier_code'); ?>
		<?php echo $form->textField($model,'supplier_code',array('size'=>60,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'supplier_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'specail_note'); ?>
		<?php echo $form->textArea($model,'specail_note',array('rows'=>6, 'cols'=>60)); ?>
		<?php echo $form->error($model,'specail_note'); ?>
	</div>
        <script>
                $('#Chemlist_specail_note').focus(function(){
                        if($(this).text() == '请详细描述该化学品的使用方向以及化学废弃物如何进行处理') $(this).text('');
                });
                $('#Chemlist_specail_note').blur(function(){
                        if($(this).text() == '') $(this).text('请详细描述该化学品的使用方向以及化学废弃物如何进行处理');
                });
                $(function(){
                        if($('#Chemlist_specail_note').text() == '') $('#Chemlist_specail_note').text('请详细描述该化学品的使用方向以及化学废弃物如何进行处理');
                });
        </script>
        
        <div class="row">
		<?php echo $form->labelEx($model,'foundation'); ?>
		<?php echo $form->textArea($model,'foundation',array('rows'=>4, 'cols'=>60)); ?>
		<?php echo $form->error($model,'foundation'); ?>
	</div>
        <script>
                $('#Chemlist_foundation').focus(function(){
                        if($(this).text() == '请说明购买数据测量的依据') $(this).text('');
                });
                $('#Chemlist_foundation').blur(function(){
                        if($(this).text() == '') $(this).text('请说明购买数据测量的依据');
                });
                $(function(){
                        if($('#Chemlist_foundation').text() == '') $('#Chemlist_foundation').text('请说明购买数据测量的依据');
                });
        </script>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>3, 'cols'=>60)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'url'); ?>
        <?php echo $form->textField($model,'url',array('size'=>60, 'maxlength'=>60)); ?>
        <?php echo $form->error($model,'url'); ?>
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