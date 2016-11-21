<?php

namespace app\controllers\modeloa;

use Yii;
use app\models\MultipleModel as Model;
use app\models\modeloa\DetalhesModeloA;
use app\models\modeloa\ModeloA;
use app\models\modeloa\ModeloASearch;
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

        //-------Detalhes Modelo A--------------
        $oldIDsDetalhesModeloA = ArrayHelper::map($modelsDetalhesModeloA, 'id', 'id');
        $modelsDetalhesModeloA = Model::createMultiple(DetalhesModeloA::classname(), $modelsDetalhesModeloA);
        Model::loadMultiple($modelsDetalhesModeloA, Yii::$app->request->post());
        $deletedIDsDetalhesModeloA = array_diff($oldIDsDetalhesModeloA, array_filter(ArrayHelper::map($modelsDetalhesModeloA, 'id', 'id')));


 // validate all models
        $valid = $model->validate();
        $valid = (Model::validateMultiple($modelsDetalhesModeloA)) && $valid;

                        if ($valid) {
                            $transaction = \Yii::$app->db_apl->beginTransaction();
                            try {
                                if ($flag = $model->save(false)) {

                                    if (! empty($deletedIDsDetalhesModeloA)) {
                                        DetalhesModeloA::deleteAll(['id' => $deletedIDsDetalhesModeloA]);
                                    }
                                    foreach ($modelsDetalhesModeloA as $modelsDetalhesModeloA) {
                                        $modelsDetalhesModeloA->deta_codmodelo = $model->moda_codmodelo;
                                        if (! ($flag = $modelsDetalhesModeloA->save(false))) {
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

            Yii::$app->session->setFlash('info', '<strong>SUCESSO! </strong> Modelo A '.$id.' Atualizado!</strong>');

            return $this->redirect(['update', 'id' => $model->moda_codmodelo]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelsDetalhesModeloA' => (empty($modelsDetalhesModeloA)) ? [new DetalhesModeloA] : $modelsDetalhesModeloA,
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
