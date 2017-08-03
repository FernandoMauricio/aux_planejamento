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
                        <i class="glyphicon glyphicon-star-empty"></i> O que há de novo? - Versão 1.8 - Publicado em 03/08/2017
            </div>
                    <div class="panel-body">
                      <h4><strong style="color: #337ab7;">Implementações</strong></h4>
                        <h5><i class="glyphicon glyphicon-tag"></i><strong> Markup</strong></h5>
                                <h5>- Markup passará a permitir unidades móveis com custo 0.</h5>
                        <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilha de Curso</strong></h5>
                                <h5>- Despesas com docentes agora podem ter custo 0.</h5>
                                <h5>- Agora é permitido que o "Preço de Venda" seja igual a 0.</h5><br>
                                
                      <h4><strong style="color: #337ab7;">Correções</strong></h4>
                        <h5><i class="glyphicon glyphicon-tag"></i><strong> Custos da Unidade</strong></h5>
                                <h5>- Correção de bug que não estava deletando os itens no cadastro de custos da unidade.</h5>
                        <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilha de Curso</strong></h5>
                                <h5>- Somente aparecerão planos ativos na listagem de planos.</h5>
                        <h5><i class="glyphicon glyphicon-tag"></i><strong> Relatórios</strong></h5>
                                <h5>- Corrigido valores da coluna "Taxa de Retorno" do Relatório Geral.</h5><br>

                                <p><a href="index.php?r=site/versao" class="btn btn-warning" role="button">Histórico de Versões</a></p>
                    </div>
            </div>
</div>
