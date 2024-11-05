<?php

namespace app\modules\ficModule\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\JobOrderRequest;

/**
 * JobOrderRequestSearch represents the model behind the search form of `app\models\JobOrderRequest`.
 */
class JobOrderRequestSearch extends JobOrderRequest
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fic_id', 'requestor_profile_id', 'status'], 'integer'],
            [['request_type', 'requestor', 'requestor_contact', 'request_description', 'request_date', 'date_approved', 'request_approved_by', 'request_noted_by', 'request_personnel_in_charge', 'date_accomplished', 'created_at', 'updated_at'], 'safe'],
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
        $query = JobOrderRequest::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fic_id' => $this->fic_id,
            'requestor_profile_id' => $this->requestor_profile_id,
            'request_date' => $this->request_date,
            'status' => $this->status,
            'date_approved' => $this->date_approved,
            'date_accomplished' => $this->date_accomplished,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'request_type', $this->request_type])
            ->andFilterWhere(['like', 'requestor', $this->requestor])
            ->andFilterWhere(['like', 'requestor_contact', $this->requestor_contact])
            ->andFilterWhere(['like', 'request_description', $this->request_description])
            ->andFilterWhere(['like', 'request_approved_by', $this->request_approved_by])
            ->andFilterWhere(['like', 'request_noted_by', $this->request_noted_by])
            ->andFilterWhere(['like', 'request_personnel_in_charge', $this->request_personnel_in_charge]);

        return $dataProvider;
    }

    public function searchMyPending($params, $fic_id)
    {
        $query = JobOrderRequest::find();
        $query->where(['status' => JobOrderRequest::STATUS_PENDING]);
        $query->andWhere(['fic_id' => $fic_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fic_id' => $this->fic_id,
            'requestor_profile_id' => $this->requestor_profile_id,
            'request_date' => $this->request_date,
            'status' => $this->status,
            'date_approved' => $this->date_approved,
            'date_accomplished' => $this->date_accomplished,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'request_type', $this->request_type])
            ->andFilterWhere(['like', 'requestor', $this->requestor])
            ->andFilterWhere(['like', 'requestor_contact', $this->requestor_contact])
            ->andFilterWhere(['like', 'request_description', $this->request_description])
            ->andFilterWhere(['like', 'request_approved_by', $this->request_approved_by])
            ->andFilterWhere(['like', 'request_noted_by', $this->request_noted_by])
            ->andFilterWhere(['like', 'request_personnel_in_charge', $this->request_personnel_in_charge]);

        return $dataProvider;
    }
}
