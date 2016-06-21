<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AwIndividualRank */

$this->title = '添加个人排名记录';
$this->params['breadcrumbs'][] = ['label' => '个人排名信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-individual-rank-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
