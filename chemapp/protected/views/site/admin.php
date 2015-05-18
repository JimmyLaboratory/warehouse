<?php $this->pageTitle=Yii::app()->name; ?>
<?php 
Yii::app()->getClientScript()->registerCssFile(Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview'.'/styles.css');
?>

<h1>系统管理</h1>
<style type="text/css" id="grid-view">
.grid-view table.items th
{
	font-size: 100%;
	border: 15px white solid;
	padding: 0.5em 0.0em;
}
</style>
<div class="narrowPage grid-view" style="font-size: 1.6em">
	<!--<table class="items"> -->
		<table class="items">
		<tbody>
			<tr><td></td></tr>
			<tr><td></td></tr>	
			<tr class="even">
				<td border = "20">
					<a target="_blank" href="index.php?r=user">用户管理</a>
					<td></td><td><a target="_blank" href="index.php?r=department">学院部门管理</a></td>
					<td></td><td><a target="_blank" href="index.php?r=supplier">供应商管理</a></td>
					<td></td><td><a target="_blank" href="index.php?r=storage/admin">仓库管理</a></td>
					<td></td><td><a target="_blank" href="index.php?r=chemcat/admin">化学品分类管理</a></td></tr>
				</td>		
			</tr>
			<!-- <tr class="odd"><td><a target="_blank" href="index.php?r=quality">化学品规格管理</a></td></tr>	
			<tr class="odd"><td><a target="_blank" href="index.php?r=unit">化学品国际单位管理</a></td></tr> -->
			
			
		</tbody>
	</table>
</div>

