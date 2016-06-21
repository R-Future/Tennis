<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AwActive */

$this->title = '添加活动记录';
$this->params['breadcrumbs'][] = ['label' => '活动记录', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-active-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
