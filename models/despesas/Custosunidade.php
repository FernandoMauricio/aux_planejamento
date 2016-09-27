<?php

namespace app\models\despesas;

use Yii;
use app\models\base\Unidade;
use app\models\cadastros\Ano;

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
            [['cust_codunidade', 'cust_indireto', 'cust_status', 'cust_ano'], 'required'],
            //['cust_codunidade', 'unique', 'targetAttribute' => ['cust_ano'],'message' => '"{attribute} já utilizada para o ano selecionado"'],
            [['cust_indireto', 'cust_MediaPorcentagem', 'cust_MediaCustoIndireto'], 'number'],
            [['cust_codunidade', 'cust_status', 'cust_ano'], 'integer'],
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
            'cust_indireto' => 'Custo Indireto',
            'cust_status' => 'Situação',
            'cust_ano' => 'Ano',
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


    public function getAno()
    {
        return $this->hasOne(Ano::className(), ['an_codano' => 'cust_ano']);
    }


}
