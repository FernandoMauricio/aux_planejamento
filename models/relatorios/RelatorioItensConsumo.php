<?php

namespace app\models\relatorios;

use Yii;
use yii\base\Model;

class RelatorioItensConsumo extends Model
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
            'relat_codano' => 'Orçamento',
        ];
    }
}
