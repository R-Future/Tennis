<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '爱网网球俱乐部',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '基本信息',
         'items'=>[
             ['label'=>'球员信息','url'=>['/player-information/index']],
             ['label'=>'场馆信息','url'=>['/region/index']],
             ['label'=>'赛事信息','url'=>['/tournament/index']],
             ['label'=>'双打组合','url'=>['/team/index']],
             ['label'=>'个人排名','url'=>['/individual-rank/index']],
             ['label'=>'俱乐部活动','url'=>['/active/index']],
             ['label'=>'个人活动详情','url'=>['/individual-active/index']],
         ]
        ],
        ['label'=>'积分详情',
         'items'=>[
             ['label'=>'混合个人','url'=>['/single-point/index']],
             ['label'=>'男单个人','url'=>['/men-individual-point/index']],
             ['label'=>'女单个人','url'=>['/women-individual-point/index']],
             ['label'=>'双打个人','url'=>['/double-individual-point/index']],
             ['label'=>'双打组合','url'=>['/double-point/index']],
             ['label'=>'男双组合','url'=>['/men-double-point/index']],
             ['label'=>'女双组合','url'=>['/women-double-point/index']],
             ['label'=>'混双组合','url'=>['/mixed-double-point/index']],
             ['label'=>'个人扣分','url'=>['/deduct-point/index']],
         ]
        ],
        ['label'=>'比赛记录',
         'items'=>[
             ['label'=>'单打比赛记录','url'=>['/singles-match/index']],
             ['label'=>'双打比赛记录','url'=>['/doubles-match/index']],
         ]
        ],
        ['label'=>'单打比赛统计', 'url'=>['/match-record/singles']],
        ['label'=>'双打比赛统计', 'url'=>['/match-record/doubles']],
        ['label'=>'积分排名',
         'items'=>[
            ['label'=>'本赛季单打排名','url'=>['/rank/season-singles-rank']],
            ['label'=>'本赛季双打个人排名','url'=>['/rank/season-doubles-individual-rank']],
            ['label'=>'单打混合排名','url'=>['/rank/singles-rank']],
            ['label'=>'男单排名','url'=>['/rank/men-rank']],
            ['label'=>'女单排名','url'=>['/rank/women-rank']],
            ['label'=>'男双排名','url'=>['/rank/men-double-rank']],
            ['label'=>'女双排名','url'=>['/rank/women-double-rank']],
            ['label'=>'混双排名','url'=>['/rank/mixed-double-rank']],
            ['label'=>'双打混合排名','url'=>['/rank/doubles-rank']],
            ['label'=>'双打个人排名','url'=>['/rank/doubles-individual-rank']],
         ]
        ],
        ['label'=>'H2H', 'url'=>['/match-record/player-search']],
        ['label'=>'球员信息', 'url'=>['/player-show/index']],
        ['label'=>'退赛扣分及球员调整', 'url'=>['/scrappy/index']],
    ];
//    if (Yii::$app->user->isGuest) {
//        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
//    } else {
//        $menuItems[] = '<li>'
//            . Html::beginForm(['/site/logout'], 'post')
//            . Html::submitButton(
//                'Logout (' . Yii::$app->user->identity->username . ')',
//                ['class' => 'btn btn-link']
//            )
//            . Html::endForm()
//            . '</li>';
//    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; 爱网体育发展有限公司 <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
