<?php

namespace app\models\planos;

use Yii;

use app\models\cadastros\Materialaluno;

/**
 * This is the model class for table "plano_materialaluno".
 *
 * @property integer $planmatalu_cod
 * @property string $planodeacao_cod
 * @property integer $materialaluno_cod
 * @property string $planmatalu_unidade
 * @property string $planmatalu_tipo
 * @property double $planmatalu_valor
 * @property integer $planmatalu_quantidade
 *
 * @property MaterialalunoMatalu $materialalunoCod
 * @property PlanodeacaoPlan $planodeacaoCod
 */
class PlanoAluno extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plano_materialaluno';
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
            //[['planodeacao_cod', 'materialaluno_cod'], 'required'],
            [['planodeacao_cod', 'materialaluno_cod', 'planmatalu_quantidade'], 'integer'],
            [['planmatalu_valor'], 'number'],
            [['planmatalu_unidade'], 'string', 'max' => 20],
            [['planmatalu_tipo'], 'string', 'max' => 45],
            [['materialaluno_cod'], 'exist', 'skipOnError' => true, 'targetClass' => Materialaluno::className(), 'targetAttribute' => ['materialaluno_cod' => 'matalu_cod']],
            [['planodeacao_cod'], 'exist', 'skipOnError' => true, 'targetClass' => Planodeacao::className(), 'targetAttribute' => ['planodeacao_cod' => 'plan_codplano']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'planmatalu_cod' => 'Cod',
            'planodeacao_cod' => 'Planodeacao Cod',
            'materialaluno_cod' => 'Descrição',
            'planmatalu_unidade' => 'Unidade',
            'planmatalu_tipo' => 'Tipo',
            'planmatalu_valor' => 'Valor',
            'planmatalu_quantidade' => 'Quantidade',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialalunoCod()
    {
        return $this->hasOne(MaterialalunoMatalu::className(), ['matalu_cod' => 'materialaluno_cod']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanodeacaoCod()
    {
        return $this->hasOne(PlanodeacaoPlan::className(), ['plan_codplano' => 'planodeacao_cod']);
    }
}
