<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EquipmentIssue;

/**
 * EquipmentIssueSearch represents the model behind the search form of `app\models\EquipmentIssue`.
 */
class EquipmentIssueSearch extends EquipmentIssue
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fic_equipment_id', 'status'], 'integer'],
            [['global_id', 'fic_equipment_gid', 'title', 'description', 'reported_by', 'created_at', 'updated_at'], 'safe'],
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
        $query = EquipmentIssue::find();
        // if (!empty($params['id']))
        //     $query->andWhere(['fic_equipment_id' => $params['id']]);

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
            'fic_equipment_id' => $this->fic_equipment_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'global_id', $this->global_id])
            ->andFilterWhere(['like', 'fic_equipment_gid', $this->fic_equipment_gid])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'reported_by', $this->reported_by]);

        return $dataProvider;
    }
}
