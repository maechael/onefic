<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FicEquipment;
use yii\helpers\ArrayHelper;

/**
 * FicEquipmentSearch represents the model behind the search form of `app\models\FicEquipment`.
 */
class FicEquipmentSearch extends FicEquipment
{
    public $fic;
    public $equipment;

    // public function init()
    // {
    //     parent::init();
    //     $this->attributeLabels();
    // }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fic_id', 'equipment_id', 'status', 'isDeleted', 'version'], 'integer'],
            [['global_id', 'serial_number', 'remarks', 'created_at', 'updated_at', 'fic', 'equipment'], 'safe'],
        ];
    }

    // public function attributeLabels()
    // {
    //     $labels = parent::attributeLabels();
    //     $test =  ArrayHelper::merge([
    //         'fic' => 'Test',
    //     ], $labels);
    //     // return $labels;
    // }

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
        $query = FicEquipment::find();
        $query->joinWith(['fic', 'equipment']);
        $query->orderBy(['fic_id' => SORT_ASC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['fic'] = [
            'asc' => ['{{%fic}}.name' => SORT_ASC],
            'desc' => ['{{%fic}}.name' => SORT_DESC]
        ];

        $dataProvider->sort->attributes['equipment'] = [
            'asc' => ['{{%equipment}}.model' => SORT_ASC],
            'desc' => ['{{%equipment}}.model' => SORT_DESC]
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
            'fic_id' => $this->fic_id,
            'equipment_id' => $this->equipment_id,
            'status' => $this->status,
            'isDeleted' => $this->isDeleted,
            'version' => $this->version,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'global_id', $this->global_id])
            ->andFilterWhere(['like', 'serial_number', $this->serial_number])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', '{{%fic}}.name', $this->fic])
            ->andFilterWhere(['like', '{{%equipment}}.model', $this->equipment]);

        return $dataProvider;
    }
}
