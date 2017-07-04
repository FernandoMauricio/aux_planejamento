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
                        <i class="glyphicon glyphicon-star-empty"></i> O que há de novo? - Versão 1.5 - Publicado em 04/07/2017
            </div>
                    <div class="panel-body">
                      <h4><strong style="color: #337ab7;">Implementações</strong></h4>
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Relatórios PAAR</strong></h5>
                                   <h5>Novos relatórios do PAAR foram incluídos: </h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Receita x Despesa por Unidade</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Receita x Segmento x Tipo Ação</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Listagem de Cursos Previstos</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Matrículas por Segmento e Tipo de Ação</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Matrículas PSG por Segmento</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Quantidade Hora Aluno por Segmento</h5>
                                <h4 style="color: #d35400;"><i>Para visualizar detalhes de Versões Anteriores, clique abaixo:</i></h4>
                                <p><a href="index.php?r=site/versao" class="btn btn-warning" role="button">Histórico de Versões</a></p>
                    </div>
            </div>

</div>
