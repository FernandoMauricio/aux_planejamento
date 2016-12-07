<?php

namespace app\controllers\relatorios;

use Yii;
use app\models\cadastros\Ano;
use app\models\cadastros\Tiporelatorio;
use app\models\cadastros\Tipoplanilha;
use app\models\cadastros\Situacaoplanilha;
use app\models\relatorios\RelatoriosPaar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;


class RelatoriosPaarController extends Controller
{

    public function actionGerarRelatorio()
    {
      $session = Yii::$app->session;
    	$model = new RelatoriosPaar();

    	$ano              = Ano::find()->orderBy(['an_codano'=>SORT_DESC])->all();
      $tipoPlanilha     = Tipoplanilha::find()->all();
    	$situacaoPlanilha = Situacaoplanilha::find()->all();
      $tipoRelatorio    = Tiporelatorio::find()->all();
      //$tipoRelatorio    = Tiporelatorio::find()->orderBy(['tiprel_descricao'=>SORT_ASC])->all();

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
            else if($model->relat_tiporelatorio == 7){
                  return $this->redirect(['matricula-educacaoprofissional', 'ano_planilha' => $model->relat_codano, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 8){
                  return $this->redirect(['cargahoraria-educacaoprofissional', 'ano_planilha' => $model->relat_codano, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 9){
                  return $this->redirect(['matricula-acaoextensiva', 'ano_planilha' => $model->relat_codano, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 10){
                  return $this->redirect(['cargahoraria-acaoextensiva', 'ano_planilha' => $model->relat_codano, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 11){
                  return $this->redirect(['receita-despesa', 'ano_planilha' => $model->relat_codano, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 12){
                  return $this->redirect(['receita-segmento-tipo', 'ano_planilha' => $model->relat_codano, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }

        }else{
            return $this->render('/relatorios/relatorios-paar/gerar-relatorio', [
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
       $this->layout = 'main-imprimir';
       $ano_planilha      = $this->findModelAnoPlanilha($ano_planilha);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/matricula-unidade', [
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionCargahorariaUnidade($ano_planilha, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_planilha      = $this->findModelAnoPlanilha($ano_planilha);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/cargahoraria-unidade', [
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionMatriculaEixo($ano_planilha, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {

       $this->layout = 'main-imprimir';
       $ano_planilha      = $this->findModelAnoPlanilha($ano_planilha);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/matricula-eixo', [
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionCargahorariaEixo($ano_planilha, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_planilha      = $this->findModelAnoPlanilha($ano_planilha);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/cargahoraria-eixo', [
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionMatriculaSegmento($ano_planilha, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_planilha      = $this->findModelAnoPlanilha($ano_planilha);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/matricula-segmento', [
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionCargahorariaSegmento($ano_planilha, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_planilha      = $this->findModelAnoPlanilha($ano_planilha);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/cargahoraria-segmento', [
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionMatriculaEducacaoprofissional($ano_planilha, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_planilha      = $this->findModelAnoPlanilha($ano_planilha);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/matricula-educacaoprofissional', [
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionCargahorariaEducacaoprofissional($ano_planilha, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_planilha      = $this->findModelAnoPlanilha($ano_planilha);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/cargahoraria-educacaoprofissional', [
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionMatriculaAcaoextensiva($ano_planilha, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_planilha      = $this->findModelAnoPlanilha($ano_planilha);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/matricula-acaoextensiva', [
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionCargahorariaAcaoextensiva($ano_planilha, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_planilha      = $this->findModelAnoPlanilha($ano_planilha);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/cargahoraria-acaoextensiva', [
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionReceitaDespesa($ano_planilha, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_planilha      = $this->findModelAnoPlanilha($ano_planilha);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/receita-despesa', [
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionReceitaSegmentoTipo($ano_planilha, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_planilha      = $this->findModelAnoPlanilha($ano_planilha);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/receita-segmento-tipo', [
              'ano_planilha'      => $ano_planilha, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
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

    protected function findModelTipoRelatorio($tipo_relatorio)
    {
        $queryTipoRelatorio = "SELECT * FROM tiporelatorio_tiprel WHERE tiprel_id = '".$tipo_relatorio."'";

        if (($tipo_relatorio = Tiporelatorio::findBySql($queryTipoRelatorio)->one()) !== null) {
            return $tipo_relatorio;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}