<?php

namespace backend\models\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AwPointType;

/**
 * AwPointTypeSearch represents the model behind the search form about `app\models\AwPointType`.
 */
class AwPointTypeSearch extends AwPointType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tournament', 'round', 'winner_point', 'loser_point','penalty'], 'integer'],
            [['create_at', 'update_at', 'comment'], 'safe'],
            [['is_invalidated'], 'boolean'],
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
     *
     * author: Future
     * time: 17:12 20.5.2016
     * modified: add an argument '$tournament_id'
     */
    public function search($params,$tournament_id)
    {
        $query = AwPointType::find();

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
            'tournament' => is_null($this->tournament)? $tournament_id:$this->tournament,
            'round' => $this->round,
            'winner_point' => $this->winner_point,
            'loser_point' => $this->loser_point,
            'penalty' => $this->penalty,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
            'is_invalidated' => $this->is_invalidated,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
