<h1>采购清单列表</h1>

<div id="purchasing-grid" class="grid-view">
<table class="items">
<thead>
<tr>
<th id="purchasing-grid_c0">采购清单号</th><th id="purchasing-grid_c2">打印</th></tr>
</thead>
<tbody>
<?php
foreach($datas as $data):
?>
        <tr class="odd"><td><?php echo $data['purchasing_no'] ?></td><td><a target="_blank" href="<?php echo Yii::app()->createUrl('/Purchasing/purchasePrint',array('no'=>$data['purchasing_no'])) ?>">打印</a></td></tr>
<?php
endforeach;
?>
</tbody>
</table>
</div>