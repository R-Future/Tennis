<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/6/16
 * Time: 8:56
 */

/**
 * @var @data
 */

$this->title='男单排名';
//var_dump($players);
$this->registerCssFile('@web/css/table-center.css');
echo $this->render('_indform',['data'=>$data]);
?>