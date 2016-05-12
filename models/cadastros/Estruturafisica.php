<?php

namespace app\models\cadastros;

use Yii;

/**
 * This is the model class for table "estruturafisica_estr".
 *
 * @property integer $estr_cod
 * @property string $estr_descricao
 * @property integer $estr_status
 *
 * @property PlanodeacaoEstruturafisica[] $planodeacaoEstruturafisicas
 */
class Estruturafisica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estruturafisica_estr';
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
            [['estr_descricao', 'estr_status'], 'required'],
            [['estr_status'], 'integer'],
            [['estr_descricao'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'estr_cod' => 'Código',
            'estr_descricao' => 'Descrição',
            'estr_status' => 'Situação',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanodeacaoEstruturafisicas()
    {
        return $this->hasMany(PlanoEstruturafisica::className(), ['estruturafisica_estr_cod' => 'estr_cod']);
    }
}
