<?php

namespace app\controllers\despesas;

use Yii;
use yii\base\Model;
use app\models\despesas\Markup;
use app\models\despesas\MarkupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MarkupController implements the CRUD actions for Markup model.
 */
class MarkupController extends Controller
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
     * Lists all Markup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MarkupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Markup model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionBatchUpdate()
    {
        $sourceModel = new MarkupSearch();
        $dataProvider = $sourceModel->search(Yii::$app->request->getQueryParams());
        $models = $dataProvider->getModels();

        //Realiza a Verificação se as configurações estão atualizadas do Markup
        foreach ($models as $model) {
                    if($model->mark_ano != date('Y')){
                         Yii::$app->session->setFlash('danger', "As Configurações de Markup estão configuradas para o ano de <strong>" .$model->mark_ano. "</strong>. Por gentileza, atualize as informações para o ano corrente(" .date('Y').") clicando em <strong>Salvar Dados</strong>!" );
                    }else{
                        Yii::$app->session->removeFlash('danger',null);
                    }
        }

        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
            $count = 0;
            foreach ($models as $index => $model) {
                // populate and save records for each model
                $model->mark_ano = date('Y');
                $model->mark_totalincidencias = $model->mark_custoindireto + $model->mark_ipca + $model->mark_reservatecnica + $model->mark_despesasede;
                $model->mark_divisor = (100 - $model->mark_totalincidencias);

                if ($model->save()) {
                    $count++;
                }
            }
            // Yii::$app->session->setFlash('success', "Processed {$count} records successfully.");
            Yii::$app->session->setFlash('success', "Configurações Atualizadas!");
            return $this->redirect(['batch-update']); // redirect to your next desired page
        } else {
            return $this->render('update', [
                'model'=>$sourceModel,
                'dataProvider'=>$dataProvider
            ]);
        }
    }

    /**
     * Creates a new Markup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Markup();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->mark_id]);
        } else {      

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Markup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->mark_id]);
        } else {
            //var_dump($model->getErrors());
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Markup model.
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
     * Finds the Markup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Markup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Markup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
