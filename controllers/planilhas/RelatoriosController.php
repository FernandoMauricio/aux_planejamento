<?php

namespace app\controllers\planilhas;

use Yii;
use app\models\cadastros\Ano;
use app\models\cadastros\Tipoplanilha;
use app\models\cadastros\Situacaoplanilha;
use app\models\planilhas\Planilhadecurso;
use app\models\planilhas\PlanilhadecursoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;


class RelatoriosController extends Controller
{

    public function actionRelatorio()
    {
        $session = Yii::$app->session;
    	$model = new Planilhadecurso();

    	$ano              = Ano::find()->orderBy(['an_codano'=>SORT_DESC])->all();
        $tipoPlanilha     = Tipoplanilha::find()->all();
    	$situacaoPlanilha = Situacaoplanilha::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            return $this->redirect(['matricula-unidade', 'ano_planilha' => $model->placu_codano, 'tipo_planilha'=> $model->placu_codtipla, 'situacao_planilha' => $model->placu_codsituacao]);

        }else{
            return $this->render('/relatorios/relatorio', [
                'model'            => $model,
                'ano'              => $ano,
                'tipoPlanilha'     => $tipoPlanilha,
                'situacaoPlanilha' => $situacaoPlanilha,
                ]);
        }
    }

    public function actionMatriculaUnidade($ano_planilha, $situacao_planilha, $tipo_planilha)
    {
        $queryAno = "SELECT * FROM ano_an WHERE an_codano = '".$ano_planilha."'";
        $ano_planilha = Ano::findBySql($queryAno)->one();

        $querySituacaoPlanilha = "SELECT * FROM situacaoplanilha_sipla WHERE sipla_codsituacao = '".$situacao_planilha."'";
        $situacao_planilha = Situacaoplanilha::findBySql($querySituacaoPlanilha)->one(); 

        $queryTipoPlanilha = "SELECT * FROM tipoplanilha_tipla WHERE tipla_codtipla = '".$tipo_planilha."'";
        $tipo_planilha = Tipoplanilha::findBySql($queryTipoPlanilha)->one(); 

            return $this->render('/relatorios/matricula-unidade', [
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              ]);
    }

}