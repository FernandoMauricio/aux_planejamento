<?php

namespace app\controllers\cadastros;

use Yii;
use app\models\cadastros\Materialaluno;
use app\models\cadastros\TipoUnidade;
use app\models\cadastros\MaterialalunoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MaterialalunoController implements the CRUD actions for Materialaluno model.
 */
class MaterialalunoController extends Controller
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
     * Lists all Materialaluno models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MaterialalunoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Materialaluno model.
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
     * Creates a new Materialaluno model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Materialaluno();

        $tipounidade = TipoUnidade::find()->orderBy('tipuni_descricao')->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Material do aluno cadastrado!</strong>');

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'tipounidade' => $tipounidade,
            ]);
        }
    }

    /**
     * Updates an existing Materialaluno model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $tipounidade = TipoUnidade::find()->orderBy('tipuni_descricao')->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Material do aluno atualizado!</strong>');

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'tipounidade' => $tipounidade,
            ]);
        }
    }

    /**
     * Deletes an existing Materialaluno model.
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
     * Finds the Materialaluno model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Materialaluno the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Materialaluno::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
