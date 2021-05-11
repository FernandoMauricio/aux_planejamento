<?php

namespace app\controllers\relatorios;

use Yii;
use app\models\cadastros\Ano;
use app\models\cadastros\Tiporelatorio;
use app\models\cadastros\Tipoprogramacao;
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

    public function behaviors()
    {

        $this->AccessAllow(); //Irá ser verificado se o usuário está logado no sistema

        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionGerarRelatorio()
    {
      $session = Yii::$app->session;
      $model = new RelatoriosPaar();

      $ano              = Ano::find()->orderBy(['an_codano'=>SORT_DESC])->all();
      $tipoProgramacao  = Tipoprogramacao::find()->all();
      $tipoPlanilha     = Tipoplanilha::find()->all();
      $situacaoPlanilha = Situacaoplanilha::find()->all();
      $tipoRelatorio    = Tiporelatorio::find()->orderBy(['tiprel_descricao'=>SORT_ASC])->all();

        if ($model->load(Yii::$app->request->post())) {

            if($model->relat_tiporelatorio == 1){
                  return $this->redirect(['matricula-unidade', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 2){
                  return $this->redirect(['cargahoraria-unidade', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 3){
                  return $this->redirect(['matricula-eixo', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 4){
                  return $this->redirect(['cargahoraria-eixo', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 5){
                  return $this->redirect(['matricula-segmento', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 6){
                  return $this->redirect(['cargahoraria-segmento', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 7){
                  return $this->redirect(['matricula-educacaoprofissional', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 8){
                  return $this->redirect(['cargahoraria-educacaoprofissional', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 9){
                  return $this->redirect(['matricula-acaoextensiva', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 10){
                  return $this->redirect(['cargahoraria-acaoextensiva', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 11){
                  return $this->redirect(['receita-despesa', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 12){
                  return $this->redirect(['receita-segmento-tipo', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 13){
                  return $this->redirect(['listagem-cursos-previstos', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 14){
                  return $this->redirect(['matricula-segmento-tipo', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 15){
                  return $this->redirect(['matricula-psg-segmento', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 16){
                  return $this->redirect(['hora-aluno-segmento', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 17){
                  return $this->redirect(['cargahoraria-aluno', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 18){
                  return $this->redirect(['cargahoraria-aluno-eixo', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 19){
                  return $this->redirect(['cargahoraria-aluno-segmento', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 20){
                  return $this->redirect(['cargahoraria-aluno-educacaoprofissional', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 21){
                  return $this->redirect(['cargahoraria-aluno-acaoextensiva', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }
            else if($model->relat_tiporelatorio == 22){
                  return $this->redirect(['matricula-cargahoraria-aluno-psg', 'ano_orcamento' => $model->relat_codano, 'tipo_programacao' => $model->relat_codprogramacao, 'tipo_planilha'=> $model->relat_codtipla, 'situacao_planilha' => $model->relat_codsituacao, 'tipo_relatorio' => $model->relat_tiporelatorio]);
                }

        }else{
            return $this->render('/relatorios/relatorios-paar/gerar-relatorio', [
                'model'            => $model,
                'ano'              => $ano,
                'tipoProgramacao'  => $tipoProgramacao,
                'tipoPlanilha'     => $tipoPlanilha,
                'situacaoPlanilha' => $situacaoPlanilha,
                'tipoRelatorio'    => $tipoRelatorio,
                ]);
        }
    }

    public function actionMatriculaUnidade($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/matricula-unidade', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionCargahorariaUnidade($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/cargahoraria-unidade', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionMatriculaEixo($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {

       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/matricula-eixo', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionCargahorariaEixo($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/cargahoraria-eixo', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionMatriculaSegmento($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/matricula-segmento', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionCargahorariaSegmento($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/cargahoraria-segmento', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionMatriculaEducacaoprofissional($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/matricula-educacaoprofissional', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionCargahorariaEducacaoprofissional($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/cargahoraria-educacaoprofissional', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionMatriculaAcaoextensiva($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/matricula-acaoextensiva', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionCargahorariaAcaoextensiva($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/cargahoraria-acaoextensiva', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionReceitaDespesa($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/receita-despesa', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionReceitaSegmentoTipo($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/receita-segmento-tipo', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionListagemCursosPrevistos($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/listagem-cursos-previstos', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionListagemCursosPrevistosDetalhes($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio,$codplano)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/listagem-cursos-previstos-detalhes', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionMatriculaSegmentoTipo($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/matricula-segmento-tipo', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionMatriculaPsgSegmento($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/matricula-psg-segmento', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionHoraAlunoSegmento($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/hora-aluno-segmento', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionCargahorariaAluno($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/cargahoraria-aluno', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionCargahorariaAlunoEixo($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/cargahoraria-aluno-eixo', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionCargahorariaAlunoSegmento($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/cargahoraria-aluno-segmento', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionCargahorariaAlunoEducacaoprofissional($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/cargahoraria-aluno-educacaoprofissional', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionCargahorariaAlunoAcaoextensiva($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/cargahoraria-aluno-acaoextensiva', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    public function actionMatriculaCargahorariaAlunoPsg($ano_orcamento, $tipo_programacao, $situacao_planilha, $tipo_planilha, $tipo_relatorio)
    {
       $this->layout = 'main-imprimir';
       $ano_orcamento     = $this->findModelAnoPlanilha($ano_orcamento);
       $tipo_programacao  = $this->findModelTipoProgramacaoPlanilha($tipo_programacao);
       $situacao_planilha = $this->findModelSituacaoPlanilha($situacao_planilha);
       $tipo_planilha     = $this->findModelTipoPlanilha($tipo_planilha);
       $tipo_relatorio    = $this->findModelTipoRelatorio($tipo_relatorio);

            return $this->render('/relatorios/relatorios-paar/matricula-cargahoraria-aluno-psg', [
              'ano_orcamento'     => $ano_orcamento,
              'tipo_programacao'  => $tipo_programacao, 
              'situacao_planilha' => $situacao_planilha,
              'tipo_planilha'     => $tipo_planilha, 
              'tipo_relatorio'    => $tipo_relatorio,
              ]);
    }

    protected function findModelAnoPlanilha($ano_orcamento)
    {
        $queryAno = "SELECT * FROM ano_an WHERE an_codano = '".$ano_orcamento."'";

        if (($ano_orcamento = Ano::findBySql($queryAno)->one()) !== null) {
            return $ano_orcamento;
        } else {
            throw new NotFoundHttpException('A página solicitada não existe.');
        }
    }

    protected function findModelTipoProgramacaoPlanilha($tipo_programacao)
    {
        $queryTipoProgramacaoPlanilha = "SELECT * FROM tipoprogramacao_tipro WHERE tipro_codprogramacao = '".$tipo_programacao."'";

        if (($tipo_programacao = Tipoprogramacao::findBySql($queryTipoProgramacaoPlanilha)->one()) !== null ) {
            return $tipo_programacao;
        } else {
            throw new NotFoundHttpException('A página solicitada não existe.');
        }
    }

    protected function findModelSituacaoPlanilha($situacao_planilha)
    {
        $querySituacaoPlanilha = "SELECT * FROM situacaoplanilha_sipla WHERE sipla_codsituacao = '".$situacao_planilha."'";

        if (($situacao_planilha = Situacaoplanilha::findBySql($querySituacaoPlanilha)->one()) !== null ) {
            return $situacao_planilha;
        } else {
            throw new NotFoundHttpException('A página solicitada não existe.');
        }
    }

    protected function findModelTipoPlanilha($tipo_planilha)
    {
        $queryTipoPlanilha = "SELECT * FROM tipoplanilha_tipla WHERE tipla_codtipla = '".$tipo_planilha."'";

        if (($tipo_planilha = Tipoplanilha::findBySql($queryTipoPlanilha)->one()) !== null ) {
            return $tipo_planilha;
        } else {
            throw new NotFoundHttpException('A página solicitada não existe.');
        }
    }

    protected function findModelTipoRelatorio($tipo_relatorio)
    {
        $queryTipoRelatorio = "SELECT * FROM tiporelatorio_tiprel WHERE tiprel_id = '".$tipo_relatorio."'";

        if (($tipo_relatorio = Tiporelatorio::findBySql($queryTipoRelatorio)->one()) !== null) {
            return $tipo_relatorio;
        } else {
            throw new NotFoundHttpException('A página solicitada não existe.');
        }
    }

    public function AccessAllow()
    {
        $session = Yii::$app->session;
        if (!isset($session['sess_codusuario']) && !isset($session['sess_codcolaborador']) && !isset($session['sess_codunidade']) && !isset($session['sess_nomeusuario']) && !isset($session['sess_coddepartamento']) && !isset($session['sess_codcargo']) && !isset($session['sess_cargo']) && !isset($session['sess_setor']) && !isset($session['sess_unidade']) && !isset($session['sess_responsavelsetor'])) 
        {
           return $this->redirect('https://portalsenac.am.senac.br');
        }
    }
}