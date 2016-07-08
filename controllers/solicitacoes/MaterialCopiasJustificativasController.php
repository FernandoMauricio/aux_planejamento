<?php

namespace app\controllers\solicitacoes;

use Yii;
use app\models\solicitacoes\MaterialCopias;
use app\models\solicitacoes\MaterialCopiasJustificativas;
use app\models\solicitacoes\MaterialCopiasJustificativasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MaterialCopiasJustificativasController implements the CRUD actions for MaterialCopiasJustificativas model.
 */
class MaterialCopiasJustificativasController extends Controller
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
     * Lists all MaterialCopiasJustificativas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MaterialCopiasJustificativasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MaterialCopiasJustificativas model.
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
     * Creates a new MaterialCopiasJustificativas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session = Yii::$app->session;

        $model = new MaterialCopiasJustificativas();

        $model->id_materialcopias = $session['sess_materialcopias'];
        $model->usuario = $session['sess_nomeusuario'];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

     //envia para reprovação a solicitação de cópia que está pendente
    $sql_materialCopia = "SELECT * FROM materialcopias_matc WHERE matc_id = '".$model->id_materialcopias."' ";

     $materialCopia = MaterialCopias::findBySql($sql_materialCopia)->one(); 

     $connection = Yii::$app->db;
     $command = $connection->createCommand(
     "UPDATE `db_apl`.`materialcopias_matc` SET `situacao_id` = '3' WHERE `matc_id` = '".$materialCopia->matc_id."'");
     $command->execute();

     //$contratacao->situacao_id = 2;
     // if($contratacao->situacao_id == 2){

     //     //ENVIANDO EMAIL PARA O SOLICITANTE INFORMANDO SOBRE A SOLICITAÇÃO DE CÓPIA REPROVADA
     //      $sql_email = "SELECT emus_email FROM emailusuario_emus, colaborador_col, responsavelambiente_ream WHERE ream_codunidade = '".$contratacao->cod_unidade_solic."' AND ream_codcolaborador = col_codcolaborador AND col_codusuario = emus_codusuario";
      
     //          $email_solicitacao = Emailusuario::findBySql($sql_email)->all(); 
     //          foreach ($email_solicitacao as $email)
     //              {
     //                $email_gerente  = $email["emus_email"];

     //                                Yii::$app->mailer->compose()
     //                                ->setFrom(['contratacao@am.senac.br' => 'Contratação - Senac AM'])
     //                                ->setTo($email_gerente)
     //                                ->setSubject('Solicitação de Contratação '.$contratacao->id.' - ' . $contratacao->situacao->descricao)
     //                                ->setTextBody('A solicitação de contratação de código: '.$contratacao->id.' está com status de '.$contratacao->situacao->descricao.' ')
     //                                ->setHtmlBody('<h4>Prezado(a) Gerente, <br><br>Existe uma solicitação de contratação de <strong style="color: #337ab7"">código: '.$contratacao->id.'</strong> com status de '.$contratacao->situacao->descricao.'. <br> Por favor, não responda esse e-mail. Acesse http://portalsenac.am.senac.br para ANALISAR a solicitação de contratação. <br><br> Atenciosamente, <br> Contratação de Pessoal - Senac AM.</h4>')
     //                                ->send();
     //             } 
     //    }

         //MENSAGEM DE CONFIRMAÇÃO DA SOLICITAÇÃO DE CÓPIA REPROVADA

        Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Solicitação de Cópia reprovada!</strong>');

            return $this->redirect(['solicitacoes/material-copias-pendentes/index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MaterialCopiasJustificativas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MaterialCopiasJustificativas model.
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
     * Finds the MaterialCopiasJustificativas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MaterialCopiasJustificativas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MaterialCopiasJustificativas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
