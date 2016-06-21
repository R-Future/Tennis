<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AwTournament */

$this->title = '添加赛事';
$this->params['breadcrumbs'][] = ['label' => '赛事信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-tournament-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
