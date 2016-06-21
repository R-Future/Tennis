<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AwSinglePoint */

$this->title = '添加混单个人积分';
$this->params['breadcrumbs'][] = ['label' => '混单个人积分', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-single-point-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
