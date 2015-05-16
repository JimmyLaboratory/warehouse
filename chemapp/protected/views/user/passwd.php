<h1>修改用户密码</h1>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">标有<span class="required">*</span> 符号为必填项</p>

	<?php echo isset($_GET['msg']) ? $_GET['msg'] : '' ?>

        <div class="row">
                <label for="User_user_name" class="required">请输入原帐号密码 <span class="required">*</span></label>
                <input size="60" maxlength="60" name="User[old_password]" id="User_old_password" type="password" value="">
        </div>
        
        <div class="row">
                <label for="User_user_name" class="required">新密码 <span class="required">*</span></label>
                <input size="60" maxlength="60" name="User[new_password]" id="User_new_password" type="password" value="">
        </div>
        
        <div class="row">
                <label for="User_user_name" class="required">重复输入一次新密码 <span class="required">*</span></label>
                <input size="60" maxlength="60" name="User[new_password_confirm]" id="User_new_password_confirm" type="password" value="">
        </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('确认修改密码'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
        $(function(){
                $('#user-form').submit(function(){
                        if($('#User_old_password').val() == ''){
                                alert('旧密码不可为空，请检查输入');return false;
                        }
                        if($('#User_new_password').val() == ''){
                                alert('新密码不可为空，请检查输入');return false;
                        }
                        if($('#User_new_password').val() != $('#User_new_password_confirm').val()){
                                $('#User_new_password').val('');
                                $('#User_new_password_confirm').val('');
                                alert('新密码两次输入不唯一，请重新输入新密码');return false;
                        }
                        return true;
                });
        });
</script>