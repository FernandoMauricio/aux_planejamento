<?php

namespace app\models\despesas;

use Yii;
use app\models\base\Unidade;

/**
 * This is the model class for table "custosunidade_cust".
 *
 * @property integer $cust_codcusto
 * @property integer $cust_codunidade
 * @property integer $cust_status
 *
 * @property SalasSal[] $salasSals
 */
class Custosunidade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'custosunidade_cust';
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
            [['cust_codunidade', 'cust_status'], 'required'],
            [['cust_codunidade', 'cust_status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cust_codcusto' => 'Código',
            'cust_codunidade' => 'Unidade',
            'cust_status' => 'Situação',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalas()
    {
        return $this->hasMany(Salas::className(), ['custosunidade_id' => 'cust_codcusto']);
    }

    public function getUnidade()
    {
        return $this->hasOne(Unidade::className(), ['uni_codunidade' => 'cust_codunidade']);
    }

}
