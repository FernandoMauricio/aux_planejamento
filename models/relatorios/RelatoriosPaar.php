<?php

namespace app\models\relatorios;

use Yii;
use yii\base\Model;

class RelatoriosPaar extends Model
{
    public $relat_codano;
    public $relat_codtipla;
    public $relat_codsituacao;
    public $relat_tiporelatorio;
    public $relat_codprogramacao;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['relat_codano', 'relat_codtipla', 'relat_codsituacao', 'relat_tiporelatorio', 'relat_codprogramacao'], 'required'],
            [['relat_codano', 'relat_codtipla', 'relat_codsituacao', 'relat_tiporelatorio', 'relat_codprogramacao'], 'integer'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'relat_codano' => 'Orçamento',
            'relat_codsituacao' => 'Situação Planilha',
            'relat_codtipla' => 'Tipo Planilha',
            'relat_tiporelatorio' => 'Tipo de Relatório',
            'relat_codprogramacao' => 'Tipo de Programação',
        ];
    }
}
