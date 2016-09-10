<?php

namespace backend\models\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AwMatchScore;

/**
 * AwMatchScoreSearch represents the model behind the search form about `common\models\AwMatchScore`.
 */
class AwMatchScoreSearch extends AwMatchScore
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'set', 'player1_score', 'player2_score', 'tie_player1_score', 'tie_player2_score'], 'integer'],
            [['match_id'], 'safe'],
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
    public function search($params,$match_id)
    {
        $query = AwMatchScore::find();

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
            'match_id' => is_null($match_id)?$this->match_id:$match_id,
            'set' => $this->set,
            'player1_score' => $this->player1_score,
            'player2_score' => $this->player2_score,
            'tie_player1_score' => $this->tie_player1_score,
            'tie_player2_score' => $this->tie_player2_score,
        ]);

        //$query->andFilterWhere(['like', 'match_id', is_null($match_id)?$this->match_id:$match_id]);

        return $dataProvider;
    }
}
