<?php

namespace backend\models\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AwPlayerInformation;

/**
 * AwPlayerInformationtSearch represents the model behind the search form about `app\models\AwPlayerInformation`.
 */
class AwPlayerInformationtSearch extends AwPlayerInformation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'age', 'height', 'singles_titles','doubles_titles'], 'integer'],
            [['hometown_province','hometown_city','hometown_town','residence_province','residence_city','residence_town'], 'string'],
            [['name', 'gender', 'forehand', 'backhand', 'group', 'retired', 'create_at', 'update_at', 'comment'], 'safe'],
            [['weight', 'playing_years', 'grade'], 'number'],
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
        $query = AwPlayerInformation::find();

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
            'age' => $this->age,
            'height' => $this->height,
            'weight' => $this->weight,
            'hometown_province' => $this->hometown_province,
            'hometown_city' => $this->hometown_city,
            'hometown_town' => $this->hometown_town,
            'residence_province' => $this->residence_province,
            'residence_city' => $this->residence_city,
            'residence_town' => $this->residence_town,
            'playing_years' => $this->playing_years,
            'grade' => $this->grade,
            'singles_titles' => $this->singles_titles,
            'doubles_titles' => $this->doubles_titles,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'forehand', $this->forehand])
            ->andFilterWhere(['like', 'backhand', $this->backhand])
            ->andFilterWhere(['like', 'group', $this->group])
            ->andFilterWhere(['like', 'retired', $this->retired])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
