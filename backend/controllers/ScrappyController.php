<?php
/**
 * Created by PhpStorm.
 * User: peRFect
 * Date: 2016/6/15
 * Time: 19:38
 */
namespace backend\controllers;

use common\models\AwSinglesMatch;
use Yii;
use yii\base\Object;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\Controller;
use common\models\AwIndividualRank;
use common\models\AwPlayerInformation;
use common\models\AwSinglePoint;
use common\models\AwMenIndividualPoint;
use common\models\AwWomenIndividualPoint;
use common\base\MyFunction;

const MIXED='混单';
const GOLD='金';
const SILVER='银';
class ScrappyController extends Controller{
    /**
     * @return string
     * 退赛扣分
     */
    public function actionIndex(){
        if(Yii::$app->request->isAjax){
            $year=date('Y');
            $week=date('W');
            $data=Yii::$app->request->post();
            $player_id=explode(":",$data['player_id']);
            $point=explode(":",$data['point']);
            $entry_project=explode(":",$data['entry_project']);
            $entry_project=$entry_project[0];
            $player_id=$player_id[0];
            $point=$point[0];
            $playerModel=new Object();
            switch ($entry_project){
                case '混单':
                    $playerModel=AwSinglePoint::findOne(['player'=>$player_id,'year'=>$year,'week'=>$week]);
                    $playerModel=MyFunction::penalty($playerModel,new AwSinglePoint(),$player_id,$point);
                    break;
                case '男单':
                    $playerModel=AwMenIndividualPoint::findOne(['player'=>$player_id,'year'=>$year,'week'=>$week]);
                    $playerModel=MyFunction::penalty($playerModel,new AwMenIndividualPoint(),$player_id,$point);
                    break;
                case '女单':
                    $playerModel=AwWomenIndividualPoint::findOne(['player'=>$player_id,'year'=>$year,'week'=>$week]);
                    $playerModel=MyFunction::penalty($playerModel,new AwWomenIndividualPoint(),$player_id,$point);

            }
            if($playerModel->save(false)){
                $alert=AwPlayerInformation::findOne($player_id)->name."已被扣除".$point."分 ".MyFunction::getCurrentTime();
                return $this->renderPartial('_alert',['alert'=>$alert]);
            }
        }
        return $this->render('index');
    }

    /**
     * @return string
     * 金银组人员调整
     */
    public function actionAdjust(){
        if(Yii::$app->request->isAjax){
            $data=Yii::$app->request->post();
            $number=explode(":",$data['number']);
            $number=$number[0];
            //查找后number位金组选手并降级到银组
            $gold=AwIndividualRank::find()->innerJoin('aw_player_information','aw_player_information.id=aw_individual_rank.player')->
                  select(['aw_player_information.id','aw_player_information.group'])->
                  where(['aw_individual_rank.rank_type'=>MIXED,'aw_player_information.group'=>GOLD])->
                  orderBy('aw_individual_rank.current_rank desc')->asArray()->all();
            //查找前number为银组选手并升级到金组
            $silver=AwIndividualRank::find()->innerJoin('aw_player_information','aw_player_information.id=aw_individual_rank.player')->
            select(['aw_player_information.id','aw_player_information.group'])->
            where(['aw_individual_rank.rank_type'=>MIXED,'aw_player_information.group'=>SILVER])->
            orderBy('aw_individual_rank.current_rank')->asArray()->all();
            //金组降级
            if(count($gold)<$number){//如果金组人数少于交换人数，则全部降级
                $exchange=count($gold);
            }else{
                $exchange=$number;
            }
            for($i=0;$i<$exchange;$i++){
                $model=AwPlayerInformation::findOne(['id'=>$gold[$i]['id']]);
                $model->group=SILVER;
                $model->update_at=MyFunction::getCurrentTime();
                $model->save(false);
            }
            //银组升级
            if(count($silver)<$number){//如果银组人数少于交换人数，则全部升级
                $exchange=count($silver);
            }else{
                $exchange=$number;
            }
            for($i=0;$i<$exchange;$i++){
                $model=AwPlayerInformation::findOne(['id'=>$silver[$i]['id']]);
                $model->group=GOLD;
                $model->update_at=MyFunction::getCurrentTime();
                $model->save(false);
            }
            $alert='金银组已调整完毕';
            return $this->renderPartial('_alert',['alert'=>$alert]);
        }
    }

    /**
     * 根据参赛项目选择球员列表
     */
    public function actionPlayerList(){
        if(Yii::$app->request->isAjax){
            $data=Yii::$app->request->post();
            $entry_project=explode(":",$data['entry_type']);
            $entry_project=$entry_project[0];
            $players=array();
            switch ($entry_project){
                case '混单':
                    $players=AwPlayerInformation::find()->select('name')->indexBy('id')->column();
                    break;
                case '男单':
                    $players=AwPlayerInformation::find()->select('name')->where(['gender'=>'男'])->indexBy('id')->column();
                    break;
                case '女单':
                    $players=AwPlayerInformation::find()->select('name')->where(['gender'=>'女'])->indexBy('id')->column();
            }
            echo Html::tag('option','--请选择球员--',['value'=>'empty']);
            foreach ($players as $index => $player){
                echo Html::tag('option',Html::encode($player),['value'=>$player,'id'=>$index]);
            }
        }
    }
}