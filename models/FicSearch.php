<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Fic;
use Yii;

/**
 * FicSearch represents the model behind the search form of `app\models\Fic`.
 */
class FicSearch extends Fic
{
    public $region;
    public $province;
    public $municipalityCity;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['municipalityCity', 'province', 'region'], 'safe'],
            [['id', 'municipality_city_id'], 'integer'],
            [['name', 'address', 'suc', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Fic::find();
        $query->joinWith(['municipalityCity', 'province', 'region']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['defaultPageSize'],
            ],
        ]);

        $dataProvider->sort->attributes['region'] = [
            'asc' => ['{{%region}}.number' => SORT_ASC],
            'desc' => ['{{%region}}.number' => SORT_DESC]
        ];

        $dataProvider->sort->attributes['province'] = [
            'asc' => ['{{%province}}.name' => SORT_ASC],
            'desc' => ['{{%province}}.name' => SORT_DESC]
        ];

        $dataProvider->sort->attributes['municipalityCity'] = [
            'asc' => ['{{%municipality_city}}.name' => SORT_ASC],
            'desc' => ['{{%municipality_city}}.name' => SORT_DESC]
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'municipality_city_id' => $this->municipality_city_id,
            'suc' => $this->suc,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', '{{%fic}}.name', $this->name])
            ->andFilterWhere(['like', '{{%fic}}.address', $this->address])
            ->andFilterWhere(['like', '{{%region}}.code', $this->region])
            ->andFilterWhere(['like', 'v', $this->province])
            ->andFilterWhere(['like', '{{%municipality_city}}.name', $this->municipalityCity]);

        return $dataProvider;
    }
}
