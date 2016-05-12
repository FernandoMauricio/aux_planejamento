<?php

namespace app\models\planos;

use Yii;
use app\models\cadastros\Estruturafisica;

/**
 * This is the model class for table "plano_estruturafisica".
 *
 * @property integer $planestr_cod
 * @property string $planodeacao_cod
 * @property integer $estruturafisica_cod
 * @property integer $quantidade
 * @property string $tipo
 *
 * @property EstruturafisicaEstr $estruturafisicaCod
 * @property PlanodeacaoPlan $planodeacaoCod
 */
class PlanoEstruturafisica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'plano_estruturafisica';
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
            [['quantidade', 'tipo'], 'required'],
            [['planestr_cod', 'planodeacao_cod', 'estruturafisica_cod', 'quantidade'], 'integer'],
            [['tipo'], 'string', 'max' => 45],
            [['estruturafisica_cod'], 'exist', 'skipOnError' => true, 'targetClass' => Estruturafisica::className(), 'targetAttribute' => ['estruturafisica_cod' => 'estr_cod']],
            [['planodeacao_cod'], 'exist', 'skipOnError' => true, 'targetClass' => Planodeacao::className(), 'targetAttribute' => ['planodeacao_cod' => 'plan_codplano']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'planestr_cod' => 'Planestr Cod',
            'planodeacao_cod' => 'Planodeacao Cod',
            'estruturafisica_cod' => 'Descrição',
            'quantidade' => 'Quantidade',
            'tipo' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstruturafisicaCod()
    {
        return $this->hasOne(EstruturafisicaEstr::className(), ['estr_cod' => 'estruturafisica_cod']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanodeacaoCod()
    {
        return $this->hasOne(PlanodeacaoPlan::className(), ['plan_codplano' => 'planodeacao_cod']);
    }
}
