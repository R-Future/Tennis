<?php

namespace backend\models\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AwArena;

/**
 * AwArenaSearch represents the model behind the search form about `app\models\AwArena`.
 */
class AwArenaSearch extends AwArena
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'region_id', 'indoor_field_number', 'outdoor_field_number'], 'integer'],
            [['name', 'address', 'field_type', 'create_at', 'update_at', 'comment'], 'safe'],
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
     *
     * author:Future
     * time:2016.5.19 17:27
     * modified: add a new argument '$region_id'
     */
    public function search($params,$region_id)
    {
        $query = AwArena::find();

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
            'region_id' => is_null($region_id)?$this->region_id:$region_id,
            'indoor_field_number' => $this->indoor_field_number,
            'outdoor_field_number' => $this->outdoor_field_number,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'field_type', $this->field_type])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
