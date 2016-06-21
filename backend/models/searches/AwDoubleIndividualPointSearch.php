<?php

namespace backend\models\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AwDoubleIndividualPoint;

/**
 * AwDoubleIndividualPointSearch represents the model behind the search form about `app\models\AwDoubleIndividualPoint`.
 */
class AwDoubleIndividualPointSearch extends AwDoubleIndividualPoint
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'player', 'total_matches', 'win_matches', 'margin_bureau', 'point'], 'integer'],
            [['year', 'week', 'create_at', 'update_at', 'comment'], 'safe'],
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
        $query = AwDoubleIndividualPoint::find();

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
            'total_matches' => $this->total_matches,
            'win_matches' => $this->win_matches,
            'margin_bureau' => $this->margin_bureau,
            'point' => $this->point,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
            'is_invalidated' => $this->is_invalidated,
        ]);

        $query->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'week', $this->week])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
