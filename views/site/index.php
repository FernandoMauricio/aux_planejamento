<?php

/* @var $this yii\web\View */

$this->title = 'Auxílio ao Planejamento';
$session = Yii::$app->session;
$nome_user    = $session['sess_nomeusuario'];
?>

<div class="site-index">
    <h1 class="text-center"> Auxílio ao Planejamento</h1>
    <div class="body-content">
        <div class="container">
            <h3>Bem vindo(a), <?php echo $nome_user = utf8_encode(ucwords(strtolower($nome_user)))?>!</h3>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-star-empty"></i> O que há de novo? - Versão 3.1 - Publicado em 11/05/2021
        </div>
        <div class="panel-body">
            <h4><strong style="color: #337ab7;">Implementações</strong></h4>
            <h5><i class="glyphicon glyphicon-tag"></i><strong> Relatório Geral – Modelo 1</strong></h5>
                <h5>- Incluído informações sobre campos como: <strong style="color: #27ae60;">Novo Modelo Pedagógico, Ano Início da turma, Turmas (EAD, Remoto, Presencial)</strong>.</h5><br />

            <h5><i class="glyphicon glyphicon-tag"></i><strong>Relatório PAAR Excel</strong></h5>
                <h5>- Inserido a filtragem por  <strong style="color: #3498db;">ano orçamentário</strong>.</h5>
                <h5>- Incluído colunas na extração em excel dos campos <strong style="color: #27ae60;">Novo Modelo Pedagógico, Ano Início da turma, Turmas (EAD, Remoto, Presencial)</strong>.</h5><br />


            <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilha de Curso</strong></h5>
                <h5>- Incluído campo para informar se a planilha será <strong style="color: #27ae60;">Escola Interativa</strong>.</h5>
                <h5>- Incluído campo para informar quantas turmas serão <strong style="color: #27ae60;">presenciais, EAD ou remotas</strong>.</h5>
                <h5>- Incluído pesquisa na listagem de planilhas sobre o <strong style="color: #27ae60;">Novo Modelo Pedagógico</strong>.</h5><br>

            <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilha de Precificação</strong></h5>
                <h5>- Adicionado campo EAD para as planilhas de precificação </h5>
                <h5>- Adicionado a informação para cursos EAD cujo valor tenderá a 0.</h5><br>

            <p><a href="index.php?r=site/versao" class="btn btn-warning" role="button">Histórico de Versões</a></p>

        </div>
    </div>
</div>
