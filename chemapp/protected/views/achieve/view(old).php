<?php
Yii::app()->getClientScript()->registerCssFile(Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview'.'/styles.css');
$this->breadcrumbs=array(
	'Achieves'=>array('index'),
	$model->achieve_id,
);

$this->menu=array(
	array('label'=>'查看所有备案单', 'url'=>array('admin')),
        array('label'=>'打印备案单', 'url'=>array('print','id'=>$model->achieve_id), 'linkOptions'=>array('target'=>'_blank')),
);
?>

<h1>查看备案单信息</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'achieve_id',
		array(
                    'name'=>'timestamp',
                    'value'=>date('Y-m-d H:i:s',$model->timestamp)
                ),
		'achiever',
		'note',
	),
)); ?>
<div id="purchasing-grid" class="grid-view">
<table class="items">
<thead>
<tr>
<th id="purchasing-grid_c0"><a href="/kehu1023/chemapp/index.php?r=purchasing/toachieve&amp;Purchasing_sort=chem_id">化学品名称</a></th><th id="purchasing-grid_c1"><a href="/kehu1023/chemapp/index.php?r=purchasing/toachieve&amp;Purchasing_sort=chem_id">规格</a></th><th id="purchasing-grid_c2"><a href="/kehu1023/chemapp/index.php?r=purchasing/toachieve&amp;Purchasing_sort=chem_id">包装</a></th><th id="purchasing-grid_c3"><a href="/kehu1023/chemapp/index.php?r=purchasing/toachieve&amp;Purchasing_sort=chem_id">数量</a></th><th id="purchasing-grid_c4"><a href="/kehu1023/chemapp/index.php?r=purchasing/toachieve&amp;Purchasing_sort=chem_id">使用方向</a></th><th id="purchasing-grid_c5"><a href="/kehu1023/chemapp/index.php?r=purchasing/toachieve&amp;Purchasing_sort=chem_id">备注</a></th></tr>
<tr class="filters">
<td><input name="Purchasing[chem_id]" type="text"></td><td><input name="Purchasing[chem_id]" type="text"></td><td><input name="Purchasing[chem_id]" type="text"></td><td><input name="Purchasing[chem_id]" type="text"></td><td><input name="Purchasing[chem_id]" type="text"></td><td><input name="Purchasing[chem_id]" type="text"></td><td></td></tr>
</thead>
<tbody>
<?php
$achieve_info = json_decode($model->achieve_info,true);
foreach($achieve_info as $info):
?>
<tr class="odd"><td><?php echo $info['chem_name'] ?></td><td><?php echo $info['quality'] ?></td><td><?php echo $info['unit'] ?></td><td><?php echo $info['nums'] ?></td><td><?php echo $info['useway'] ?></td><td><?php echo $info['note'] ?></td><td><a target="_blank" title="查看" href="index.php?r=purchasing/view&amp;id=<?php echo $info['purchasing_id'] ?>"><img src="assets/e83dd259/gridview/view.png" alt="查看"></a></td></tr>
<?php
endforeach;
?>
</tbody>
</table>
</div>