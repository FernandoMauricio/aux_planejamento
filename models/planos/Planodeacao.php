<?php

namespace app\models\planos;


use Yii;
use app\models\cadastros\Eixo;
use app\models\cadastros\Nivel;
use app\models\cadastros\Segmento;
use app\models\cadastros\Tipo;


/**
 * This is the model class for table "planodeacao_plan".
 *
 * @property string $plan_codplano
 * @property string $plan_descricao
 * @property string $plan_codeixo
 * @property string $plan_codsegmento
 * @property string $plan_codtipoa
 * @property string $plan_codnivel
 * @property string $plan_cargahoraria
 * @property string $plan_sobre
 * @property string $plan_prerequisito
 * @property string $plan_orgcurricular
 * @property string $plan_perfTecnico
 * @property string $plan_matConsumo
 * @property string $plan_matAluno
 * @property integer $plan_codcolaborador
 * @property string $plan_data
 * @property integer $plan_status
 *
 * @property AtualizarplanilhaAtupla[] $atualizarplanilhaAtuplas
 * @property PlanilhadecursoPlacu[] $planilhadecursoPlacus
 * @property PlanilhamaterialPlanima[] $planilhamaterialPlanimas
 * @property PlanodeacaoEstruturafisica[] $planodeacaoEstruturafisicas
 * @property EixoEix $planCodeixo
 * @property NivelNiv $planCodnivel
 * @property SegmentoSeg $planCodsegmento
 * @property TipodeacaoTip $planCodtipoa
 */
class Planodeacao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'planodeacao_plan';
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
            [['plan_descricao', 'plan_codeixo', 'plan_codsegmento', 'plan_codtipoa', 'plan_codnivel', 'plan_cargahoraria', 'plan_codcolaborador', 'plan_data', 'plan_status'], 'required'],
            [['plan_codeixo', 'plan_codsegmento', 'plan_codtipoa', 'plan_codnivel', 'plan_codcolaborador', 'plan_status'], 'integer'],
            [['plan_sobre', 'plan_prerequisito', 'plan_orgcurricular', 'plan_perfTecnico', 'plan_matConsumo', 'plan_matAluno'], 'string'],
            [['plan_data'], 'safe'],
            [['plan_descricao'], 'string', 'max' => 100],
            [['plan_cargahoraria'], 'string', 'max' => 20],
            [['plan_codeixo'], 'exist', 'skipOnError' => true, 'targetClass' => Eixo::className(), 'targetAttribute' => ['plan_codeixo' => 'eix_codeixo']],
            [['plan_codnivel'], 'exist', 'skipOnError' => true, 'targetClass' => Nivel::className(), 'targetAttribute' => ['plan_codnivel' => 'niv_codnivel']],
            [['plan_codsegmento'], 'exist', 'skipOnError' => true, 'targetClass' => Segmento::className(), 'targetAttribute' => ['plan_codsegmento' => 'seg_codsegmento']],
            [['plan_codtipoa'], 'exist', 'skipOnError' => true, 'targetClass' => Tipo::className(), 'targetAttribute' => ['plan_codtipoa' => 'tip_codtipoa']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'plan_codplano' => 'Plan Codplano',
            'plan_descricao' => 'Plan Descricao',
            'plan_codeixo' => 'Plan Codeixo',
            'plan_codsegmento' => 'Plan Codsegmento',
            'plan_codtipoa' => 'Plan Codtipoa',
            'plan_codnivel' => 'Plan Codnivel',
            'plan_cargahoraria' => 'Plan Cargahoraria',
            'plan_sobre' => 'Plan Sobre',
            'plan_prerequisito' => 'Plan Prerequisito',
            'plan_orgcurricular' => 'Plan Orgcurricular',
            'plan_perfTecnico' => 'Plan Perf Tecnico',
            'plan_matConsumo' => 'Plan Mat Consumo',
            'plan_matAluno' => 'Plan Mat Aluno',
            'plan_codcolaborador' => 'Plan Codcolaborador',
            'plan_data' => 'Plan Data',
            'plan_status' => 'Plan Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAtualizarplanilhaAtuplas()
    {
        return $this->hasMany(AtualizarplanilhaAtupla::className(), ['atupla_codplano' => 'plan_codplano']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanilhadecursoPlacus()
    {
        return $this->hasMany(PlanilhadecursoPlacu::className(), ['placu_codplano' => 'plan_codplano']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanilhamaterialPlanimas()
    {
        return $this->hasMany(PlanilhamaterialPlanima::className(), ['planima_codplano' => 'plan_codplano']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanodeacaoEstruturafisicas()
    {
        return $this->hasMany(PlanodeacaoEstruturafisica::className(), ['planodeacao_codplano' => 'plan_codplano']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanCodeixo()
    {
        return $this->hasOne(EixoEix::className(), ['eix_codeixo' => 'plan_codeixo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanCodnivel()
    {
        return $this->hasOne(NivelNiv::className(), ['niv_codnivel' => 'plan_codnivel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanCodsegmento()
    {
        return $this->hasOne(SegmentoSeg::className(), ['seg_codsegmento' => 'plan_codsegmento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanCodtipoa()
    {
        return $this->hasOne(TipodeacaoTip::className(), ['tip_codtipoa' => 'plan_codtipoa']);
    }
}
