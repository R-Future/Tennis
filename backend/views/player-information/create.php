<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AwPlayerInformation */

$this->title = '添加球员信息';
$this->params['breadcrumbs'][] = ['label' => '球员列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-player-information-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
