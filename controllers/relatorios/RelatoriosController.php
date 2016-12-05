<?php

namespace app\controllers\relatorios;

use Yii;
use app\models\cadastros\Ano;
use app\models\cadastros\Tiporelatorio;
use app\models\cadastros\Tipoplanilha;
use app\models\cadastros\Situacaoplanilha;
use app\models\relatorios\Relatorios;
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
    	$model = new Relatorios();

    	$ano              = Ano::find()->orderBy(['an_codano'=>SORT_DESC])->all();
      $tipoPlanilha     = Tipoplanilha::find()->all();
    	$situacaoPlanilha = Situacaoplanilha::find()->all();
      $tipoRelatorio    = Tiporelatorio::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            if($model->relat_tiporelatorio == 1){
                  return $this->redirect(['matricula-unidade', 'ano_planilha' => $model->relat_codano, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 2){
                  return $this->redirect(['cargahoraria-unidade', 'ano_planilha' => $model->relat_codano, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 3){
                  return $this->redirect(['matricula-eixo', 'ano_planilha' => $model->relat_codano, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 4){
                  return $this->redirect(['cargahoraria-eixo', 'ano_planilha' => $model->relat_codano, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 5){
                  return $this->redirect(['matricula-segmento', 'ano_planilha' => $model->relat_codano, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 6){
                  return $this->redirect(['cargahoraria-segmento', 'ano_planilha' => $model->relat_codano, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
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

    public function actionMatriculaUnidade($ano_planilha, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
        $queryAno = "SELECT * FROM ano_an WHERE an_codano = '".$ano_planilha."'";
        $ano_planilha = Ano::findBySql($queryAno)->one();

        $querySituacaoPlanilha = "SELECT * FROM situacaoplanilha_sipla WHERE sipla_codsituacao = '".$situacao_planilha."'";
        $situacao_planilha = Situacaoplanilha::findBySql($querySituacaoPlanilha)->one(); 

        $queryTipoPlanilha = "SELECT * FROM tipoplanilha_tipla WHERE tipla_codtipla = '".$tipo_planilha."'";
        $tipo_planilha = Tipoplanilha::findBySql($queryTipoPlanilha)->one(); 

        $queryTipoRelatorio = "SELECT * FROM tiporelatorio_tiprel WHERE tiprel_id = '".$tipo_relatorio."'";
        $tipo_relatorio = Tiporelatorio::findBySql($queryTipoRelatorio)->one();

            return $this->render('/relatorios/matricula-unidade', [
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionCargahorariaUnidade($ano_planilha, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
        $queryAno = "SELECT * FROM ano_an WHERE an_codano = '".$ano_planilha."'";
        $ano_planilha = Ano::findBySql($queryAno)->one();

        $querySituacaoPlanilha = "SELECT * FROM situacaoplanilha_sipla WHERE sipla_codsituacao = '".$situacao_planilha."'";
        $situacao_planilha = Situacaoplanilha::findBySql($querySituacaoPlanilha)->one(); 

        $queryTipoPlanilha = "SELECT * FROM tipoplanilha_tipla WHERE tipla_codtipla = '".$tipo_planilha."'";
        $tipo_planilha = Tipoplanilha::findBySql($queryTipoPlanilha)->one(); 

        $queryTipoRelatorio = "SELECT * FROM tiporelatorio_tiprel WHERE tiprel_id = '".$tipo_relatorio."'";
        $tipo_relatorio = Tiporelatorio::findBySql($queryTipoRelatorio)->one();

            return $this->render('/relatorios/cargahoraria-unidade', [
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionMatriculaEixo($ano_planilha, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
        $queryAno = "SELECT * FROM ano_an WHERE an_codano = '".$ano_planilha."'";
        $ano_planilha = Ano::findBySql($queryAno)->one();

        $querySituacaoPlanilha = "SELECT * FROM situacaoplanilha_sipla WHERE sipla_codsituacao = '".$situacao_planilha."'";
        $situacao_planilha = Situacaoplanilha::findBySql($querySituacaoPlanilha)->one(); 

        $queryTipoPlanilha = "SELECT * FROM tipoplanilha_tipla WHERE tipla_codtipla = '".$tipo_planilha."'";
        $tipo_planilha = Tipoplanilha::findBySql($queryTipoPlanilha)->one(); 

        $queryTipoRelatorio = "SELECT * FROM tiporelatorio_tiprel WHERE tiprel_id = '".$tipo_relatorio."'";
        $tipo_relatorio = Tiporelatorio::findBySql($queryTipoRelatorio)->one();

            return $this->render('/relatorios/matricula-eixo', [
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionCargahorariaEixo($ano_planilha, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
        $queryAno = "SELECT * FROM ano_an WHERE an_codano = '".$ano_planilha."'";
        $ano_planilha = Ano::findBySql($queryAno)->one();

        $querySituacaoPlanilha = "SELECT * FROM situacaoplanilha_sipla WHERE sipla_codsituacao = '".$situacao_planilha."'";
        $situacao_planilha = Situacaoplanilha::findBySql($querySituacaoPlanilha)->one(); 

        $queryTipoPlanilha = "SELECT * FROM tipoplanilha_tipla WHERE tipla_codtipla = '".$tipo_planilha."'";
        $tipo_planilha = Tipoplanilha::findBySql($queryTipoPlanilha)->one(); 

        $queryTipoRelatorio = "SELECT * FROM tiporelatorio_tiprel WHERE tiprel_id = '".$tipo_relatorio."'";
        $tipo_relatorio = Tiporelatorio::findBySql($queryTipoRelatorio)->one();

            return $this->render('/relatorios/cargahoraria-eixo', [
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionMatriculaSegmento($ano_planilha, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
        $queryAno = "SELECT * FROM ano_an WHERE an_codano = '".$ano_planilha."'";
        $ano_planilha = Ano::findBySql($queryAno)->one();

        $querySituacaoPlanilha = "SELECT * FROM situacaoplanilha_sipla WHERE sipla_codsituacao = '".$situacao_planilha."'";
        $situacao_planilha = Situacaoplanilha::findBySql($querySituacaoPlanilha)->one(); 

        $queryTipoPlanilha = "SELECT * FROM tipoplanilha_tipla WHERE tipla_codtipla = '".$tipo_planilha."'";
        $tipo_planilha = Tipoplanilha::findBySql($queryTipoPlanilha)->one(); 

        $queryTipoRelatorio = "SELECT * FROM tiporelatorio_tiprel WHERE tiprel_id = '".$tipo_relatorio."'";
        $tipo_relatorio = Tiporelatorio::findBySql($queryTipoRelatorio)->one();

            return $this->render('/relatorios/matricula-segmento', [
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionCargahorariaSegmento($ano_planilha, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
        $queryAno = "SELECT * FROM ano_an WHERE an_codano = '".$ano_planilha."'";
        $ano_planilha = Ano::findBySql($queryAno)->one();

        $querySituacaoPlanilha = "SELECT * FROM situacaoplanilha_sipla WHERE sipla_codsituacao = '".$situacao_planilha."'";
        $situacao_planilha = Situacaoplanilha::findBySql($querySituacaoPlanilha)->one(); 

        $queryTipoPlanilha = "SELECT * FROM tipoplanilha_tipla WHERE tipla_codtipla = '".$tipo_planilha."'";
        $tipo_planilha = Tipoplanilha::findBySql($queryTipoPlanilha)->one(); 

        $queryTipoRelatorio = "SELECT * FROM tiporelatorio_tiprel WHERE tiprel_id = '".$tipo_relatorio."'";
        $tipo_relatorio = Tiporelatorio::findBySql($queryTipoRelatorio)->one();

            return $this->render('/relatorios/cargahoraria-segmento', [
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

}