<?php

namespace app\models\planilhas;

use Yii;
use app\models\planos\Planodeacao;
use app\models\despesas\Despesasdocente;

/**
 * This is the model class for table "precificacao_planp".
 *
 * @property integer $planp_id
 * @property integer $planp_codunidade
 * @property string $planp_planodeacao
 * @property integer $planp_cargahoraria
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
 *
 * @property DespesasDocente $planpDocente
 * @property PlanodeacaoPlan $planpPlanodeacao
 */
class Precificacao extends \yii\db\ActiveRecord
{
    public $hiddenPlanejamento;
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

    // 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['planp_codunidade', 'planp_planodeacao', 'planp_cargahoraria', 'planp_qntaluno', 'planp_totalhorasdocente', 'planp_docente', 'planp_diarias', 'planp_passagens', 'planp_pessoafisica', 'planp_pessoajuridica' ], 'required'],
            [['planp_codunidade', 'planp_planodeacao', 'planp_cargahoraria', 'planp_qntaluno', 'planp_totalhorasdocente', 'planp_docente', 'planp_servpedagogico'], 'integer'],
            [['planp_valorhoraaula', 'planp_horaaulaplanejamento', 'planp_totalcustodocente', 'planp_decimo', 'planp_ferias', 'planp_tercoferias', 'planp_totalsalario', 'planp_encargos', 'planp_totalencargos', 'planp_totalsalarioencargo', 'planp_custosmateriais', 'planp_diarias', 'planp_passagens', 'planp_pessoafisica', 'planp_pessoajuridica', 'planp_totalcustodireto', 'planp_totalhoraaulacustodireto', 'planp_custosindiretos', 'planp_ipca', 'planp_reservatecnica', 'planp_despesadm', 'planp_totalincidencias', 'planp_totalcustoindireto', 'planp_despesatotal', 'planp_markdivisor', 'planp_markmultiplicador', 'planp_vendaturma', 'planp_vendaaluno', 'planp_horaaulaaluno', 'planp_retorno', 'planp_porcentretorno', 'planp_precosugerido', 'planp_retornoprecosugerido', 'planp_minimoaluno', 'hiddenPlanejamento'], 'safe'],
            [['planp_docente'], 'exist', 'skipOnError' => true, 'targetClass' => Despesasdocente::className(), 'targetAttribute' => ['planp_docente' => 'doce_id']],
            [['planp_planodeacao'], 'exist', 'skipOnError' => true, 'targetClass' => Planodeacao::className(), 'targetAttribute' => ['planp_planodeacao' => 'plan_codplano']],
        ];
    }

    //Replace de ',' por '.' nos valores da precificação
    public function beforeSave($insert) {
            if (parent::beforeSave($insert)) {
                $this->planp_valorhoraaula            = str_replace(",", ".", $this->planp_valorhoraaula);
                $this->planp_horaaulaplanejamento     = str_replace(",", ".", $this->planp_horaaulaplanejamento);
                $this->planp_totalcustodocente        = str_replace(",", ".", $this->planp_totalcustodocente);
                $this->planp_decimo                   = str_replace(",", ".", $this->planp_decimo);
                $this->planp_ferias                   = str_replace(",", ".", $this->planp_ferias);
                $this->planp_tercoferias              = str_replace(",", ".", $this->planp_tercoferias);
                $this->planp_totalsalario             = str_replace(",", ".", $this->planp_totalsalario);
                $this->planp_encargos                 = str_replace(",", ".", $this->planp_encargos);
                $this->planp_totalencargos            = str_replace(",", ".", $this->planp_totalencargos);
                $this->planp_totalsalarioencargo      = str_replace(",", ".", $this->planp_totalsalarioencargo);
                $this->planp_custosmateriais          = str_replace(",", ".", $this->planp_custosmateriais);
                $this->planp_diarias                  = str_replace(",", ".", $this->planp_diarias);
                $this->planp_passagens                = str_replace(",", ".", $this->planp_passagens);
                $this->planp_pessoafisica             = str_replace(",", ".", $this->planp_pessoafisica);
                $this->planp_pessoajuridica           = str_replace(",", ".", $this->planp_pessoajuridica);
                $this->planp_totalcustodireto         = str_replace(",", ".", $this->planp_totalcustodireto);
                $this->planp_totalhoraaulacustodireto = str_replace(",", ".", $this->planp_totalhoraaulacustodireto);
                $this->hiddenPlanejamento             = str_replace(",", ".", $this->hiddenPlanejamento);
                $this->planp_custosindiretos          = str_replace(",", ".", $this->planp_custosindiretos);
                $this->planp_ipca                     = str_replace(",", ".", $this->planp_ipca);
                $this->planp_reservatecnica           = str_replace(",", ".", $this->planp_reservatecnica);
                $this->planp_despesadm                = str_replace(",", ".", $this->planp_despesadm);
                $this->planp_totalincidencias         = str_replace(",", ".", $this->planp_totalincidencias);
                $this->planp_totalcustoindireto       = str_replace(",", ".", $this->planp_totalcustoindireto);
                $this->planp_despesatotal             = str_replace(",", ".", $this->planp_despesatotal);
                $this->planp_markdivisor              = str_replace(",", ".", $this->planp_markdivisor);
                $this->planp_markmultiplicador        = str_replace(",", ".", $this->planp_markmultiplicador);
                $this->planp_vendaturma               = str_replace(",", ".", $this->planp_vendaturma);
                $this->planp_vendaaluno               = str_replace(",", ".", $this->planp_vendaaluno);
                $this->planp_horaaulaaluno            = str_replace(",", ".", $this->planp_horaaulaaluno);
                $this->planp_retorno                  = str_replace(",", ".", $this->planp_retorno);
                $this->planp_porcentretorno           = str_replace(",", ".", $this->planp_porcentretorno);
                $this->planp_precosugerido            = str_replace(",", ".", $this->planp_precosugerido);
                $this->planp_retornoprecosugerido     = str_replace(",", ".", $this->planp_retornoprecosugerido);
                $this->planp_minimoaluno              = str_replace(",", ".", $this->planp_minimoaluno);

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
            'planp_id' => 'Cód',
            'planp_codunidade' => 'Unidade',
            'planp_planodeacao' => 'Curso',
            'planp_cargahoraria' => 'Carga Horária',
            'planp_qntaluno' => 'Qnt de Alunos',
            'planp_totalhorasdocente' => 'Total de horas docente',
            'planp_docente' => 'Nível Docente',
            'planp_valorhoraaula' => 'Valor hora/aula',
            'planp_servpedagogico' => 'Vr. hora/aula S. Pedagógico (s/produtividade)',
            'planp_horaaulaplanejamento' => 'Valor hora/aula Planejamento',
            'planp_totalcustodocente' => 'Custo de Mão de Obra Direta' ,
            'planp_decimo' => '1/12 de 13º',
            'planp_ferias' => '1/12 de Férias',
            'planp_tercoferias' => '1/12 de 1/3 de férias',
            'planp_totalsalario' => 'Total de Salários',
            'planp_encargos' => '(%) Encargos s/13º, férias e salários',
            'planp_totalencargos' => 'Total de Encargos',
            'planp_totalsalarioencargo' => 'Total de Salários + Encargos',
            'planp_custosmateriais' => 'Material Didático/Aluno/Consumo',
            'planp_diarias' => 'Diarias',
            'planp_passagens' => 'Passagens',
            'planp_pessoafisica' => 'Serv. Terceiros (PF)',
            'planp_pessoajuridica' => 'Serv. Terceiros (PJ)',
            'planp_totalcustodireto' => 'Total de Custo Direto',
            'planp_totalhoraaulacustodireto' => 'Vr. hora/aula de Custo Direto',
            'planp_custosindiretos' => 'Custos Indiretos(%)',
            'planp_ipca' => 'IPCA/Mês(%)',
            'planp_reservatecnica' => 'R.Técnica(%)',
            'planp_despesadm' => 'Despesa Sede ADM ' .  date('Y') . '(%)',
            'planp_totalincidencias' => 'Total Incidências(%)',
            'planp_totalcustoindireto' => 'Total Custo Indireto',
            'planp_despesatotal' => 'Despesa Total',
            'planp_markdivisor' => 'Markdivisor',
            'planp_markmultiplicador' => 'Markmultiplicador',
            'planp_vendaturma' => 'Vendaturma',
            'planp_vendaaluno' => 'Vendaaluno',
            'planp_horaaulaaluno' => 'Horaaulaaluno',
            'planp_retorno' => 'Retorno',
            'planp_porcentretorno' => 'Porcentretorno',
            'planp_precosugerido' => 'Precosugerido',
            'planp_retornoprecosugerido' => 'Retornoprecosugerido',
            'planp_minimoaluno' => 'Minimoaluno',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanpDocente()
    {
        return $this->hasOne(DespesasDocente::className(), ['doce_id' => 'planp_docente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanpPlanodeacao()
    {
        return $this->hasOne(PlanodeacaoPlan::className(), ['plan_codplano' => 'planp_planodeacao']);
    }
}
