<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AwDoubleIndividualPoint */

$this->title = '添加双打个人积分';
$this->params['breadcrumbs'][] = ['label' => '双打个人积分', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-double-individual-point-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
