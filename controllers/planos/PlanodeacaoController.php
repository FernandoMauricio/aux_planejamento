<?php

namespace app\controllers\planos;

use Yii;
use app\models\Model;
use app\models\cadastros\Segmento;
use app\models\cadastros\Eixo;
use app\models\cadastros\Materialaluno;
use app\models\cadastros\Materialconsumo;
use app\models\cadastros\Estruturafisica;
use app\models\planos\PlanoMaterial;
use app\models\planos\PlanoAluno;
use app\models\planos\PlanoConsumo;
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
        $session = Yii::$app->session;
        $model = new Planodeacao();
        $modelsPlanoMaterial  = [new PlanoMaterial];
        $modelsPlanoEstrutura = [new PlanoEstruturafisica];
        $modelsPlanoConsumo   = [new PlanoConsumo];
        $modelsPlanoAluno     = [new PlanoAluno];

        $estruturafisica   = EstruturaFisica::find()->all();
        $repositorio       = Repositorio::find()->all();
        $materialconsumo   = Materialconsumo::find()->orderBy('matcon_descricao')->all();
        $materialaluno     = Materialaluno::find()->orderBy('matalu_descricao')->all();

        $model->plan_data           = date('Y-m-d');
        $model->plan_codcolaborador = $session['sess_codcolaborador'];

        // $searchPlanoMaterialModel = new PlanoMaterialSearch();
        // $dataProviderPlanoMaterial = $searchPlanoMaterialModel->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //Inserir vários Materiais Didáticos
            $modelsPlanoMaterial = Model::createMultiple(PlanoMaterial::classname());
            Model::loadMultiple($modelsPlanoMaterial, Yii::$app->request->post());

            //Inserir várias Estruturas Físicas do Plano
            $modelsPlanoEstrutura = Model::createMultiple(PlanoEstruturafisica::classname());
            Model::loadMultiple($modelsPlanoEstrutura, Yii::$app->request->post());

            //Inserir vários materiais de consumo do plano
            $modelsPlanoConsumo = Model::createMultiple(PlanoConsumo::classname());
            Model::loadMultiple($modelsPlanoConsumo, Yii::$app->request->post());

            //Inserir vários materiais do aluno do plano
            $modelsPlanoAluno = Model::createMultiple(PlanoAluno::classname());
            Model::loadMultiple($modelsPlanoAluno, Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsPlanoEstrutura) && $valid;

            $valid2 = $model->validate();
            $valid_planotmaterial = Model::validateMultiple($modelsPlanoMaterial) && $valid2;

            $valid3 = $model->validate();
            $valid_planoconsumo = Model::validateMultiple($modelsPlanoConsumo) && $valid2 && $valid3;

            $valid4 = $model->validate();
            $valid_planoaluno = Model::validateMultiple($modelsPlanoAluno) && $valid2 && $valid3;


            if ($valid && $valid_planotmaterial && $valid_planoconsumo && $valid_planoaluno) {
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

                        foreach ($modelsPlanoConsumo as $modelPlanoConsumo) {
                            $modelPlanoConsumo->planodeacao_cod = $model->plan_codplano;
                            if (! ($flag = $modelPlanoConsumo->save(false))) {
                                $transactionRep->rollBack();
                                break;
                            }
                        }

                        foreach ($modelsPlanoAluno as $modelPlanoAluno) {
                            $modelPlanoAluno->planodeacao_cod = $model->plan_codplano;
                            if (! ($flag = $modelPlanoAluno->save(false))) {
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
                'model'                 => $model,
                'estruturafisica'       => $estruturafisica,
                'repositorio'           => $repositorio,
                'materialconsumo'       => $materialconsumo,
                'materialaluno'         => $materialaluno,
                'modelsPlanoMaterial'   => (empty($modelsPlanoMaterial)) ? [new PlanoMaterial] : $modelsPlanoMaterial,
                'modelsPlanoEstrutura'  => (empty($modelsPlanoEstrutura)) ? [new PlanoEstruturafisica] : $modelsPlanoEstrutura,
                'modelsPlanoConsumo'    => (empty($modelsPlanoConsumo)) ? [new PlanoConsumo] : $modelsPlanoConsumo,
                'modelsPlanoAluno'      => (empty($modelsPlanoAluno)) ? [new PlanoAluno] : $modelsPlanoAluno,
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


    //Localiza os dados de valores e tipos de material cadastrados no repositorio
    public function actionGetPlanoConsumo($matconId){

        $getPlanoConsumo = Materialconsumo::findOne($matconId);
        echo Json::encode($getPlanoConsumo);
    }


    //Localiza os dados de valores e tipos de material cadastrados no repositorio
    public function actionGetPlanoAluno($mataluId){

        $getPlanoAluno = Materialaluno::findOne($mataluId);
        echo Json::encode($getPlanoAluno);
    }


    //Localiza os dados cadastrados
    public function actionGetPlanoEstruturaFisica($estrfisicID){

        $getPlanoEstruturaFisica = EstruturaFisica::findOne($estrfisicID);
        echo Json::encode($getPlanoEstruturaFisica);
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
