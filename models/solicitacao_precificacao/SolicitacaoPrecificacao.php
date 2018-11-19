<?php

namespace app\models\solicitacao_precificacao;

use Yii;

/**
 * This is the model class for table "solicitacao_precificao".
 *
 * @property integer $solpre_id
 * @property string $solpre_titulo
 * @property integer $solpre_cargahoraria
 * @property integer $solpre_qntaluno
 * @property string $solpre_observacao
 * @property integer $solpre_codplano
 * @property string $solpre_autorizacao
 * @property string $solpre_dataautorizacao
 * @property string $solpre_situacao
 * @property string $solpre_unidade
 * @property string $solpre_solicitante
 */
class SolicitacaoPrecificacao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'solicitacao_precificao';
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
            [['solpre_titulo', 'solpre_cargahoraria', 'solpre_qntaluno'], 'required'],
            [['solpre_cargahoraria', 'solpre_qntaluno', 'solpre_codplano'], 'integer'],
            [['solpre_dataautorizacao'], 'safe'],
            [['solpre_titulo', 'solpre_observacao', 'solpre_unidade', 'solpre_solicitante'], 'string', 'max' => 255],
            [['solpre_autorizacao', 'solpre_situacao'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'solpre_id' => 'Cód.',
            'solpre_titulo' => 'Título',
            'solpre_cargahoraria' => 'Carga Horária',
            'solpre_qntaluno' => 'Qnt Alunos',
            'solpre_observacao' => 'Observação',
            'solpre_codplano' => 'Plano',
            'solpre_autorizacao' => 'Autorização DEP',
            'solpre_dataautorizacao' => 'Data Autorização',
            'solpre_situacao' => 'Situação',
            'solpre_unidade' => 'Unidade',
            'solpre_solicitante' => 'Solicitante',
        ];
    }
}
