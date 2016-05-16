<?php

namespace app\models\repositorio;

use Yii;

/**
 * This is the model class for table "repositorio_rep".
 *
 * @property string $rep_codrepositorio
 * @property string $rep_titulo
 * @property string $rep_codcategoria
 * @property string $rep_codtipo
 * @property string $rep_codeditora
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
 * @property TipomaterialTip $repCodtipo
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
            [['rep_titulo', 'rep_codcategoria', 'rep_codtipo', 'rep_codeditora', 'rep_sobre', 'rep_codunidade', 'rep_codcolaborador', 'rep_data', 'rep_codvisualizacao', 'rep_palavrachave'], 'required'],
            [['rep_codcategoria', 'rep_codtipo', 'rep_codeditora', 'rep_codunidade', 'rep_codcolaborador', 'rep_codvisualizacao'], 'integer'],
            [['rep_valor'], 'number'],
            [['rep_sobre'], 'string'],
            [['rep_data'], 'safe'],
            [['rep_titulo', 'rep_arquivo'], 'string', 'max' => 80],
            [['rep_palavrachave'], 'string', 'max' => 200],
            [['rep_codcategoria'], 'exist', 'skipOnError' => true, 'targetClass' => CategoriaCat::className(), 'targetAttribute' => ['rep_codcategoria' => 'cat_codcategoria']],
            [['rep_codeditora'], 'exist', 'skipOnError' => true, 'targetClass' => EditoraEdi::className(), 'targetAttribute' => ['rep_codeditora' => 'edi_codeditora']],
            [['rep_codtipo'], 'exist', 'skipOnError' => true, 'targetClass' => TipomaterialTip::className(), 'targetAttribute' => ['rep_codtipo' => 'tip_codtipo']],
            [['rep_codvisualizacao'], 'exist', 'skipOnError' => true, 'targetClass' => VisualizacaomaterialVis::className(), 'targetAttribute' => ['rep_codvisualizacao' => 'vis_codvisualizacao']],
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
            'rep_codtipo' => 'Rep Codtipo',
            'rep_codeditora' => 'Rep Codeditora',
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
        return $this->hasOne(EditoraEdi::className(), ['edi_codeditora' => 'rep_codeditora']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepCodtipo()
    {
        return $this->hasOne(TipomaterialTip::className(), ['tip_codtipo' => 'rep_codtipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepCodvisualizacao()
    {
        return $this->hasOne(VisualizacaomaterialVis::className(), ['vis_codvisualizacao' => 'rep_codvisualizacao']);
    }
}
