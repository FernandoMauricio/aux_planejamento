<?php

namespace app\controllers\planilhas;

use Yii;
use app\models\planilhas\PlanilhadecursoHomologadas;
use app\models\planilhas\PlanilhadecursoHomologadasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlanilhadecursoHomologadasController implements the CRUD actions for PlanilhadecursoHomologadas model.
 */
class PlanilhadecursoHomologadasController extends Controller
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
     * Lists all PlanilhadecursoHomologadas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'main-planilhadecurso';
        $searchModel = new PlanilhadecursoHomologadasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PlanilhadecursoHomologadas model.
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

    /**
     * Creates a new PlanilhadecursoHomologadas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PlanilhadecursoHomologadas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->placu_codplanilha]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PlanilhadecursoHomologadas model.
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
     * Deletes an existing PlanilhadecursoHomologadas model.
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
     * Finds the PlanilhadecursoHomologadas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PlanilhadecursoHomologadas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PlanilhadecursoHomologadas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
