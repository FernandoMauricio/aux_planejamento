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
                        <i class="glyphicon glyphicon-star-empty"></i> O que há de novo? - Versão 1.6 - Publicado em 21/07/2017
            </div>
                    <div class="panel-body">
                      <h4><strong style="color: #337ab7;">Implementações</strong></h4>
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Relatórios PAAR</strong></h5>
                                   <h5>- Ordem alfabética dos tipos de relatórios do PAAR </h5>
                                   <h5>- Novos relatórios do PAAR foram incluídos: </h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Carga Horária Aluno por Eixos Tecnológicos</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Carga Horária Aluno por Segmento</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Carga Horária Aluno por Ações de Educação Profissional</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Carga Horária Aluno por Ações Extensivas</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Carga Horária Aluno por Unidade</h5><br>
                                   
                      <h4><strong style="color: #337ab7;">Correções</strong></h4>
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilha de Precificação</strong></h5>
                                   <h5>- Alterações de nomeclatura dos campos:</h5>
                                    <h5>&nbsp;&nbsp;&nbsp;&nbsp;- <strong style="color: red;">"Preço sugerido"</strong> => <strong style="color: green;">"Preço de venda"</strong></h5>
                                    <h5>&nbsp;&nbsp;&nbsp;&nbsp;- <strong style="color: red;">"Preço de venda total por aluno"</strong> => <strong style="color: green;">"Preço sugerido pela planilha"</strong></h5><br>
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilha de Curso</strong></h5>
                                   <h5>- Inclusão do campo: "Orçamento" (será um campo para incluir o ano orçamentário, onde os relatórios se basearão)</h5>
                                   <h5>- Alterações de nomeclatura dos campos:</h5>
                                    <h5>&nbsp;&nbsp;&nbsp;&nbsp;- <strong style="color: red;">"Ano da planilha"</strong> => <strong style="color: green;">"Início da Turma"</strong></h5>
                                <p><a href="index.php?r=site/versao" class="btn btn-warning" role="button">Histórico de Versões</a></p>
                    </div>
            </div>

</div>
