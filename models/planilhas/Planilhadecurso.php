<?php

namespace app\models\planilhas;

use Yii;
use app\models\cadastros\Ano;
use app\models\cadastros\Eixo;
use app\models\cadastros\Nivel;
use app\models\cadastros\Segmento;
use app\models\cadastros\Tipo;
use app\models\cadastros\Categoriaplanilha;
use app\models\cadastros\Tipoprogramacao;
use app\models\cadastros\Tipoplanilha;
use app\models\cadastros\Situacaoplanilha;
use app\models\planos\Planodeacao;
/**
 * This is the model class for table "planilhadecurso_placu".
 *
 * @property string $placu_codplanilha
 * @property string $placu_codeixo
 * @property string $placu_codsegmento
 * @property string $placu_codplano
 * @property string $placu_codtipoa
 * @property string $placu_codnivel
 * @property double $placu_cargahorariaplano
 * @property double $placu_cargahorariarealizada
 * @property double $placu_cargahorariaarealizar
 * @property string $placu_codano
 * @property string $placu_codcategoria
 * @property string $placu_codtipla
 * @property integer $placu_quantidadeturmas
 * @property integer $placu_quantidadealunos
 * @property integer $placu_quantidadeparcelas
 * @property double $placu_valormensalidade
 * @property string $placu_codsituacao
 * @property integer $placu_codcolaborador
 * @property integer $placu_codunidade
 * @property string $placu_nomeunidade
 * @property integer $placu_quantidadealunospsg
 * @property integer $placu_tipocalculo
 * @property string $placu_arquivolistamaterial
 * @property string $placu_listamaterialdoaluno
 * @property string $placu_observacao
 * @property double $placu_taxaretorno
 * @property integer $placu_cargahorariavivencia
 * @property integer $placu_quantidadealunosisentos
 * @property string $placu_codprogramacao
 *
 * @property HistoricoplanilhaHis[] $historicoplanilhaHis
 * @property ObservacaoplanilhaObpla[] $observacaoplanilhaObplas
 * @property AnoAn $placuCodano
 * @property CategoriaplanilhaCat $placuCodcategoria
 * @property EixoEix $placuCodeixo
 * @property NivelNiv $placuCodnivel
 * @property PlanodeacaoPlan $placuCodplano
 * @property TipoprogramacaoTipro $placuCodprogramacao
 * @property SegmentoSeg $placuCodsegmento
 * @property SegmentotipoacaoSegtip $placuCodsegtip
 * @property SituacaoplanilhaSipla $placuCodsituacao
 * @property TipoplanilhaTipla $placuCodtipla
 * @property TipodeacaoTip $placuCodtipoa
 * @property PlanilhadespesaPlades[] $planilhadespesaPlades
 */
class Planilhadecurso extends \yii\db\ActiveRecord
{
    public $nivelLabel;
    public $segmentoLabel;
    public $eixoLabel;
    public $tipoAcaoLabel;
    public $PlanoLabel;
    public $anoLabel;
    public $tipoPlanilhaLabel;
    public $tipoProgramacaoLabel;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'planilhadecurso_placu';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_apl');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['placu_codeixo', 'placu_codsegmento', 'placu_codplano', 'placu_codtipoa', 'placu_codnivel', 'placu_codano', 'placu_codcategoria', 'placu_codtipla', 'placu_codsituacao', 'placu_codcolaborador', 'placu_codunidade', 'placu_nomeunidade', 'placu_tipocalculo', 'placu_quantidadealunos', 'placu_quantidadealunospsg', 'placu_quantidadealunosisentos'], 'required'],
            [['placu_codeixo', 'placu_codsegmento', 'placu_codplano', 'placu_codtipoa', 'placu_codnivel', 'placu_codano', 'placu_codcategoria', 'placu_codtipla', 'placu_quantidadeturmas', 'placu_quantidadealunos', 'placu_quantidadeparcelas', 'placu_codsituacao', 'placu_codcolaborador', 'placu_codunidade', 'placu_quantidadealunospsg', 'placu_tipocalculo', 'placu_cargahorariavivencia', 'placu_quantidadealunosisentos', 'placu_codprogramacao'], 'integer'],
            [['placu_cargahorariaplano', 'placu_cargahorariarealizada', 'placu_cargahorariaarealizar', 'placu_valormensalidade', 'placu_taxaretorno'], 'number'],
            [['nivelLabel', 'segmentoLabel', 'eixoLabel', 'tipoAcaoLabel', 'PlanoLabel', 'tipoProgramacaoLabel', 'placu_diarias', 'placu_equipamentos', 'placu_pessoafisica', 'placu_pessoajuridica', 'placu_totalcustodocente', 'placu_decimo', 'placu_ferias', 'placu_tercoferias', 'placu_totalsalario', 'placu_encargos', 'placu_totalencargos', 'placu_totalsalarioencargo', 'placu_custosmateriais', 'placu_custosconsumo', 'placu_PJApostila', 'placu_totalcustodireto', 'placu_totalhoraaulacustodireto', 'placu_hiddenmaterialdidatico', 'placu_hiddenpjapostila'], 'safe'],
            [['placu_observacao'], 'string'],
            [['placu_nomeunidade'], 'string', 'max' => 150],
            [['placu_codano'], 'exist', 'skipOnError' => true, 'targetClass' => Ano::className(), 'targetAttribute' => ['placu_codano' => 'an_codano']],
            [['placu_codcategoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoriaplanilha::className(), 'targetAttribute' => ['placu_codcategoria' => 'cat_codcategoria']],
            [['placu_codeixo'], 'exist', 'skipOnError' => true, 'targetClass' => Eixo::className(), 'targetAttribute' => ['placu_codeixo' => 'eix_codeixo']],
            [['placu_codnivel'], 'exist', 'skipOnError' => true, 'targetClass' => Nivel::className(), 'targetAttribute' => ['placu_codnivel' => 'niv_codnivel']],
            [['placu_codplano'], 'exist', 'skipOnError' => true, 'targetClass' => Planodeacao::className(), 'targetAttribute' => ['placu_codplano' => 'plan_codplano']],
            [['placu_codprogramacao'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoprogramacao::className(), 'targetAttribute' => ['placu_codprogramacao' => 'tipro_codprogramacao']],
            [['placu_codsegmento'], 'exist', 'skipOnError' => true, 'targetClass' => Segmento::className(), 'targetAttribute' => ['placu_codsegmento' => 'seg_codsegmento']],
            [['placu_codsituacao'], 'exist', 'skipOnError' => true, 'targetClass' => Situacaoplanilha::className(), 'targetAttribute' => ['placu_codsituacao' => 'sipla_codsituacao']],
            [['placu_codtipla'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoplanilha::className(), 'targetAttribute' => ['placu_codtipla' => 'tipla_codtipla']],
            [['placu_codtipoa'], 'exist', 'skipOnError' => true, 'targetClass' => Tipo::className(), 'targetAttribute' => ['placu_codtipoa' => 'tip_codtipoa']],
        ];
    }


    //Replace de ',' por '.' nos valores da precificação
    public function beforeSave($insert) {
            if (parent::beforeSave($insert)) {
                $this->placu_totalcustodocente        = str_replace(",", ".", $this->placu_totalcustodocente);
                $this->placu_decimo                   = str_replace(",", ".", $this->placu_decimo);
                $this->placu_ferias                   = str_replace(",", ".", $this->placu_ferias);
                $this->placu_tercoferias              = str_replace(",", ".", $this->placu_tercoferias);
                $this->placu_totalsalario             = str_replace(",", ".", $this->placu_totalsalario);
                $this->placu_encargos                 = str_replace(",", ".", $this->placu_encargos);
                $this->placu_totalencargos            = str_replace(",", ".", $this->placu_totalencargos);
                $this->placu_totalsalarioencargo      = str_replace(",", ".", $this->placu_totalsalarioencargo);
                $this->placu_PJApostila               = str_replace(",", ".", $this->placu_PJApostila);
                $this->placu_custosmateriais          = str_replace(",", ".", $this->placu_custosmateriais);
                $this->placu_custosconsumo            = str_replace(",", ".", $this->placu_custosconsumo);
                $this->placu_diarias                  = str_replace(",", ".", $this->placu_diarias);
                $this->placu_passagens                = str_replace(",", ".", $this->placu_passagens);
                $this->placu_pessoafisica             = str_replace(",", ".", $this->placu_pessoafisica);
                $this->placu_pessoajuridica           = str_replace(",", ".", $this->placu_pessoajuridica);
                $this->placu_totalcustodireto         = str_replace(",", ".", $this->placu_totalcustodireto);
                $this->placu_totalhoraaulacustodireto = str_replace(",", ".", $this->placu_totalhoraaulacustodireto);

                return true;
            } else {
                return false;
            }
        }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'placu_codplanilha' => 'Código',
            'placu_codeixo' => 'Eixo',
            'placu_codsegmento' => 'Segmento',
            'placu_codplano' => 'Plano de Ação',
            'placu_codtipoa' => 'Tipo de Ação',
            'placu_codnivel' => 'Nível',
            'placu_cargahorariaplano' => 'Carga Horária do Plano',
            'placu_cargahorariarealizada' => 'Carga Horária Realizada',
            'placu_cargahorariaarealizar' => 'Carga Horária a Realizar no SENAC',
            'placu_cargahorariavivencia' => 'Carga Horária na Vivência(Aprend)',
            'placu_codano' => 'Ano',
            'placu_codcategoria' => 'Categoria',
            'placu_codtipla' => 'Tipo de Planilha',
            'placu_quantidadeturmas' => 'Quantidade Turmas',
            'placu_quantidadealunos' => 'Quantidade Alunos Pagantes por Turma',
            'placu_quantidadealunospsg' => 'Quantidade Alunos PSG por Turma',
            'placu_quantidadealunosisentos' => 'Quantidade Alunos Isentos por Turma',
            'placu_quantidadeparcelas' => 'Quantidadeparcelas',
            'placu_valormensalidade' => 'Valormensalidade',
            'placu_codsituacao' => 'Situação',
            'placu_codcolaborador' => 'Colaborador',
            'placu_codunidade' => 'Cód. Unidade',
            'placu_nomeunidade' => 'Unidade',
            'placu_tipocalculo' => 'Tipocalculo',
            'placu_observacao' => 'Observacao',
            'placu_taxaretorno' => 'Taxaretorno',
            'placu_codprogramacao' => 'Tipo de Programação',

            'placu_totalcustodocente' => 'Custo de Mão de Obra Direta',
            'placu_decimo' => '1/12 de 13º',
            'placu_ferias' => '1/12 de Férias',
            'placu_tercoferias' => '1/12 de 1/3 de férias',
            'placu_totalsalario' => 'Total de Salários',
            'placu_encargos' => '(%) Encargos s/13º, férias e salários',
            'placu_totalencargos' => 'Total de Encargos',
            'placu_totalsalarioencargo' => 'Total de Salários + Encargos',
            'placu_custosmateriais' => 'Mat. Didático (Livros/plano A):',
            'placu_custosconsumo' => 'Mat. de Consumo',
            'placu_diarias' => 'Diárias',
            'placu_passagens' => 'Passagens',
            'placu_pessoafisica' => 'Serv. Terceiros (PF)',
            'placu_pessoajuridica' => 'Serv. Terceiros (PJ)',
            'placu_equipamentos' => 'Equipamentos',
            'placu_PJApostila' => 'Mat. Didático (Apost./plano A):',
            'placu_totalcustodireto' => 'Total de Custo Direto',
            'placu_totalhoraaulacustodireto' => 'V. Hora/Aula de Custo Direto',

            'nivelLabel' => 'Nível',
            'segmentoLabel' => 'Segmento',
            'eixoLabel' => 'Eixo',
            'tipoAcaoLabel' => 'Tipo de Ação',
            'PlanoLabel' => 'Plano de Ação',
            'anoLabel' => 'Ano da Planilha',
            'tipoPlanilhaLabel' => 'Tipo de Planilha',
            'tipoProgramacaoLabel' => 'Tipo de Programação',

        ];
    }

    //Busca dados dos Planos que estão vinculados ao eixo e segmento escolhido pelo usuário
    public static function getPlanosSubCat($cat_id, $subcat_id) {
        $data=\app\models\planos\Planodeacao::find()
       ->where(['plan_codeixo' => $cat_id, 'plan_codsegmento' => $subcat_id])
       ->select(['plan_codplano AS id','plan_descricao AS name'])
       ->orderBy('name')
       ->asArray()->all();

            return $data;
        }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoricoplanilhaHis()
    {
        return $this->hasMany(HistoricoplanilhaHis::className(), ['his_codplanilha' => 'placu_codplanilha']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObservacaoplanilhaObplas()
    {
        return $this->hasMany(ObservacaoplanilhaObpla::className(), ['obpla_codplanilha' => 'placu_codplanilha']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanilhaAno()
    {
        return $this->hasOne(Ano::className(), ['an_codano' => 'placu_codano']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacuCodcategoria()
    {
        return $this->hasOne(CategoriaplanilhaCat::className(), ['cat_codcategoria' => 'placu_codcategoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEixo()
    {
        return $this->hasOne(Eixo::className(), ['eix_codeixo' => 'placu_codeixo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNivel()
    {
        return $this->hasOne(Nivel::className(), ['niv_codnivel' => 'placu_codnivel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlano()
    {
        return $this->hasOne(Planodeacao::className(), ['plan_codplano' => 'placu_codplano']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoprogramacao()
    {
        return $this->hasOne(Tipoprogramacao::className(), ['tipro_codprogramacao' => 'placu_codprogramacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSegmento()
    {
        return $this->hasOne(Segmento::className(), ['seg_codsegmento' => 'placu_codsegmento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacuCodsituacao()
    {
        return $this->hasOne(SituacaoplanilhaSipla::className(), ['sipla_codsituacao' => 'placu_codsituacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoplanilha()
    {
        return $this->hasOne(Tipoplanilha::className(), ['tipla_codtipla' => 'placu_codtipla']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipo()
    {
        return $this->hasOne(Tipo::className(), ['tip_codtipoa' => 'placu_codtipoa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanilhadespesaPlades()
    {
        return $this->hasMany(PlanilhadespesaPlades::className(), ['plades_codplanilha' => 'placu_codplanilha']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaniMateriais()
    {
        return $this->hasMany(PlanilhaMaterial::className(), ['planilhadecurso_cod' => 'placu_codplanilha']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaniConsumo()
    {
        return $this->hasMany(PlanilhaConsumo::className(), ['planilhadecurso_cod' => 'placu_codplanilha']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaniEquipamento()
    {
        return $this->hasMany(PlanilhaEquipamento::className(), ['planilhadecurso_cod' => 'placu_codplanilha']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaniUC()
    {
        return $this->hasMany(PlanilhaUnidadesCurriculares::className(), ['planilhadecurso_cod' => 'placu_codplanilha']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaniDespDocente()
    {
        return $this->hasMany(PlanilhaDespesaDocente::className(), ['planilhadecurso_cod' => 'placu_codplanilha']);
    }

}
