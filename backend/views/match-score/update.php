<?php

use yii\helpers\Html;
use common\models\AwSinglesMatch;
use common\models\AwDoublesMatch;
/* @var $this yii\web\View */
/* @var $model common\models\AwMatchScore */

$this->title = '更新比分信息: ' . ' ' . $model->id;

if(preg_match("/d/",$model->match_id)){
    $match=AwDoublesMatch::find()->select(['id'])->where(['scores'=>$model->match_id])->one();
    $this->params['breadcrumbs'][] = ['label' => '双打比赛', 'url' => ['doubles-match/view','id'=>$match['id']]];
}
if(preg_match("/s/",$model->match_id)){
    $match=AwSinglesMatch::find()->select(['id'])->where(['scores'=>$model->match_id])->one();
    $this->params['breadcrumbs'][] = ['label' => '单打比赛', 'url' => ['singles-match/view','id'=>$match['id']]];
}

$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新信息';
?>
<div class="aw-match-score-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
