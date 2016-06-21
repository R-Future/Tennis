<?php

namespace backend\models\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AwIndividualRank;

/**
 * AwIndividualRankSearch represents the model behind the search form about `app\models\AwIndividualRank`.
 */
class AwIndividualRankSearch extends AwIndividualRank
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'player', 'total_points', 'current_rank', 'highest_rank', 'no1_weeks', 'consecutive_no1_weeks', 'longest_no1_weeks', 'margin_bureau','week'], 'integer'],
            [['rank_type', 'create_at', 'update_at', 'comment'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AwIndividualRank::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'player' => $this->player,
            'total_points' => $this->total_points,
            'current_rank' => $this->current_rank,
            'highest_rank' => $this->highest_rank,
            'no1_weeks' => $this->no1_weeks,
            'consecutive_no1_weeks' => $this->consecutive_no1_weeks,
            'longest_no1_weeks' => $this->longest_no1_weeks,
            'margin_bureau' => $this->margin_bureau,
            'week' => $this->week,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
        ]);

        $query->andFilterWhere(['like', 'rank_type', $this->rank_type])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
