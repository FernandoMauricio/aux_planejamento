<?php

namespace app\controllers\despesas;

use Yii;
use app\models\MultipleModel as Model;
use app\models\base\Unidade;
use app\models\despesas\Salas;
use app\models\despesas\Custosindireto;
use app\models\despesas\Custosunidade;
use app\models\despesas\CustosunidadeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustosunidadeController implements the CRUD actions for Custosunidade model.
 */
class CustosunidadeController extends Controller
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
     * Lists all Custosunidade models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustosunidadeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Custosunidade model.
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
     * Creates a new Custosunidade model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Custosunidade();

        $modelsCustosIndireto = [new Custosindireto()];

        $unidades = Unidade::find()->where(['uni_codsituacao'=> 1])->orderBy('uni_nomecompleto')->all();
        $salas    = Salas::find()->where(['sal_status' => 1])->orderBy('sal_descricao')->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //Inserir vários custos indiretos (salas, metragem, cap máxima de alunos)
            $modelsCustosIndireto = Model::createMultiple(Custosindireto::classname());
            Model::loadMultiple($modelsCustosIndireto, Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsCustosIndireto) && $valid;

             if ($valid ) {
                $transaction = \Yii::$app->db_apl->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsCustosIndireto as $modelCustosIndireto) {
                            $modelCustosIndireto->custosunidade_id = $model->cust_codcusto;
                            if (! ($flag = $modelCustosIndireto->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Custo Indireto Cadastrado!</strong>');
                        return $this->redirect(['view', 'id' => $model->cust_codcusto]);
                    }
                }  catch (Exception $e) {
                    $transaction->rollBack();
                }
            }

            Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Custo Indireto Cadastrado!</strong>');

            return $this->redirect(['view', 'id' => $model->cust_codcusto]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'unidades' => $unidades,
                'salas' => $salas,
                'modelsCustosIndireto'   => (empty($modelsCustosIndireto)) ? [new Custosindireto] : $modelsCustosIndireto,
            ]);
        }
    }

    /**
     * Updates an existing Custosunidade model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->cust_codcusto]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Custosunidade model.
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
     * Finds the Custosunidade model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Custosunidade the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Custosunidade::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
