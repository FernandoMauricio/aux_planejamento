<?php

namespace app\models\solicitacao_precificacao;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\solicitacao_precificacao\SolicitacaoPrecificacao;

/**
 * SolicitacaoPrecificacaoSearch represents the model behind the search form about `app\models\solicitacao_precificacao\SolicitacaoPrecificacao`.
 */
class SolicitacaoPrecificacaoSearch extends SolicitacaoPrecificacao
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['solpre_id', 'solpre_cargahoraria', 'solpre_qntaluno', 'solpre_codplano'], 'integer'],
            [['solpre_titulo', 'solpre_observacao', 'solpre_autorizacao', 'solpre_dataautorizacao', 'solpre_situacao', 'solpre_unidade', 'solpre_solicitante'], 'safe'],
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
        $query = SolicitacaoPrecificacao::find();

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
            'solpre_id' => $this->solpre_id,
            'solpre_cargahoraria' => $this->solpre_cargahoraria,
            'solpre_qntaluno' => $this->solpre_qntaluno,
            'solpre_codplano' => $this->solpre_codplano,
            'solpre_dataautorizacao' => $this->solpre_dataautorizacao,
        ]);

        $query->andFilterWhere(['like', 'solpre_titulo', $this->solpre_titulo])
            ->andFilterWhere(['like', 'solpre_observacao', $this->solpre_observacao])
            ->andFilterWhere(['like', 'solpre_autorizacao', $this->solpre_autorizacao])
            ->andFilterWhere(['like', 'solpre_situacao', $this->solpre_situacao])
            ->andFilterWhere(['like', 'solpre_unidade', $this->solpre_unidade])
            ->andFilterWhere(['like', 'solpre_solicitante', $this->solpre_solicitante]);

        return $dataProvider;
    }
}
