<?php

namespace app\models\planilhas;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\planilhas\Precificacao;

/**
 * PrecificacaoSearch represents the model behind the search form about `app\models\planilhas\Precificacao`.
 */
class PrecificacaoSearch extends Precificacao
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['planp_id', 'planp_codunidade', 'planp_planodeacao', 'planp_cargahoraria', 'planp_qntaluno', 'planp_totalhorasdocente', 'planp_docente', 'planp_servpedagogico'], 'integer'],
            [['planp_valorhoraaula', 'planp_horaaulaplanejamento', 'planp_totalcustodocente', 'planp_decimo', 'planp_ferias', 'planp_tercoferias', 'planp_totalsalario', 'planp_encargos', 'planp_totalencargos', 'planp_totalsalarioencargo', 'planp_diarias', 'planp_passagens', 'planp_pessoafisica', 'planp_pessoajuridica', 'planp_totalcustodireto', 'planp_totalhoraaulacustodireto'], 'number'],
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
        $query = Precificacao::find();

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
            'planp_id' => $this->planp_id,
            'planp_codunidade' => $this->planp_codunidade,
            'planp_planodeacao' => $this->planp_planodeacao,
            'planp_cargahoraria' => $this->planp_cargahoraria,
            'planp_qntaluno' => $this->planp_qntaluno,
            'planp_totalhorasdocente' => $this->planp_totalhorasdocente,
            'planp_docente' => $this->planp_docente,
            'planp_valorhoraaula' => $this->planp_valorhoraaula,
            'planp_servpedagogico' => $this->planp_servpedagogico,
            'planp_horaaulaplanejamento' => $this->planp_horaaulaplanejamento,
            'planp_totalcustodocente' => $this->planp_totalcustodocente,
            'planp_decimo' => $this->planp_decimo,
            'planp_ferias' => $this->planp_ferias,
            'planp_tercoferias' => $this->planp_tercoferias,
            'planp_totalsalario' => $this->planp_totalsalario,
            'planp_encargos' => $this->planp_encargos,
            'planp_totalencargos' => $this->planp_totalencargos,
            'planp_totalsalarioencargo' => $this->planp_totalsalarioencargo,
            'planp_diarias' => $this->planp_diarias,
            'planp_passagens' => $this->planp_passagens,
            'planp_pessoafisica' => $this->planp_pessoafisica,
            'planp_pessoajuridica' => $this->planp_pessoajuridica,
            'planp_totalcustodireto' => $this->planp_totalcustodireto,
            'planp_totalhoraaulacustodireto' => $this->planp_totalhoraaulacustodireto,
        ]);

        return $dataProvider;
    }
}
