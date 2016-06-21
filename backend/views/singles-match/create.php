<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AwSinglesMatch */

$this->title = '新增比赛记录';
$this->params['breadcrumbs'][] = ['label' => '单打比赛', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-singles-match-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
