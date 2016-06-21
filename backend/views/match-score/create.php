<?php

use yii\helpers\Html;
use common\models\AwSinglesMatch;
use common\models\AwDoublesMatch;
/* @var $this yii\web\View */
/* @var $model common\models\AwMatchScore */
/* @var $match_id string */

$this->title = '新增比分记录';
if(preg_match("/d/",$match_id)){
    $match=AwDoublesMatch::find()->select(['id'])->where(['scores'=>$match_id])->one();
    $this->params['breadcrumbs'][] = ['label' => '双打比赛', 'url' => ['doubles-match/view','id'=>$match['id']]];
}
if(preg_match("/s/",$match_id)){
    $match=AwSinglesMatch::find()->select(['id'])->where(['scores'=>$match_id])->one();
    $this->params['breadcrumbs'][] = ['label' => '单打比赛', 'url' => ['singles-match/view','id'=>$match['id']]];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-match-score-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'match_id' => $match_id
    ]) ?>

</div>
