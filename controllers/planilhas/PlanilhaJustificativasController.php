<?php

namespace app\controllers\planilhas;

use Yii;
use app\models\planilhas\Planilhadecurso;
use app\models\planilhas\PlanilhaJustificativas;
use app\models\planilhas\PlanilhaJustificativasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlanilhaJustificativasController implements the CRUD actions for PlanilhaJustificativas model.
 */
class PlanilhaJustificativasController extends Controller
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
     * Lists all PlanilhaJustificativas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlanilhaJustificativasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionObservacoes()
    {
        $searchModel = new PlanilhaJustificativasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('observacoes', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionObservacoesGerentes()
    {
        $searchModel = new PlanilhaJustificativasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('observacoes-gerentes', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single PlanilhaJustificativas model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PlanilhaJustificativas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session = Yii::$app->session;

        $model = new PlanilhaJustificativas();

        $model->planilhadecurso_id = $session['sess_planilhadecurso'];
        $model->planijust_usuario = $session['sess_nomeusuario'];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $connection = Yii::$app->db;
            $command = $connection->createCommand(
            "UPDATE `db_apl`.`planilhadecurso_placu` SET `placu_codsituacao` = 2 WHERE `placu_codplanilha` = '".$model->planilhadecurso_id."'");
            $command->execute();

            Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Justificativa para Correção da Planilha '.$model->planilhadecurso_id.' enviada!</strong>');

            return $this->redirect(['/planilhas/planilhadecurso-admin/index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Updates an existing PlanilhaJustificativas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PlanilhaJustificativas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PlanilhaJustificativas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PlanilhaJustificativas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PlanilhaJustificativas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
