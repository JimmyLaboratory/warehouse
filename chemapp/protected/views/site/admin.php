<?php $this->pageTitle=Yii::app()->name; ?>

<h1>系统管理</h1>
<style type="text/css" id="grid-view">
.grid-view-loading
{
	background:url(loading.gif) no-repeat;
}

.grid-view
{
	padding: 15px 0;
}

.grid-view table.items
{
	background: white;
	border-collapse: collapse;
	width: 100%;
	border: 1px #D0E3EF solid;
}

.grid-view table.items th, .grid-view table.items td
{
	font-size: 0.9em;
	border: 1px white solid;
	padding: 0.3em;
}

.grid-view table.items th
{
	color: white;
	background: url("css/bg.gif") repeat-x scroll left top white;
	text-align: center;
}

.grid-view table.items th a
{
	color: #EEE;
	font-weight: bold;
	text-decoration: none;
}

.grid-view table.items th a:hover
{
	color: #FFF;
}

.grid-view table.items tr.even
{
	background: #F8F8F8;
}

.grid-view table.items tr.odd
{
	background: #E5F1F4;
}

.grid-view table.items tr:hover
{
	background: #ECFBD4;
}

</style>
<div class="narrowPage grid-view" style="font-size: 1.5em">
	<table class="items">
		<thead>
			<tr><th>可选操作<th></tr>
		</thead>
		<tbody>
			<tr class="odd"><td><a target="_blank" href="index.php?r=user">用户管理</a></td></tr>
			<tr class="even"><td><a target="_blank" href="index.php?r=department">学院部门管理</a><!-- --></tr>
			<tr class="odd"><td><a target="_blank" href="index.php?r=supplier">供应商管理</a></td></tr>
			<tr class="even"><td><a target="_blank" href="index.php?r=storage/admin">仓库管理</a></td></tr>
			<tr class="even"><td><a target="_blank" href="index.php?r=chemcat/admin">化学品分类管理</a></td></tr>
			<!-- <tr class="odd"><td><a target="_blank" href="index.php?r=quality">化学品规格管理</a></td></tr>	
			<tr class="odd"><td><a target="_blank" href="index.php?r=unit">化学品国际单位管理</a></td></tr> -->
			
			
		</tbody>
	</table>
</div>

