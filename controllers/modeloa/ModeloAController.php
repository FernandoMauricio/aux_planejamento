<?php

namespace app\controllers\modeloa;

use Yii;
use app\models\MultipleModel as Model;
use app\models\cadastros\Centrocusto;
use app\models\cadastros\Ano;
use app\models\cadastros\Tipoprogramacao;
use app\models\modeloa\DetalhesModeloA;
use app\models\modeloa\ModeloA;
use app\models\modeloa\ModeloASearch;
use app\models\modeloa\SituacaoModeloA;
use app\models\modeloa\OrcamentoPrograma;
use app\models\planilhas\Planilhadecurso;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ModeloAController implements the CRUD actions for ModeloA model.
 */
class ModeloAController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ModeloA models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ModeloASearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ModeloA model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionGerarModeloA()
    {
        $session = Yii::$app->session;

        //$session['sess_codunidade']
        //$session['sess_unidade']
        //$session['sess_codcolaborador']
        //$session['sess_nomeusuario']

        $model = new ModeloA();

        //$unidades = Unidade::find()->where(['uni_codsituacao' => 1])->orderBy('uni_nomeabreviado')->all();
        $ano = Ano::find()->where(['an_status'=> 1])->orderBy(['an_codano'=>SORT_DESC])->all();
        $tipoProgramacao = Tipoprogramacao::find()->all();

        if ($model->load(Yii::$app->request->post())) {

        $centrocustos = Centrocusto::find()->where(['cen_codano' => $model->anoModeloA->an_ano, 'cen_codunidade' =>$session['sess_codunidade']])->all();

        foreach ($centrocustos as $centrocusto) {

           $cen_codcentrocusto      = $centrocusto['cen_codcentrocusto'];
           $cen_centrocusto         = $centrocusto['cen_centrocusto'];
           $cen_nomecentrocusto     = $centrocusto['cen_nomecentrocusto'];
           $cen_centrocustoreduzido = $centrocusto['cen_centrocustoreduzido'];
           $cen_codsegmento         = $centrocusto['cen_codsegmento'];
           $cen_codtipoacao         = $centrocusto['cen_codtipoacao'];
          
           //CRIANDO O MODELO A....
           $identificador_modeloa = $session['sess_codusuario']."-".$cen_codcentrocusto;

                //Inclui as informações do Centro de Custos para o Modelo A
                Yii::$app->db_apl->createCommand()
                    ->insert('modeloa_moda', [
                             'moda_codano'              => $model->anoModeloA->an_codano,
                             'moda_centrocusto'         => $cen_centrocusto,
                             'moda_centrocustoreduzido' => $cen_centrocustoreduzido,
                             'moda_nomecentrocusto'     => $cen_nomecentrocusto,
                             'moda_codunidade'          => $sess_codunidade,
                             'moda_nomeunidade'         => $sess_unidade,
                             'moda_codcolaborador'      => $sess_codcolaborador,
                             'moda_codusuario'          => $sess_codusuario,
                             'moda_nomeusuario'         => $sess_nomeusuario,
                             'moda_codsituacao'         => 1,
                             'moda_codentrada'          => 1,
                             'moda_codsegmento'         => $cen_codsegmento,
                             'moda_codtipoacao'         => $cen_codtipoacao,
                             'moda_identificacao'       => $identificador_modeloa,
                             ])
                    ->execute();
        }//FIM INSERÇÃO MODELOA A

        //EXTRAINDO TODOS OS ORCAMENTOS PROGRAMAS EXISTENTES PARA COMPOR OS DETALHES DO MODELO A...
        $orcamentoProgramas = OrcamentoPrograma::find()->all();

        foreach ($orcamentoProgramas as $orcamentoPrograma) {

            $orcpro_codigo        = $orcamentoPrograma['orcpro_codigo'];
            $orcpro_titulo        = $orcamentoPrograma['orcpro_titulo'];
            $orcpro_identificacao = $orcamentoPrograma['orcpro_identificacao'];
            $orcpro_codtipo       = $orcamentoPrograma['orcpro_codtipo'];

            $valor_programado = 0;

              //IDENTIFICANDO O TIPO DE TITULO PARA BUSCAR VALORES NAS PLANILHAS...
              if($orcpro_identificacao == 111 || $orcpro_identificacao == 113 || $orcpro_identificacao == 116 || $orcpro_identificacao == 414 || $orcpro_identificacao == 430 || $orcpro_identificacao == 433 || $orcpro_identificacao == 439) {

                //Localiza as Planilhas de Cursos onde contêm os centros de Custos cadastrados // Parâmetros -> situação 4 - (Homologada) e Tipo de Planilha (Produção)
                $planilhaDeCursos = Planilhadecurso::find()->where(['placu_codunidade' => $session['sess_codunidade'], 'placu_codano' => $model->anoModeloA->an_codano, 'placu_codsegmento' => $cen_codsegmento, 'placu_codtipoa' => $cen_codtipoacao, 'placu_codsituacao' => 4, 'placu_codtipla' => 1])->all();

                foreach ($planilhaDeCursos as $planilhaDeCurso) {

                    $placu_codplanilha             = $planilhaDeCurso['placu_codplanilha'];
                    $placu_quantidadeturmas        = $planilhaDeCurso['placu_quantidadeturmas'];

                    $placu_quantidadealunos        = $planilhaDeCurso['placu_quantidadealunos'];
                    $placu_quantidadealunospsg     = $planilhaDeCurso['placu_quantidadealunospsg'];
                    $placu_quantidadealunosisentos = $planilhaDeCurso['placu_quantidadealunosisentos'];

                    $placu_cargahorariaarealizar   = $planilhaDeCurso['placu_cargahorariaarealizar'];

                    $placu_diarias                 = $planilhaDeCurso['placu_diarias'];
  
                    $placu_custosmateriais         = $planilhaDeCurso['placu_custosmateriais'];
                    $placu_PJApostila              = $planilhaDeCurso['placu_PJApostila'];
                    $placu_custosconsumo           = $planilhaDeCurso['placu_custosconsumo'];
                    //$placu_custosaluno          = $planilhaDeCurso['placu_custosaluno']; //----Verificar se entrará no cálculo

                    if($orcpro_identificacao == 414) { //DIARIAS ----->DIÁRIAS - PESSOAL CIVIL

                       $valor_programado += $placu_diarias * $placu_quantidadeturmas; //Valor das diárias das planilhas * Quantidade de Turmas

                    }
                    else if($orcpro_identificacao == 430) { //MATERIAL DE CONSUMO, MATERIAL DIDÁTICO E (MATERIAL DO ALUNO->Verificar se entra no cálculo) - TOTAL ----->MATERIAL DE CONSUMO

                    $valor_programado += ($placu_custosmateriais * $placu_quantidadeturmas) + ($placu_PJApostila * $placu_quantidadeturmas) + ($placu_custosconsumo * $placu_quantidadeturmas);

                    }

                    else if($orcpro_identificacao == 433) { //PASSAGENS URBANAS E INTERURBANAS ----->PASSAGENS E DESPESA COM LOCOMOÇÃO

                    }

                    else if($orcpro_identificacao == 439) { //SEGURO DOS ALUNOS ----->OUTROS SERVIÇOS TERC. PESSOA JURÍDICA

                    }

                    else if($orcpro_identificacao == 113) { //VALOR COM ENCARGOS ----->OBRIGAÇÕES PATRONAIS

                    }

                    else if($orcpro_identificacao == 111) { //VALOR COM HORAS AULAS SEM ENCARGOS ----->VENC. E VANTAGENS FIXAS - PESSOAL CIVIL

                    }

                    else if($orcpro_identificacao == 116) { //VALOR PRODUTIVIDADE 45% ----->OUTRAS DESP. VARIÁVEIS - PESSOAL CIVIL

                    }


                }
              }
            }


        Yii::$app->session->setFlash('success','<strong>Sucesso!</strong> Modelo A gerado!');

        return $this->redirect(['index']);

        }else{
            return $this->renderAjax('gerar-modelo-a', [
                'model' => $model,
                'ano' => $ano,
                'tipoProgramacao' => $tipoProgramacao,
            ]);
        }
    }
    /**
     * Creates a new ModeloA model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ModeloA();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->moda_codmodelo]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ModeloA model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsDetalhesModeloA  = $model->detalhesModeloA;

        $situacaoModeloA = SituacaoModeloA::find()->all();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {

        //-------Detalhes Modelo A--------------
        $oldIDsDetalhesModeloA = ArrayHelper::map($modelsDetalhesModeloA, 'id', 'id');
        $modelsDetalhesModeloA = Model::createMultiple(DetalhesModeloA::classname(), $modelsDetalhesModeloA);
        Model::loadMultiple($modelsDetalhesModeloA, Yii::$app->request->post());
        $deletedIDsDetalhesModeloA = array_diff($oldIDsDetalhesModeloA, array_filter(ArrayHelper::map($modelsDetalhesModeloA, 'id', 'id')));

        // validate all models
        $valid = $model->validate();
        //$valid = ( Model::validateMultiple($modelsDetalhesModeloA) ) && $valid;

                        if ($valid) {
                            $transaction = \Yii::$app->db_apl->beginTransaction();
                            try {
                                if ($flag = $model->save(false)) {

                                    if (! empty($deletedIDsDetalhesModeloA)) {
                                        DetalhesModeloA::deleteAll(['id' => $deletedIDsDetalhesModeloA]);
                                    }
                                    foreach ($modelsDetalhesModeloA as $modelDetalhesModeloA) {
                                        $modelDetalhesModeloA->deta_codmodelo   = $model->moda_codmodelo;//--Cod. modelo
                                        $modelDetalhesModeloA->deta_codsegmento = $model->moda_codsegmento;//--Cod. Segmento
                                        $modelDetalhesModeloA->deta_codtipoa    = $model->moda_codtipoacao;//--Cod.Tipo de ação
                                        if (! ($flag = $modelDetalhesModeloA->save(false))) {
                                            $transaction->rollBack();
                                            break;
                                        }
                                    }
                                }

                                if ($flag) {
                                    $transaction->commit();

                                    Yii::$app->session->setFlash('info', '<strong>SUCESSO! </strong> Modelo A '.$id.' Atualizado!</strong>');

                                    return $this->redirect(['update', 'id' => $model->moda_codmodelo]);
                                }
                            } catch (Exception $e) {
                                $transaction->rollBack();
                            }
                        }
                        $model->save();

            Yii::$app->session->setFlash('info', '<strong>SUCESSO! </strong> Modelo A '.$id.' Atualizado!</strong>');

            return $this->redirect(['update', 'id' => $model->moda_codmodelo]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelsDetalhesModeloA' => (empty($modelsDetalhesModeloA)) ? [new DetalhesModeloA] : $modelsDetalhesModeloA,
                'situacaoModeloA' => $situacaoModeloA,
            ]);
        }
    }

    /**
     * Deletes an existing ModeloA model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ModeloA model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ModeloA the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ModeloA::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
