<?php

namespace app\models\planos;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\planos\Planodeacao;

/**
 * PlanodeacaoSearch represents the model behind the search form about `app\models\planos\Planodeacao`.
 */
class PlanodeacaoSearch extends Planodeacao
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plan_codplano', 'plan_codeixo', 'plan_codsegmento', 'plan_codtipoa', 'plan_codnivel', 'plan_codcolaborador', 'plan_status', 'plan_modelonacional'], 'integer'],
            [['plan_descricao', 'plan_cargahoraria', 'plan_sobre', 'plan_prerequisito', 'plan_orgcurricular', 'plan_perfTecnico', 'plan_data'], 'safe'],
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
        $query = Planodeacao::find();

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
            'plan_codplano' => $this->plan_codplano,
            'plan_codeixo' => $this->plan_codeixo,
            'plan_codsegmento' => $this->plan_codsegmento,
            'plan_codtipoa' => $this->plan_codtipoa,
            'plan_codnivel' => $this->plan_codnivel,
            'plan_codcolaborador' => $this->plan_codcolaborador,
            'plan_data' => $this->plan_data,
            'plan_status' => $this->plan_status,
            'plan_modelonacional' => $this->plan_modelonacional,
        ]);

        $query->andFilterWhere(['like', 'plan_descricao', $this->plan_descricao])
            ->andFilterWhere(['like', 'plan_cargahoraria', $this->plan_cargahoraria])
            ->andFilterWhere(['like', 'plan_sobre', $this->plan_sobre])
            ->andFilterWhere(['like', 'plan_prerequisito', $this->plan_prerequisito])
            ->andFilterWhere(['like', 'plan_orgcurricular', $this->plan_orgcurricular])
            ->andFilterWhere(['like', 'plan_perfTecnico', $this->plan_perfTecnico]);

        return $dataProvider;
    }
}
