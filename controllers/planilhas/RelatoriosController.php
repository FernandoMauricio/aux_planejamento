<?php

namespace app\controllers\planilhas;

use Yii;
use app\models\cadastros\Ano;
use app\models\cadastros\Tiporelatorio;
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
        $tipoRelatorio    = Tiporelatorio::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            if($model->placu_tiporelatorio == 1){
                  return $this->redirect(['matricula-unidade', 'ano_orcamento' => $model->placu_codano, 'tipo_planilha'=> $model->placu_codtipla, 'situacao_planilha' => $model->placu_codsituacao, 'tipo_relatorio' => $model->placu_tiporelatorio]);
                }
            else if($model->placu_tiporelatorio == 2){
                  return $this->redirect(['cargahoraria-unidade', 'ano_orcamento' => $model->placu_codano, 'tipo_planilha'=> $model->placu_codtipla, 'situacao_planilha' => $model->placu_codsituacao, 'tipo_relatorio' => $model->placu_tiporelatorio]);
                }


        }else{
            return $this->render('/relatorios/relatorio', [
                'model'            => $model,
                'ano'              => $ano,
                'tipoPlanilha'     => $tipoPlanilha,
                'situacaoPlanilha' => $situacaoPlanilha,
                'tipoRelatorio'    => $tipoRelatorio,
                ]);
        }

    }

    public function actionMatriculaUnidade($ano_orcamento, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
        $queryAno = "SELECT * FROM ano_an WHERE an_codano = '".$ano_orcamento."'";
        $ano_orcamento = Ano::findBySql($queryAno)->one();

        $querySituacaoPlanilha = "SELECT * FROM situacaoplanilha_sipla WHERE sipla_codsituacao = '".$situacao_planilha."'";
        $situacao_planilha = Situacaoplanilha::findBySql($querySituacaoPlanilha)->one(); 

        $queryTipoPlanilha = "SELECT * FROM tipoplanilha_tipla WHERE tipla_codtipla = '".$tipo_planilha."'";
        $tipo_planilha = Tipoplanilha::findBySql($queryTipoPlanilha)->one(); 

        $queryTipoRelatorio = "SELECT * FROM tiporelatorio_tiprel WHERE tiprel_id = '".$tipo_relatorio."'";
        $tipo_relatorio = Tiporelatorio::findBySql($queryTipoRelatorio)->one();

            return $this->render('/relatorios/matricula-unidade', [
              'ano_orcamento'      => $ano_orcamento, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionCargahorariaUnidade($ano_orcamento, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
        $queryAno = "SELECT * FROM ano_an WHERE an_codano = '".$ano_orcamento."'";
        $ano_orcamento = Ano::findBySql($queryAno)->one();

        $querySituacaoPlanilha = "SELECT * FROM situacaoplanilha_sipla WHERE sipla_codsituacao = '".$situacao_planilha."'";
        $situacao_planilha = Situacaoplanilha::findBySql($querySituacaoPlanilha)->one(); 

        $queryTipoPlanilha = "SELECT * FROM tipoplanilha_tipla WHERE tipla_codtipla = '".$tipo_planilha."'";
        $tipo_planilha = Tipoplanilha::findBySql($queryTipoPlanilha)->one(); 

        $queryTipoRelatorio = "SELECT * FROM tiporelatorio_tiprel WHERE tiprel_id = '".$tipo_relatorio."'";
        $tipo_relatorio = Tiporelatorio::findBySql($queryTipoRelatorio)->one();

            return $this->render('/relatorios/cargahoraria-unidade', [
              'ano_orcamento'      => $ano_orcamento, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

}