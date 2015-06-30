<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>危险品领用申请单</title>
<style type="text/css">
body{
	font-size: 18px;
}
</style>
</head>

<body>
<div >
  <h1 align="center">危险品领用申请单 </h1>
  <p align="center">单号：<?php echo $model->using_id ?>&nbsp;&nbsp;打印日期：<?php echo date('Y-m-d') ?>&nbsp;&nbsp;申请人签字：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
  <table border="1" align="center" cellpadding="1" cellspacing="1" >
    <tr >
      <td width="87" valign="center" ><p >申请人信息 </p></td>
      <td width="686" valign="center" ><p >姓名：<?php echo $model->user->realname ?>&nbsp;&nbsp;学院：<?php echo $model->user->dname ?>&nbsp;&nbsp;联系电话：<?php echo $model->user->tel_long ?>&nbsp; </p></td>
    </tr>
    <tr >
      <td width="87" valign="center" ><p >危险品信息 </p></td>
      <td width="686" valign="center" ><p >名称：<?php echo $model->chemlist->chem_name ?>&nbsp;&nbsp;规格：<?php echo isset($model->chemlist->quality->quality_name) ? $model->chemlist->quality->quality_name : '其它,'.$model->chemlist->quality_other ?>&nbsp;&nbsp; </p>
        <p >包装：<?php echo $model->chemlist->unit_package.' '.$model->chemlist->unit->unit_name ?>&nbsp;&nbsp;存放处：<?php echo Storage::getLevels($model->chemlist->storage_id) ?> </p>
        <p >库存量：<?php echo (float)$model->chemlist->unit_package * (int)$model->chemlist->nums - (float)$model->chemlist->used . $model->chemlist->unit->unit_name ?>&nbsp;&nbsp;申请量：<?php echo $model->applyuse.$model->chemlist->unit->unit_name ?>&nbsp;&nbsp; </p></td>
    </tr>
    <tr >
      <td width="87" valign="center" ><p >申领 </p>
        <p >说明 </p></td>
      <td width="686" valign="center" ><p > </p></td>
    </tr>
    <tr >
      <td width="87" valign="center" ><p >学院意见 </p></td>
      <td width="686" valign="center" ><p > </p></td>
    </tr>
    <tr >
      <td width="87" valign="center" ><p >保卫部意见 </p></td>
      <td width="686" valign="center" ><p > </p></td>
    </tr>
    <tr >
      <td width="87" valign="center" ><p >实验与设备部意见 </p></td>
      <td width="686" valign="center" ><p > </p></td>
    </tr>
  </table>
  <p > </p>
  <p >&nbsp;</p>
</div>
</body>
</html>
