<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Section;

/**
 * SectionSearch represents the model behind the search form of `common\models\Section`.
 */
class SectionSearch extends Section
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_id', 'sec_id', 'semester', 'building', 'room_number', 'time_slot_id'], 'safe'],
            [['year'], 'number'],
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
        $query = Section::find();

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
            'year' => $this->year,
        ]);

        $query->andFilterWhere(['like', 'course_id', $this->course_id])
            ->andFilterWhere(['like', 'sec_id', $this->sec_id])
            ->andFilterWhere(['like', 'semester', $this->semester])
            ->andFilterWhere(['like', 'building', $this->building])
            ->andFilterWhere(['like', 'room_number', $this->room_number])
            ->andFilterWhere(['like', 'time_slot_id', $this->time_slot_id]);

        return $dataProvider;
    }
}
