<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UserProfile;
use Yii;

/**
 * UserProfileSearch represents the model behind the search form of `app\models\UserProfile`.
 */
class UserProfileSearch extends UserProfile
{
    public $status;
    public $fic_affiliation;
    public $designation;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'designation_id'], 'integer'],
            [['firstname', 'lastname', 'middlename', 'fic_affiliation', 'designation', 'status', 'created_at', 'updated_at'], 'safe'],
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
        $query = UserProfile::find()->joinWith(['user', 'fic', 'designation']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['defaultPageSize'],
            ],
        ]);

        $dataProvider->sort->attributes['status'] = [
            'asc' => ['user.status' => SORT_ASC],
            'desc' => ['user.status' => SORT_DESC]
        ];

        $dataProvider->sort->attributes['fic_affiliation'] = [
            'asc' => ['fic.name' => SORT_ASC],
            'desc' => ['fic.name' => SORT_DESC]
        ];

        $dataProvider->sort->attributes['designation'] = [
            'asc' => ['designation.description' => SORT_ASC],
            'desc' => ['designation.description' => SORT_DESC]
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
            '{{%user}}.status' => $this->status,
            'designation_id' => $this->designation_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'fic.name', $this->fic_affiliation])
            ->andFilterWhere(['like', '{{%designation}}.description', $this->designation]);

        return $dataProvider;
    }
}
