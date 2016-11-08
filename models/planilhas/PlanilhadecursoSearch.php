<?php

namespace app\models\planilhas;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\planilhas\Planilhadecurso;

/**
 * PlanilhadecursoSearch represents the model behind the search form about `app\models\planilhas\Planilhadecurso`.
 */
class PlanilhadecursoSearch extends Planilhadecurso
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['placu_codplanilha', 'placu_codeixo', 'placu_codsegmento', 'placu_codplano', 'placu_codtipoa', 'placu_codnivel', 'placu_codano', 'placu_codcategoria', 'placu_codtipla', 'placu_quantidadeturmas', 'placu_quantidadealunos', 'placu_quantidadeparcelas', 'placu_codsituacao', 'placu_codcolaborador', 'placu_codunidade', 'placu_quantidadealunospsg', 'placu_tipocalculo', 'placu_cargahorariavivencia', 'placu_quantidadealunosisentos', 'placu_codprogramacao'], 'integer'],
            [['placu_cargahorariaplano', 'placu_cargahorariarealizada', 'placu_cargahorariaarealizar', 'placu_valormensalidade', 'placu_taxaretorno'], 'number'],
            [['placu_nomeunidade', 'placu_observacao', 'planilhadecurso_placucol'], 'safe'],
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
        $query = Planilhadecurso::find();

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
            'placu_codplanilha' => $this->placu_codplanilha,
            'placu_codeixo' => $this->placu_codeixo,
            'placu_codsegmento' => $this->placu_codsegmento,
            'placu_codplano' => $this->placu_codplano,
            'placu_codtipoa' => $this->placu_codtipoa,
            'placu_codnivel' => $this->placu_codnivel,
            'placu_cargahorariaplano' => $this->placu_cargahorariaplano,
            'placu_cargahorariarealizada' => $this->placu_cargahorariarealizada,
            'placu_cargahorariaarealizar' => $this->placu_cargahorariaarealizar,
            'placu_codano' => $this->placu_codano,
            'placu_codcategoria' => $this->placu_codcategoria,
            'placu_codtipla' => $this->placu_codtipla,
            'placu_quantidadeturmas' => $this->placu_quantidadeturmas,
            'placu_quantidadealunos' => $this->placu_quantidadealunos,
            'placu_quantidadeparcelas' => $this->placu_quantidadeparcelas,
            'placu_valormensalidade' => $this->placu_valormensalidade,
            'placu_codsituacao' => $this->placu_codsituacao,
            'placu_codcolaborador' => $this->placu_codcolaborador,
            'placu_codunidade' => $this->placu_codunidade,
            'placu_quantidadealunospsg' => $this->placu_quantidadealunospsg,
            'placu_tipocalculo' => $this->placu_tipocalculo,
            'placu_taxaretorno' => $this->placu_taxaretorno,
            'placu_cargahorariavivencia' => $this->placu_cargahorariavivencia,
            'placu_quantidadealunosisentos' => $this->placu_quantidadealunosisentos,
            'placu_codprogramacao' => $this->placu_codprogramacao,
        ]);

        $query->andFilterWhere(['like', 'placu_nomeunidade', $this->placu_nomeunidade])
            ->andFilterWhere(['like', 'placu_observacao', $this->placu_observacao])
            ->andFilterWhere(['like', 'planilhadecurso_placucol', $this->planilhadecurso_placucol]);

        return $dataProvider;
    }
}