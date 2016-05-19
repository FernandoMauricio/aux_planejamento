<?php

namespace app\models\repositorio;

use Yii;

/**
 * This is the model class for table "repositorio_rep".
 *
 * @property string $rep_codrepositorio
 * @property string $rep_titulo
 * @property string $rep_codcategoria
 * @property string $rep_tipo
 * @property string $rep_editora
 * @property double $rep_valor
 * @property string $rep_sobre
 * @property string $rep_arquivo
 * @property integer $rep_codunidade
 * @property integer $rep_codcolaborador
 * @property string $rep_data
 * @property string $rep_codvisualizacao
 * @property string $rep_palavrachave
 *
 * @property CategoriaCat $repCodcategoria
 * @property EditoraEdi $repCodeditora
 * @property VisualizacaomaterialVis $repCodvisualizacao
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
            [['rep_titulo', 'rep_codcategoria', 'rep_tipo', 'rep_editora', 'rep_sobre', 'rep_codunidade', 'rep_codcolaborador', 'rep_data', 'rep_codvisualizacao', 'rep_palavrachave'], 'required'],
            [['rep_codcategoria', 'rep_editora', 'rep_codunidade', 'rep_codcolaborador', 'rep_codvisualizacao'], 'integer'],
            [['rep_valor'], 'number'],
            [['rep_data'], 'safe'],
            [['rep_titulo'], 'string', 'max' => 80],
            [['rep_tipo', 'rep_arquivo'], 'string', 'max' => 100],
            [['rep_sobre'], 'string', 'max' => 255],
            [['rep_palavrachave'], 'string', 'max' => 200],
            [['rep_codcategoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['rep_codcategoria' => 'cat_codcategoria']],
            [['rep_editora'], 'exist', 'skipOnError' => true, 'targetClass' => Editora::className(), 'targetAttribute' => ['rep_editora' => 'edi_codeditora']],
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
            'rep_codcategoria' => 'Rep Codcategoria',
            'rep_tipo' => 'Rep Tipo',
            'rep_editora' => 'Rep Codeditora',
            'rep_valor' => 'Rep Valor',
            'rep_sobre' => 'Rep Sobre',
            'rep_arquivo' => 'Rep Arquivo',
            'rep_codunidade' => 'Rep Codunidade',
            'rep_codcolaborador' => 'Rep Codcolaborador',
            'rep_data' => 'Rep Data',
            'rep_codvisualizacao' => 'Rep Codvisualizacao',
            'rep_palavrachave' => 'Rep Palavrachave',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepCodcategoria()
    {
        return $this->hasOne(CategoriaCat::className(), ['cat_codcategoria' => 'rep_codcategoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepCodeditora()
    {
        return $this->hasOne(EditoraEdi::className(), ['edi_codeditora' => 'rep_editora']);
    }

}
