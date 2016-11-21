<?php

namespace app\controllers\planilhas;

use Yii;
use app\models\base\Unidade;
use app\models\cadastros\Tipoprogramacao;
use app\models\planilhas\Planilhadecurso;
use app\models\planilhas\PlanilhaJustificativas;
use app\models\planilhas\PlanilhadecursoAdmin;
use app\models\planilhas\PlanilhadecursoAdminSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlanilhadecursoAdminController implements the CRUD actions for PlanilhadecursoAdmin model.
 */
class PlanilhadecursoAdminController extends Controller
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
     * Lists all PlanilhadecursoAdmin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'main-planilhadecurso';
        $searchModel = new PlanilhadecursoAdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PlanilhadecursoAdmin model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $modelsPlaniDespDocente = $model->planiDespDocente;
        $modelsPlaniUC          = $model->planiUC;
        $modelsPlaniMaterial    = $model->planiMateriais;
        $modelsPlaniConsumo     = $model->planiConsumo;
        $modelsPlaniEquipamento = $model->planiEquipamento;

        return $this->render('/planilhas/planilhadecurso/view-admin', [
            'model' => $this->findModel($id),
            'modelsPlaniDespDocente' => $modelsPlaniDespDocente,
            'modelsPlaniUC'          => $modelsPlaniUC,
            'modelsPlaniMaterial'    => $modelsPlaniMaterial,
            'modelsPlaniConsumo'     => $modelsPlaniConsumo,
            'modelsPlaniEquipamento' => $modelsPlaniEquipamento,
        ]);
    }

    //Homologa todo o Planejamento da unidade selecionada para o MODELO A
    public function actionHomologarPlanejamento() 
    {
        $model = new PlanilhadecursoAdmin();

        $unidades = Unidade::find()->where(['uni_codsituacao' => 1])->orderBy('uni_nomeabreviado')->all();
        $tipoProgramacao = Tipoprogramacao::find()->all();

     if ($model->load(Yii::$app->request->post())) {

        //Realiza a Contagem das Planilhas da unidade que estão definidas como como PRODUÇÃO(1), PROGRAMAÇÃO ANUAL(1) e EM ANÁLISE PELO GPO - SITUAÇÃO COD 3
        $countPlanilhas = 0;
        $countPlanilhas = Planilhadecurso::find()->where(['placu_codtipla' => 1, 'placu_codsituacao' => 3,  'placu_codprogramacao' => $model->placu_codprogramacao,  'placu_codunidade' =>  $model->placu_codunidade])->count();

            //Altera a situação de todas as planilhas da unidade selecionada
        if($countPlanilhas != 0){
                Yii::$app->db_apl->createCommand()
                    ->update('planilhadecurso_placu', [
                             'placu_codsituacao' => 4, //Homologado pelo GPO
                             ], [//------WHERE
                             'placu_codtipla' => 1,  //PRODUÇÃO(1)
                             'placu_codsituacao' => 3, //EM ANÁLISE PELO GPO
                             'placu_codprogramacao' => $model->placu_codprogramacao, // PROGRAMAÇÃO ANUAL
                             'placu_codunidade' => $model->placu_codunidade, // Unidade selecionada
                             ]) 
                    ->execute();
        Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Total de '.$countPlanilhas.' planilhas do tipo <strong>'.$model->tipoprogramacao->tipro_descricao.'</strong> da unidade <strong>'.$model->unidade->uni_nomeabreviado.'</strong> Homologadas pelo GPO!</strong>');
        }else{
            Yii::$app->session->setFlash('warning', '<strong>AVISO! </strong> Não existem planilhas da unidade <strong>'.$model->unidade->uni_nomeabreviado.'</strong> do tipo <strong>'.$model->tipoprogramacao->tipro_descricao.'</strong> com a situação: <strong>"Em análise pela GPO"</strong> para serem Homologadas!</strong>');
        }

        return $this->redirect(['/planilhas/planilhadecurso-admin/index']);

        }else{
            return $this->renderAjax('homologar-planejamento', [
                'model' => $model,
                'unidades'=> $unidades,
                'tipoProgramacao' => $tipoProgramacao,
            ]);
        }

    }

    /**
     * Creates a new PlanilhadecursoAdmin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PlanilhadecursoAdmin();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->placu_codplanilha]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCorrecao($id) 
    {
        $model = Planilhadecurso::findOne($id);
        $session = Yii::$app->session;
        $session->set('sess_planilhadecurso', $model->placu_codplanilha);

        return $this->redirect(['planilhas/planilha-justificativas/index'], [
             'model' => $model,
         ]);
    }

    /**
     * Updates an existing PlanilhadecursoAdmin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->placu_codplanilha]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PlanilhadecursoAdmin model.
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
     * Finds the PlanilhadecursoAdmin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PlanilhadecursoAdmin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PlanilhadecursoAdmin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
