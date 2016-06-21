<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AwWomenIndividualPoint */

$this->title = '添加女单积分';
$this->params['breadcrumbs'][] = ['label' => '女单积分', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-women-individual-point-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
