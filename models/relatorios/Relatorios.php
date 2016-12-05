<?php

namespace app\models\relatorios;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "ano_an".
 *
 * @property string $an_codano
 * @property integer $an_ano
 * @property integer $an_status
 *
 * @property ModeloaModa[] $modeloaModas
 * @property PlanilhadecursoPlacu[] $planilhadecursoPlacus
 */
class Relatorios extends Model
{
    public $relat_codano;
    public $relat_codtipla;
    public $relat_codsituacao;
    public $relat_tiporelatorio;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['relat_codano', 'relat_codtipla', 'relat_codsituacao', 'relat_tiporelatorio'], 'required'],
            [['relat_codano', 'relat_codtipla', 'relat_codsituacao', 'relat_tiporelatorio'], 'integer'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'relat_codano' => 'Código',
            'relat_codtipla' => 'Ano',
            'relat_codsituacao' => 'Situação',
            'relat_tiporelatorio' => 'Situação',
        ];
    }
}
