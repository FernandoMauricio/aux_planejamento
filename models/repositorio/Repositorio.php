<?php

namespace app\models\repositorio;

use Yii;

/**
 * This is the model class for table "repositorio_rep".
 *
 * @property string $rep_codrepositorio
 * @property string $rep_titulo
 * @property string $rep_categoria
 * @property string $rep_tipo
 * @property string $rep_editora
 * @property double $rep_valor
 * @property string $rep_sobre
 * @property string $rep_arquivo
 * @property integer $rep_codunidade
 * @property integer $rep_codcolaborador
 * @property string $rep_data
 */
class Repositorio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'repositorio_rep';
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
            [['rep_titulo', 'rep_categoria', 'rep_tipo', 'rep_editora', 'rep_sobre', 'rep_codunidade', 'rep_codcolaborador', 'rep_data'], 'required'],
            [['rep_valor'], 'number'],
            [['rep_codunidade', 'rep_codcolaborador'], 'integer'],
            [['rep_data'], 'safe'],
            [['rep_titulo'], 'string', 'max' => 80],
            [['rep_categoria', 'rep_editora'], 'string', 'max' => 50],
            [['rep_tipo', 'rep_arquivo'], 'string', 'max' => 100],
            [['rep_sobre'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rep_codrepositorio' => 'Rep Codrepositorio',
            'rep_titulo' => 'Rep Titulo',
            'rep_categoria' => 'Rep Categoria',
            'rep_tipo' => 'Rep Tipo',
            'rep_editora' => 'Rep Editora',
            'rep_valor' => 'Rep Valor',
            'rep_sobre' => 'Rep Sobre',
            'rep_arquivo' => 'Rep Arquivo',
            'rep_codunidade' => 'Rep Codunidade',
            'rep_codcolaborador' => 'Rep Codcolaborador',
            'rep_data' => 'Rep Data',
        ];
    }
}
