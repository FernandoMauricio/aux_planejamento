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
 * @property integer $rep_status
 */
class Repositorio extends \yii\db\ActiveRecord
{
    public $file;

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
            [['rep_titulo', 'rep_categoria', 'rep_tipo', 'rep_editora', 'rep_sobre', 'rep_codunidade', 'rep_codcolaborador', 'rep_data', 'rep_status'], 'required'],
            [['rep_valor'], 'number'],
            [['rep_codunidade', 'rep_codcolaborador', 'rep_status'], 'integer'],
            [['rep_data'], 'safe'],
            [['file'], 'file','checkExtensionByMimeType'=>false, 'extensions' => 'pdf, zip, rar, doc, docx'],
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
            'rep_titulo' => 'Título',
            'rep_categoria' => 'Categoria',
            'rep_tipo' => 'Tipo de Material',
            'rep_editora' => 'Editora',
            'rep_valor' => 'Valor',
            'rep_sobre' => 'Sobre',
            'rep_arquivo' => 'Arquivo',
            'file' => 'Arquivo',
            'rep_codunidade' => 'Rep Codunidade',
            'rep_codcolaborador' => 'Rep Codcolaborador',
            'rep_data' => 'Rep Data',
            'rep_status' => 'Situação',
        ];
    }
}