<?php

namespace app\models\repositorio;

use Yii;

/**
 * This is the model class for table "tipomaterial_tip".
 *
 * @property string $tip_codtipo
 * @property string $tip_descricao
 * @property integer $tip_status
 */
class Tipomaterial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipomaterial_tip';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_rep');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tip_descricao', 'tip_status'], 'required'],
            [['tip_status'], 'integer'],
            [['tip_descricao'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tip_codtipo' => 'Tip Codtipo',
            'tip_descricao' => 'Descrição',
            'tip_status' => 'Situação',
        ];
    }
}
