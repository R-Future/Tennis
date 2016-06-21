<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\AwSinglesMatch;
use common\models\AwDoublesMatch;
/* @var $this yii\web\View */
/* @var $model common\models\AwMatchScore */

$this->title = $model->id;

if(preg_match("/d/",$model->match_id)){
    $match=AwDoublesMatch::find()->select(['id'])->where(['scores'=>$model->match_id])->one();
    $this->params['breadcrumbs'][] = ['label' => '双打比赛', 'url' => ['doubles-match/view','id'=>$match['id']]];
}
if(preg_match("/s/",$model->match_id)){
    $match=AwSinglesMatch::find()->select(['id'])->where(['scores'=>$model->match_id])->one();
    $this->params['breadcrumbs'][] = ['label' => '单打比赛', 'url' => ['singles-match/view','id'=>$match['id']]];
}

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-match-score-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'match_id',
            'set',
            'player1_score',
            'player2_score',
            'tie_player1_score',
            'tie_player2_score',
        ],
    ]) ?>

</div>
