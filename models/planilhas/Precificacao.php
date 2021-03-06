<?php

namespace app\models\planilhas;

use Yii;
use app\models\planos\Planodeacao;
use app\models\despesas\Despesasdocente;
use app\models\base\Colaborador;
use app\models\base\Unidade;

/**
 * This is the model class for table "precificacao_planp".
 *
 * @property integer $planp_id
 * @property integer $planp_codunidade
 * @property string $planp_planodeacao
 * @property integer $planp_cargahoraria
 * @property integer $planp_mesesdocurso
 * @property integer $planp_qntaluno
 * @property integer $planp_totalhorasdocente
 * @property integer $planp_docente
 * @property double $planp_valorhoraaula
 * @property integer $planp_servpedagogico
 * @property double $planp_horaaulaplanejamento
 * @property double $planp_totalcustodocente
 * @property double $planp_decimo
 * @property double $planp_ferias
 * @property double $planp_tercoferias
 * @property double $planp_totalsalario
 * @property double $planp_encargos
 * @property double $planp_totalencargos
 * @property double $planp_totalsalarioencargo
 * @property double $planp_custosmateriais
 * @property double $planp_diarias
 * @property double $planp_passagens
 * @property double $planp_pessoafisica
 * @property double $planp_pessoajuridica
 * @property double $planp_totalcustodireto
 * @property double $planp_totalhoraaulacustodireto
 * @property double $planp_custosindiretos
 * @property double $planp_ipca
 * @property double $planp_reservatecnica
 * @property double $planp_despesadm
 * @property double $planp_totalincidencias
 * @property double $planp_totalcustoindireto
 * @property double $planp_despesatotal
 * @property double $planp_markdivisor
 * @property double $planp_markmultiplicador
 * @property double $planp_vendaturma
 * @property double $planp_vendaaluno
 * @property double $planp_horaaulaaluno
 * @property double $planp_retorno
 * @property double $planp_porcentretorno
 * @property double $planp_precosugerido
 * @property double $planp_retornoprecosugerido
 * @property double $planp_minimoaluno
 * @property double $planp_vendaturmasugeridointerior
 * @property double $planp_porcentretornosugeridointerior
 * @property double $planp_retornoprecosugeridointerior
 * @property double $planp_minimoalunointerior
 * @property double $planp_valorparcelasinterior
 *
 * @property DespesasDocente $planpDocente
 * @property PlanodeacaoPlan $planpPlanodeacao
 */
class Precificacao extends \yii\db\ActiveRecord
{
    public $hiddenPlanejamento;
    public $hiddenMaterialDidatico;
    public $hiddenPJApostila;
    public $hiddenOutrosMateriais;
    public $labelCurso;
    public $desconto;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'precificacao_planp';
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
            [['planp_codunidade', 'planp_planodeacao', 'planp_cargahoraria', 'planp_qntaluno', 'planp_totalhorasdocente', 'planp_docente', 'planp_diarias', 'planp_passagens', 'planp_pessoafisica', 'planp_pessoajuridica', 'planp_precosugerido', 'planp_parcelas', 'planp_mesesdocurso'], 'required'],
            //[['planp_ead'], 'string', 'max' => 5],
            [['planp_codunidade', 'planp_planodeacao', 'planp_cargahoraria', 'planp_qntaluno', 'planp_totalhorasdocente', 'planp_docente', 'planp_servpedagogico','planp_codcolaborador', 'planp_parcelas', 'planp_parcelasinterior', 'planp_mesesdocurso', 'planp_codcolaboradoratualizacao'], 'integer'],
            [['planp_qntaluno'], 'compare', 'compareValue' => 0, 'operator' => '>', 'message'=>'Valores maiores que 0 e sem vírgulas.'],
            [['planp_valorhoraaula', 'planp_horaaulaplanejamento', 'planp_totalcustodocente', 'planp_decimo', 'planp_ferias', 'planp_tercoferias', 'planp_totalsalario', 'planp_encargos', 'planp_totalencargos', 'planp_totalsalarioencargo', 'planp_custosmateriais', 'planp_custosconsumo', 'planp_diarias', 'planp_passagens', 'planp_pessoafisica', 'planp_pessoajuridica', 'planp_totalcustodireto', 'planp_totalhoraaulacustodireto', 'planp_custosindiretos', 'planp_ipca', 'planp_reservatecnica', 'planp_despesadm', 'planp_totalincidencias', 'planp_totalcustoindireto', 'planp_despesatotal', 'planp_markdivisor', 'planp_markmultiplicador', 'planp_vendaturma', 'planp_vendaturmasugerido', 'planp_vendaaluno', 'planp_horaaulaaluno', 'planp_retorno', 'planp_porcentretorno', 'planp_porcentretornosugerido', 'planp_precosugerido', 'planp_retornoprecosugerido', 'planp_minimoaluno', 'hiddenPlanejamento', 'hiddenMaterialDidatico', 'hiddenPJApostila', 'hiddenOutrosMateriais', 'planp_data','labelCurso', 'planp_valorparcelas', 'desconto', 'planp_valorcomdesconto', 'planp_dataatualizacao', 'planp_vendaturmasugeridointerior', 'planp_porcentretornosugeridointerior', 'planp_retornoprecosugeridointerior', 'planp_minimoalunointerior', 'planp_valorparcelasinterior', 'planp_desconto'], 'safe'],
            [['planp_diarias', 'planp_passagens', 'planp_pessoafisica', 'planp_pessoajuridica', 'planp_PJApostila', 'planp_outrosmateriais', 'planp_ipca', 'planp_precosugerido'], 'number'],
            [['planp_docente'], 'exist', 'skipOnError' => true, 'targetClass' => Despesasdocente::className(), 'targetAttribute' => ['planp_docente' => 'doce_id']],
            [['planp_planodeacao'], 'exist', 'skipOnError' => true, 'targetClass' => Planodeacao::className(), 'targetAttribute' => ['planp_planodeacao' => 'plan_codplano']],
            [['planp_observacao'], 'string', 'max' => 255],
            [['planp_totalhorasdocente', 'planp_precosugerido', 'planp_mesesdocurso'], 'compare', 'compareValue' => 0, 'operator' => '>'],

        ];
    }

    //Replace de ',' por '.' nos valores da precificação
    public function beforeSave($insert) {
            if (parent::beforeSave($insert)) {
                $this->planp_valorhoraaula                  = str_replace(",", ".", $this->planp_valorhoraaula);
                $this->planp_horaaulaplanejamento           = str_replace(",", ".", $this->planp_horaaulaplanejamento);
                $this->planp_totalcustodocente              = str_replace(",", ".", $this->planp_totalcustodocente);
                $this->planp_decimo                         = str_replace(",", ".", $this->planp_decimo);
                $this->planp_ferias                         = str_replace(",", ".", $this->planp_ferias);
                $this->planp_tercoferias                    = str_replace(",", ".", $this->planp_tercoferias);
                $this->planp_totalsalario                   = str_replace(",", ".", $this->planp_totalsalario);
                $this->planp_encargos                       = str_replace(",", ".", $this->planp_encargos);
                $this->planp_totalencargos                  = str_replace(",", ".", $this->planp_totalencargos);
                $this->planp_totalsalarioencargo            = str_replace(",", ".", $this->planp_totalsalarioencargo);
                $this->planp_custosmateriais                = str_replace(",", ".", $this->planp_custosmateriais);
                $this->planp_custosconsumo                  = str_replace(",", ".", $this->planp_custosconsumo);
                $this->planp_diarias                        = str_replace(",", ".", $this->planp_diarias);
                $this->planp_passagens                      = str_replace(",", ".", $this->planp_passagens);
                $this->planp_pessoafisica                   = str_replace(",", ".", $this->planp_pessoafisica);
                $this->planp_pessoajuridica                 = str_replace(",", ".", $this->planp_pessoajuridica);
                $this->planp_totalcustodireto               = str_replace(",", ".", $this->planp_totalcustodireto);
                $this->planp_totalhoraaulacustodireto       = str_replace(",", ".", $this->planp_totalhoraaulacustodireto);
                $this->hiddenPlanejamento                   = str_replace(",", ".", $this->hiddenPlanejamento);
                $this->hiddenMaterialDidatico               = str_replace(",", ".", $this->hiddenMaterialDidatico);
                $this->hiddenPJApostila                     = str_replace(",", ".", $this->hiddenPJApostila);
                $this->hiddenOutrosMateriais                = str_replace(",", ".", $this->hiddenOutrosMateriais);
                $this->planp_custosindiretos                = str_replace(",", ".", $this->planp_custosindiretos);
                $this->planp_ipca                           = str_replace(",", ".", $this->planp_ipca);
                $this->planp_reservatecnica                 = str_replace(",", ".", $this->planp_reservatecnica);
                $this->planp_despesadm                      = str_replace(",", ".", $this->planp_despesadm);
                $this->planp_totalincidencias               = str_replace(",", ".", $this->planp_totalincidencias);
                $this->planp_totalcustoindireto             = str_replace(",", ".", $this->planp_totalcustoindireto);
                $this->planp_despesatotal                   = str_replace(",", ".", $this->planp_despesatotal);
                $this->planp_markdivisor                    = str_replace(",", ".", $this->planp_markdivisor);
                $this->planp_markmultiplicador              = str_replace(",", ".", $this->planp_markmultiplicador);
                $this->planp_vendaturma                     = str_replace(",", ".", $this->planp_vendaturma);
                $this->planp_vendaturmasugerido             = str_replace(",", ".", $this->planp_vendaturmasugerido);
                $this->planp_vendaaluno                     = str_replace(",", ".", $this->planp_vendaaluno);
                $this->planp_horaaulaaluno                  = str_replace(",", ".", $this->planp_horaaulaaluno);
                $this->planp_retorno                        = str_replace(",", ".", $this->planp_retorno);
                $this->planp_porcentretorno                 = str_replace(",", ".", $this->planp_porcentretorno);
                $this->planp_porcentretornosugerido         = str_replace(",", ".", $this->planp_porcentretornosugerido);
                $this->planp_precosugerido                  = str_replace(",", ".", $this->planp_precosugerido);
                $this->planp_retornoprecosugerido           = str_replace(",", ".", $this->planp_retornoprecosugerido);
                $this->planp_minimoaluno                    = str_replace(",", ".", $this->planp_minimoaluno);
                $this->planp_valorparcelas                  = str_replace(",", ".", $this->planp_valorparcelas);
                $this->planp_valorcomdesconto               = str_replace(",", ".", $this->planp_valorcomdesconto);
                $this->planp_vendaturmasugeridointerior     = str_replace(",", ".", $this->planp_vendaturmasugeridointerior);
                $this->planp_porcentretornosugeridointerior = str_replace(",", ".", $this->planp_porcentretornosugeridointerior);
                $this->planp_retornoprecosugeridointerior   = str_replace(",", ".", $this->planp_retornoprecosugeridointerior);
                $this->planp_minimoalunointerior            = str_replace(",", ".", $this->planp_minimoalunointerior);
                $this->planp_valorparcelasinterior          = str_replace(",", ".", $this->planp_valorparcelasinterior);
                $this->planp_desconto                       = str_replace(",", ".", $this->planp_desconto);

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
            'planp_id' => 'Cód.',
            'planp_ano' => 'Ano',
            'planp_codunidade' => 'Unidade',
            'planp_planodeacao' => 'Plano',
            'planp_cargahoraria' => 'C.H',
            'planp_mesesdocurso' => 'Provisão de Ano',
            'planp_qntaluno' => 'Qnt de Alunos',
            //'planp_ead' => 'Curso EAD?',
            'planp_totalhorasdocente' => 'Total de horas docente',
            'planp_docente' => 'Nível Docente',
            'planp_valorhoraaula' => 'Valor hora/aula',
            'planp_servpedagogico' => 'Hora/Aula S. Pedag. (s/produtividade)',
            'planp_horaaulaplanejamento' => 'Valor hora/aula Planejamento',
            'planp_totalcustodocente' => 'Custo de Mão de Obra Direta' ,
            'planp_decimo' => 'Provisão de 13º',
            'planp_ferias' => 'Provisão de Férias',
            'planp_tercoferias' => 'Provisão de 1/3 de férias',
            'planp_totalsalario' => 'Total de Salários',
            'planp_encargos' => '(%) Encargos s/13º, férias e salários',
            'planp_totalencargos' => 'Total de Encargos',
            'planp_totalsalarioencargo' => 'Total de Salários + Encargos',
            'planp_PJApostila' => 'Mat. Didático (Apostilas)',
            'planp_custosmateriais' => 'Mat. Didático (Livros)',
            'planp_outrosmateriais' => 'Mat. Didático (Outros)',
            'planp_custosconsumo' => 'Mat. de Consumo',
            'planp_diarias' => 'Diarias',
            'planp_passagens' => 'Passagens',
            'planp_pessoafisica' => 'Serv. Terceiros (PF)',
            'planp_pessoajuridica' => 'Serv. Terceiros (PJ)',
            'planp_totalcustodireto' => 'Total de Custo Direto',
            'planp_totalhoraaulacustodireto' => 'V. Hora/Aula de Custo Direto',
            'planp_custosindiretos' => 'Custos Indiretos(%)',
            'planp_ipca' => 'IPCA/Mês(%)',
            'planp_reservatecnica' => 'Reserva Técnica(%)',
            'planp_despesadm' => 'Despesa Sede ADM(%)',
            'planp_totalincidencias' => 'Total Incidências(%)',
            'planp_totalcustoindireto' => 'Total Custo Indireto',
            'planp_despesatotal' => 'Despesa Total',
            'planp_markdivisor' => 'Mark-Up Divisor 100-X/100',
            'planp_markmultiplicador' => 'Mark-Up Multiplicador 100/Markup',
            'planp_vendaturma' => 'Preço de venda total da turma',
            'planp_vendaturmasugerido' => 'Valor Total',
            'planp_vendaaluno' => 'Preço de Venda pela planilha',
            'planp_horaaulaaluno' => 'Valor Hora/Aula por aluno',
            'planp_retorno' => 'Retorno com preço de venda',
            'planp_porcentretorno' => '% de Retorno',
            'planp_porcentretornosugerido' => '% de Retorno',
            'planp_precosugerido' => 'Venda',
            'planp_retornoprecosugerido' => 'Retorno R$',
            'planp_minimoaluno' => 'Mínimo de Alunos',
            'planp_parcelas' => 'Parcelas',
            'planp_parcelasinterior' => 'Parcelas',
            'planp_valorparcelas' => 'Valor das Parcelas',
            'planp_data' => 'Data de Cadastro',
            'planp_observacao' => 'Observação',
            'planp_desconto' => '% Desconto',
            'planp_valorcomdesconto' => 'Preço de Venda',
            'planp_codcolaboradoratualizacao' => 'Atualizado por',
            'planp_dataatualizacao' => 'Data da Atualização',
            'desconto' => '30% de desconto',
            'labelCurso' => 'Curso',
            'planp_vendaturmasugeridointerior' => 'Valor Total',
            'planp_retornoprecosugeridointerior' => 'Retorno R$',
            'planp_porcentretornosugeridointerior' => '% de Retorno',
            'planp_minimoalunointerior' => 'Mínimo de Alunos',
            'planp_valorparcelasinterior' => 'Valor das Parcelas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrecificacaoUnidades()
    {
        return $this->hasMany(PrecificacaoUnidades::className(), ['planp_id' => 'precificacao_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDespesasdocente()
    {
        return $this->hasOne(Despesasdocente::className(), ['doce_id' => 'planp_docente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanodeacao()
    {
        return $this->hasOne(Planodeacao::className(), ['plan_codplano' => 'planp_planodeacao']);
    }

    public function getColaborador()
    {
        return $this->hasOne(Colaborador::className(), ['col_codcolaborador' => 'planp_codcolaborador']);
    }

    public function getColaboradorAtualizacao()
    {
        return $this->hasOne(Colaborador::className(), ['col_codcolaborador' => 'planp_codcolaboradoratualizacao']);
    }

    public function getUnidade()
    {
        return $this->hasOne(Unidade::className(), ['uni_codunidade' => 'planp_codunidade']);
    }
}
