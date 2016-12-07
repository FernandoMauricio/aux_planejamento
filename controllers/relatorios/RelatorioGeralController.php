<?php

namespace app\controllers\relatorios;

use Yii;
use app\models\base\Unidade;
use app\models\cadastros\Ano;
use app\models\cadastros\Tipoprogramacao;
use app\models\cadastros\Tipoplanilha;
use app\models\cadastros\Situacaoplanilha;
use app\models\relatorios\RelatorioGeral;
use app\models\planilhas\Planilhadecurso;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;


class RelatorioGeralController extends Controller
{
    public function actionGerarRelatorio()
    {

	    $session = Yii::$app->session;
	    $model = new RelatorioGeral();

	    $unidades     	  = Unidade::find()->where(['uni_codsituacao' => 1])->orderBy('uni_nomeabreviado')->all();
	    $ano              = Ano::find()->orderBy(['an_codano'=>SORT_DESC])->all();
	    $tipoPlanilha     = Tipoplanilha::find()->all();
	    $situacaoPlanilha = Situacaoplanilha::find()->all();
	    $tipoProgramacao  = Tipoprogramacao::find()->all();

        if ($model->load(Yii::$app->request->post())) {

        	//Irá pesquisar todas as unidades
        	// if($model->relat_unidade == NULL){
        	// 	$model->relat_unidade = 0;
        	// }

            return $this->redirect(['relatorio-geral', 'combounidade' => $model->relat_unidade, 'ano_planilha' => $model->relat_codano, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_planilha' => $model->relat_codtipla, 'tipo' => $model->relat_modelorelatorio, 'combotipoprogramacao' => $model->relat_tipoprogramacao]);

        }else{
	            return $this->render('/relatorios/relatorio-geral/gerar-relatorio', [
	                'model'            => $model,
	                'unidades'         => $unidades,
	                'ano'              => $ano,
	                'tipoPlanilha'     => $tipoPlanilha,
	                'situacaoPlanilha' => $situacaoPlanilha,
	                'tipoProgramacao'  => $tipoProgramacao,
	                ]);
	         }
    }

    public function actionRelatorioGeral($combounidade, $ano_planilha, $situacao_planilha, $tipo_planilha, $tipo, $combotipoprogramacao)
    {
       $this->layout = 'main-imprimir';
       $combounidade      = $this->findModelUnidade($combounidade);
       $ano_planilha      = $this->findModelAnoPlanilha($ano_planilha);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo              = 1;

            return $this->render('/relatorios/relatorio-geral/relatorio-geral', [
              'combounidade'      => $combounidade,
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              ]);
    }


    protected function findModelUnidade($combounidade)
    {
        $queryUnidade = "SELECT placu_codunidade, placu_nomeunidade FROM planilhadecurso_placu WHERE placu_codunidade = '".$combounidade."'";

        $combounidade = Planilhadecurso::findBySql($queryUnidade)->one();

        return $combounidade;
    }

    protected function findModelAnoPlanilha($ano_planilha)
    {
        $queryAno = "SELECT * FROM ano_an WHERE an_codano = '".$ano_planilha."'";

        if (($ano_planilha = Ano::findBySql($queryAno)->one()) !== null) {
            return $ano_planilha;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelSituacaoPlanilha($situacao_planilha)
    {
        $querySituacaoPlanilha = "SELECT * FROM situacaoplanilha_sipla WHERE sipla_codsituacao = '".$situacao_planilha."'";

        if (($situacao_planilha = Situacaoplanilha::findBySql($querySituacaoPlanilha)->one()) !== null ) {
            return $situacao_planilha;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelTipoPlanilha($tipo_planilha)
    {
        $queryTipoPlanilha = "SELECT * FROM tipoplanilha_tipla WHERE tipla_codtipla = '".$tipo_planilha."'";

        if (($tipo_planilha = Tipoplanilha::findBySql($queryTipoPlanilha)->one()) !== null ) {
            return $tipo_planilha;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelTipoProgramacao($combotipoprogramacao)
    {
        $queryTipoProgramacao = "SELECT * FROM tipoprogramacao_tipro WHERE tipro_codprogramacao = '".$combotipoprogramacao."'";

        if (($combotipoprogramacao = Tipoprogramacao::findBySql($queryTipoProgramacao)->one()) !== null) {
            return $combotipoprogramacao;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}