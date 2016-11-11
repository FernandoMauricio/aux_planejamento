<?php

namespace app\controllers\planilhas;

use Yii;
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
