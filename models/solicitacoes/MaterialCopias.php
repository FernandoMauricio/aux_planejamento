<?php

namespace app\models\solicitacoes;

use Yii;

use app\models\base\Colaborador;
use app\models\base\Unidade;

/**
 * This is the model class for table "materialcopias_matc".
 *
 * @property integer $matc_id
 * @property string $matc_descricao
 * @property integer $matc_qtoriginais
 * @property integer $matc_qtexemplares
 * @property integer $matc_mono
 * @property integer $matc_color
 * @property string $matc_curso
 * @property string $matc_centrocusto
 * @property string $matc_unidade
 * @property string $matc_solicitante
 * @property string $matc_data
 * @property integer $situacao_id
 * @property integer $matc_qteCopias
 * @property integer $matc_qteTotal
 * @property integer $matc_totalValorMono
 * @property integer $matc_totalValorColor
 * @property string $matc_ResponsavelAut
 * @property string $matc_dataAut
 *
 * @property CopiasacabamentoCopac[] $copiasacabamentoCopacs
 * @property SituacaomatcopiasSitmat $situacao
 */
class MaterialCopias extends \yii\db\ActiveRecord
{
    public $listAcabamento;
    public $matc_totalGeral;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'materialcopias_matc';
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
            [['matc_descricao', 'matc_qtoriginais', 'listAcabamento', 'matc_qtexemplares', 'matc_curso', 'matc_centrocusto', 'situacao_id', 'matc_totalValorMono', 'matc_totalValorColor', 'matc_totalGeral', 'matc_segmento', 'matc_tipoacao'], 'required'],
            [['matc_qtoriginais', 'matc_qtexemplares', 'matc_mono', 'matc_color', 'situacao_id', 'matc_qteCopias', 'matc_qteTotal', 'matc_autorizado', 'matc_encaminhadoRepro', 'matc_segmento', 'matc_tipoacao'], 'integer'],
            [['matc_data', 'matc_dataAut','matc_dataRepro'], 'safe'],
            [['matc_totalValorMono', 'matc_totalValorColor'], 'number'],
            [['matc_descricao', 'matc_curso', 'matc_observacao'], 'string', 'max' => 255],
            [['matc_centrocusto'], 'string',  'min' => 6, 'max' => 6,'tooShort' => '"{attribute}" deve conter 5 números'], // exemplo: 25.555
            [['matc_qteTotal'], 'compare','compareAttribute'=>'matc_qteCopias'], // total copias == quantidade total (mono+color)
            [['matc_unidade', 'matc_solicitante', 'matc_ResponsavelAut','matc_ResponsavelRepro'], 'string', 'max' => 100],
            [['situacao_id'], 'exist', 'skipOnError' => true, 'targetClass' => Situacao::className(), 'targetAttribute' => ['situacao_id' => 'sitmat_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'matc_id' => 'Código',
            'matc_segmento' => 'Segmento',
            'matc_tipoacao' => 'Tipo de Ação',
            'matc_descricao' => 'Material',
            'matc_qtoriginais' => 'Qte Originais',
            'matc_qtexemplares' => 'Qte Exemplares',
            'matc_mono' => 'Mono',
            'matc_color' => 'Color',
            'matc_curso' => 'Curso',
            'matc_centrocusto' => 'Centro de Custo',
            'matc_unidade' => 'Unidade',
            'matc_solicitante' => 'Solicitante',
            'matc_data' => 'Data da Solicitação',
            'situacao_id' => 'Situação',
            'matc_qteCopias' => 'Qte Cópias',
            'matc_qteTotal' => 'Qte Total',
            'matc_totalValorMono' => 'Total em cópias mono',
            'matc_totalValorColor' => 'Total em cópias coloridas',
            'matc_observacao' => 'Observação',
            
            'listAcabamento' => 'Serviços de Acabamento',
            'matc_totalGeral' => 'Total Geral',
        ];
    }


    public function getCopiasAcabamento() //Relation between Cargos & Processo table
    {
        return $this->hasMany(CopiasAcabamento::className(), ['materialcopias_id' => 'matc_id']);
    }


    public function afterSave($insert, $changedAttributes){
        //Cargos
        \Yii::$app->db_apl->createCommand()->delete('copiasacabamento_copac', 'materialcopias_id = '.(int) $this->matc_id)->execute(); //Delete existing value
        foreach ($this->listAcabamento as $id) { //Write new values
            $tc = new CopiasAcabamento();
            $tc->materialcopias_id = $this->matc_id;
            $tc->acabamento_id = $id;
            $tc->save();
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSituacao()
    {
        return $this->hasOne(Situacao::className(), ['sitmat_id' => 'situacao_id']);
    }

    public function getColaborador()
    {
        return $this->hasOne(Colaborador::className(), ['col_codcolaborador' => 'matc_solicitante']);
    }

    public function getUnidade()
    {
        return $this->hasOne(Unidade::className(), ['uni_codunidade' => 'matc_unidade']);
    }

}
