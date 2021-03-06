<?php

namespace app\controllers\planilhas;

use Yii;
use app\models\MultipleModel as Model;
use app\models\base\Unidade;
use app\models\despesas\Markup;
use app\models\despesas\Despesasdocente;
use app\models\planos\Planodeacao;
use app\models\planos\Unidadescurriculares;
use app\models\planos\PlanoMaterial;
use app\models\planos\PlanoConsumo;
use app\models\planos\PlanoAluno;
use app\models\planos\PlanoEstruturafisica;
use app\models\planilhas\PlanilhaDespesaDocente;
use app\models\planilhas\PlanilhaDespesaDocenteSearch;
use app\models\planilhas\PlanilhaUnidadesCurriculares;
use app\models\planilhas\PlanilhaMaterial;
use app\models\planilhas\PlanilhaConsumo;
use app\models\planilhas\PlanilhaMaterialAluno;
use app\models\planilhas\PlanilhaEquipamento;
use app\models\planilhas\PlanilhaJustificativas;
use app\models\planilhas\Planilhadecurso;
use app\models\planilhas\PlanilhadecursoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use mPDF;

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

        $this->AccessAllow(); //Irá ser verificado se o usuário está logado no sistema

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
    public function actionPlanos() 
    {
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
    public function actionGetPlanoDetalhes($planoId)
    {

        $getPlanoDetalhes = Planodeacao::findOne($planoId);
        echo Json::encode($getPlanoDetalhes);
    }

    //Envia todo o Planejamento para o GPO
    public function actionEnviarPlanejamento() 
    {
        return $this->renderAjax('enviar-planejamento', [
        ]);
    }

    public function actionEnviarProgramacaoAnual()
    {
        $session = Yii::$app->session;

        //Realiza a Contagem das Planilhas da unidade que estão definidas como PRODUÇÃO, PROGRAMAÇÃO ANUAL e AGUARDANDO ENVIO
        $countPlanilhas = 0;
        $countPlanilhas = Planilhadecurso::find()->where(['placu_codtipla' => 1, 'placu_codsituacao' => 5, 'placu_codprogramacao' => 1, 'placu_codunidade' => $session['sess_codunidade']])->count();  

        if($countPlanilhas != 0){
        //Envia as Planilhas para o GPO da unidade que estão definidas como PRODUÇÃO, PROGRAMAÇÃO ANUAL e AGUARDANDO ENVIO
        Yii::$app->db_apl->createCommand('UPDATE `planilhadecurso_placu` SET `placu_codsituacao` = 3 WHERE `placu_codtipla` = 1 AND `placu_codprogramacao` = 1 AND `placu_codsituacao`= 5 AND `placu_codunidade` = "'.$session['sess_codunidade'].'" ')->execute();

        Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Total de '.$countPlanilhas.' planilhas de "'.$session['sess_unidade'].'" enviadas para análise do GPO!</strong>');
        }else{
        Yii::$app->session->setFlash('warning', '<strong>AVISO! </strong> Não existem planilhas com a situação: <strong>"Aguardando Envio Planejamento"</strong> para serem enviadas à GPO!</strong>');
        }

        return $this->redirect(['index']);

    }

    public function actionEnviarProgramacaoRetificativo()
    {
        $session = Yii::$app->session;

        //Realiza a Contagem das Planilhas da unidade que estão definidas como PRODUÇÃO, PROGRAMAÇÃO ANUAL e AGUARDANDO ENVIO
        $countPlanilhas = 0;
        $countPlanilhas = Planilhadecurso::find()->where(['placu_codtipla' => 1, 'placu_codsituacao' => 5,  'placu_codprogramacao' => 2,  'placu_codunidade' => $session['sess_codunidade']])->count();  

        if($countPlanilhas != 0){
        //Envia as Planilhas para o GPO da unidade que estão definidas como PRODUÇÃO, RETIFICATIVO e AGUARDANDO ENVIO
        Yii::$app->db_apl->createCommand('UPDATE `planilhadecurso_placu` SET `placu_codsituacao` = 3 WHERE `placu_codtipla` = 1 AND `placu_codprogramacao` = 2 AND `placu_codsituacao`= 5 AND `placu_codunidade` = "'.$session['sess_codunidade'].'" ')->execute();

        Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Total de '.$countPlanilhas.' planilhas de "'.$session['sess_unidade'].'" enviadas para análise do GPO!</strong>');
        }else{
        Yii::$app->session->setFlash('warning', '<strong>AVISO! </strong> Não existem planilhas com a situação: "Aguardando Envio Planejamento" para serem enviadas à GPO!</strong>');
        }

        return $this->redirect(['index']);
        
    }

   public function actionImprimir($id) 
    {
        $this->layout = 'main-imprimir';
        
        $model = $this->findModel($id);
        $modelsPlaniDespDocente    = $model->planiDespDocente;
        $modelsPlaniUC             = $model->planiUC;
        $modelsPlaniMaterial       = $model->planiMateriais;
        $modelsPlaniConsumo        = $model->planiConsumo;
        $modelsPlaniMateriaisAluno = $model->planiMateriaisAluno;
        $modelsPlaniEquipamento    = $model->planiEquipamento;

        return $this->render('imprimir', [
            'model' => $this->findModel($id),
            'modelsPlaniDespDocente'    => $modelsPlaniDespDocente,
            'modelsPlaniUC'             => $modelsPlaniUC,
            'modelsPlaniMaterial'       => $modelsPlaniMaterial,
            'modelsPlaniConsumo'        => $modelsPlaniConsumo,
            'modelsPlaniMateriaisAluno' => $modelsPlaniMateriaisAluno,
            'modelsPlaniEquipamento'    => $modelsPlaniEquipamento,
        ]);
    }

    /**
     * Lists all Planilhadecurso models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'main-full';
        $searchModel = new PlanilhadecursoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionObservacoes($id)
    {
        $model = Planilhadecurso::findOne($id);
        $session = Yii::$app->session;
        $session->set('sess_planilhadecurso', $model->placu_codplanilha);

        return $this->redirect(['/planilhas/planilha-justificativas/observacoes'], [
             'model' => $model,
         ]);
    }

    public function actionObservacoesGerentes($id)
    {
        $model = Planilhadecurso::findOne($id);
        $session = Yii::$app->session;
        $session->set('sess_planilhadecurso', $model->placu_codplanilha);

        return $this->redirect(['/planilhas/planilha-justificativas/observacoes-gerentes'], [
             'model' => $model,
         ]);
    }


    /**
     * Displays a single Planilhadecurso model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $modelsPlaniDespDocente    = $model->planiDespDocente;
        $modelsPlaniUC             = $model->planiUC;
        $modelsPlaniMaterial       = $model->planiMateriais;
        $modelsPlaniConsumo        = $model->planiConsumo;
        $modelsPlaniMateriaisAluno = $model->planiMateriaisAluno;
        $modelsPlaniEquipamento    = $model->planiEquipamento;

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelsPlaniDespDocente'    => $modelsPlaniDespDocente,
            'modelsPlaniUC'             => $modelsPlaniUC,
            'modelsPlaniMaterial'       => $modelsPlaniMaterial,
            'modelsPlaniConsumo'        => $modelsPlaniConsumo,
            'modelsPlaniMateriaisAluno' => $modelsPlaniMateriaisAluno,
            'modelsPlaniEquipamento'    => $modelsPlaniEquipamento,
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
        $model->placu_codsituacao    = 1; //Situação Padrão: Em elaboração
        $model->placu_tipocalculo    = 1; //Tipo de Cálculo: Taxa de Retorno ou Valor Curso Por Aluno
        $model->placu_diarias        = 0;
        $model->placu_passagens      = 0;
        $model->placu_equipamentos   = 0;
        $model->placu_pessoafisica   = 0;
        $model->placu_pessoajuridica = 0;
        $model->placu_data           = date('Y-m-d');
        $model->placu_codano         = 10; // Ano 2021

            //Localiza as Despesas Indiretas da Unidade
            $ListagemMarkups = "SELECT * FROM  `markup_mark` WHERE `mark_codunidade` = '".$model->placu_codunidade."'";

                $markup = Markup::findBySql($ListagemMarkups)->one();

                if(isset($markup->mark_codunidade)){ // Irá Verificar se existe configuração de Markup para a Unidade
                    //Inclui Despesas Indiretas da Unidade na Planilha que está sendo criada
                    $model->placu_custosindiretos = $markup->mark_custoindireto;
                    $model->placu_ipca            = $markup->mark_ipca;
                    $model->placu_reservatecnica  = $markup->mark_reservatecnica;
                    $model->placu_despesadm       = $markup->mark_despesasede;
                }else{
                    Yii::$app->session->setFlash('danger', '<strong>ERRO! </strong> Unidade de ensino sem Markup configurado. Você não conseguirá criar Planilhas. Por favor, informe ao GPO!</strong>');
                    return $this->render('create', [
                    'model' => $model,
                    ]);
                }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //Se a CH do Plano for inferior a 15 horas e for selecionado a Fonte de Financiamento PSG, o sistema não deixará prosseguir
            if($model->placu_cargahorariaplano < 15 && $model->placu_codcategoria == 2){
                 Yii::$app->session->setFlash('danger', '<strong>AVISO! </strong> Fonte de Financiamento selecionado não pode ter a Carga Horária do Plano inferior a <strong>15 horas</strong>.');

                 return $this->redirect(['create']);
            }

            //Localiza as Despesas com Docentes
            $ListagemDespDocente = "SELECT * FROM `despesas_docente` WHERE doce_status = 1";

                $despDocentes = Despesasdocente::findBySql($ListagemDespDocente)->all();

                foreach ($despDocentes as $despDocente) {

                    $doce_descricao     = $despDocente['doce_descricao'];
                    $doce_encargos      = $despDocente['doce_encargos'];
                    $doce_valor         = $despDocente['doce_valor'];
                    $doce_dsr           = $despDocente['doce_dsr'];
                    $doce_planejamento  = $despDocente['doce_planejamento'];
                    $doce_produtividade = $despDocente['doce_produtividade'];
                    $doce_valorhoraaula = $despDocente['doce_valorhoraaula'];

                //Inclui Despesas com Docentes do Plano na Planilha que está sendo criada
                Yii::$app->db_apl->createCommand()
                    ->insert('planilhadespesadoce_planides', [
                             'planilhadecurso_cod'    => $model->placu_codplanilha,
                             'planides_descricao'     => $doce_descricao,
                             'planides_encargos'      => $doce_encargos,
                             'planides_valor'         => $doce_valor,
                             'planides_valorhidden'   => $doce_valor,
                             'planides_dsr'           => $doce_dsr,
                             'planides_planejamento'  => $doce_planejamento,
                             'planides_produtividade' => $doce_produtividade,
                             'planides_valorhoraaula' => $doce_valorhoraaula,
                             'planides_cargahoraria'  => 0,
                             ])
                    ->execute();
                }

            //Localiza os Materiais Didáticos do Plano
            $ListagemUC = "SELECT * FROM `unidadescurriculares_uncu` WHERE `planodeacao_cod` = '".$model->placu_codplano."' ORDER BY `nivel_uc` DESC";

                $materiais = Unidadescurriculares::findBySql($ListagemUC)->all();

                foreach ($materiais as $material) {

                    $planodeacao_cod      = $material['planodeacao_cod'];
                    $uncu_descricao       = $material['uncu_descricao'];
                    $uncu_cargahoraria    = $material['uncu_cargahoraria'];
                    $nivel_uc             = $material['nivel_uc'];

                //Inclui os Materiais Didáticos do Plano na Planilha que está sendo criada
                Yii::$app->db_apl->createCommand()
                    ->insert('planilhaunidadescurriculares_planiuc', [
                             'planilhadecurso_cod'  => $model->placu_codplanilha,
                             'planodeacao_cod'      => $planodeacao_cod,
                             'planiuc_descricao'    => $uncu_descricao,
                             'planiuc_cargahoraria' => $uncu_cargahoraria,
                             'planiuc_nivelUC'      => $nivel_uc,
                             ])
                    ->execute();
                }

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

            //Localiza os Materiais do Aluno do Plano
            if($model->placu_codcategoria == 1){//COMERCIAL
            $ListagemMaterialAluno = "SELECT * FROM `plano_materialaluno` WHERE `planodeacao_cod` = '".$model->placu_codplano."' AND `planmatalu_tipo` = 'COMERCIAL'";
            }
            if($model->placu_codcategoria == 2){//PSG
               $ListagemMaterialAluno = "SELECT * FROM `plano_materialaluno` WHERE `planodeacao_cod` = '".$model->placu_codplano."' AND `planmatalu_tipo` = 'PSG'";
            }
            if($model->placu_codcategoria == 3){//COMERCIAL/PSG
               $ListagemMaterialAluno = "SELECT * FROM `plano_materialaluno` WHERE `planodeacao_cod` = '".$model->placu_codplano."' AND `planmatalu_tipo` = 'COMERCIAL/PSG'";
            }
            if($model->placu_codcategoria == 4){//PRONATEC
                $ListagemMaterialAluno = "SELECT * FROM `plano_materialaluno` WHERE `planodeacao_cod` = '".$model->placu_codplano."' AND `planmatalu_tipo` = 'PRONATEC'";
            }
            if($model->placu_codcategoria == 5){//PRONATEC/PSG
                $ListagemMaterialAluno = "SELECT * FROM `plano_materialaluno` WHERE `planodeacao_cod` = '".$model->placu_codplano."' AND `planmatalu_tipo` = 'PRONATEC/PSG'";
            }
            if($model->placu_codcategoria == 6){//RECURSOS DA EMPRESA
                $ListagemMaterialAluno = "SELECT * FROM `plano_materialaluno` WHERE `planodeacao_cod` = '".$model->placu_codplano."' AND `planmatalu_tipo` = 'RECURSOS DA EMPRESA'";
            }
            if($model->placu_codcategoria == 7){//ISENTO
                $ListagemMaterialAluno = "SELECT * FROM `plano_materialaluno` WHERE `planodeacao_cod` = '".$model->placu_codplano."' AND `planmatalu_tipo` = 'ISENTO'";
            }

                $materiaisAluno = PlanoAluno::findBySql($ListagemMaterialAluno)->all(); 

                foreach ($materiaisAluno as $materialAluno) {

                    $planodeacao_cod       = $materialAluno['planodeacao_cod'];
                    $planmatalu_descricao  = $materialAluno['planmatalu_descricao'];
                    $planmatalu_unidade    = $materialAluno['planmatalu_unidade'];
                    $planmatalu_tipo       = $materialAluno['planmatalu_tipo'];
                    $planmatalu_valor      = $materialAluno['planmatalu_valor'];
                    $planmatalu_quantidade = $materialAluno['planmatalu_quantidade'];

                //Inclui os Materiais do Aluno do Plano na Planilha que está sendo criada
                Yii::$app->db_apl->createCommand()
                    ->insert('planilhamaterialaluno_planimatalun', [
                             'planilhadecurso_cod'     => $model->placu_codplanilha,
                             'planodeacao_cod'         => $planodeacao_cod,
                             'planimatalun_descricao'  => $planmatalu_descricao,
                             'planimatalun_unidade'    => $planmatalu_unidade,
                             'planimatalun_tipo'       => $planmatalu_tipo,
                             'planimatalun_valor'      => $planmatalu_valor,
                             'planimatalun_quantidade' => $planmatalu_quantidade,
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

                if($model->save()){

                    //realiza a soma dos custos de material didático(LIVROS) SOMENTE DO PLANO A
                    $query = (new \yii\db\Query())->from('db_apl2.planilhamaterial_planima')->where(['planilhadecurso_cod' => $model->placu_codplanilha, 'planima_tipoplano' => 'Plano A', 'planima_tipomaterial' => 'LIVROS']);
                    $totalValorMaterialLivro = $query->sum('planima_valor');

                    //realiza a soma dos custos de material didático(APOSTILAS) SOMENTE DO PLANO A
                    $query = (new \yii\db\Query())->from('db_apl2.planilhamaterial_planima')->where(['planilhadecurso_cod' => $model->placu_codplanilha, 'planima_tipoplano' => 'Plano A', 'planima_tipomaterial' => 'APOSTILAS']);
                    $totalValorMaterialApostila = $query->sum('planima_valor');

                    //realiza a soma dos custos de material didático(OUTROS) SOMENTE DO PLANO A
                    $query = (new \yii\db\Query())->from('db_apl2.planilhamaterial_planima')->where(['planilhadecurso_cod' => $model->placu_codplanilha, 'planima_tipoplano' => 'Plano A'])->andWhere(['<>','planima_tipomaterial', 'LIVROS'])->andWhere(['<>','planima_tipomaterial', 'APOSTILAS']);
                    $totalValorOutrosMateriais = $query->sum('planima_valor');

                    //realiza a soma dos custos de materiais de consumo (somatória de Quantidade * Valor de todas as linhas)
                    $query = (new \yii\db\Query())->from('db_apl2.planilhaconsumo_planico')->where(['planilhadecurso_cod' => $model->placu_codplanilha]);
                    $totalValorConsumo = $query->sum('planico_valor*planico_quantidade');

                    //realiza a soma dos custos de material do aluno
                    $query = (new \yii\db\Query())->from('db_apl2.planilhamaterialaluno_planimatalun')->where(['planilhadecurso_cod' => $model->placu_codplanilha]);
                    $totalValorAluno = $query->sum('planimatalun_valor*planimatalun_quantidade');

                    //Valores padrões para caso não tenha custos com docente
                    $model->placu_totalcustodocente      = 0;
                    $model->placu_decimo                 = 0;
                    $model->placu_ferias                 = 0;
                    $model->placu_tercoferias            = 0;
                    $model->placu_totalsalario           = 0;
                    $model->placu_totalsalarioPrestador  = 0;
                    $model->placu_totalencargosPrestador = 0;
                    $model->placu_totalencargos          = 0;
                    $model->placu_outdespvariaveis       = 0;
                    $model->placu_totalsalarioencargo    = 0;

                    //Somatória Quantidade de Alunos Pagantes, Isentos e PSG
                    $valorTotalQntAlunos = $model->placu_quantidadealunos + $model->placu_quantidadealunosisentos + $model->placu_quantidadealunospsg;
                    // + 0 -> Caso não tenha nenhum item relacionado será adicionado por default o 0
                    $model->placu_custosmateriais  = ($totalValorMaterialLivro * $valorTotalQntAlunos) + 0; //save custo material didático - LIVROS
                    $model->placu_PJApostila       = ($totalValorMaterialApostila * $valorTotalQntAlunos) + 0; //save custo material didático - APOSTILAS
                    $model->placu_outrosmateriais  = ($totalValorOutrosMateriais * $valorTotalQntAlunos) + 0; //save custo material didático - OUTROS
                    $model->placu_custosconsumo    = $totalValorConsumo + 0; //save custo material consumo
                    $model->placu_custosaluno      = ($totalValorAluno * $model->placu_quantidadealunospsg) + 0; //save custo material do aluno

                    $model->placu_hiddenmaterialdidatico = $totalValorMaterialLivro + 0; //save hidden custo para multiplicação javascript
                    $model->placu_hiddenpjapostila       = $totalValorMaterialApostila + 0; //save hidden custo para multiplicação javascript
                    $model->placu_hiddenoutrosmateriais  = $totalValorOutrosMateriais + 0; //save hidden custo para multiplicação javascript
                    $model->placu_hiddencustosaluno      = $totalValorAluno + 0; //save hidden custo para multiplicação javascript

                    //Totalização das Despesas Diretas (Total de Custo Direto)
                    $model->placu_totalcustodireto = $model->placu_totalsalarioencargo + $model->placu_diarias + $model->placu_passagens + $model->placu_pessoafisica + $model->placu_pessoajuridica + $model->placu_PJApostila + $model->placu_outrosmateriais + $model->placu_custosmateriais + $model->placu_custosconsumo + $model->placu_custosaluno;

                    $model->placu_totalhoraaulacustodireto = $model->placu_totalcustodireto / $model->placu_cargahorariaplano / $valorTotalQntAlunos;

                    //Despesas Indiretas
                    $model->placu_totalincidencias     = $model->placu_custosindiretos + $model->placu_ipca + $model->placu_reservatecnica + $model->placu_despesadm;
                    $model->placu_totalcustoindireto   = ($model->placu_totalcustodireto * $model->placu_totalincidencias) / 100;
                    $model->placu_despesatotal         = $model->placu_totalcustoindireto + $model->placu_totalcustodireto;
                    $model->placu_markdivisor          = (100 - $model->placu_totalincidencias);
                    $model->placu_markmultiplicador    = ((100 / $model->placu_markdivisor) - 1) * 100; // Valores em %
                    $model->placu_vendaturma           = ($model->placu_totalcustodireto / $model->placu_markdivisor) * 100; // Valores em %
                    $model->placu_vendaaluno           = ($model->placu_vendaturma / $valorTotalQntAlunos);
                    $model->placu_horaaulaaluno        = $model->placu_vendaturma / $model->placu_cargahorariaplano / $valorTotalQntAlunos; //Venda da Turma / CH TOTAL / QNT Alunos
                    $model->placu_retorno              = $model->placu_vendaturma - $model->placu_despesatotal; // Preço de venda da turma - Despesa Total;
                    $model->placu_porcentretorno       = $model->placu_porcentretorno != 0 ? ($model->placu_retorno / $model->placu_vendaturma) * 100 : 0; // % de Retorno / Preço de venda da Turma -- Valores em %

                    $model->save();
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
        $model->scenario = 'update'; //Validações obrigatórias na atualização
        $modelsPlaniUC             = $model->planiUC;
        $modelsPlaniMaterial       = $model->planiMateriais;
        $modelsPlaniConsumo        = $model->planiConsumo;
        $modelsPlaniMateriaisAluno = $model->planiMateriaisAluno;
        $modelsPlaniEquipamento    = $model->planiEquipamento;
        $modelsPlaniDespDocente    = $model->planiDespDocente;

        //Será verificado se existem os valores dos campos abaixo
        if($model->placu_PJApostila == NULL){
            $model->placu_PJApostila = 0;
        }
        if($model->placu_hiddenpjapostila == NULL){
            $model->placu_hiddenpjapostila = 0;
        }
        if($model->placu_outrosmateriais == NULL){
            $model->placu_outrosmateriais = 0;
        }
        if($model->placu_hiddenoutrosmateriais == NULL){
            $model->placu_hiddenoutrosmateriais = 0;
        }
        if($model->placu_hiddenmaterialdidatico == NULL){
            $model->placu_hiddenmaterialdidatico = 0;
        }
        if($model->placu_custosmateriais == NULL){
            $model->placu_custosmateriais = 0;
        }
        if($model->placu_custosconsumo == NULL){
            $model->placu_custosconsumo = 0;
        }
        if($model->placu_custosaluno == NULL){
            $model->placu_custosaluno = 0;
        }
        if($model->placu_hiddencustosaluno == NULL){
            $model->placu_hiddencustosaluno = 0;
        }

        //Caso o exercicio da Planilha seja diferente com o ano da Planilha, será avisado ao usuário para excluir alguns itens
        if($model->planilhaAno->an_ano < date('Y')){
             Yii::$app->session->setFlash('danger', '<strong>AVISO! </strong> Planilha '.$id.' do ano de <strong>'.$model->planilhaAno->an_ano.'</strong>. Por favor, <strong>exclua</strong> os itens de Organização Curricular, Material Didático, Consumo e Aluno que não irá utilizar!</strong>');
        }

        // Se a Planilha estiver HOMOLOGADA e o usuário tentar acessar, será redirecionada automaticamente para a listagem
        if($model->placu_codsituacao == 4){
            return $this->redirect(['index']);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

        //--------Despesas com Docentes--------------
        $oldIDsDespesaDocente = ArrayHelper::map($modelsPlaniDespDocente, 'id', 'id');
        $modelsPlaniDespDocente = Model::createMultiple(PlanilhaDespesaDocente::classname(), $modelsPlaniDespDocente);
        Model::loadMultiple($modelsPlaniDespDocente, Yii::$app->request->post());
        $deletedIDsDespesaDocente = array_diff($oldIDsDespesaDocente, array_filter(ArrayHelper::map($modelsPlaniDespDocente, 'id', 'id')));

        //--------Unidades Curriculares--------------
        $oldIDsUnidadesCurriculares = ArrayHelper::map($modelsPlaniUC, 'id', 'id');
        $modelsPlaniUC = Model::createMultiple(PlanilhaUnidadesCurriculares::classname(), $modelsPlaniUC);
        Model::loadMultiple($modelsPlaniUC, Yii::$app->request->post());
        $deletedIDsUnidadesCurriculares = array_diff($oldIDsUnidadesCurriculares, array_filter(ArrayHelper::map($modelsPlaniUC, 'id', 'id')));

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

        //--------Materiais do Aluno--------------
        $oldIDsMaterialAluno = ArrayHelper::map($modelsPlaniMateriaisAluno, 'id', 'id');
        $modelsPlaniMateriaisAluno = Model::createMultiple(PlanilhaMaterialAluno::classname(), $modelsPlaniMateriaisAluno);
        Model::loadMultiple($modelsPlaniMateriaisAluno, Yii::$app->request->post());
        $deletedIDsMaterialAluno = array_diff($oldIDsMaterialAluno, array_filter(ArrayHelper::map($modelsPlaniMateriaisAluno, 'id', 'id')));

        //--------Equipamentos / Utensílios--------------
        $oldIDsEquipamento = ArrayHelper::map($modelsPlaniEquipamento, 'id', 'id');
        $modelsPlaniEquipamento = Model::createMultiple(PlanilhaEquipamento::classname(), $modelsPlaniEquipamento);
        Model::loadMultiple($modelsPlaniEquipamento, Yii::$app->request->post());
        $deletedIDsEquipamento = array_diff($oldIDsEquipamento, array_filter(ArrayHelper::map($modelsPlaniEquipamento, 'id', 'id')));

        // validate all models
        $valid = $model->validate();
        $valid = (Model::validateMultiple($modelsPlaniDespDocente) || Model::validateMultiple($modelsPlaniUC) || Model::validateMultiple($modelsPlaniMaterial) || Model::validateMultiple($modelsPlaniConsumo) || Model::validateMultiple($modelsPlaniEquipamento) ) && $valid;

                        if ($valid) {
                            $transaction = \Yii::$app->db_apl->beginTransaction();
                            try {
                                if ($flag = $model->save(false)) {

                                    if (! empty($deletedIDsDespesaDocente)) {
                                        PlanilhaDespesaDocente::deleteAll(['id' => $deletedIDsDespesaDocente]);
                                    }
                                    foreach ($modelsPlaniDespDocente as $modelPlaniDespDocente) {
                                        $modelPlaniDespDocente->planilhadecurso_cod = $model->placu_codplanilha;
                                        if (! ($flag = $modelPlaniDespDocente->save(false))) {
                                            $transaction->rollBack();
                                            break;
                                        }
                                    }

                                    if (! empty($deletedIDsUnidadesCurriculares)) {
                                        PlanilhaUnidadesCurriculares::deleteAll(['id' => $deletedIDsUnidadesCurriculares]);
                                    }
                                    foreach ($modelsPlaniUC as $modelPlaniUC) {
                                        $modelPlaniUC->planilhadecurso_cod = $model->placu_codplanilha;
                                        if (! ($flag = $modelPlaniUC->save(false))) {
                                            $transaction->rollBack();
                                            break;
                                        }
                                    }

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

                                    if (! empty($deletedIDsMaterialAluno)) {
                                        PlanilhaMaterialAluno::deleteAll(['id' => $deletedIDsMaterialAluno]);
                                    }
                                    foreach ($modelsPlaniMateriaisAluno as $modelPlaniMateriaisAluno) {
                                        $modelPlaniMateriaisAluno->planilhadecurso_cod = $model->placu_codplanilha;
                                        if (! ($flag = $modelPlaniMateriaisAluno->save(false))) {
                                            $transaction->rollBack();
                                            break;
                                        }
                                    }

                                    if (! empty($deletedIDsEquipamento)) {
                                        PlanilhaEquipamento::deleteAll(['id' => $deletedIDsEquipamento]);
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

                                if($model->save()){

                                    //realiza a soma dos custos de material didático(LIVROS) SOMENTE DO PLANO A
                                    $query = (new \yii\db\Query())->from('db_apl2.planilhamaterial_planima')->where(['planilhadecurso_cod' => $model->placu_codplanilha, 'planima_tipoplano' => 'Plano A', 'planima_tipomaterial' => 'LIVROS']);
                                    $totalValorMaterialLivro = $query->sum('planima_valor');

                                    //realiza a soma dos custos de material didático(APOSTILAS) SOMENTE DO PLANO A
                                    $query = (new \yii\db\Query())->from('db_apl2.planilhamaterial_planima')->where(['planilhadecurso_cod' => $model->placu_codplanilha, 'planima_tipoplano' => 'Plano A', 'planima_tipomaterial' => 'APOSTILAS']);
                                    $totalValorMaterialApostila = $query->sum('planima_valor');

                                    //realiza a soma dos custos de material didático(OUTROS) SOMENTE DO PLANO A
                                    $query = (new \yii\db\Query())->from('db_apl2.planilhamaterial_planima')->where(['planilhadecurso_cod' => $model->placu_codplanilha, 'planima_tipoplano' => 'Plano A'])->andWhere(['<>','planima_tipomaterial', 'LIVROS'])->andWhere(['<>','planima_tipomaterial', 'APOSTILAS']);
                                    $totalValorOutrosMateriais = $query->sum('planima_valor');

                                    //realiza a soma dos custos de materiais de consumo (somatória de Quantidade * Valor de todas as linhas)
                                    $query = (new \yii\db\Query())->from('db_apl2.planilhaconsumo_planico')->where(['planilhadecurso_cod' => $model->placu_codplanilha]);
                                    $totalValorConsumo = $query->sum('planico_valor*planico_quantidade');

                                    //realiza a soma dos custos de material do aluno
                                    $query = (new \yii\db\Query())->from('db_apl2.planilhamaterialaluno_planimatalun')->where(['planilhadecurso_cod' => $model->placu_codplanilha]);
                                    $totalValorAluno = $query->sum('planimatalun_valor*planimatalun_quantidade');

                                    //Somatória Quantidade de Alunos Pagantes, Isentos e PSG
                                    $valorTotalQntAlunos = $model->placu_quantidadealunos + $model->placu_quantidadealunosisentos + $model->placu_quantidadealunospsg;

                                    $model->placu_custosmateriais  = $totalValorMaterialLivro * $valorTotalQntAlunos; //save custo material didático - LIVROS
                                    $model->placu_PJApostila       = $totalValorMaterialApostila * $valorTotalQntAlunos; //save custo material didático - APOSTILAS
                                    $model->placu_outrosmateriais  = $totalValorOutrosMateriais * $valorTotalQntAlunos; //save custo material didático - OUTROS
                                    $model->placu_custosconsumo    = $totalValorConsumo; //save custo material consumo
                                    $model->placu_custosaluno      = ($totalValorAluno * $model->placu_quantidadealunospsg) + 0; //save custo material do aluno

                                    $model->placu_hiddenmaterialdidatico = $totalValorMaterialLivro; //save hidden custo para multiplicação javascript
                                    $model->placu_hiddenpjapostila       = $totalValorMaterialApostila; //save hidden custo para multiplicação javascript
                                    $model->placu_hiddenoutrosmateriais  = $totalValorOutrosMateriais; //save hidden custo para multiplicação javascript
                                    $model->placu_hiddencustosaluno      = $totalValorAluno + 0; //save hidden custo para multiplicação javascript
                                    $model->placu_data                   = date('Y-m-d');
                                    $model->placu_codsituacao            = 1; //Situação Padrão: Em elaboração

                                    //Totalização das Despesas Diretas (Total de Custo Direto)
                                    $model->placu_totalcustodireto = $model->placu_totalsalarioencargo + $model->placu_diarias + $model->placu_passagens + $model->placu_pessoafisica + $model->placu_pessoajuridica + $model->placu_PJApostila + $model->placu_outrosmateriais + $model->placu_custosmateriais + $model->placu_custosconsumo + $model->placu_custosaluno;

                                    //Despesas Indiretas
                                    $model->placu_totalincidencias     = $model->placu_custosindiretos + $model->placu_ipca + $model->placu_reservatecnica + $model->placu_despesadm;
                                    $model->placu_totalcustoindireto   = ($model->placu_totalcustodireto * $model->placu_totalincidencias) / 100;
                                    $model->placu_despesatotal         = $model->placu_totalcustoindireto + $model->placu_totalcustodireto;
                                    $model->placu_markdivisor          = (100 - $model->placu_totalincidencias);
                                    $model->placu_markmultiplicador    = ((100 / $model->placu_markdivisor) - 1) * 100; // Valores em %
                                    $model->placu_vendaturma           = ($model->placu_totalcustodireto / $model->placu_markdivisor) * 100; // Valores em %
                                    $model->placu_vendaaluno           = ($model->placu_vendaturma / $valorTotalQntAlunos);
                                    $model->placu_horaaulaaluno        = $model->placu_vendaturma / $model->placu_cargahorariaplano / $valorTotalQntAlunos; //Venda da Turma / CH TOTAL / QNT Alunos
                                    $model->placu_retorno              = $model->placu_vendaturma - $model->placu_despesatotal; // Preço de venda da turma - Despesa Total;
                                    $model->placu_retornoprecosugerido = ($model->placu_precosugerido * $valorTotalQntAlunos) - $model->placu_despesatotal; // Preço Sugerido x Qnt de Alunos - Despesa  Total;
                                    $model->placu_valorparcelas        =  $model->placu_precosugerido / $model->placu_parcelas;

                                    //SE PREÇO SUGERIRIDO FOR IGUAL A 0, O SISTEMA MOSTRARÁ MINIMO DE ALUNOS E O RETORNO COM PREÇO SUGERIDO
                                    if($model->placu_precosugerido != 0){
                                        $model->placu_minimoaluno          = ceil($model->placu_despesatotal / $model->placu_precosugerido); // Despesa Total / Preço Sugerido;
                                        $model->placu_retornoprecosugerido = ($model->placu_precosugerido * $valorTotalQntAlunos) - $model->placu_despesatotal; // Preço Sugerido x Qnt de Alunos - Despesa  Total;
                                        $model->placu_porcentprecosugerido = $model->placu_vendaturma != 0 ? ($model->placu_retornoprecosugerido / $model->placu_vendaturma) * 100 : 0; // % de Retorno / Preço de venda da Turma -- Valores em %
                                        $model->placu_porcentretorno       = $model->placu_vendaturma != 0 ? ($model->placu_retorno / $model->placu_vendaturma) * 100 : 0;
                                    }else{
                                      $model->placu_minimoaluno          = 0;
                                      $model->placu_porcentprecosugerido = $model->placu_vendaturma != 0 ? ($model->placu_retornoprecosugerido / $model->placu_vendaturma) * 100 : 0; 
                                      $model->placu_porcentretorno       = $model->placu_vendaturma != 0 ? ($model->placu_retorno / $model->placu_vendaturma) * 100 : 0; 
                                    }

                                    $model->save();
                                }
                
                                    Yii::$app->session->setFlash('info', '<strong>SUCESSO! </strong> Planilha '.$id.' Atualizada!</strong>');
                                    return $this->redirect(['update', 'id' => $model->placu_codplanilha]);
                                }
                            } catch (Exception $e) {
                                $transaction->rollBack();
                            }
                        }

            Yii::$app->session->setFlash('info', '<strong>SUCESSO! </strong> Planilha '.$id.' Atualizada!</strong>');

            return $this->redirect(['update', 'id' => $model->placu_codplanilha]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelsPlaniDespDocente'    => (empty($modelsPlaniDespDocente)) ? [new PlanilhaDespesaDocente] : $modelsPlaniDespDocente,
                'modelsPlaniUC'             => (empty($modelsPlaniUC)) ? [new PlanilhaUnidadesCurriculares] : $modelsPlaniUC,
                'modelsPlaniMaterial'       => (empty($modelsPlaniMaterial)) ? [new PlanilhaMaterial] : $modelsPlaniMaterial,
                'modelsPlaniConsumo'        => (empty($modelsPlaniConsumo)) ? [new PlanilhaConsumo] : $modelsPlaniConsumo,
                'modelsPlaniMateriaisAluno' => (empty($modelsPlaniMateriaisAluno)) ? [new PlanilhaMaterialAluno] : $modelsPlaniMateriaisAluno,
                'modelsPlaniEquipamento'    => (empty($modelsPlaniEquipamento)) ? [new PlanilhaEquipamento] : $modelsPlaniEquipamento,
            ]);
        }
    }

    public function actionFinalizar($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update'; //Validações obrigatórias na atualização
        $modelsPlaniUC             = $model->planiUC;
        $modelsPlaniMaterial       = $model->planiMateriais;
        $modelsPlaniConsumo        = $model->planiConsumo;
        $modelsPlaniMateriaisAluno = $model->planiMateriaisAluno;
        $modelsPlaniEquipamento    = $model->planiEquipamento;
        $modelsPlaniDespDocente    = $model->planiDespDocente;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

        //--------Despesas com Docentes--------------
        $oldIDsDespesaDocente = ArrayHelper::map($modelsPlaniDespDocente, 'id', 'id');
        $modelsPlaniDespDocente = Model::createMultiple(PlanilhaDespesaDocente::classname(), $modelsPlaniDespDocente);
        Model::loadMultiple($modelsPlaniDespDocente, Yii::$app->request->post());
        $deletedIDsDespesaDocente = array_diff($oldIDsDespesaDocente, array_filter(ArrayHelper::map($modelsPlaniDespDocente, 'id', 'id')));

        //--------Unidades Curriculares--------------
        $oldIDsUnidadesCurriculares = ArrayHelper::map($modelsPlaniUC, 'id', 'id');
        $modelsPlaniUC = Model::createMultiple(PlanilhaUnidadesCurriculares::classname(), $modelsPlaniUC);
        Model::loadMultiple($modelsPlaniUC, Yii::$app->request->post());
        $deletedIDsUnidadesCurriculares = array_diff($oldIDsUnidadesCurriculares, array_filter(ArrayHelper::map($modelsPlaniUC, 'id', 'id')));

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

        //--------Materiais do Aluno--------------
        $oldIDsMaterialAluno = ArrayHelper::map($modelsPlaniMateriaisAluno, 'id', 'id');
        $modelsPlaniMateriaisAluno = Model::createMultiple(PlanilhaMaterialAluno::classname(), $modelsPlaniMateriaisAluno);
        Model::loadMultiple($modelsPlaniMateriaisAluno, Yii::$app->request->post());
        $deletedIDsMaterialAluno = array_diff($oldIDsMaterialAluno, array_filter(ArrayHelper::map($modelsPlaniMateriaisAluno, 'id', 'id')));

        //--------Equipamentos / Utensílios--------------
        $oldIDsEquipamento = ArrayHelper::map($modelsPlaniEquipamento, 'id', 'id');
        $modelsPlaniEquipamento = Model::createMultiple(PlanilhaEquipamento::classname(), $modelsPlaniEquipamento);
        Model::loadMultiple($modelsPlaniEquipamento, Yii::$app->request->post());
        $deletedIDsEquipamento = array_diff($oldIDsEquipamento, array_filter(ArrayHelper::map($modelsPlaniEquipamento, 'id', 'id')));

        // validate all models
        $valid = $model->validate();
        $valid = (Model::validateMultiple($modelsPlaniDespDocente) || Model::validateMultiple($modelsPlaniUC) || Model::validateMultiple($modelsPlaniMaterial) || Model::validateMultiple($modelsPlaniConsumo) || Model::validateMultiple($modelsPlaniEquipamento) ) && $valid;

                        if ($valid) {
                            $transaction = \Yii::$app->db_apl->beginTransaction();
                            try {
                                if ($flag = $model->save(false)) {

                                    if (! empty($deletedIDsDespesaDocente)) {
                                        PlanilhaDespesaDocente::deleteAll(['id' => $deletedIDsDespesaDocente]);
                                    }
                                    foreach ($modelsPlaniDespDocente as $modelPlaniDespDocente) {
                                        $modelPlaniDespDocente->planilhadecurso_cod = $model->placu_codplanilha;
                                        if (! ($flag = $modelPlaniDespDocente->save(false))) {
                                            $transaction->rollBack();
                                            break;
                                        }
                                    }

                                    if (! empty($deletedIDsUnidadesCurriculares)) {
                                        PlanilhaUnidadesCurriculares::deleteAll(['id' => $deletedIDsUnidadesCurriculares]);
                                    }
                                    foreach ($modelsPlaniUC as $modelPlaniUC) {
                                        $modelPlaniUC->planilhadecurso_cod = $model->placu_codplanilha;
                                        if (! ($flag = $modelPlaniUC->save(false))) {
                                            $transaction->rollBack();
                                            break;
                                        }
                                    }

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

                                    if (! empty($deletedIDsMaterialAluno)) {
                                        PlanilhaMaterialAluno::deleteAll(['id' => $deletedIDsMaterialAluno]);
                                    }
                                    foreach ($modelsPlaniMateriaisAluno as $modelPlaniMateriaisAluno) {
                                        $modelPlaniMateriaisAluno->planilhadecurso_cod = $model->placu_codplanilha;
                                        if (! ($flag = $modelPlaniMateriaisAluno->save(false))) {
                                            $transaction->rollBack();
                                            break;
                                        }
                                    }

                                    if (! empty($deletedIDsEquipamento)) {
                                        PlanilhaEquipamento::deleteAll(['id' => $deletedIDsEquipamento]);
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

                                if($model->save()){

                                    //realiza a soma dos custos de material didático(LIVROS) SOMENTE DO PLANO A
                                    $query = (new \yii\db\Query())->from('db_apl2.planilhamaterial_planima')->where(['planilhadecurso_cod' => $model->placu_codplanilha, 'planima_tipoplano' => 'Plano A', 'planima_tipomaterial' => 'LIVROS']);
                                    $totalValorMaterialLivro = $query->sum('planima_valor');

                                    //realiza a soma dos custos de material didático(APOSTILAS) SOMENTE DO PLANO A
                                    $query = (new \yii\db\Query())->from('db_apl2.planilhamaterial_planima')->where(['planilhadecurso_cod' => $model->placu_codplanilha, 'planima_tipoplano' => 'Plano A', 'planima_tipomaterial' => 'APOSTILAS']);
                                    $totalValorMaterialApostila = $query->sum('planima_valor');

                                    //realiza a soma dos custos de material didático(OUTROS) SOMENTE DO PLANO A
                                    $query = (new \yii\db\Query())->from('db_apl2.planilhamaterial_planima')->where(['planilhadecurso_cod' => $model->placu_codplanilha, 'planima_tipoplano' => 'Plano A'])->andWhere(['<>','planima_tipomaterial', 'LIVROS'])->andWhere(['<>','planima_tipomaterial', 'APOSTILAS']);
                                    $totalValorOutrosMateriais = $query->sum('planima_valor');

                                    //realiza a soma dos custos de materiais de consumo (somatória de Quantidade * Valor de todas as linhas)
                                    $query = (new \yii\db\Query())->from('db_apl2.planilhaconsumo_planico')->where(['planilhadecurso_cod' => $model->placu_codplanilha]);
                                    $totalValorConsumo = $query->sum('planico_valor*planico_quantidade');

                                    //realiza a soma dos custos de material do aluno
                                    $query = (new \yii\db\Query())->from('db_apl2.planilhamaterialaluno_planimatalun')->where(['planilhadecurso_cod' => $model->placu_codplanilha]);
                                    $totalValorAluno = $query->sum('planimatalun_valor*planimatalun_quantidade');

                                    //Somatória Quantidade de Alunos Pagantes, Isentos e PSG 
                                    $valorTotalQntAlunos = $model->placu_quantidadealunos + $model->placu_quantidadealunosisentos + $model->placu_quantidadealunospsg;
                                    
                                    $model->placu_custosmateriais  = $totalValorMaterialLivro * $valorTotalQntAlunos; //save custo material didático - LIVROS
                                    $model->placu_PJApostila       = $totalValorMaterialApostila * $valorTotalQntAlunos; //save custo material didático - APOSTILAS
                                    $model->placu_outrosmateriais  = $totalValorOutrosMateriais * $valorTotalQntAlunos; //save custo material didático - OUTROS
                                    $model->placu_custosconsumo    = $totalValorConsumo; //save custo material consumo
                                    $model->placu_custosaluno      = ($totalValorAluno * $model->placu_quantidadealunospsg) + 0; //save custo material do aluno

                                    $model->placu_hiddenmaterialdidatico = $totalValorMaterialLivro; //save hidden custo para multiplicação javascript
                                    $model->placu_hiddenpjapostila       = $totalValorMaterialApostila; //save hidden custo para multiplicação javascript
                                    $model->placu_hiddenoutrosmateriais  = $totalValorOutrosMateriais; //save hidden custo para multiplicação javascript
                                    $model->placu_hiddencustosaluno      = $totalValorAluno + 0; //save hidden custo para multiplicação javascript
                                    $model->placu_data                   = date('Y-m-d');
                                    $model->placu_codsituacao  = 5; //Atualiza a Planilha para Aguardando Envio Planejamento

                                    //Totalização das Despesas Diretas (Total de Custo Direto)
                                    $model->placu_totalcustodireto = $model->placu_totalsalarioencargo + $model->placu_diarias + $model->placu_passagens + $model->placu_pessoafisica + $model->placu_pessoajuridica + $model->placu_PJApostila + $model->placu_outrosmateriais + $model->placu_custosmateriais + $model->placu_custosconsumo + $model->placu_custosaluno;

                                    //Despesas Indiretas
                                    $model->placu_totalincidencias     = $model->placu_custosindiretos + $model->placu_ipca + $model->placu_reservatecnica + $model->placu_despesadm;
                                    $model->placu_totalcustoindireto   = ($model->placu_totalcustodireto * $model->placu_totalincidencias) / 100;
                                    $model->placu_despesatotal         = $model->placu_totalcustoindireto + $model->placu_totalcustodireto;
                                    $model->placu_markdivisor          = (100 - $model->placu_totalincidencias);
                                    $model->placu_markmultiplicador    = ((100 / $model->placu_markdivisor) - 1) * 100; // Valores em %
                                    $model->placu_vendaturma           = ($model->placu_totalcustodireto / $model->placu_markdivisor) * 100; // Valores em %
                                    $model->placu_vendaaluno           = ($model->placu_vendaturma / $valorTotalQntAlunos);
                                    $model->placu_horaaulaaluno        = $model->placu_vendaturma / $model->placu_cargahorariaplano / $valorTotalQntAlunos; //Venda da Turma / CH TOTAL / QNT Alunos
                                    $model->placu_retorno              = $model->placu_vendaturma - $model->placu_despesatotal; // Preço de venda da turma - Despesa Total;
                                    $model->placu_retornoprecosugerido = ($model->placu_precosugerido * $valorTotalQntAlunos) - $model->placu_despesatotal; // Preço Sugerido x Qnt de Alunos - Despesa  Total;
                                    $model->placu_valorparcelas        =  $model->placu_precosugerido / $model->placu_parcelas;

                                    //SE PREÇO SUGERIRIDO FOR IGUAL A 0, O SISTEMA MOSTRARÁ MINIMO DE ALUNOS E O RETORNO COM PREÇO SUGERIDO
                                    if($model->placu_precosugerido != 0){
                                        $model->placu_minimoaluno          = ceil($model->placu_despesatotal / $model->placu_precosugerido); // Despesa Total / Preço Sugerido;
                                        $model->placu_retornoprecosugerido = ($model->placu_precosugerido * $valorTotalQntAlunos) - $model->placu_despesatotal; // Preço Sugerido x Qnt de Alunos - Despesa  Total;
                                        $model->placu_porcentprecosugerido = $model->placu_vendaturma != 0 ? ($model->placu_retornoprecosugerido / $model->placu_vendaturma) * 100 : 0; // % de Retorno / Preço de venda da Turma -- Valores em %
                                        $model->placu_porcentretorno       = $model->placu_vendaturma != 0 ? ($model->placu_retorno / $model->placu_vendaturma) * 100 : 0;
                                    }else{
                                      $model->placu_minimoaluno          = 0;
                                      $model->placu_porcentprecosugerido = $model->placu_vendaturma != 0 ? ($model->placu_retornoprecosugerido / $model->placu_vendaturma) * 100 : 0; 
                                      $model->placu_porcentretorno       = $model->placu_vendaturma != 0 ? ($model->placu_retorno / $model->placu_vendaturma) * 100 : 0; 
                                    }

                                    $model->save();
                                }
                
                                    Yii::$app->session->setFlash('info', '<strong>SUCESSO! </strong> Planilha '.$id.' Atualizada!</strong>');
                                    return $this->redirect(['index']);
                                }
                            } catch (Exception $e) {
                                $transaction->rollBack();
                            }
                        }

            Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Planilha '.$id.' Atualizada e Aguardando o Envio do Planejamento!</strong>');

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelsPlaniDespDocente'    => (empty($modelsPlaniDespDocente)) ? [new PlanilhaDespesaDocente] : $modelsPlaniDespDocente,
                'modelsPlaniUC'             => (empty($modelsPlaniUC)) ? [new PlanilhaUnidadesCurriculares] : $modelsPlaniUC,
                'modelsPlaniMaterial'       => (empty($modelsPlaniMaterial)) ? [new PlanilhaMaterial] : $modelsPlaniMaterial,
                'modelsPlaniConsumo'        => (empty($modelsPlaniConsumo)) ? [new PlanilhaConsumo] : $modelsPlaniConsumo,
                'modelsPlaniMateriaisAluno' => (empty($modelsPlaniMateriaisAluno)) ? [new PlanilhaMaterialAluno] : $modelsPlaniMateriaisAluno,
                'modelsPlaniEquipamento'    => (empty($modelsPlaniEquipamento)) ? [new PlanilhaEquipamento] : $modelsPlaniEquipamento,
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
        $model = $this->findModel($id);
        //Exclusão de todas as tabelas relacionadas com a planilha
        PlanilhaDespesaDocente::deleteAll('planilhadecurso_cod = "'.$id.'"');
        PlanilhaUnidadesCurriculares::deleteAll('planilhadecurso_cod = "'.$id.'"');
        PlanilhaMaterial::deleteAll('planilhadecurso_cod = "'.$id.'"');
        PlanilhaConsumo::deleteAll('planilhadecurso_cod = "'.$id.'"');
        PlanilhaMaterialAluno::deleteAll('planilhadecurso_cod = "'.$id.'"');
        PlanilhaEquipamento::deleteAll('planilhadecurso_cod = "'.$id.'"');
        PlanilhaJustificativas::deleteAll('planilhadecurso_id = "'.$id.'"');
        $model->delete(); //Exclui a planilha

        Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Planilha de Curso de código: ' . '<strong>' .$id. '</strong>' . ' excluída!');

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
            throw new NotFoundHttpException('A página solicitada não existe.');
        }
    }

    public function AccessAllow()
    {
        $session = Yii::$app->session;
        if (!isset($session['sess_codusuario']) && !isset($session['sess_codcolaborador']) && !isset($session['sess_codunidade']) && !isset($session['sess_nomeusuario']) && !isset($session['sess_coddepartamento']) && !isset($session['sess_codcargo']) && !isset($session['sess_cargo']) && !isset($session['sess_setor']) && !isset($session['sess_unidade']) && !isset($session['sess_responsavelsetor'])) 
        {
           return $this->redirect('https://portalsenac.am.senac.br');
        }
    }
}