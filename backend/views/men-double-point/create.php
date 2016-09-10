<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AwMenDoublePoint */

$this->title = 'Create Aw Men Double Point';
$this->params['breadcrumbs'][] = ['label' => 'Aw Men Double Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-men-double-point-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
