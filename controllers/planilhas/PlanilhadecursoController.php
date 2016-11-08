<?php

namespace app\controllers\planilhas;

use Yii;
use app\models\MultipleModel as Model;
use app\models\planos\Planodeacao;
use app\models\planilhas\Planilhamaterial;
use app\models\planilhas\Planilhadecurso;
use app\models\planilhas\PlanilhadecursoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * PlanilhadecursoController implements the CRUD actions for Planilhadecurso model.
 */
class PlanilhadecursoController extends Controller
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

    //Localiza os Planos qu estão vinculados ao eixo e segmento selecionado pelo usuário
    public function actionPlanos() {
            $out = [];
            if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];

            if ($parents != null) {
                    $cat_id = $parents[0];
                    $subcat_id = $parents[1];
                    $out = Planilhadecurso::getPlanosSubCat($cat_id, $subcat_id);
                    echo Json::encode(['output'=>$out, 'selected'=>'']);
                    return;
                    }
                 }
            echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    //Localiza os dados dos Planos
    public function actionGetPlanoDetalhes($planoId){

        $getPlanoDetalhes = Planodeacao::findOne($planoId);
        echo Json::encode($getPlanoDetalhes);
    }


    /**
     * Lists all Planilhadecurso models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlanilhadecursoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Planilhadecurso model.
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
     * Creates a new Planilhadecurso model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session = Yii::$app->session;
        $model = new Planilhadecurso();
        
        
        $model->placu_codcolaborador = $session['sess_codcolaborador'];
        $model->placu_codunidade     = $session['sess_codunidade'];
        $model->placu_nomeunidade    = $session['sess_unidade'];

        $model->placu_codcategoria = 1; //PSG / Não PSG
        $model->placu_codsituacao  = 1; //Situação Padrão: Em elaboração
        $model->placu_tipocalculo  = 1; //Tipo de Cálculo: Taxa de Retorno ou Valor Curso Por Aluno

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['update', 'id' => $model->placu_codplanilha]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Planilhadecurso model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsPlaniMaterial        = $model->planiMateriais;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

        //--------Materiais Didáticos--------------
        $oldIDsMateriais = ArrayHelper::map($modelsPlaniMaterial, 'id', 'id');
        $modelsPlaniMaterial = Model::createMultiple(Planilhamaterial::classname(), $modelsPlaniMaterial);
        Model::loadMultiple($modelsPlaniMaterial, Yii::$app->request->post());
        $deletedIDsMateriais = array_diff($oldIDsMateriais, array_filter(ArrayHelper::map($modelsPlaniMaterial, 'id', 'id')));

        // validate all models
        $valid = $model->validate();

                        if ($valid) {
                            $transaction = \Yii::$app->db_apl->beginTransaction();
                            try {
                                if ($flag = $model->save(false)) {
                                    if (! empty($deletedIDsMateriais)) {
                                        Planilhamaterial::deleteAll(['id' => $deletedIDsMateriais]);
                                    }
                                    foreach ($modelsPlaniMaterial as $modelPlaniMaterial) {
                                        $modelPlaniMaterial->planilhadecurso_cod = $model->placu_codplanilha;
                                        if (! ($flag = $modelPlaniMaterial->save(false))) {
                                            $transaction->rollBack();
                                            break;
                                        }
                                    }
                                }

                                if ($flag) {
                                    $transaction->commit();
                                    Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Planilha '.$id.' Atualizada !</strong>');
                                    return $this->redirect(['view', 'id' => $model->placu_codplanilha]);
                                }
                            } catch (Exception $e) {
                                $transaction->rollBack();
                            }
                        }

            Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Planilha '.$id.' Atualizada !</strong>');

            return $this->redirect(['view', 'id' => $model->placu_codplanilha]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelsPlaniMaterial'  => (empty($modelsPlaniMaterial)) ? [new Planilhamaterial] : $modelsPlaniMaterial,
            ]);
        }
    }

    /**
     * Deletes an existing Planilhadecurso model.
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
     * Finds the Planilhadecurso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Planilhadecurso the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Planilhadecurso::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
