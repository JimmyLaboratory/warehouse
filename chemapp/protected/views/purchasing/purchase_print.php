<?php
$criteria = new CDbCriteria;
$criteria ->addInCondition('purchasing_no', array($no));
$criteria ->compare('status', Purchasing::STATUS_PURCHASING);
$purchasing_ids = $model -> findAll($criteria);
if(empty($purchasing_ids)) throw new CHttpException(404,'选中的订单并未进入采购状态');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>危险品备案单</title>
<style type="text/css">
body{
	font-size: 14px;
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
      <td colspan="3" align="center"><h1>危险品采购单</h1></td>
    </tr>
    <tr>
      <td width="45%">采购单编号：<?php echo $purchasing_ids[0]->purchasing_id ?></td>
      <td width="30%">打印日期：<?php echo date('Y-m-d') ?>&nbsp;&nbsp;</td>
      <td width="25%">采购人签字：</td>
    </tr>
    <?php 
  $showed = array();
  foreach($purchasing_ids as $purchasing){
          if(isset($showed[$purchasing -> chemlist -> supplier -> supplier_id]))continue;
  ?>
    <tr>
      <td width="45%">供应商：<?php echo $purchasing -> chemlist -> supplier -> supplier_name; ?></td>
      <td width="30%">供应商联系人：<?php echo $purchasing -> chemlist -> supplier -> contact; ?></td>
      <td width="25%">联系电话：<?php echo $purchasing -> chemlist -> supplier -> tel; ?></td>
    </tr>
    <?php 
  $showed[$purchasing -> chemlist -> supplier -> supplier_id] = true;
  } ?>
  </table>
  
  <table width="100%" border="1" align="center" cellpadding="1" cellspacing="1">
    <tr >
      <td width="211" valign="center" ><p >化学品名称 </p></td>
      <td width="178" valign="center" ><p >规格 </p></td>
      <td width="178" valign="center" ><p >包装 </p></td>
      <td width="100" valign="center" ><p >采购数量 </p></td>
      <td width="120" valign="center" ><p >供应商 </p></td>
    </tr>
<?php
        foreach($purchasing_ids as $purchasing):
?>
    <tr >
      <td width="211" valign="center" ><p ><?php echo $purchasing->chemlist->chem_name ?></p></td>
      <td width="178" valign="center" ><p ><?php echo isset($purchasing->chemlist->quality->quality_name) ? $purchasing->chemlist->quality->quality_name : '其它,'.$purchasing->chemlist->quality_other ?></p></td>
      <td width="178" valign="center" ><p ><?php echo $purchasing->chemlist->unit_package.' '.$purchasing->chemlist->unit->unit_name ?></p></td>
      <td width="100" valign="center" ><p ><?php echo $purchasing->chemlist->nums ?></p></td>
      <td width="120" valign="center" ><p ><?php echo $purchasing->chemlist -> supplier -> supplier_name ?></p></td>
    </tr>
<?php
endforeach;
?>
  </table>
</div>
<!--endprint1-->
</body>
</html>
