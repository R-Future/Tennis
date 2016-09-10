<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AwWomenDoublePoint */

$this->title = 'Create Aw Women Double Point';
$this->params['breadcrumbs'][] = ['label' => 'Aw Women Double Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-women-double-point-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
