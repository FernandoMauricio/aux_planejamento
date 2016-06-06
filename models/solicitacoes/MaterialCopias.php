<?php

namespace app\models\solicitacoes;

use Yii;

/**
 * This is the model class for table "materialcopias_matc".
 *
 * @property integer $matc_id
 * @property string $matc_descricao
 * @property integer $matc_qtoriginais
 * @property integer $matc_qtexemplares
 * @property integer $matc_mono
 * @property integer $matc_color
 * @property string $matc_curso
 * @property string $matc_centrocusto
 * @property string $matc_unidade
 * @property string $matc_solicitante
 * @property string $matc_data
 * @property integer $situacao_id
 *
 * @property CopiasacabamentoCopac[] $copiasacabamentoCopacs
 * @property SituacaomatcopiasSitmat $situacao
 */
class MaterialCopias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'materialcopias_matc';
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
            [['matc_descricao', 'matc_qtoriginais', 'matc_qtexemplares', 'matc_curso', 'matc_centrocusto', 'situacao_id'], 'required'],
            [['matc_qtoriginais', 'matc_qtexemplares', 'matc_mono', 'matc_color', 'situacao_id'], 'integer'],
            [['matc_data'], 'safe'],
            [['matc_descricao', 'matc_curso'], 'string', 'max' => 255],
            [['matc_centrocusto', 'matc_unidade', 'matc_solicitante'], 'string', 'max' => 100],
            [['situacao_id'], 'exist', 'skipOnError' => true, 'targetClass' => Situacao::className(), 'targetAttribute' => ['situacao_id' => 'sitmat_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'matc_id' => 'Código',
            'matc_descricao' => 'Material',
            'matc_qtoriginais' => 'Qte Originais',
            'matc_qtexemplares' => 'Qte Exemplares',
            'matc_mono' => 'Mono',
            'matc_color' => 'Color',
            'matc_curso' => 'Curso',
            'matc_centrocusto' => 'Centro de Custo',
            'matc_unidade' => 'Unidade Solicitante',
            'matc_solicitante' => 'Usuário Solicitante',
            'matc_data' => 'Data da Solicitação',
            'situacao_id' => 'Situação',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCopiasacabamentoCopacs()
    {
        return $this->hasMany(CopiasacabamentoCopac::className(), ['materialcopias_id' => 'matc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSituacao()
    {
        return $this->hasOne(SituacaomatcopiasSitmat::className(), ['sitmat_id' => 'situacao_id']);
    }
}
