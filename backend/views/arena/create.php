<?php

use yii\helpers\Html;
use common\models\AwRegion;

/* @var $this yii\web\View */
/* @var $model common\models\AwArena */
/* @var $region_id integer*/

$region=(new AwRegion())->findOne($region_id);
$this->title = '新增球馆';
$this->params['breadcrumbs'][] = ['label' => $region['city'].$region['county'], 'url' => ['region/view', 'id' => $region_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-arena-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'region_id' => $region_id
    ]) ?>

</div>
