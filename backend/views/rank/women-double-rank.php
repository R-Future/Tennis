<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/5/28
 * Time: 0:14
 */

/**
 * @var $data
 */
$this->title='女双排名';
//var_dump($teams);
$this->registerCssFile('@web/css/table-center.css');
echo $this->render('_douform',['data'=>$data])
?>
