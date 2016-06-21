<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AwTeam */

$this->title = '添加组合';
$this->params['breadcrumbs'][] = ['label' => '组合信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-team-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
