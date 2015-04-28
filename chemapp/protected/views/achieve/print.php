<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>危险品备案单</title>
<style type="text/css">
body{
	font-size: 16px;
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
<div >
  <table width="100%" border="0">
    <tr>
      <td colspan="3" align="center"><h1>危险品备案单</h1></td>
    </tr>
    <tr>
      <td width="33%">备案单编号：<?php echo $model->achieve_id ?></td>
      <td width="33%">&nbsp;</td>
      <td width="33%">打印日期：<?php echo date('Y-m-d') ?></td>
    </tr>
    <tr>
      <td width="33%">备案人姓名：<?php echo $model->achiever ?></td>
      <td width="33%">联系电话：</td>
      <td width="33%">备案人签字：</td>
    </tr>
  </table>
  <table width="100%" border="1" align="center" cellpadding="1" cellspacing="1" >
    <tr >
      <td width="211" valign="center" ><p >化学品名称 </p></td>
      <td width="178" valign="center" ><p >规格 </p></td>
      <td width="178" valign="center" ><p >包装 </p></td>
      <td width="215" valign="center" ><p >申购数量 </p></td>
    </tr>
<?php
$achieve_info = json_decode($model->achieve_info,true);
?>
    <tr >
      <td width="211" valign="center" ><p ><?php echo $achieve_info['chem_name'] ?></p></td>
      <td width="178" valign="center" ><p ><?php echo $achieve_info['quality'] ?></p></td>
      <td width="178" valign="center" ><p ><?php echo $achieve_info['unit'] ?></p></td>
      <td width="215" valign="center" ><p ><?php echo $achieve_info['nums'] ?></p></td>
    </tr>

    
  </table>
  
  <p ></p>
</div>
<!--endprint1-->
</body>
</html>
