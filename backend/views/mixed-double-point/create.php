<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AwMixedDoublePoint */

$this->title = 'Create Aw Mixed Double Point';
$this->params['breadcrumbs'][] = ['label' => 'Aw Mixed Double Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-mixed-double-point-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
