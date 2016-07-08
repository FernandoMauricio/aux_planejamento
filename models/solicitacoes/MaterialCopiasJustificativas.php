<?php

namespace app\models\solicitacoes;

use Yii;

/**
 * This is the model class for table "materialcopias_justificativas".
 *
 * @property integer $id
 * @property string $descricao
 * @property string $usuario
 * @property integer $id_materialcopias
 *
 * @property MaterialcopiasMatc $idMaterialcopias
 */
class MaterialCopiasJustificativas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'materialcopias_justificativas';
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
            [['descricao', 'usuario', 'id_materialcopias'], 'required'],
            [['id_materialcopias'], 'integer'],
            [['descricao', 'usuario'], 'string', 'max' => 100],
            [['id_materialcopias'], 'exist', 'skipOnError' => true, 'targetClass' => MaterialCopias::className(), 'targetAttribute' => ['id_materialcopias' => 'matc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descricao' => 'Descrição',
            'usuario' => 'Usuário',
            'id_materialcopias' => 'Código da Solicitação',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMaterialcopias()
    {
        return $this->hasOne(MaterialcopiasMatc::className(), ['matc_id' => 'id_materialcopias']);
    }
}
