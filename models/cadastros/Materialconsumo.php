<?php

namespace app\models\cadastros;

use Yii;

/**
 * This is the model class for table "materialconsumo_matcon".
 *
 * @property integer $matcon_cod
 * @property string $matcon_descricao
 * @property string $matcon_tipo
 * @property double $matcon_valor
 * @property integer $matcon_status
 *
 * @property PlanoMaterialconsumo[] $planoMaterialconsumos
 */
class Materialconsumo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'materialconsumo_matcon';
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
            [['matcon_valor'], 'number'],
            [['matcon_status'], 'integer'],
            [['matcon_descricao'], 'string', 'max' => 100],
            [['matcon_tipo'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'matcon_cod' => 'Matcon Cod',
            'matcon_descricao' => 'Matcon Descricao',
            'matcon_tipo' => 'Matcon Tipo',
            'matcon_valor' => 'Matcon Valor',
            'matcon_status' => 'Matcon Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanoMaterialconsumos()
    {
        return $this->hasMany(PlanoMaterialconsumo::className(), ['materialconsumo_cod' => 'matcon_cod']);
    }
}
