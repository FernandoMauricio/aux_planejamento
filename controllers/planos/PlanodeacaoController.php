<?php

namespace app\controllers\planos;

use Yii;
use app\models\MultipleModel as Model;
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
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use mPDF;

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

    public function actionImprimir($id) {

            $model = $this->findModel($id);

            $pdf = new Pdf([
                'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
                'format' => Pdf::FORMAT_A4,
                'content' => $this->renderPartial('imprimir', ['model' => $model]),
                'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
                'cssInline'=> '.kv-heading-1{font-size:18px}',
                'options' => [
                    'title' => 'Divisão de Educação Profissional - DEP',
                ],
                'methods' => [
                    'SetHeader' => ['DETALHES DO PLANO - SENAC AM||Gerado em: ' . date("d/m/Y - H:i:s")],
                    'SetFooter' => ['Divisão de Educação Profissional - DEP||Página {PAGENO}'],
                ]
            ]);

        return $pdf->render('imprimir', [
            'model' => $model,

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
        $modelsPlanoConsumo   = [new PlanoConsumo];
        $modelsPlanoAluno     = [new PlanoAluno];
        $modelsPlanoEstrutura = [new PlanoEstruturafisica];

        $repositorio       = Repositorio::find()->where(['rep_status' => 1])->orderBy('rep_titulo')->all();
        $materialconsumo   = Materialconsumo::find()->where(['matcon_status' => 1])->orderBy('matcon_descricao')->all();
        $materialaluno     = Materialaluno::find()->where(['matalu_status' => 1])->orderBy('matalu_descricao')->all();
        $estruturafisica   = EstruturaFisica::find()->where(['estr_status' => 1])->orderBy('estr_descricao')->all();

        $model->plan_data           = date('Y-m-d');
        $model->plan_codcolaborador = $session['sess_codcolaborador'];

        if ($model->load(Yii::$app->request->post())) {

            //Inserir vários Materiais Didáticos
            $modelsPlanoMaterial = Model::createMultiple(PlanoMaterial::classname());
            Model::loadMultiple($modelsPlanoMaterial, Yii::$app->request->post());

            //Inserir vários materiais de consumo do plano
            $modelsPlanoConsumo = Model::createMultiple(PlanoConsumo::classname());
            Model::loadMultiple($modelsPlanoConsumo, Yii::$app->request->post());

            //Inserir vários materiais do aluno do plano
            $modelsPlanoAluno = Model::createMultiple(PlanoAluno::classname());
            Model::loadMultiple($modelsPlanoAluno, Yii::$app->request->post());

            //Inserir várias Estruturas Físicas do Plano
            $modelsPlanoEstrutura = Model::createMultiple(PlanoEstruturafisica::classname());
            Model::loadMultiple($modelsPlanoEstrutura, Yii::$app->request->post());


            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsPlanoMaterial) && $valid;
            $valid = Model::validateMultiple($modelsPlanoConsumo) && $valid;
            $valid = Model::validateMultiple($modelsPlanoAluno) && $valid;
            $valid = Model::validateMultiple($modelsPlanoEstrutura) && $valid;


            if ($valid ) {
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

                            if($model->save()){

                                //realiza a soma dos custos de material didático SOMENTE DO PLANO A
                                $query = (new \yii\db\Query())->from('db_apl.planomaterial_plama')->where(['plama_codplano' => $model->plan_codplano, `plama_tipoplano` => 'Plano A']);
                                $totalValorMaterial = $query->sum('plama_valor');

                                //realiza a soma dos custos de materiais de consumo (somatória de Quantidade * Valor de todas as linhas)
                                $query = (new \yii\db\Query())->from('db_apl.plano_materialconsumo')->where(['planodeacao_cod' => $id]);
                                $totalValorConsumo = $query->sum('planmatcon_valor*planmatcon_quantidade');

                                //realiza a soma dos custos de material de consumo
                                $query = (new \yii\db\Query())->from('db_apl.plano_materialaluno')->where(['planodeacao_cod' => $id]);
                                $totalValorAluno = $query->sum('planmatalu_valor*planmatalu_quantidade');

                                $model->plan_custoTotalMaterial = $totalValorMaterial; //save custo material didático
                                $model->plan_custoTotalConsumo  = $totalValorConsumo; //save custo material aluno
                                $model->plan_custoTotalAluno    = $totalValorAluno; //save custo material consumo
                                $model->save();

                            }
                            
                        Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Plano Cadastrado!</strong>');
                        return $this->redirect(['view', 'id' => $model->plan_codplano]);
                    }
                }  catch (Exception $e) {
                    $transaction->rollBack();
                    $transactionRep->rollBack();
                }
            }

            Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Plano Cadastrado!</strong>');

            return $this->redirect(['view', 'id' => $model->plan_codplano]);
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
        $session = Yii::$app->session;
        
        $model = $this->findModel($id);
        $modelsPlanoMaterial  = $model->planoMateriais;
        $modelsPlanoConsumo   = $model->planoConsumo;
        $modelsPlanoAluno     = $model->planoAluno;
        $modelsPlanoEstrutura = $model->planoEstruturafisica;
        
        $repositorio       = Repositorio::find()->where(['rep_status' => 1])->orderBy('rep_titulo')->all();
        $materialconsumo   = Materialconsumo::find()->where(['matcon_status' => 1])->orderBy('matcon_descricao')->all();
        $materialaluno     = Materialaluno::find()->where(['matalu_status' => 1])->orderBy('matalu_descricao')->all();
        $estruturafisica   = EstruturaFisica::find()->where(['estr_status' => 1])->orderBy('estr_descricao')->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

        $model->plan_data           = date('Y-m-d');
        $model->plan_codcolaborador = $session['sess_codcolaborador'];

        //--------Materiais Didáticos--------------
        $oldIDsMateriais = ArrayHelper::map($modelsPlanoMaterial, 'id', 'id');
        $modelsPlanoMaterial = Model::createMultiple(PlanoMaterial::classname(), $modelsPlanoMaterial);
        Model::loadMultiple($modelsPlanoMaterial, Yii::$app->request->post());
        $deletedIDsMateriais = array_diff($oldIDsMateriais, array_filter(ArrayHelper::map($modelsPlanoMaterial, 'id', 'id')));

        //--------Materiais de Consumo--------------
        $oldIDsConsumo = ArrayHelper::map($modelsPlanoConsumo, 'id', 'id');
        $modelsPlanoConsumo = Model::createMultiple(PlanoConsumo::classname(), $modelsPlanoConsumo,'id');            
        Model::loadMultiple($modelsPlanoConsumo, Yii::$app->request->post());
        $deletedIDsConsumo = array_diff($oldIDsConsumo, array_filter(ArrayHelper::map($modelsPlanoConsumo, 'id', 'id')));

        //--------Materiais do Aluno--------------
        $oldIDsAluno = ArrayHelper::map($modelsPlanoAluno, 'id', 'id');
        $modelsPlanoAluno = Model::createMultiple(PlanoAluno::classname(), $modelsPlanoAluno,'id');            
        Model::loadMultiple($modelsPlanoAluno, Yii::$app->request->post());
        $deletedIDsAluno = array_diff($oldIDsAluno, array_filter(ArrayHelper::map($modelsPlanoAluno, 'id', 'id')));

        //--------Equipamentos / Utensílios do Plano--------------
        $oldIDsEstrutura = ArrayHelper::map($modelsPlanoEstrutura, 'id', 'id');
        $modelsPlanoEstrutura = Model::createMultiple(PlanoEstruturafisica::classname(), $modelsPlanoEstrutura,'id');            
        Model::loadMultiple($modelsPlanoEstrutura, Yii::$app->request->post());
        $deletedIDsEstrutura = array_diff($oldIDsEstrutura, array_filter(ArrayHelper::map($modelsPlanoEstrutura, 'id', 'id')));


        // validate all models
        $valid = $model->validate();
        $valid = (Model::validateMultiple($modelsPlanoMaterial) || Model::validateMultiple($modelsPlanoConsumo) || Model::validateMultiple($modelsPlanoAluno) || Model::validateMultiple($modelsPlanoEstrutura) ) && $valid;

                        if ($valid) {
                            $transaction = \Yii::$app->db->beginTransaction();
                            try {
                                if ($flag = $model->save(false)) {
                                    if (! empty($deletedIDsMateriais)) {
                                        PlanoMaterial::deleteAll(['id' => $deletedIDsMateriais]);
                                    }
                                    foreach ($modelsPlanoMaterial as $modelPlanoMaterial) {
                                        $modelPlanoMaterial->plama_codplano = $model->plan_codplano;
                                        if (! ($flag = $modelPlanoMaterial->save(false))) {
                                            $transaction->rollBack();
                                            break;
                                        }
                                    }

                                    if (! empty($deletedIDsConsumo)) {
                                        PlanoConsumo::deleteAll(['id' => $deletedIDsConsumo]);
                                    }
                                    foreach ($modelsPlanoConsumo as $modelPlanoConsumo) {
                                        $modelPlanoConsumo->planodeacao_cod = $model->plan_codplano;
                                        if (! ($flag = $modelPlanoConsumo->save(false))) {
                                            $transaction->rollBack();
                                            break;
                                        }
                                    }

                                    if (! empty($deletedIDsAluno)) {
                                        PlanoAluno::deleteAll(['id' => $deletedIDsAluno]);
                                    }
                                    foreach ($modelsPlanoAluno as $modelPlanoAluno) {
                                        $modelPlanoAluno->planodeacao_cod = $model->plan_codplano;
                                        if (! ($flag = $modelPlanoAluno->save(false))) {
                                            $transaction->rollBack();
                                            break;
                                        }
                                    }

                                    if (! empty($deletedIDsEstrutura)) {
                                        PlanoEstruturafisica::deleteAll(['id' => $deletedIDsEstrutura]);
                                    }
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

                                if($model->save()){

                                    //realiza a soma dos custos de material didático SOMENTE DO PLANO A
                                    $query = (new \yii\db\Query())->from('db_apl.planomaterial_plama')->where(['plama_codplano' => $model->plan_codplano, 'plama_tipoplano' => 'Plano A']);
                                    $totalValorMaterial = $query->sum('plama_valor');

                                    //realiza a soma dos custos de materiais de consumo (somatória de Quantidade * Valor de todas as linhas)
                                    $query = (new \yii\db\Query())->from('db_apl.plano_materialconsumo')->where(['planodeacao_cod' => $id]);
                                    $totalValorConsumo = $query->sum('planmatcon_valor*planmatcon_quantidade');

                                    //realiza a soma dos custos de material de consumo
                                    $query = (new \yii\db\Query())->from('db_apl.plano_materialaluno')->where(['planodeacao_cod' => $id]);
                                    $totalValorAluno = $query->sum('planmatalu_valor*planmatalu_quantidade');

                                    $model->plan_custoTotalMaterial = $totalValorMaterial; //save custo material didático
                                    $model->plan_custoTotalConsumo  = $totalValorConsumo; //save custo material aluno
                                    $model->plan_custoTotalAluno    = $totalValorAluno; //save custo material consumo
                                    $model->save();

                                }

                                    Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Plano '.$id.' Atualizado !</strong>');
                                    return $this->redirect(['view', 'id' => $model->plan_codplano]);
                                }
                            } catch (Exception $e) {
                                $transaction->rollBack();
                            }
                        }

            Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Plano '.$id.' Atualizado !</strong>');

            return $this->redirect(['view', 'id' => $model->plan_codplano]);
        } else {
            return $this->render('update', [
                'model'                 => $model,
                'estruturafisica'       => $estruturafisica,
                'repositorio'           => $repositorio,
                'materialconsumo'       => $materialconsumo,
                'materialaluno'         => $materialaluno,
                'modelsPlanoMaterial'   => (empty($modelsPlanoMaterial)) ? [new PlanoMaterial] : $modelsPlanoMaterial,
                'modelsPlanoEstrutura'  => (empty($modelsPlanoEstrutura)) ? [new PlanoEstruturafisica] : $modelsPlanoEstrutura,
                'modelsPlanoConsumo'    => (empty($modelsPlanoConsumo)) ? [new PlanoConsumo] : $modelsPlanoConsumo,
                'modelsPlanoAluno'      => (empty($modelsPlanoAluno)) ? [new PlanoAluno] : $modelsPlanoAluno,
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
