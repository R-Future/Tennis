<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/9/1
 * Time: 23:28
 */
/**
 * @var $data array
 */
$this->title="本赛季单打排名";
$this->registerCssFile('@web/css/table-center.css');
echo $this->render('_seasonForm',['data'=>$data,'luckyNumber'=>8]);