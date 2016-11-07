<?php

namespace app\models\planilhas;

use Yii;
use app\models\cadastros\Ano;
use app\models\cadastros\Eixo;
use app\models\cadastros\Nivel;
use app\models\cadastros\Segmento;
use app\models\cadastros\Tipo;
use app\models\cadastros\Categoriaplanilha;
use app\models\cadastros\Finalidade;
use app\models\cadastros\Tipoprogramacao;
use app\models\cadastros\Tipoplanilha;
use app\models\cadastros\Situacaoplanilha;
use app\models\planos\Planodeacao;
use app\models\planos\Segmentotipoacao;
/**
 * This is the model class for table "planilhadecurso_placu".
 *
 * @property string $placu_codplanilha
 * @property string $placu_codeixo
 * @property string $placu_codsegmento
 * @property string $placu_codplano
 * @property string $placu_codtipoa
 * @property string $placu_codnivel
 * @property string $placu_codsegtip
 * @property double $placu_cargahorariaplano
 * @property double $placu_cargahorariarealizada
 * @property double $placu_cargahorariaarealizar
 * @property string $placu_codano
 * @property string $placu_codfinalidade
 * @property string $placu_codcategoria
 * @property string $placu_codtipla
 * @property integer $placu_quantidadeturmas
 * @property integer $placu_quantidadealunos
 * @property integer $placu_quantidadeparcelas
 * @property double $placu_valormensalidade
 * @property string $placu_codsituacao
 * @property integer $placu_codcolaborador
 * @property integer $placu_codunidade
 * @property string $plcau_nomeunidade
 * @property integer $placu_quantidadealunospsg
 * @property integer $placu_tipocalculo
 * @property string $placu_arquivolistamaterial
 * @property string $placu_listamaterialdoaluno
 * @property string $placu_observacao
 * @property double $placu_taxaretorno
 * @property integer $placu_cargahorariavivencia
 * @property integer $placu_quantidadealunosisentos
 * @property string $planilhadecurso_placucol
 * @property string $placu_codprogramacao
 *
 * @property HistoricoplanilhaHis[] $historicoplanilhaHis
 * @property ObservacaoplanilhaObpla[] $observacaoplanilhaObplas
 * @property AnoAn $placuCodano
 * @property CategoriaplanilhaCat $placuCodcategoria
 * @property EixoEix $placuCodeixo
 * @property FinalidadeFin $placuCodfinalidade
 * @property NivelNiv $placuCodnivel
 * @property PlanodeacaoPlan $placuCodplano
 * @property TipoprogramacaoTipro $placuCodprogramacao
 * @property SegmentoSeg $placuCodsegmento
 * @property SegmentotipoacaoSegtip $placuCodsegtip
 * @property SituacaoplanilhaSipla $placuCodsituacao
 * @property TipoplanilhaTipla $placuCodtipla
 * @property TipodeacaoTip $placuCodtipoa
 * @property PlanilhadespesaPlades[] $planilhadespesaPlades
 */
class Planilhadecurso extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'planilhadecurso_placu';
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
            [['placu_codeixo', 'placu_codsegmento', 'placu_codplano', 'placu_codtipoa', 'placu_codnivel', 'placu_codsegtip', 'placu_codano', 'placu_codfinalidade', 'placu_codcategoria', 'placu_codtipla', 'placu_codsituacao', 'placu_codcolaborador', 'placu_codunidade', 'plcau_nomeunidade', 'placu_tipocalculo', 'placu_quantidadealunosisentos'], 'required'],
            [['placu_codeixo', 'placu_codsegmento', 'placu_codplano', 'placu_codtipoa', 'placu_codnivel', 'placu_codsegtip', 'placu_codano', 'placu_codfinalidade', 'placu_codcategoria', 'placu_codtipla', 'placu_quantidadeturmas', 'placu_quantidadealunos', 'placu_quantidadeparcelas', 'placu_codsituacao', 'placu_codcolaborador', 'placu_codunidade', 'placu_quantidadealunospsg', 'placu_tipocalculo', 'placu_cargahorariavivencia', 'placu_quantidadealunosisentos', 'placu_codprogramacao'], 'integer'],
            [['placu_cargahorariaplano', 'placu_cargahorariarealizada', 'placu_cargahorariaarealizar', 'placu_valormensalidade', 'placu_taxaretorno'], 'number'],
            [['placu_observacao'], 'string'],
            [['plcau_nomeunidade'], 'string', 'max' => 150],
            [['placu_arquivolistamaterial', 'placu_listamaterialdoaluno'], 'string', 'max' => 60],
            [['planilhadecurso_placucol'], 'string', 'max' => 45],
            [['placu_codano'], 'exist', 'skipOnError' => true, 'targetClass' => Ano::className(), 'targetAttribute' => ['placu_codano' => 'an_codano']],
            [['placu_codcategoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoriaplanilha::className(), 'targetAttribute' => ['placu_codcategoria' => 'cat_codcategoria']],
            [['placu_codeixo'], 'exist', 'skipOnError' => true, 'targetClass' => Eixo::className(), 'targetAttribute' => ['placu_codeixo' => 'eix_codeixo']],
            [['placu_codfinalidade'], 'exist', 'skipOnError' => true, 'targetClass' => Finalidade::className(), 'targetAttribute' => ['placu_codfinalidade' => 'fin_codfinalidade']],
            [['placu_codnivel'], 'exist', 'skipOnError' => true, 'targetClass' => Nivel::className(), 'targetAttribute' => ['placu_codnivel' => 'niv_codnivel']],
            [['placu_codplano'], 'exist', 'skipOnError' => true, 'targetClass' => Planodeacao::className(), 'targetAttribute' => ['placu_codplano' => 'plan_codplano']],
            [['placu_codprogramacao'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoprogramacao::className(), 'targetAttribute' => ['placu_codprogramacao' => 'tipro_codprogramacao']],
            [['placu_codsegmento'], 'exist', 'skipOnError' => true, 'targetClass' => Segmento::className(), 'targetAttribute' => ['placu_codsegmento' => 'seg_codsegmento']],
            [['placu_codsegtip'], 'exist', 'skipOnError' => true, 'targetClass' => Segmentotipoacao::className(), 'targetAttribute' => ['placu_codsegtip' => 'segtip_codsegtip']],
            [['placu_codsituacao'], 'exist', 'skipOnError' => true, 'targetClass' => Situacaoplanilha::className(), 'targetAttribute' => ['placu_codsituacao' => 'sipla_codsituacao']],
            [['placu_codtipla'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoplanilha::className(), 'targetAttribute' => ['placu_codtipla' => 'tipla_codtipla']],
            [['placu_codtipoa'], 'exist', 'skipOnError' => true, 'targetClass' => Tipo::className(), 'targetAttribute' => ['placu_codtipoa' => 'tip_codtipoa']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'placu_codplanilha' => 'Placu Codplanilha',
            'placu_codeixo' => 'Placu Codeixo',
            'placu_codsegmento' => 'Placu Codsegmento',
            'placu_codplano' => 'Placu Codplano',
            'placu_codtipoa' => 'Placu Codtipoa',
            'placu_codnivel' => 'Placu Codnivel',
            'placu_codsegtip' => 'Placu Codsegtip',
            'placu_cargahorariaplano' => 'Placu Cargahorariaplano',
            'placu_cargahorariarealizada' => 'Placu Cargahorariarealizada',
            'placu_cargahorariaarealizar' => 'Placu Cargahorariaarealizar',
            'placu_codano' => 'Placu Codano',
            'placu_codfinalidade' => 'Placu Codfinalidade',
            'placu_codcategoria' => 'Placu Codcategoria',
            'placu_codtipla' => 'Placu Codtipla',
            'placu_quantidadeturmas' => 'Placu Quantidadeturmas',
            'placu_quantidadealunos' => 'Placu Quantidadealunos',
            'placu_quantidadeparcelas' => 'Placu Quantidadeparcelas',
            'placu_valormensalidade' => 'Placu Valormensalidade',
            'placu_codsituacao' => 'Placu Codsituacao',
            'placu_codcolaborador' => 'Placu Codcolaborador',
            'placu_codunidade' => 'Placu Codunidade',
            'plcau_nomeunidade' => 'Plcau Nomeunidade',
            'placu_quantidadealunospsg' => 'Placu Quantidadealunospsg',
            'placu_tipocalculo' => 'Placu Tipocalculo',
            'placu_arquivolistamaterial' => 'Placu Arquivolistamaterial',
            'placu_listamaterialdoaluno' => 'Placu Listamaterialdoaluno',
            'placu_observacao' => 'Placu Observacao',
            'placu_taxaretorno' => 'Placu Taxaretorno',
            'placu_cargahorariavivencia' => 'Placu Cargahorariavivencia',
            'placu_quantidadealunosisentos' => 'Placu Quantidadealunosisentos',
            'planilhadecurso_placucol' => 'Planilhadecurso Placucol',
            'placu_codprogramacao' => 'Placu Codprogramacao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoricoplanilhaHis()
    {
        return $this->hasMany(HistoricoplanilhaHis::className(), ['his_codplanilha' => 'placu_codplanilha']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObservacaoplanilhaObplas()
    {
        return $this->hasMany(ObservacaoplanilhaObpla::className(), ['obpla_codplanilha' => 'placu_codplanilha']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacuCodano()
    {
        return $this->hasOne(AnoAn::className(), ['an_codano' => 'placu_codano']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacuCodcategoria()
    {
        return $this->hasOne(CategoriaplanilhaCat::className(), ['cat_codcategoria' => 'placu_codcategoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacuCodeixo()
    {
        return $this->hasOne(EixoEix::className(), ['eix_codeixo' => 'placu_codeixo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacuCodfinalidade()
    {
        return $this->hasOne(FinalidadeFin::className(), ['fin_codfinalidade' => 'placu_codfinalidade']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacuCodnivel()
    {
        return $this->hasOne(NivelNiv::className(), ['niv_codnivel' => 'placu_codnivel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacuCodplano()
    {
        return $this->hasOne(PlanodeacaoPlan::className(), ['plan_codplano' => 'placu_codplano']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacuCodprogramacao()
    {
        return $this->hasOne(TipoprogramacaoTipro::className(), ['tipro_codprogramacao' => 'placu_codprogramacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacuCodsegmento()
    {
        return $this->hasOne(SegmentoSeg::className(), ['seg_codsegmento' => 'placu_codsegmento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacuCodsegtip()
    {
        return $this->hasOne(SegmentotipoacaoSegtip::className(), ['segtip_codsegtip' => 'placu_codsegtip']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacuCodsituacao()
    {
        return $this->hasOne(SituacaoplanilhaSipla::className(), ['sipla_codsituacao' => 'placu_codsituacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacuCodtipla()
    {
        return $this->hasOne(TipoplanilhaTipla::className(), ['tipla_codtipla' => 'placu_codtipla']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacuCodtipoa()
    {
        return $this->hasOne(TipodeacaoTip::className(), ['tip_codtipoa' => 'placu_codtipoa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanilhadespesaPlades()
    {
        return $this->hasMany(PlanilhadespesaPlades::className(), ['plades_codplanilha' => 'placu_codplanilha']);
    }
}
