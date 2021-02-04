<?php

namespace app\models\relatorios;

use Yii;
use yii\base\Model;

class RelatorioPlanilhasPrecificacao extends Model
{
    public $relat_codano;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['relat_codano'], 'required'],
            [['relat_codano'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'relat_codano' => 'Ano Planilha',
        ];
    }
}
