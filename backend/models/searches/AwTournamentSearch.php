<?php

namespace backend\models\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AwTournament;

/**
 * AwTournamentSearch represents the model behind the search form about `app\models\AwTournament`.
 */
class AwTournamentSearch extends AwTournament
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'prize'], 'integer'],
            [['name', 'level', 'create_at', 'update_at', 'comment'], 'safe'],
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
     */
    public function search($params)
    {
        $query = AwTournament::find();

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
            'prize' => $this->prize,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
            'is_invalidated' => $this->is_invalidated,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
