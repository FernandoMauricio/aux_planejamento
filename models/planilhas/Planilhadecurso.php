<?php

namespace app\models\planilhas;

use Yii;
use app\models\base\Colaborador;
use app\models\base\Unidade;
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
    public $nomeUsuario;
    public $situacaoLabel;
    public $categoriaLabel;
    public $unidades;
    public $planModeloPedagogico;

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
            [['placu_codeixo', 'placu_codsegmento', 'placu_codplano', 'placu_codano', 'placu_codcategoria', 'placu_codtipla', 'placu_codsituacao', 'placu_codcolaborador', 'placu_codunidade', 'placu_nomeunidade', 'placu_tipocalculo', 'placu_quantidadealunos', 'placu_quantidadealunospsg', 'placu_quantidadealunosisentos','placu_quantidadeturmas', 'placu_cargahorariarealizada', 'placu_cargahorariaarealizar', 'placu_cargahorariavivencia', 'placu_codprogramacao', 'placu_ead', 'placu_remoto'], 'required'],
            [['placu_precosugerido', 'placu_parcelas', 'placu_totalsalarioencargo', 'placu_interativa'], 'required', 'on' => 'update'],
            [['placu_parcelas'], 'compare', 'compareValue' => 0, 'operator' => '>', 'message'=>'Valores maiores que 0 e sem vírgulas.'],
            [['placu_codeixo', 'placu_codsegmento', 'placu_codplano', 'placu_codtipoa', 'placu_codnivel', 'placu_codano', 'placu_codcategoria', 'placu_codtipla', 'placu_quantidadeturmas', 'placu_quantidadealunos', 'placu_codsituacao', 'placu_codcolaborador', 'placu_codunidade', 'placu_quantidadealunospsg', 'placu_tipocalculo', 'placu_cargahorariavivencia', 'placu_quantidadealunosisentos', 'placu_codprogramacao', 'placu_anoexercicio', 'placu_ead', 'placu_remoto'], 'integer'],
            [['placu_cargahorariaplano', 'placu_cargahorariarealizada', 'placu_cargahorariaarealizar'], 'number'],
            [['nivelLabel', 'segmentoLabel', 'eixoLabel', 'tipoAcaoLabel', 'PlanoLabel', 'anoLabel', 'tipoProgramacaoLabel', 'placu_diarias', 'placu_passagens', 'placu_equipamentos', 'placu_pessoafisica', 'placu_pessoajuridica', 'placu_totalcustodocente', 'placu_decimo', 'placu_ferias', 'placu_tercoferias', 'placu_totalsalario', 'placu_totalencargosPrestador', 'placu_totalencargos', 'placu_outdespvariaveis', 'placu_totalsalarioencargo', 'placu_custosmateriais', 'placu_custosconsumo', 'placu_custosaluno', 'placu_PJApostila', 'placu_outrosmateriais', 'placu_hiddenoutrosmateriais', 'placu_totalcustodireto', 'placu_totalhoraaulacustodireto', 'placu_hiddenmaterialdidatico', 'placu_hiddenpjapostila', 'placu_hiddencustosaluno', 'placu_custosindiretos', 'placu_ipca', 'placu_reservatecnica', 'placu_despesadm', 'placu_totalincidencias', 'placu_totalcustoindireto', 'placu_despesatotal', 'placu_markdivisor', 'placu_markmultiplicador', 'placu_vendaturma', 'placu_vendaaluno', 'placu_horaaulaaluno', 'placu_retorno', 'placu_porcentretorno', 'placu_precosugerido', 'placu_retornoprecosugerido', 'placu_porcentprecosugerido', 'placu_minimoaluno', 'placu_parcelas', 'placu_valorparcelas', 'nomeUsuario', 'situacaoLabel', 'categoriaLabel', 'placu_data', 'unidades', 'placu_totalsalarioPrestador', 'planModeloPedagogico'], 'safe'],
            [['placu_observacao'], 'string'],
            [['placu_nomeunidade'], 'string', 'max' => 150],
            [['placu_interativa'], 'string', 'max' => 10],
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

    public function scenarios()
        {
            $scenarios = parent::scenarios();
            $scenarios['update'] = ['nivelLabel', 'segmentoLabel', 'eixoLabel', 'tipoAcaoLabel', 'PlanoLabel', 'anoLabel', 'tipoProgramacaoLabel', 'placu_diarias', 'placu_equipamentos', 'placu_pessoafisica', 'placu_pessoajuridica', 'placu_totalcustodocente', 'placu_decimo', 'placu_ferias', 'placu_tercoferias', 'placu_totalsalario', 'placu_totalencargosPrestador', 'placu_totalencargos', 'placu_outdespvariaveis', 'placu_totalsalarioencargo', 'placu_custosmateriais', 'placu_custosconsumo', 'placu_custosaluno', 'placu_PJApostila', 'placu_outrosmateriais', 'placu_hiddenoutrosmateriais', 'placu_totalcustodireto', 'placu_totalhoraaulacustodireto', 'placu_hiddenmaterialdidatico', 'placu_hiddenpjapostila', 'placu_hiddencustosaluno', 'placu_custosindiretos', 'placu_ipca', 'placu_reservatecnica', 'placu_despesadm', 'placu_totalincidencias', 'placu_totalcustoindireto', 'placu_despesatotal', 'placu_markdivisor', 'placu_markmultiplicador', 'placu_vendaturma', 'placu_vendaaluno', 'placu_horaaulaaluno', 'placu_retorno', 'placu_porcentretorno', 'placu_precosugerido', 'placu_retornoprecosugerido', 'placu_porcentprecosugerido', 'placu_minimoaluno', 'placu_parcelas', 'placu_valorparcelas', 'nomeUsuario', 'situacaoLabel', 'categoriaLabel', 'placu_data', 'placu_codtipla', 'placu_cargahorariaplano', 'placu_quantidadeturmas', 'placu_cargahorariarealizada', 'placu_cargahorariaarealizar', 'placu_cargahorariavivencia', 'placu_quantidadealunos', 'placu_quantidadealunosisentos', 'placu_quantidadealunospsg', 'placu_passagens', 'placu_totalsalarioPrestador', 'placu_observacao', 'placu_interativa', 'placu_ead', 'placu_remoto'];//Scenario Values Only Accepted
            return $scenarios;
        }

    //Replace de ',' por '.' nos valores da planilha
    public function beforeSave($insert) {
            if (parent::beforeSave($insert)) {
                $this->placu_totalcustodocente        = str_replace(",", ".", $this->placu_totalcustodocente);
                $this->placu_decimo                   = str_replace(",", ".", $this->placu_decimo);
                $this->placu_ferias                   = str_replace(",", ".", $this->placu_ferias);
                $this->placu_tercoferias              = str_replace(",", ".", $this->placu_tercoferias);
                $this->placu_totalsalario             = str_replace(",", ".", $this->placu_totalsalario);
                $this->placu_totalsalarioPrestador    = str_replace(",", ".", $this->placu_totalsalarioPrestador);
                $this->placu_totalencargosPrestador   = str_replace(",", ".", $this->placu_totalencargosPrestador);
                $this->placu_totalencargos            = str_replace(",", ".", $this->placu_totalencargos);
                $this->placu_outdespvariaveis         = str_replace(",", ".", $this->placu_outdespvariaveis);
                $this->placu_totalsalarioencargo      = str_replace(",", ".", $this->placu_totalsalarioencargo);
                $this->placu_PJApostila               = str_replace(",", ".", $this->placu_PJApostila);
                $this->placu_outrosmateriais          = str_replace(",", ".", $this->placu_outrosmateriais);
                $this->placu_custosmateriais          = str_replace(",", ".", $this->placu_custosmateriais);
                $this->placu_custosconsumo            = str_replace(",", ".", $this->placu_custosconsumo);
                $this->placu_custosaluno              = str_replace(",", ".", $this->placu_custosaluno);
                $this->placu_diarias                  = str_replace(",", ".", $this->placu_diarias);
                $this->placu_passagens                = str_replace(",", ".", $this->placu_passagens);
                $this->placu_pessoafisica             = str_replace(",", ".", $this->placu_pessoafisica);
                $this->placu_pessoajuridica           = str_replace(",", ".", $this->placu_pessoajuridica);
                $this->placu_totalcustodireto         = str_replace(",", ".", $this->placu_totalcustodireto);
                $this->placu_totalhoraaulacustodireto = str_replace(",", ".", $this->placu_totalhoraaulacustodireto);
                $this->placu_custosindiretos          = str_replace(",", ".", $this->placu_custosindiretos);
                $this->placu_ipca                     = str_replace(",", ".", $this->placu_ipca);
                $this->placu_reservatecnica           = str_replace(",", ".", $this->placu_reservatecnica);
                $this->placu_despesadm                = str_replace(",", ".", $this->placu_despesadm);
                $this->placu_totalincidencias         = str_replace(",", ".", $this->placu_totalincidencias);
                $this->placu_totalcustoindireto       = str_replace(",", ".", $this->placu_totalcustoindireto);
                $this->placu_despesatotal             = str_replace(",", ".", $this->placu_despesatotal);
                $this->placu_markdivisor              = str_replace(",", ".", $this->placu_markdivisor);
                $this->placu_markmultiplicador        = str_replace(",", ".", $this->placu_markmultiplicador);
                $this->placu_vendaturma               = str_replace(",", ".", $this->placu_vendaturma);
                $this->placu_vendaaluno               = str_replace(",", ".", $this->placu_vendaaluno);
                $this->placu_horaaulaaluno            = str_replace(",", ".", $this->placu_horaaulaaluno);
                $this->placu_retorno                  = str_replace(",", ".", $this->placu_retorno);
                $this->placu_porcentretorno           = str_replace(",", ".", $this->placu_porcentretorno);
                $this->placu_precosugerido            = str_replace(",", ".", $this->placu_precosugerido);
                $this->placu_retornoprecosugerido     = str_replace(",", ".", $this->placu_retornoprecosugerido);
                $this->placu_porcentprecosugerido     = str_replace(",", ".", $this->placu_porcentprecosugerido);
                $this->placu_minimoaluno              = str_replace(",", ".", $this->placu_minimoaluno);
                $this->placu_parcelas                 = str_replace(",", ".", $this->placu_parcelas);
                $this->placu_valorparcelas            = str_replace(",", ".", $this->placu_valorparcelas);

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
            'placu_codplanilha' => 'Cód. Planilha',
            'placu_codeixo' => 'Eixo',
            'placu_codsegmento' => 'Segmento',
            'placu_codplano' => 'Plano de Curso',
            'placu_codtipoa' => 'Tipo de Ação',
            'placu_codnivel' => 'Nível',
            'placu_cargahorariaplano' => 'CH',
            'placu_cargahorariarealizada' => 'Carga Horária Realizada no Exercicio Anterior',
            'placu_cargahorariaarealizar' => 'Carga Horária a Realizar no SENAC',
            'placu_cargahorariavivencia' => 'Carga Horária na Vivência(Aprend)',
            'placu_codano' => 'Orçamento',
            'placu_codcategoria' => 'Financiamento',
            'placu_codtipla' => 'Tipo de Planilha',
            'placu_quantidadealunos' => 'Quantidade Alunos Pagantes por Turma',
            'placu_quantidadealunospsg' => 'Quantidade Alunos PSG por Turma',
            'placu_quantidadealunosisentos' => 'Quantidade Alunos Isentos por Turma - Não PSG',
            'placu_codsituacao' => 'Situação da Planilha',
            'placu_codcolaborador' => 'Colaborador',
            'placu_codunidade' => 'Cód. Unidade',
            'placu_nomeunidade' => 'Unidade',
            'placu_tipocalculo' => 'Tipocalculo',
            'placu_observacao' => 'Observação',
            'placu_codprogramacao' => 'Tipo de Programação',

            'placu_totalcustodocente' => 'Mão de Obra Direta',
            'placu_decimo' => '1/12 de 13º',
            'placu_ferias' => '1/12 de Férias',
            'placu_tercoferias' => '1/12 de 1/3 de férias',
            'placu_totalsalario' => 'SubTotal de Venc.',
            'placu_totalsalarioPrestador' => 'SubTotal de Vencimentos(Prestador)',
            'placu_totalencargosPrestador' => 'SubTotal de Encargos(Prestador)',
            'placu_totalencargos' => 'SubTotal de Encargos',
            'placu_outdespvariaveis' => 'Outras Desp. Variáveis',
            'placu_totalsalarioencargo' => 'Total Vencimentos + Encargos (Horista+Prestador)',
            'placu_PJApostila' => 'Mat. Didático (Apostilas)',
            'placu_custosmateriais' => 'Mat. Didático (Livros)',
            'placu_outrosmateriais' => 'Mat. Didático (Outros)',
            'placu_custosconsumo' => 'Mat. de Consumo',
            'placu_custosaluno' => 'Mat. do Aluno',
            'placu_diarias' => 'Diárias',
            'placu_passagens' => 'Passagens',
            'placu_pessoafisica' => 'Serv. Terceiros (PF)',
            'placu_pessoajuridica' => 'Serv. Terceiros (PJ)',
            'placu_equipamentos' => 'Equipamentos',
            'placu_totalcustodireto' => 'Total de Custo Direto',
            'placu_totalhoraaulacustodireto' => 'V. Hora/Aula de Custo Direto',

            'placu_custosindiretos' => 'Custos Indiretos(%)',
            'placu_ipca' => 'IPCA/Mês(%)',
            'placu_reservatecnica' => 'Rerserva Técnica(%)',
            'placu_despesadm' => 'Despesa Sede ADM ' .  date('Y') . '(%)',
            'placu_totalincidencias' => 'Total Incidências(%)',
            'placu_totalcustoindireto' => 'Total Custo Indireto',
            'placu_despesatotal' => 'Despesa Total',
            'placu_markdivisor' => 'Mark-Up Divisor 100-X/100',
            'placu_markmultiplicador' => 'Mark-Up Multiplicador 100/Markup',
            'placu_vendaturma' => 'Preço de venda total da turma',
            'placu_vendaaluno' => 'Preço de Venda pela planilha',
            'placu_horaaulaaluno' => 'Valor Hora/Aula por aluno',
            'placu_retorno' => 'Retorno com preço de venda',
            'placu_porcentretorno' => '% de Retorno',
            'placu_precosugerido' => 'Preço de Venda da Precificação',
            'placu_retornoprecosugerido' => 'Retorno com Preço de Venda',
            'placu_porcentprecosugerido' => '% de Retorno - Preço de Venda',
            'placu_minimoaluno' => 'Numero minimo de alunos por turma',
            'placu_parcelas' => 'Quantidade de Parcelas',
            'placu_valorparcelas' => 'Valor das Parcelas',
            'placu_data' => 'Data da modificação',
            'placu_anoexercicio' => 'Início da Turma',
            'placu_interativa' => 'Escola Interativa?',
            'placu_quantidadeturmas' => 'Quantas Turmas Presenciais?',
            'placu_ead' => 'Quantas Turmas EAD?', 
            'placu_remoto' => 'Quantas Turmas Remotas?',

            'nivelLabel' => 'Nível',
            'segmentoLabel' => 'Segmento',
            'eixoLabel' => 'Eixo',
            'tipoAcaoLabel' => 'Tipo de Ação',
            'PlanoLabel' => 'Plano de Curso',
            'anoLabel' => 'Início da Turma',
            'tipoPlanilhaLabel' => 'Tipo de Planilha',
            'tipoProgramacaoLabel' => 'Tipo de Programação',
            'nomeUsuario' => 'Última modificação',
            'situacaoLabel' => 'Situação da Planilha',
            'categoriaLabel' => 'Financiamento',
            'planModeloPedagogico' => 'Novo Modelo Pedagógico',
        ];
    }

    //Busca dados dos Planos que estão vinculados ao eixo e segmento escolhido pelo usuário
    public static function getPlanosSubCat($cat_id, $subcat_id) {
        $data=\app\models\planos\Planodeacao::find()
       ->where(['plan_codeixo' => $cat_id, 'plan_codsegmento' => $subcat_id, 'plan_status' => 1]) //somente os ativos
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
    public function getCategoriaPlanilha()
    {
        return $this->hasOne(Categoriaplanilha::className(), ['cat_codcategoria' => 'placu_codcategoria']);
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
    public function getSituacaoPlani()
    {
        return $this->hasOne(Situacaoplanilha::className(), ['sipla_codsituacao' => 'placu_codsituacao']);
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
    public function getPlaniMateriais()
    {
        return $this->hasMany(PlanilhaMaterial::className(), ['planilhadecurso_cod' => 'placu_codplanilha']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaniMateriaisAluno()
    {
        return $this->hasMany(PlanilhaMaterialAluno::className(), ['planilhadecurso_cod' => 'placu_codplanilha']);
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

    public function getColaborador()
    {
        return $this->hasOne(Colaborador::className(), ['col_codcolaborador' => 'placu_codcolaborador']);
    }

    public function getUnidade()
    {
        return $this->hasOne(Unidade::className(), ['uni_codunidade' => 'placu_codunidade']);
    }

}
