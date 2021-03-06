<?php

namespace app\controllers\planilhas;

use Yii;
use app\models\base\Unidade;
use app\models\despesas\Markup;
use app\models\despesas\MarkupSearch;
use app\models\despesas\Despesasdocente;
use app\models\despesas\Custosunidade;
use app\models\planos\Planodeacao;
use app\models\planilhas\PrecificacaoUnidades;
use app\models\planilhas\Precificacao;
use app\models\planilhas\PrecificacaoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use kartik\mpdf\Pdf;
//use mPDF;

/**
 * PrecificacaoController implements the CRUD actions for Precificacao model.
 */
class PrecificacaoController extends Controller
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

    public function actionGerarPrecificacao()
    {
        $model = new Precificacao();

        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['create']);
        }
        return $this->renderAjax('gerar-precificacao', [
            'model' => $model,
        ]);
    }

    public function actionRecalcularPlanilha($id)
    {
        $session = Yii::$app->session;
        $model = $this->findModel($id);
        $model->planp_valorhoraaula = $model->despesasdocente->doce_valorhoraaula;
        $model->planp_codcolaboradoratualizacao = $session['sess_codcolaborador'];
        $model->planp_dataatualizacao = date('Y-m-d');

        //realiza a soma dos custos de material didático(OUTROS) SOMENTE DO PLANO A - Implementação do campo após planilhas já criadas
        $query = (new \yii\db\Query())->from('db_apl2.planomaterial_plama')->where(['plama_codplano' => $model->planp_planodeacao, 'plama_tipoplano' => 'Plano A'])->andWhere(['<>','plama_tipomaterial', 'LIVROS'])->andWhere(['<>','plama_tipomaterial', 'APOSTILAS']);
        $totalValorMaterialOutros = $query->sum('plama_valor');

        $model->planp_outrosmateriais = ($totalValorMaterialOutros + 0) * $model->planp_qntaluno; //save custo material didático - OUTROS

        //CÁLCULOS REALIZADOS - SEÇÃO 2
        $model->planp_totalcustodocente = ($model->planp_totalhorasdocente * $model->planp_valorhoraaula) + $model->planp_servpedagogico;
        $model->planp_decimo = $model->planp_totalcustodocente / ($model->planp_mesesdocurso * 12);
        $model->planp_ferias = $model->planp_decimo;
        $model->planp_tercoferias = $model->planp_ferias / 3;
        $model->planp_totalsalario = $model->planp_totalcustodocente + $model->planp_decimo + $model->planp_ferias + $model->planp_tercoferias;
        $model->planp_totalencargos = ($model->planp_totalsalario * $model->planp_encargos) / 100;
        $model->planp_totalsalarioencargo = $model->planp_totalencargos + $model->planp_totalsalario ;
        $model->planp_totalcustodireto = $model->planp_totalsalarioencargo + $model->planp_diarias + $model->planp_passagens + $model->planp_pessoafisica + $model->planp_pessoajuridica + $model->planp_PJApostila + $model->planp_outrosmateriais + $model->planp_custosmateriais + $model->planp_custosconsumo;
        $model->planp_totalhoraaulacustodireto = $model->planp_totalcustodireto / $model->planp_cargahoraria / $model->planp_qntaluno;

        //CÁLCULOS REALIZADOS - SEÇÃO 3
        $model->planp_totalincidencias = $model->planp_custosindiretos + $model->planp_ipca + $model->planp_reservatecnica + $model->planp_despesadm;
        $model->planp_totalcustoindireto = ($model->planp_totalcustodireto * $model->planp_totalincidencias) / 100;
        $model->planp_despesatotal = $model->planp_totalcustoindireto + $model->planp_totalcustodireto;
        $model->planp_markdivisor = (100 - $model->planp_totalincidencias);
        $model->planp_markmultiplicador = ((100 / $model->planp_markdivisor) - 1) * 100;
        $model->planp_vendaturma = ($model->planp_totalcustodireto / $model->planp_markdivisor) * 100;
        $model->planp_vendaaluno = $model->planp_vendaturma / $model->planp_qntaluno;
        $model->planp_horaaulaaluno = $model->planp_vendaturma / $model->planp_cargahoraria / $model->planp_qntaluno;
        $model->planp_retorno = $model->planp_vendaturma - $model->planp_despesatotal;
        $model->planp_porcentretorno = ($model->planp_retorno / $model->planp_despesatotal) * 100;
        $model->planp_retornoprecosugerido = ($model->planp_precosugerido * $model->planp_qntaluno) - $model->planp_despesatotal;
        $model->planp_porcentretornosugerido = ($model->planp_retornoprecosugerido /$model->planp_despesatotal) * 100;// % de Retorno / Despesa Total -- Valores em %
        $model->planp_minimoaluno = ceil($model->planp_despesatotal / $model->planp_precosugerido);
        $model->planp_valorparcelas = $model->planp_precosugerido / $model->planp_parcelas;
        $model->planp_reservatecnica = $model->planp_cargahoraria >= 800 ? 8 : 3;//Reserva Técnica = CH do Plano >= 800  == 8% senão == 3%;
        $model->planp_valorcomdesconto = $model->planp_precosugerido - (($model->planp_precosugerido * $model->planp_desconto) / 100);//Aplicação do Desconto em cima do Preço Sugerido

        //CÁLCULOS DOS MUNICÍPIOS DO INTERIOR
        $model->planp_retornoprecosugeridointerior = ($model->planp_valorcomdesconto * $model->planp_qntaluno) - $model->planp_despesatotal;
        $model->planp_vendaturmasugeridointerior = $model->planp_valorcomdesconto * $model->planp_qntaluno;
        $model->planp_porcentretornosugeridointerior = ($model->planp_retornoprecosugeridointerior /$model->planp_despesatotal) * 100;
        $model->planp_minimoalunointerior = ceil($model->planp_despesatotal / $model->planp_valorcomdesconto);

        if($model->planp_parcelasinterior != NULL ) {
            $model->planp_valorparcelasinterior = $model->planp_valorcomdesconto / $model->planp_parcelasinterior;
        }

        $model->save();

        if($model->save()) {

            //SE A UNIDADE FOR FATESE OS ENCARGOS SERÃO 32.7
            $model->planp_encargos = $model->planp_codunidade == 30 ? $model->planp_encargos = 32.70 : $model->planp_encargos = 33.29;

            //Localiza as unidades configuradas pelo MARKUP
            $listagemUnidades = "SELECT * FROM markup_mark WHERE mark_tipo = 1";
            $unidadesMarkup = Markup::findBySql($listagemUnidades)->all();

            foreach ($unidadesMarkup as $unidadeMarkup) {

                $mark_codunidade = $unidadeMarkup['mark_codunidade'];
                $mark_divisor    = $unidadeMarkup['mark_divisor'];

                $PrecoVendaTurma    = ($model->planp_totalcustodireto / $mark_divisor) * 100; // Valores em % -> Preço de Venda = Total Custo Direto / Markup Divisor
                $PrecoVendaAluno    = $PrecoVendaTurma / $model->planp_qntaluno; //Preço de Venda da Turma / QNT Alunos
                $ValorHoraAulaAluno = $PrecoVendaTurma / $model->planp_cargahoraria / $model->planp_qntaluno; //Preço de Venda da Turma / CH TOTAL / QNT Alunos

                $command = Yii::$app->db_apl->createCommand();
                $command->update('db_apl2.precificacao_unidades', array('uprec_codunidade'=>$mark_codunidade, 'precificacao_id' => $model->planp_id, 'uprec_cargahoraria' => $model->planp_cargahoraria, 'uprec_qntaluno' => $model->planp_qntaluno, 'uprec_totalcustodireto' => $model->planp_totalcustodireto, 'uprec_vendaturma' => $PrecoVendaTurma, 'uprec_vendaaluno' => $PrecoVendaAluno, 'uprec_horaaula' => $ValorHoraAulaAluno), array('precificacao_id' => $model->planp_id, 'uprec_codunidade'=>$mark_codunidade));
                $command->execute();
            }
        }

        Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Valores atualizados!</strong>');

        return $this->redirect(['view', 'id' => $model->planp_id]);

    }
    /**
     * Lists all Precificacao models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PrecificacaoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDuvidas()
    {
        return $this->renderAjax('duvidas');
    }

    public function actionImprimir($id) {

            $model = $this->findModel($id);
            
             //Corrigir bug do CentOS
             \yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
             \yii::$app->response->headers->add('Content-Type', 'application/pdf');


            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
                'format' => Pdf::FORMAT_A4,
                'content' => $this->renderPartial('imprimir', ['model' => $model]),
                'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
                'cssInline'=> '.kv-heading-1{font-size:18px}',
                'defaultFontSize' => '6px',
                'options' => [
                    'title' => 'Divisão Financeira - DIF',
                ],
                'methods' => [
                    'SetHeader' => ['DETALHES DA PRECIFICAÇÃO DE CUSTO - SENAC AM||Gerado em: ' . date("d/m/Y - H:i:s")],
                    'SetFooter' => ['Divisão Financeira - DIF||Página {PAGENO}'],
                ]
            ]);

        return $pdf->render('imprimir', [
            'model' => $model,

        ]);
        }

    /**
     * Displays a single Precificacao model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    //Localiza a despesa vinculada ao Plano
    public function actionDespesasdocente() {
                $out = [];
                if (isset($_POST['depdrop_parents'])) {
                    $parents = $_POST['depdrop_parents'];
                    if ($parents != null) {
                        $cat_id = $parents[0];
                        $out = Despesasdocente::getDespesasdocenteSubCat($cat_id);
                        echo Json::encode(['output'=>$out, 'selected'=>'']);
                        return;
                    }
                }
                echo Json::encode(['output'=>'', 'selected'=>'']);
            }

    //Localiza os dados de custos indiretos da unidade escolhida
    public function actionGetMarkup($markup){

        $getmarkup = Markup::find()->where(['mark_codunidade' => $markup])->one();

        echo Json::encode($getmarkup);
    }


    //Localiza os dados do Plano
    public function actionGetPlano($plano){

        $getPlano = Planodeacao::find()->where(['plan_codplano' => $plano])->one();

        echo Json::encode($getPlano);
    }

    //Localiza os dados de nível de docente
    public function actionGetNivelDocente($niveldocente){

        $getnivelDocente = Despesasdocente::find()->where(['doce_id' => $niveldocente])->one();

        echo Json::encode($getnivelDocente);
    }

    /**
     * Creates a new Precificacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session = Yii::$app->session;

        $model = new Precificacao();
        $precificacaoUnidades = new PrecificacaoUnidades();

        //$model->planp_ead = $_GET['planp_ead']; //tipo de curso

        $sourceMarkup = new MarkupSearch();
        $dataProvider = $sourceMarkup->search(Yii::$app->request->getQueryParams());
        $markups      = $dataProvider->getModels();

        $planos       = Planodeacao::find()->where(['plan_status' => 1])->orderBy('plan_descricao')->all();
        $unidades     = Unidade::find()->where(['uni_codsituacao' => 1, 'uni_coddisp' => 1])->orderBy('uni_nomeabreviado')->all();
        $nivelDocente = Despesasdocente::find()->where(['doce_status' => 1])->all();

        $model->planp_ano              = date('Y') + 1; //2020
        $model->planp_data             = date('Y-m-d');
        $model->planp_codcolaborador   = $session['sess_codcolaborador'];
        $model->planp_valorcomdesconto = 0;
        $model->planp_desconto = 30; //Padrão de desconto

        //Realiza a Verificação se as configurações estão atualizadas do Markup
        foreach ($markups as $markup) {
                    if($markup->mark_ano != date('Y')){
                         Yii::$app->session->setFlash('danger', "As Configurações de Markup estão configuradas para o ano de <strong>" .$markup->mark_ano. "</strong>. Por gentileza, atualize as informações para o ano corrente(" .date('Y').") na tela de Configuração de Markup.<strong> clicando aqui</strong>!" );

                         return $this->render('create', [
                            'model' => $model,
                            'precificacaoUnidades' => $precificacaoUnidades,
                            'planos' => $planos,
                            'unidades' => $unidades,
                            'nivelDocente' => $nivelDocente,
                        ]);
                    }else{
                        Yii::$app->session->removeFlash('danger',null);
                    }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

        //Realiza a Verificação se as configurações estão atualizadas do Markup
        foreach ($markups as $markup) {
                    if($markup->mark_ano != date('Y')){
                         Yii::$app->session->setFlash('danger', "As Configurações de Markup estão configuradas para o ano de <strong>" .$markup->mark_ano. "</strong>. Por gentileza, atualize as informações para o ano corrente(" .date('Y').") na tela de Configuração de Markup.<strong> clicando aqui</strong>!" );
                    }else{
                        Yii::$app->session->removeFlash('danger',null);
                    }
        }

            if($model->save()){

                $model->planp_totalcustodireto = $model->planp_totalsalarioencargo + $model->planp_diarias + $model->planp_passagens + $model->planp_pessoafisica + $model->planp_pessoajuridica + $model->planp_PJApostila + $model->planp_outrosmateriais + $model->planp_custosmateriais + $model->planp_custosconsumo;

                //SE A UNIDADE FOR FATESE OS ENCARGOS SERÃO 32.7
                $model->planp_encargos = $model->planp_codunidade == 30 ? $model->planp_encargos = 32.70 : $model->planp_encargos = 32.99;

                //Localiza as unidades configuradas pelo MARKUP
                $listagemUnidades = "SELECT * FROM markup_mark WHERE mark_tipo = 1";
                $unidadesMarkup = Markup::findBySql($listagemUnidades)->all();

                foreach ($unidadesMarkup as $unidadeMarkup) {

                    $mark_codunidade = $unidadeMarkup['mark_codunidade'];
                    $mark_divisor    = $unidadeMarkup['mark_divisor'];

                    $PrecoVendaTurma    = ($model->planp_totalcustodireto / $mark_divisor) * 100; // Valores em % -> Preço de Venda = Total Custo Direto / Markup Divisor
                    $PrecoVendaAluno    = $PrecoVendaTurma / $model->planp_qntaluno; //Preço de Venda da Turma / QNT Alunos
                    $ValorHoraAulaAluno = $PrecoVendaTurma / $model->planp_cargahoraria / $model->planp_qntaluno; //Preço de Venda da Turma / CH TOTAL / QNT Alunos

                    $command = Yii::$app->db_apl->createCommand();
                    $command->insert('db_apl2.precificacao_unidades', array('uprec_codunidade'=>$mark_codunidade, 'precificacao_id' => $model->planp_id, 'uprec_cargahoraria' => $model->planp_cargahoraria, 'uprec_qntaluno' => $model->planp_qntaluno, 'uprec_totalcustodireto' => $model->planp_totalcustodireto, 'uprec_vendaturma' => $PrecoVendaTurma, 'uprec_vendaaluno' => $PrecoVendaAluno, 'uprec_horaaula' => $ValorHoraAulaAluno));
                    $command->execute();

                    }

                    $precificacaoUnidades->save();
                }

                Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Precificação de Custo criada!</strong>');

            return $this->redirect(['view', 'id' => $model->planp_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'precificacaoUnidades' => $precificacaoUnidades,
                'planos' => $planos,
                'unidades' => $unidades,
                'nivelDocente' => $nivelDocente,
            ]);
        }
    }

    /**
     * Updates an existing Precificacao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $session = Yii::$app->session;

        $model = $this->findModel($id);
        $precificacaoUnidades = new PrecificacaoUnidades();

        $sourceMarkup = new MarkupSearch();
        $dataProvider = $sourceMarkup->search(Yii::$app->request->getQueryParams());
        $markups      = $dataProvider->getModels();

        $planos       = Planodeacao::find()->where(['plan_status' => 1])->orderBy('plan_descricao')->all();
        $unidades     = Unidade::find()->where(['uni_codsituacao' => 1, 'uni_coddisp' => 1])->orderBy('uni_nomeabreviado')->all();
        $nivelDocente = Despesasdocente::find()->where(['doce_status' => 1])->all();

        $model->planp_data           = date('Y-m-d');
        $model->planp_codcolaborador = $session['sess_codcolaborador'];

        //Realiza a Verificação se as configurações estão atualizadas do Markup
        foreach ($markups as $markup) {
                    if($markup->mark_ano != date('Y')){
                         Yii::$app->session->setFlash('danger', "As Configurações de Markup estão configuradas para o ano de <strong>" .$markup->mark_ano. "</strong>. Por gentileza, atualize as informações para o ano corrente(" .date('Y').") na tela de Configuração de Markup.<strong> clicando aqui</strong>!" );

                         return $this->render('update', [
                            'model' => $model,
                            'precificacaoUnidades' => $precificacaoUnidades,
                            'planos' => $planos,
                            'unidades' => $unidades,
                            'nivelDocente' => $nivelDocente,
                        ]);
                    }else{
                        Yii::$app->session->removeFlash('danger',null);
                    }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

      //CÁLCULOS REALIZADOS - SEÇÃO 2
        $model->planp_totalcustodocente = ($model->planp_totalhorasdocente * $model->planp_valorhoraaula) + $model->planp_servpedagogico;
        $model->planp_decimo = $model->planp_totalcustodocente / ($model->planp_mesesdocurso * 12);
        $model->planp_ferias = $model->planp_decimo;
        $model->planp_tercoferias = $model->planp_ferias / 3;
        $model->planp_totalsalario = $model->planp_totalcustodocente + $model->planp_decimo + $model->planp_ferias + $model->planp_tercoferias;
        $model->planp_totalencargos = ($model->planp_totalsalario * $model->planp_encargos) / 100;
        $model->planp_totalsalarioencargo = $model->planp_totalencargos + $model->planp_totalsalario ;
        $model->planp_totalcustodireto = $model->planp_totalsalarioencargo + $model->planp_diarias + $model->planp_passagens + $model->planp_pessoafisica + $model->planp_pessoajuridica + $model->planp_PJApostila + $model->planp_outrosmateriais + $model->planp_custosmateriais + $model->planp_custosconsumo;
        $model->planp_totalhoraaulacustodireto = $model->planp_totalcustodireto / $model->planp_cargahoraria / $model->planp_qntaluno;

      //CÁLCULOS REALIZADOS - SEÇÃO 3
        $model->planp_totalincidencias = $model->planp_custosindiretos + $model->planp_ipca + $model->planp_reservatecnica + $model->planp_despesadm;
        $model->planp_totalcustoindireto = ($model->planp_totalcustodireto * $model->planp_totalincidencias) / 100;
        $model->planp_despesatotal = $model->planp_totalcustoindireto + $model->planp_totalcustodireto;
        $model->planp_markdivisor = (100 - $model->planp_totalincidencias);
        $model->planp_markmultiplicador = ((100 / $model->planp_markdivisor) - 1) * 100;
        $model->planp_vendaturma = ($model->planp_totalcustodireto / $model->planp_markdivisor) * 100;
        $model->planp_vendaaluno = $model->planp_vendaturma / $model->planp_qntaluno;
        $model->planp_horaaulaaluno = $model->planp_vendaturma / $model->planp_cargahoraria / $model->planp_qntaluno;
        $model->planp_retorno = $model->planp_vendaturma - $model->planp_despesatotal;
        $model->planp_porcentretorno = ($model->planp_retorno / $model->planp_despesatotal) * 100;
        $model->planp_retornoprecosugerido = ($model->planp_precosugerido * $model->planp_qntaluno) - $model->planp_despesatotal;
        $model->planp_porcentretornosugerido = ($model->planp_retornoprecosugerido /$model->planp_despesatotal) * 100;// % de Retorno / Despesa Total -- Valores em %
        $model->planp_minimoaluno = ceil($model->planp_despesatotal / $model->planp_precosugerido);
        $model->planp_valorparcelas = $model->planp_precosugerido / $model->planp_parcelas;
        $model->planp_reservatecnica = $model->planp_cargahoraria >= 800 ? 8 : 3;//Reserva Técnica = CH do Plano >= 800  == 8% senão == 3%;
        $model->planp_valorcomdesconto = $model->planp_precosugerido - (($model->planp_precosugerido * $model->planp_desconto) / 100);//Aplicação do Desconto em cima do Preço Sugerido
        $model->save();

        //Realiza a Verificação se as configurações estão atualizadas do Markup
        foreach ($markups as $markup) {
                    if($markup->mark_ano != date('Y')){
                         Yii::$app->session->setFlash('danger', "As Configurações de Markup estão configuradas para o ano de <strong>" .$markup->mark_ano. "</strong>. Por gentileza, atualize as informações para o ano corrente(" .date('Y').") na tela de Configuração de Markup.<strong> clicando aqui</strong>!" );
                    }else{
                        Yii::$app->session->removeFlash('danger',null);
                    }
        }

            if($model->save()){

                // $model->planp_totalcustodireto = $model->planp_totalsalarioencargo + $model->planp_diarias + $model->planp_passagens + $model->planp_pessoafisica + $model->planp_pessoajuridica + $model->planp_PJApostila + $model->planp_outrosmateriais + $model->planp_custosmateriais + $model->planp_custosconsumo;

                //SE A UNIDADE FOR FATESE OS ENCARGOS SERÃO 32.7
                $model->planp_encargos = $model->planp_codunidade == 30 ? $model->planp_encargos = 32.70 : $model->planp_encargos = 33.29;

                //Localiza as unidades configuradas pelo MARKUP
                $listagemUnidades = "SELECT * FROM markup_mark WHERE mark_tipo = 1";
                $unidadesMarkup = Markup::findBySql($listagemUnidades)->all();

                foreach ($unidadesMarkup as $unidadeMarkup) {

                    $mark_codunidade = $unidadeMarkup['mark_codunidade'];
                    $mark_divisor    = $unidadeMarkup['mark_divisor'];

                    $PrecoVendaTurma    = ($model->planp_totalcustodireto / $mark_divisor) * 100; // Valores em % -> Preço de Venda = Total Custo Direto / Markup Divisor
                    $PrecoVendaAluno    = $PrecoVendaTurma / $model->planp_qntaluno; //Preço de Venda da Turma / QNT Alunos
                    $ValorHoraAulaAluno = $PrecoVendaTurma / $model->planp_cargahoraria / $model->planp_qntaluno; //Preço de Venda da Turma / CH TOTAL / QNT Alunos

                    $command = Yii::$app->db_apl->createCommand();
                    $command->update('db_apl2.precificacao_unidades', array('uprec_codunidade'=>$mark_codunidade, 'precificacao_id' => $model->planp_id, 'uprec_cargahoraria' => $model->planp_cargahoraria, 'uprec_qntaluno' => $model->planp_qntaluno, 'uprec_totalcustodireto' => $model->planp_totalcustodireto, 'uprec_vendaturma' => $PrecoVendaTurma, 'uprec_vendaaluno' => $PrecoVendaAluno, 'uprec_horaaula' => $ValorHoraAulaAluno), array('precificacao_id' => $model->planp_id, 'uprec_codunidade'=>$mark_codunidade));
                    $command->execute();

                    }

                    $precificacaoUnidades->save();
                }

            return $this->redirect(['view', 'id' => $model->planp_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'planos' => $planos,
                'unidades' => $unidades,
                'nivelDocente' => $nivelDocente,
            ]);
        }
    }

    /**
     * Deletes an existing Precificacao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        PrecificacaoUnidades::deleteAll('precificacao_id = "'.$id.'"');
        $model->delete(); //Exclui a planilha

        Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Precificação de Custo excluida!</strong>');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Precificacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Precificacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Precificacao::findOne($id)) !== null) {
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