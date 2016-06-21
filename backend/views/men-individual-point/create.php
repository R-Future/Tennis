<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AwMenIndividualPoint */

$this->title = '添加男单积分';
$this->params['breadcrumbs'][] = ['label' => '男单积分', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-men-individual-point-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
