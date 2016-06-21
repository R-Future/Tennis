<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AwDoublesMatch */

$this->title = 'Create Aw Doubles Match';
$this->params['breadcrumbs'][] = ['label' => 'Aw Doubles Matches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-doubles-match-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
