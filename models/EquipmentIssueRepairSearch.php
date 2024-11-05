<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EquipmentIssueRepair;

/**
 * EquipmentIssueRepairSearch represents the model behind the search form of `app\models\EquipmentIssueRepair`.
 */
class EquipmentIssueRepairSearch extends EquipmentIssueRepair
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'equipment_issue_id'], 'integer'],
            [['global_id', 'repair_activity', 'performed_by', 'created_at', 'updated_at'], 'safe'],
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
        $query = EquipmentIssueRepair::find();
        $query->joinWith(['equipmentIssue']);
        if (!empty($params['id']))
            $query->andWhere(['{{%equipment_issue}}.fic_equipment_id' => $params['id']]);
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
            'equipment_issue_id' => $this->equipment_issue_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'global_id', $this->global_id])
            ->andFilterWhere(['like', 'repair_activity', $this->repair_activity])
            ->andFilterWhere(['like', 'performed_by', $this->performed_by]);

        return $dataProvider;
    }
}
