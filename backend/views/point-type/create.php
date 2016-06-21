<?php

use yii\helpers\Html;
use common\models\AwTournament;
/* @var $this yii\web\View */
/* @var $model common\models\AwPointType */
/* @var $tournament_id common\models\AwTournament*/

$tournament=AwTournament::find()->select(['id','name'])->where(['id'=>$tournament_id])->asArray()->all();
//var_dump($tournament);
$this->title = '添加积分规则';
$this->params['breadcrumbs'][] = ['label' => $tournament[0]['name'], 'url' => ['tournament/view','id'=>$tournament_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aw-point-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tournament' => $tournament
    ]) ?>

</div>
