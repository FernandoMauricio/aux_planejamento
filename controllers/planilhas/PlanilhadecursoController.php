<?php

namespace app\controllers\planilhas;

use Yii;
use app\models\MultipleModel as Model;
use app\models\planos\Planodeacao;
use app\models\planos\PlanoMaterial;
use app\models\planos\PlanoConsumo;
use app\models\planos\PlanoEstruturafisica;
use app\models\planilhas\PlanilhaMaterial;
use app\models\planilhas\PlanilhaEquipamento;
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

            //Localiza os Materiais Didáticos do Plano
            $ListagemMaterial = "SELECT * FROM `planomaterial_plama` WHERE `plama_codplano` = '".$model->placu_codplano."' ORDER BY `nivel_uc` DESC";

                $materiais = PlanoMaterial::findBySql($ListagemMaterial)->all(); 

                foreach ($materiais as $material) {

                    $plama_codplano       = $material['plama_codplano'];
                    $plama_tipoplano      = $material['plama_tipoplano'];
                    $plama_codrepositorio = $material['plama_codrepositorio'];
                    $plama_titulo         = $material['plama_titulo'];
                    $plama_valor          = $material['plama_valor'];
                    $plama_arquivo        = $material['plama_arquivo'];
                    $plama_tipomaterial   = $material['plama_tipomaterial'];
                    $plama_editora        = $material['plama_editora'];
                    $plama_observacao     = $material['plama_observacao'];
                    $nivel_uc             = $material['nivel_uc'];

                //Inclui os Materiais Didáticos do Plano na Planilha que está sendo criada
                Yii::$app->db_apl->createCommand()
                    ->insert('planilhamaterial_planima', [
                             'planilhadecurso_cod'    => $model->placu_codplanilha,
                             'planima_codplano'       => $plama_codplano,
                             'planima_tipoplano'      => $plama_tipoplano,
                             'planima_codrepositorio' => $plama_codrepositorio,
                             'planima_titulo'         => $plama_titulo,
                             'planima_valor'          => $plama_valor,
                             'planima_arquivo'        => $plama_arquivo,
                             'planima_tipomaterial'   => $plama_tipomaterial,
                             'planima_editora'        => $plama_editora,
                             'planima_observacao'     => $plama_observacao,
                             'planima_nivelUC'        => $nivel_uc,
                             ])
                    ->execute();
                }

            //Localiza os Materiais de Consumo do Plano
            $ListagemMaterialConsumo = "SELECT * FROM `plano_materialconsumo` WHERE `planodeacao_cod` = '".$model->placu_codplano."'";

                $materiaisConsumo = PlanoConsumo::findBySql($ListagemMaterialConsumo)->all(); 

                foreach ($materiaisConsumo as $materialConsumo) {

                    $planodeacao_cod       = $materialConsumo['planodeacao_cod'];
                    $materialconsumo_cod   = $materialConsumo['materialconsumo_cod'];
                    $planmatcon_codMXM     = $materialConsumo['planmatcon_codMXM'];
                    $planmatcon_descricao  = $materialConsumo['planmatcon_descricao'];
                    $planmatcon_quantidade = $materialConsumo['planmatcon_quantidade'];
                    $planmatcon_valor      = $materialConsumo['planmatcon_valor'];
                    $planmatcon_tipo       = $materialConsumo['planmatcon_tipo'];

                //Inclui os Materiais de Consumo do Plano na Planilha que está sendo criada
                Yii::$app->db_apl->createCommand()
                    ->insert('planilhaconsumo_planico', [
                             'planilhadecurso_cod' => $model->placu_codplanilha,
                             'planodeacao_cod'     => $planodeacao_cod,
                             'materialconsumo_cod' => $materialconsumo_cod,
                             'planico_codMXM'      => $planmatcon_codMXM,
                             'planico_descricao'   => $planmatcon_descricao,
                             'planico_quantidade'  => $planmatcon_quantidade,
                             'planico_valor'       => $planmatcon_valor,
                             'planico_tipo'        => $planmatcon_tipo,
                             ])
                    ->execute();
                }

            //Localiza os Equipamentos/Utensílios do Plano
            $ListagemEquipamentos = "SELECT * FROM `plano_estruturafisica` WHERE `planodeacao_cod` = '".$model->placu_codplano."'";

                $equipamentos = PlanoEstruturafisica::findBySql($ListagemEquipamentos)->all(); 

                foreach ($equipamentos as $equipamento) {

                    $planodeacao_cod       = $equipamento['planodeacao_cod'];
                    $estruturafisica_cod   = $equipamento['estruturafisica_cod'];
                    $planestr_descricao    = $equipamento['planestr_descricao'];
                    $planestr_quantidade   = $equipamento['planestr_quantidade'];
                    $planestr_tipo         = $equipamento['planestr_tipo'];

                //Inclui os Equipamentos/Utensílios do Plano na Planilha que está sendo criada
                Yii::$app->db_apl->createCommand()
                    ->insert('planilhaequip_planieq', [
                             'planilhadecurso_cod' => $model->placu_codplanilha,
                             'planodeacao_cod'     => $planodeacao_cod,
                             'planieq_descricao'   => $planestr_descricao,
                             'planieq_quantidade'  => $planestr_quantidade,
                             'planieq_tipo'        => $planestr_tipo,
                             ])
                    ->execute();
                }

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
        $modelsPlaniConsumo         = $model->planiConsumo;
        $modelsPlaniEquipamento     = $model->planiEquipamento;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

        //--------Materiais Didáticos--------------
        $oldIDsMateriais = ArrayHelper::map($modelsPlaniMaterial, 'id', 'id');
        $modelsPlaniMaterial = Model::createMultiple(PlanilhaMaterial::classname(), $modelsPlaniMaterial);
        Model::loadMultiple($modelsPlaniMaterial, Yii::$app->request->post());
        $deletedIDsMateriais = array_diff($oldIDsMateriais, array_filter(ArrayHelper::map($modelsPlaniMaterial, 'id', 'id')));

        //--------Materiais de Consumo--------------
        $oldIDsConsumo = ArrayHelper::map($modelsPlaniConsumo, 'id', 'id');
        $modelsPlaniConsumo = Model::createMultiple(PlanilhaConsumo::classname(), $modelsPlaniConsumo);
        Model::loadMultiple($modelsPlaniConsumo, Yii::$app->request->post());
        $deletedIDsConsumo = array_diff($oldIDsConsumo, array_filter(ArrayHelper::map($modelsPlaniConsumo, 'id', 'id')));

        //--------Equipamentos / Utensílios--------------
        $oldIDsEquipamento = ArrayHelper::map($modelsPlaniEquipamento, 'id', 'id');
        $modelsPlaniEquipamento = Model::createMultiple(PlanilhaEquipamento::classname(), $modelsPlaniEquipamento);
        Model::loadMultiple($modelsPlaniEquipamento, Yii::$app->request->post());
        $deletedIDsEquipamento = array_diff($oldIDsEquipamento, array_filter(ArrayHelper::map($modelsPlaniEquipamento, 'id', 'id')));

        // validate all models
        $valid = $model->validate();
        $valid = (Model::validateMultiple($modelsPlaniMaterial) || Model::validateMultiple($modelsPlaniConsumo) ) && $valid;

                        if ($valid) {
                            $transaction = \Yii::$app->db_apl->beginTransaction();
                            try {
                                if ($flag = $model->save(false)) {
                                    if (! empty($deletedIDsMateriais)) {
                                        PlanilhaMaterial::deleteAll(['id' => $deletedIDsMateriais]);
                                    }
                                    foreach ($modelsPlaniMaterial as $modelPlaniMaterial) {
                                        $modelPlaniMaterial->planilhadecurso_cod = $model->placu_codplanilha;
                                        if (! ($flag = $modelPlaniMaterial->save(false))) {
                                            $transaction->rollBack();
                                            break;
                                        }
                                    }

                                    if (! empty($deletedIDsConsumo)) {
                                        PlanilhaConsumo::deleteAll(['id' => $deletedIDsConsumo]);
                                    }
                                    foreach ($modelsPlaniConsumo as $modelPlaniConsumo) {
                                        $modelPlaniConsumo->planilhadecurso_cod = $model->placu_codplanilha;
                                        if (! ($flag = $modelPlaniConsumo->save(false))) {
                                            $transaction->rollBack();
                                            break;
                                        }
                                    }

                                    if (! empty($deletedIDsEquipamento)) {
                                        PlanilhaConsumo::deleteAll(['id' => $deletedIDsEquipamento]);
                                    }
                                    foreach ($modelsPlaniEquipamento as $modelPlaniEquipamento) {
                                        $modelPlaniEquipamento->planilhadecurso_cod = $model->placu_codplanilha;
                                        if (! ($flag = $modelPlaniEquipamento->save(false))) {
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
                'modelsPlaniMaterial'    => (empty($modelsPlaniMaterial)) ? [new PlanilhaMaterial] : $modelsPlaniMaterial,
                'modelsPlaniConsumo'     => (empty($modelsPlaniConsumo)) ? [new PlanilhaConsumo] : $modelsPlaniConsumo,
                'modelsPlaniEquipamento' => (empty($modelsPlaniEquipamento)) ? [new PlanilhaEquipamento] : $modelsPlaniEquipamento,
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
