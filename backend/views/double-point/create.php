<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AwDoublePoint */

$this->title = '添加双打积分记录';
$this->params['breadcrumbs'][] = ['label' => '双打积分记录', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-double-point-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
