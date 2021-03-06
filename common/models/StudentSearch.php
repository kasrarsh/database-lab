<?php

namespace common\models;

use common\models\Student;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * StudentSearch represents the model behind the search form of `common\models\Student`.
 */
class StudentSearch extends Student
{
    public $idsList = array();
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ID', 'name', 'dept_name','idsList'], 'safe'],
            [['tot_cred'], 'number'],
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
        $query = Student::find();

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
        $query->andFilterWhere(['ID'=>$this->idsList]);
        // grid filtering conditions
        $query->andFilterWhere([
            'tot_cred' => $this->tot_cred,
            'ID' => $this->ID

        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'dept_name', $this->dept_name]);

        return $dataProvider;
    }

    public function searchMyStudent($params)
    {
        $query = Student::find();

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
            'tot_cred' => $this->tot_cred,
            'ID' => $this->ID

        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'dept_name', $this->dept_name]);
        $query->andWhere(['ID'=>$this->idsList]);
        return $dataProvider;
    }
}
