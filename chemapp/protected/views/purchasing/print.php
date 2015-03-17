<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>危险品申购单</title>
<style type="text/css">
body{
	font-size: 16px;
        size : auto ;
}
</style>
<script>
function preview(oper)
{
if (oper < 10)
{
	bdhtml=window.document.body.innerHTML;//获取当前页的html代码
	sprnstr="<!--startprint"+oper+"-->";//设置打印开始区域
	eprnstr="<!--endprint"+oper+"-->";//设置打印结束区域
	prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+18); //从开始代码向后取html
 
	prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html
	window.document.body.innerHTML=prnhtml;
	window.print();
	window.document.body.innerHTML=bdhtml;
} 
else 
{
	window.print();
}
}
</script>
</head>

<body>
<p style="text-align:center"><br /><input id="btnPrint" type="button" value="打印订单" onclick=preview(1) style="width:120px;height:40px;font-size: 14px" /><br /><br /></p>
<!--startprint1-->
<div style="margin:auto">
  <table width="100%" border="0">
    <tr>
      <td colspan="3" align="center"><h1><span style=" font-size:36px">危险品申购单</span></h1></td>
    </tr>
    <tr>
      <td width="45%">申购单编号：<?php echo $model->purchasing_id ?>&nbsp;&nbsp;</td>
      <td width="30%">打印日期：<?php echo date('Y-m-d') ?>&nbsp;&nbsp;</td>
      <td width="25%">申购人签字： </td>
    </tr>
  </table>
  <table width="100%" border="1" align="center" cellpadding="1" cellspacing="1" >
    <tr height="50" >
      <td colspan="2" valign="center" >&nbsp;</td>
    </tr>
    <tr >
      <td width="100" align="center" valign="center" ><p >申购人信息 </p></td>
      <td width="690" valign="center" ><p >姓名：<?php echo $model->user->realname ?>&nbsp;学院：<?php echo $model->user->department->department_name ?>&nbsp;&nbsp;联系电话：<?php echo $model->user->tel_long ?> </p></td>
    </tr>
    <tr >
      <td width="100" align="center" valign="center" ><p >危险品信息 </p></td>
      <td width="690" valign="center" ><p >名称：<?php echo $model->chemlist->chem_name ?>&nbsp;&nbsp;规格：<?php echo isset($model->chemlist->quality->quality_name) ? $model->chemlist->quality->quality_name : '其它,'.$model->chemlist->quality_other ?>&nbsp;&nbsp; </p>
        <p >包装：<?php echo $model->chemlist->unit_package.' '.$model->chemlist->unit->unit_name ?>&nbsp;&nbsp;数量： <?php echo $model->chemlist->nums ?></p></td>
    </tr>
    <tr >
      <td width="100" align="center" valign="center" ><p >申购缘由 </p></td>
      <td width="690" height="80" valign="center" ><p ><?php echo $model->chemlist->specail_note ?> </p></td>
    </tr>
    <tr >
      <td width="100" align="center" valign="center" ><p >数量测算依据 </p></td>
      <td width="690" height="80" valign="center" ><p ><?php echo $model->chemlist->foundation ?> </p></td>
    </tr>
    <tr >
      <td width="100" align="center" valign="center" ><p >学院意见 </p></td>
      <td width="690" height="140" valign="center" ><p > </p></td>
    </tr>
    <tr >
      <td width="100" align="center" valign="center" ><p >保卫部意见 </p></td>
      <td width="690" height="140" valign="center" ><p > </p></td>
    </tr>
    <tr >
      <td width="100" align="center" valign="center" ><p >实验与设备部意见 </p></td>
      <td width="690" height="150" valign="center" ><p ></p></td>
    </tr>
  </table>
</div>
<!--endprint1-->
</body>
</html>
