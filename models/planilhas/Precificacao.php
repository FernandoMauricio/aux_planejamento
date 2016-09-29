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
 * @property double $planp_diarias
 * @property double $planp_passagens
 * @property double $planp_pessoafisica
 * @property double $planp_pessoajuridica
 * @property double $planp_totalcustodireto
 * @property double $planp_totalhoraaulacustodireto
 *
 * @property DespesasDocente $planpDocente
 * @property PlanodeacaoPlan $planpPlanodeacao
 */
class Precificacao extends \yii\db\ActiveRecord
{
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
            [['planp_codunidade', 'planp_planodeacao', 'planp_cargahoraria', 'planp_qntaluno', 'planp_totalhorasdocente', 'planp_docente'], 'required'],
            [['planp_codunidade', 'planp_planodeacao', 'planp_cargahoraria', 'planp_qntaluno', 'planp_totalhorasdocente', 'planp_docente', 'planp_servpedagogico'], 'integer'],
            [['planp_valorhoraaula', 'planp_horaaulaplanejamento', 'planp_totalcustodocente', 'planp_decimo', 'planp_ferias', 'planp_tercoferias', 'planp_totalsalario', 'planp_encargos', 'planp_totalencargos', 'planp_totalsalarioencargo', 'planp_diarias', 'planp_passagens', 'planp_pessoafisica', 'planp_pessoajuridica', 'planp_totalcustodireto', 'planp_totalhoraaulacustodireto'], 'number'],
            [['planp_docente'], 'exist', 'skipOnError' => true, 'targetClass' => Despesasdocente::className(), 'targetAttribute' => ['planp_docente' => 'doce_id']],
            [['planp_planodeacao'], 'exist', 'skipOnError' => true, 'targetClass' => Planodeacao::className(), 'targetAttribute' => ['planp_planodeacao' => 'plan_codplano']],
        ];
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
            'planp_valorhoraaula' => 'Valor hora/aula docente',
            'planp_servpedagogico' => 'Valor hora/aula Serviço Pedagógico (s/produtividade)',
            'planp_horaaulaplanejamento' => 'Valor hora/aula Planejamento',
            'planp_totalcustodocente' => 'Total Custo Docente',
            'planp_decimo' => 'Decimo',
            'planp_ferias' => 'Ferias',
            'planp_tercoferias' => 'Tercoferias',
            'planp_totalsalario' => 'Totalsalario',
            'planp_encargos' => 'Encargos',
            'planp_totalencargos' => 'Totalencargos',
            'planp_totalsalarioencargo' => 'Totalsalarioencargo',
            'planp_diarias' => 'Diarias',
            'planp_passagens' => 'Passagens',
            'planp_pessoafisica' => 'Pessoafisica',
            'planp_pessoajuridica' => 'Pessoajuridica',
            'planp_totalcustodireto' => 'Totalcustodireto',
            'planp_totalhoraaulacustodireto' => 'Totalhoraaulacustodireto',
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
