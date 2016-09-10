<?php

namespace backend\models\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AwSinglesMatch;

/**
 * AwSinglesMatchSearch represents the model behind the search form about `app\models\AwSinglesMatch`.
 */
class AwSinglesMatchSearch extends AwSinglesMatch
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'player', 'opponent', 'match_place', 'tournament', 'round', 'sets', 'player_point', 'opponent_point'], 'integer'],
            [['player_challenger','opponent_challenger','player_quit', 'opponent_quit', 'is_invalidated'],'boolean'],
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
        $query = AwSinglesMatch::find();

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
            'opponent' => $this->opponent,
            'match_time' => $this->match_time,
            'match_place' => $this->match_place,
            'tournament' => $this->tournament,
            'round' => $this->round,
            'sets' => $this->sets,
            'player_point' => $this->player_point,
            'opponent_point' => $this->opponent_point,
            'player_challenger' => $this->player_challenger,
            'opponent_challenger' => $this->opponent_challenger,
            'player_quit' => $this->player_quit,
            'opponent_quit' => $this->opponent_quit,
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
