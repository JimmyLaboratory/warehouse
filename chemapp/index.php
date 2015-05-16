<?php

// change the following paths if necessary
$yii=dirname(dirname(__FILE__)).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
/*
* TJ:此处设置时区，修正出现的echo date(‘Y’);报错
*/
date_default_timezone_set("PRC");

require_once($yii);
Yii::createWebApplication($config)->run();

/*TJ:全局函数在这里编写，暂时
	2015年5月16日10:01:41
	这个是用于缩减表格中超链接按钮类的函数
	未完待续,这个位置不对，要放在那个表格类中比较好，但我找不到
	
	public function getButtonColumn($header,$label,$options,$url,$visible) {
		return
				array(
						'visible'=>Yii::app()->authManager->checkAccess("college",Yii::app()->user->getId())&&isset($_GET['ING']),
						'header'=>'操作',
						'class'=>'CButtonColumn',
						'updateButtonImageUrl'=>array('style'=>'display:none'), 
						'template'=>'{update}',
						'buttons'=>array(
							'update' => array(
								'label'=>'入库',
								'options'=>array('target'=>'_blank'),
								'url'=>'Yii::app()->createUrl("instorage/create",array("id"=>$data->purchasing_id))',
							)
						)
					)
	}

public function getLinkColumn($header,$label,$linkoptions,$url,$visible) {
	return
		array(
            'class'=>'CLinkColumn',
            'header'=>"'".$head."'",
			'linkHtmlOptions'=>$linkoptions,//array('target'=>'_blank'),
            'labelExpression'=>"'".//'$data->purchasing_id',
            'urlExpression'=>'Yii::app()->createUrl("purchasing/view",array("id"=>$data->purchasing_id, "refer"=>"purchase"))',
        )
}*/