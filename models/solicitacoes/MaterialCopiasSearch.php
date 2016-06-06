<?php

namespace app\models\solicitacoes;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\solicitacoes\MaterialCopias;

/**
 * MaterialCopiasSearch represents the model behind the search form about `app\models\solicitacoes\MaterialCopias`.
 */
class MaterialCopiasSearch extends MaterialCopias
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['matc_id', 'matc_qtoriginais', 'matc_qtexemplares', 'matc_mono', 'matc_color', 'situacao_id'], 'integer'],
            [['matc_descricao', 'matc_curso', 'matc_centrocusto', 'matc_unidade', 'matc_solicitante', 'matc_data'], 'safe'],
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
        $query = MaterialCopias::find();

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
            'matc_id' => $this->matc_id,
            'matc_qtoriginais' => $this->matc_qtoriginais,
            'matc_qtexemplares' => $this->matc_qtexemplares,
            'matc_mono' => $this->matc_mono,
            'matc_color' => $this->matc_color,
            'matc_data' => $this->matc_data,
            'situacao_id' => $this->situacao_id,
        ]);

        $query->andFilterWhere(['like', 'matc_descricao', $this->matc_descricao])
            ->andFilterWhere(['like', 'matc_curso', $this->matc_curso])
            ->andFilterWhere(['like', 'matc_centrocusto', $this->matc_centrocusto])
            ->andFilterWhere(['like', 'matc_unidade', $this->matc_unidade])
            ->andFilterWhere(['like', 'matc_solicitante', $this->matc_solicitante]);

        return $dataProvider;
    }
}
