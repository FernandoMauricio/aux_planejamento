<?php

namespace app\controllers\planos;

use Yii;
use app\models\Model;
use app\models\cadastros\Segmento;
use app\models\cadastros\Eixo;
use app\models\cadastros\Estruturafisica;
use app\models\planos\Tipoplanomaterial;
use app\models\planos\PlanoMaterial;
use app\models\planos\PlanoMaterialSearch;
use app\models\planos\Segmentotipoacao;
use app\models\planos\PlanoEstruturafisica;
use app\models\planos\Planodeacao;
use app\models\planos\PlanodeacaoSearch;
use app\models\repositorio\Repositorio;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

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


        public function actionPlanoMaterialIndex()
    {
        $searchPlanoMaterialModel = new PlanoMaterialSearch();
        $dataProviderPlanoMaterial = $searchPlanoMaterialModel->search(Yii::$app->request->queryParams);

        return $this->render('/planos/plano-material/index', [
            'searchModel' => $searchPlanoMaterialModel,
            'dataProviderPlanoMaterial' => $dataProviderPlanoMaterial,
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
        $modelsPlanoMaterial = [new PlanoMaterial];
        $modelsPlanoEstrutura = [new PlanoEstruturafisica];

        $estruturafisica = EstruturaFisica::find()->all();
        $tipoplanomaterial = Tipoplanomaterial::find()->all();
        $repositorio = Repositorio::find()->all();

        // $searchPlanoMaterialModel = new PlanoMaterialSearch();
        // $dataProviderPlanoMaterial = $searchPlanoMaterialModel->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //Inserir vários Materiais Didáticos
            $modelsPlanoMaterial = Model::createMultiple(PlanoMaterial::classname());
            Model::loadMultiple($modelsPlanoMaterial, Yii::$app->request->post());

            //Inserir várias Estruturas Físicas do Plano
            $modelsPlanoEstrutura = Model::createMultiple(PlanoEstruturafisica::classname());
            Model::loadMultiple($modelsPlanoEstrutura, Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsPlanoEstrutura) && $valid;

            $valid2 = $model->validate();
            $valid_planotmaterial = Model::validateMultiple($modelsPlanoMaterial) && $valid2;


            if ($valid && $valid_planotmaterial) {
                $transaction = \Yii::$app->db_apl->beginTransaction();
                $transactionRep = \Yii::$app->db_rep->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsPlanoMaterial as $modelPlanoMaterial) {
                            $modelPlanoMaterial->plama_codplano = $model->plan_codplano;
                            if (! ($flag = $modelPlanoMaterial->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsPlanoEstrutura as $modelPlanoEstrutura) {
                            $modelPlanoEstrutura->planodeacao_cod = $model->plan_codplano;
                            if (! ($flag = $modelPlanoEstrutura->save(false))) {
                                $transactionRep->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        $transactionRep->commit();
                        return $this->redirect(['index']);
                    }
                }  catch (Exception $e) {
                    $transaction->rollBack();
                    $transactionRep->rollBack();
                }
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'estruturafisica' => $estruturafisica,
                'tipoplanomaterial' => $tipoplanomaterial,
                'repositorio' => $repositorio,
                'modelsPlanoMaterial' => (empty($modelsPlanoMaterial)) ? [new PlanoMaterial] : $modelsPlanoMaterial,
                'modelsPlanoEstrutura' => (empty($modelsPlanoEstrutura)) ? [new PlanoEstruturafisica] : $modelsPlanoEstrutura,
                // 'searchModel' => $searchPlanoMaterialModel,
                // 'dataProviderPlanoMaterial' => $dataProviderPlanoMaterial,
            ]);
        }
    }

    //Localiza os segmentos vinculados aos eixos
    public function actionSegmento() {
            $out = [];
            if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];

            if ($parents != null) {
            $cat_id = $parents[0];
            $out = Segmento::getSegmentoSubCat($cat_id);
            echo Json::encode(['output'=>$out, 'selected'=>'']);
            return;
            }
            }
            echo Json::encode(['output'=>'', 'selected'=>'']);
    }



    //Localiza os tipos de ações vinculados aos eixos e segmentos
    public function actionTipos() {
            $out = [];
            if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];

            if ($parents != null) {
                    $cat_id = $parents[0];
                    $out = Segmentotipoacao::getTiposSubCat($cat_id);
                    echo Json::encode(['output'=>$out, 'selected'=>'']);
                    return;
                    }
                 }
            echo Json::encode(['output'=>'', 'selected'=>'']);
    }


    //Localiza os dados de valores e tipos de material cadastrados no repositorio
    public function actionGetRepositorio($repId){

        $getRepositorio = Repositorio::findOne($repId);
        echo Json::encode($getRepositorio);
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
