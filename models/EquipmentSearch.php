<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Equipment;
use Yii;

/**
 * EquipmentSearch represents the model behind the search form of `app\models\Equipment`.
 */
class EquipmentSearch extends Equipment
{
    public $equipmentType;
    public $equipmentCategory;
    public $processingCapability;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'equipment_type_id', 'equipment_category_id', 'processing_capability_id'], 'integer'],
            [['model', 'equipmentType', 'equipmentCategory', 'processingCapability', 'created_at', 'updated_at'], 'safe'],
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
        $query = Equipment::find()->joinWith(['equipmentType', 'equipmentCategory', 'processingCapability']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['defaultPageSize'],
            ],
        ]);

        $dataProvider->sort->attributes['equipmentCategory'] = [
            'asc' => ['equipment_category.name' => SORT_ASC],
            'desc' => ['equipment_category.name' => SORT_DESC]
        ];

        $dataProvider->sort->attributes['equipmentType'] = [
            'asc' => ['equipment_type.name' => SORT_ASC],
            'desc' => ['equipment_type.name' => SORT_DESC]
        ];

        $dataProvider->sort->attributes['processingCapability'] = [
            'asc' => ['processing_capability.name' => SORT_ASC],
            'desc' => ['processing_capability.name' => SORT_DESC]
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
            'equipment_type_id' => $this->equipment_type_id,
            'equipment_category_id' => $this->equipment_category_id,
            'processing_capability_id' => $this->processing_capability_id,
            //'{{%equipment_type}}.id' => $this->equipmentType,
            // 'equipment.created_at' => $this->created_at,
            // 'equipment.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', '{{%equipment_type}}.name', $this->equipmentType])
            ->andFilterWhere(['like', '{{%equipment_category}}.name', $this->equipmentCategory])
            ->andFilterWhere(['like', '{{%processing_capability}}.name', $this->processingCapability])
            ->andFilterWhere(['like', '{{%equipment}}.created_at', $this->created_at])
            ->andFilterWhere(['like', '{{%equipment}}.updated_at', $this->updated_at]);

        return $dataProvider;
    }
}
