<?php

namespace app\controllers\solicitacoes;

use Yii;

use app\models\MultipleModel as Model;
use app\models\planos\Planodeacao;
use app\models\base\Emailusuario;
use app\models\cadastros\Centrocusto;
use app\models\repositorio\Repositorio;
use app\models\solicitacoes\Acabamento;
use app\models\solicitacoes\MaterialCopiasItens;
use app\models\solicitacoes\MaterialCopias;
use app\models\solicitacoes\MaterialCopiasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * MaterialCopiasController implements the CRUD actions for MaterialCopias model.
 */
class MaterialCopiasController extends Controller
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
     * Lists all MaterialCopias models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MaterialCopiasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MaterialCopias model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    //Localiza os dados de quantidade de originais de materiais didático cadastrados no repositorio
    public function actionGetRepositorio($repId){

        $getRepositorio = Repositorio::find()->where(['rep_titulo' => $repId])->one();

        echo Json::encode($getRepositorio);
    }

    //Localiza os dados de tipos de material cadastrados no repositorio
    public function actionCentrocusto(){

            $out = [];
            if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];

            if ($parents != null) {
                    $cat_id = $parents[0];
                    $subcat_id = $parents[1];
                    $out = MaterialCopias::getCentroCustoSubCat($cat_id, $subcat_id);
                    echo Json::encode(['output'=>$out, 'selected'=>'']);
                    return;
                    }
                 }
            echo Json::encode(['output'=>'', 'selected'=>'']);
    }


    //Localiza os cursos onde foram selecionados o segmento e tipo de ação
    public function actionCursos() {
            $out = [];
            if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];

            if ($parents != null) {
                    $cat_id = $parents[0];
                    $subcat_id = $parents[1];
                    $out = MaterialCopias::getPlanodeacaoSubCat($cat_id, $subcat_id);
                    echo Json::encode(['output'=>$out, 'selected'=>'']);
                    return;
                    }
                 }
            echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    /**
     * Creates a new MaterialCopias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session = Yii::$app->session;

        $model = new MaterialCopias();
        $modelsItens  = [new MaterialCopiasItens];

        $acabamento = Acabamento::find()->all();

        $repositorio = Repositorio::find()->where(['rep_status' => 1])->orderBy('rep_titulo')->all();

        $model->matc_data        = date('Y-m-d');
        $model->matc_solicitante = $session['sess_codcolaborador'];
        $model->matc_unidade     = $session['sess_codunidade'];
        $model->situacao_id      = 1;
  
        if ($model->load(Yii::$app->request->post())) {

            $totalGeral = $model->matc_totalValorMono + $model->matc_totalValorColor;

            //Inserir vários itens na solicitação
            $modelsItens = Model::createMultiple(MaterialCopiasItens::classname());
            Model::loadMultiple($modelsItens, Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsItens) && $valid;

             if ($valid ) {
                $transaction = \Yii::$app->db_apl->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsItens as $modelItens) {
                            $modelItens->materialcopias_id = $model->matc_id;
                            if (! ($flag = $modelItens->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Solicitação de Cópia cadastrada!</strong>');
                        return $this->redirect(['view', 'id' => $model->matc_id]);
                    }
                }  catch (Exception $e) {
                    $transaction->rollBack();
                }
            }


        //ENVIANDO EMAIL PARA OS RESPONSÁVEIS DO GABINETE TÉCNICO INFORMANDO SOBRE O RECEBIMENTO DE UMA NOVA SOLICITAÇÃO DE CÓPIA 
        //-- 15 - DIVISÃO DE EDUCAÇÃO PROFISSIONAL // 87 - GABINETE TÉCNICO
                  $sql_email = "SELECT DISTINCT emus_email FROM emailusuario_emus,colaborador_col,responsavelambiente_ream,responsaveldepartamento_rede WHERE ream_codunidade = '15' AND rede_coddepartamento = '87' AND rede_codcolaborador = col_codcolaborador AND col_codusuario = emus_codusuario";
              
              $email_solicitacao = Emailusuario::findBySql($sql_email)->all(); 
              foreach ($email_solicitacao as $email)
                  {
                    $email_usuario  = $email["emus_email"];

                                    Yii::$app->mailer->compose()
                                    ->setFrom(['dep.suporte@am.senac.br' => 'DEP - INFORMA'])
                                    ->setTo($email_usuario)
                                    ->setSubject('Solicitação de Cópia - ' . $model->matc_id)
                                    ->setTextBody('Existe uma solicitação de Cópia de código: '.$model->matc_id.' - Pendente de Autorização')
                                    ->setHtmlBody('<p>Prezado(a) Senhor(a),</p>

                                    <p>Existe uma Solicita&ccedil;&atilde;o de Cópia de c&oacute;digo: <strong><span style="color:#F7941D">'.$model->matc_id.' </span></strong>- <strong><span style="color:#F7941D">Pendente de Autorização</span></strong></p>

                                    <p><strong>Situação</strong>: '.$model->situacao->sitmat_descricao.'</p>

                                    <p><strong>Material</strong>: </p>

                                    <p><strong>Total de Despesa</strong>: R$ ' .number_format($totalGeral, 2, ',', '.').'</p>

                                    <p>Por favor, n&atilde;o responda esse e-mail. Acesse http://portalsenac.am.senac.br para ANALISAR a solicita&ccedil;&atilde;o de Cópia.</p>

                                    <p>Atenciosamente,</p>

                                    <p>Divisão de Educação Profissional -&nbsp;DEP</p>
                                    ')
                                    ->send();
                                } 
            if($model->save()){

                Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Solicitação de Cópia cadastrada!</strong>');
            }

            return $this->redirect(['view', 'id' => $model->matc_id]);
        } else {
            print_r($model->getErrors());

            return $this->render('create', [
                'model'       => $model,
                'repositorio' => $repositorio,
                'acabamento'  => $acabamento,
                'modelsItens'   => (empty($modelsItens)) ? [new MaterialCopiasItens] : $modelsItens,
            ]);
        }
    }

    public function actionObservacoes($id) 
    {
        $model = MaterialCopias::findOne($id);
        $session = Yii::$app->session;
        $session->set('sess_materialcopias', $model->matc_id);

        return $this->redirect(Yii::$app->request->BaseUrl . '/index.php?r=solicitacoes/material-copias-justificativas/observacoes', [
             'model' => $model,
         ]);
    }

    /**
     * Updates an existing MaterialCopias model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $session = Yii::$app->session;

        $model = $this->findModel($id);

        $repositorio = Repositorio::find()->where(['rep_status' => 1])->orderBy('rep_titulo')->all();

        //ACABAMENTOS
        $acabamento = Acabamento::find()->where(['acab_status' => 1])->all();
        //Retrieve the stored checkboxes
        $model->listAcabamento = \yii\helpers\ArrayHelper::getColumn(
            $model->getCopiasAcabamento()->asArray()->all(),
            'acabamento_id'
        );

        $model->matc_data        = date('Y-m-d');
        $model->matc_solicitante = $session['sess_codcolaborador'];
        $model->matc_unidade     = $session['sess_codunidade'];
        $model->situacao_id      = 1;
        $model->matc_ResponsavelAut = NULL;
        $model->matc_dataAut = NULL;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
         
           $totalGeral = $model->matc_totalValorMono + $model->matc_totalValorColor;

        //ENVIANDO EMAIL PARA OS RESPONSÁVEIS DO GABINETE TÉCNICO INFORMANDO SOBRE O RECEBIMENTO DE UMA NOVA SOLICITAÇÃO DE CÓPIA 
        //-- 15 - DIVISÃO DE EDUCAÇÃO PROFISSIONAL // 87 - GABINETE TÉCNICO
                  $sql_email = "SELECT DISTINCT emus_email FROM emailusuario_emus,colaborador_col,responsavelambiente_ream,responsaveldepartamento_rede WHERE ream_codunidade = '15' AND rede_coddepartamento = '87' AND rede_codcolaborador = col_codcolaborador AND col_codusuario = emus_codusuario";
              
              $email_solicitacao = Emailusuario::findBySql($sql_email)->all(); 
              foreach ($email_solicitacao as $email)
                  {
                    $email_usuario  = $email["emus_email"];

                                    Yii::$app->mailer->compose()
                                    ->setFrom(['dep.suporte@am.senac.br' => 'DEP - INFORMA'])
                                    ->setTo($email_usuario)
                                    ->setSubject('Solicitação de Cópia - ' . $model->matc_id)
                                    ->setTextBody('Existe uma solicitação de Cópia de código: '.$model->matc_id.' - Pendente de Autorização')
                                    ->setHtmlBody('<p>Prezado(a) Senhor(a),</p>

                                    <p>Existe uma Solicita&ccedil;&atilde;o de Cópia de c&oacute;digo: <strong><span style="color:#F7941D">'.$model->matc_id.' </span></strong>- <strong><span style="color:#F7941D">Pendente de Autorização</span></strong></p>

                                    <p><strong>Situação</strong>: '.$model->situacao->sitmat_descricao.'</p>

                                    <p><strong>Material</strong>: </p>

                                    <p><strong>Total de Despesa</strong>: R$ ' .number_format($totalGeral, 2, ',', '.').'</p>

                                    <p>Por favor, n&atilde;o responda esse e-mail. Acesse http://portalsenac.am.senac.br para ANALISAR a solicita&ccedil;&atilde;o de Cópia.</p>

                                    <p>Atenciosamente,</p>

                                    <p>Divisão de Educação Profissional -&nbsp;DEP</p>
                                    ')
                                    ->send();
                                } 
 

            Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Solicitação de Cópia atualizada!</strong>');

            return $this->redirect(['view', 'id' => $model->matc_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'repositorio' => $repositorio,
                'acabamento'  => $acabamento,
            ]);
        }
    }

    /**
     * Deletes an existing MaterialCopias model.
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
     * Finds the MaterialCopias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MaterialCopias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MaterialCopias::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
