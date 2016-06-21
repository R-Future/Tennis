<?php

namespace backend\models\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AwActive;

/**
 * AwActiveSearch represents the model behind the search form about `common\models\AwActive`.
 */
class AwActiveSearch extends AwActive
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'place'], 'integer'],
            [['time', 'active', 'create_at', 'update_at', 'comment'], 'safe'],
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
        $query = AwActive::find();

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
            'time' => $this->time,
            'place' => $this->place,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
            'is_invalidated' => $this->is_invalidated,
        ]);

        $query->andFilterWhere(['like', 'active', $this->active])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
