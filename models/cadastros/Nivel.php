<?php

namespace app\models\cadastros;

use Yii;

/**
 * This is the model class for table "nivel_niv".
 *
 * @property string $niv_codnivel
 * @property string $niv_descricao
 * @property string $niv_sigla
 *
 * @property PlanilhadecursoPlacu[] $planilhadecursoPlacus
 * @property PlanodeacaoPlan[] $planodeacaoPlans
 */
class Nivel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nivel_niv';
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
            [['niv_descricao', 'niv_sigla'], 'required'],
            [['niv_descricao'], 'string', 'max' => 60],
            [['niv_sigla'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'niv_codnivel' => 'Niv Codnivel',
            'niv_descricao' => 'Niv Descricao',
            'niv_sigla' => 'Niv Sigla',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanilhadecursoPlacus()
    {
        return $this->hasMany(PlanilhadecursoPlacu::className(), ['placu_codnivel' => 'niv_codnivel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanodeacaoPlans()
    {
        return $this->hasMany(PlanodeacaoPlan::className(), ['plan_codnivel' => 'niv_codnivel']);
    }
}
