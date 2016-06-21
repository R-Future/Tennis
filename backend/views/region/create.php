<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AwRegion */

$this->title = '添加地区';
$this->params['breadcrumbs'][] = ['label' => '地区信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-region-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
