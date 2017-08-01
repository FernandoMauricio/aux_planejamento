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
                        <i class="glyphicon glyphicon-star-empty"></i> O que há de novo? - Versão 1.7 - Publicado em 01/08/2017
            </div>
                    <div class="panel-body">
                      <h4><strong style="color: #337ab7;">Implementações</strong></h4>
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilha de Precificação</strong></h5>
                                <h5>- Opção para EXCLUIR planilhas de precificação.</h5>
                                <h5>- Códigos dos Planos agora são visívies nas planilhas de precificações.</h5>
                                <h5>- Incluído um campo chamado "Valor com Desconto".</h5>
                                <h5>- Incluido um checkbox para que se marcado, realize descontos de 30% com relação ao "Preço Sugerido" e informe no campo "Valor com Desconto".</h5>
                                <h5>- Incluido nova coluna chamada "Preço de Venda" na aba "Preço de Venda por Unidade" para informar o preço de venda para todas as unidades.</h5>
                      <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilha de Curso</strong></h5>
                                <h5>- Incluído cores nas informações das colunas de "Planejamento" e "Produtividade" para destacar os cálculos que serão realizados para "Mão de Obra Direta" e "Outras Desp. Variáveis".</h5><br>
                                
                      <h4><strong style="color: #337ab7;">Correções</strong></h4>
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilha de Precificação</strong></h5>
                                <h5>- Correções no cálculo de valor hora aula.</h5><br>
                                
                                <p><a href="index.php?r=site/versao" class="btn btn-warning" role="button">Histórico de Versões</a></p>
                    </div>
            </div>

</div>
