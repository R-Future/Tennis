<?php

namespace backend\models\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AwDoublesMatch;

/**
 * AwDoublesMatchSearch represents the model behind the search form about `app\models\AwDoublesMatch`.
 */
class AwDoublesMatchSearch extends AwDoublesMatch
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'team1', 'team2', 'match_place', 'tournament', 'round', 'sets', 'team1_point', 'team2_point'], 'integer'],
            [['team1_quit','team2_quit','is_invalidated'],'boolean'],
            [['match_time', 'entry_project', 'field_type', 'scores', 'win_loss', 'create_at', 'update_at', 'comment'], 'safe'],
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
        $query = AwDoublesMatch::find();

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
            'team1' => $this->team1,
            'team2' => $this->team2,
            'match_time' => $this->match_time,
            'match_place' => $this->match_place,
            'tournament' => $this->tournament,
            'round' => $this->round,
            'sets' => $this->sets,
            'team1_point' => $this->team1_point,
            'team2_point' => $this->team2_point,
            'team1_quit' => $this->team1_quit,
            'team2_quit' => $this->team2_quit,
            'is_invalidated' => $this->is_invalidated,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
        ]);

        $query->andFilterWhere(['like', 'entry_project', $this->entry_project])
            ->andFilterWhere(['like', 'field_type', $this->field_type])
            ->andFilterWhere(['like', 'scores', $this->scores])
            ->andFilterWhere(['like', 'win_loss', $this->win_loss])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
