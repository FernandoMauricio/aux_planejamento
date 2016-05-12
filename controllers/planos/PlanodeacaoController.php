<?php

namespace app\controllers\planos;

use Yii;
use app\models\Model;
use app\models\cadastros\Estruturafisica;
use app\models\planos\PlanoEstruturafisica;
use app\models\planos\Planodeacao;
use app\models\planos\PlanodeacaoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlanodeacaoController implements the CRUD actions for Planodeacao model.
 */
class PlanodeacaoController extends Controller
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
     * Lists all Planodeacao models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlanodeacaoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Planodeacao model.
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
     * Creates a new Planodeacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Planodeacao();
        $modelsPlanoEstrutura = [new PlanoEstruturafisica];

        $estruturafisica = EstruturaFisica::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            $modelsPlanoEstrutura = Model::createMultiple(PlanoEstruturafisica::classname());
            Model::loadMultiple($modelsPlanoEstrutura, Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsPlanoEstrutura) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db_apl->beginTransaction();

                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsPlanoEstrutura as $modelPlanoEstrutura) {
                            $modelPlanoEstrutura->planodeacao_cod = $model->plan_codplano;
                            if (! ($flag = $modelPlanoEstrutura->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->plan_codplano]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            return $this->redirect(['view', 'id' => $model->plan_codplano]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'estruturafisica' => $estruturafisica,
                'modelsPlanoEstrutura' => (empty($modelsPlanoEstrutura)) ? [new PlanoEstruturafisica] : $modelsPlanoEstrutura,
            ]);
        }
    }

    /**
     * Updates an existing Planodeacao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->plan_codplano]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Planodeacao model.
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
     * Finds the Planodeacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Planodeacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Planodeacao::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
