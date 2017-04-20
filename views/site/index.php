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
                        <i class="glyphicon glyphicon-star-empty"></i> O que há de novo? - Versão 1.3 - Publicado em 20/04/2017
            </div>

                    <div class="panel-body">
                      <h4><strong style="color: #337ab7;">Implementações</strong></h4>
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Cadastros de Planos</strong></h5>
                                   <h5>- Ação para imprimir materiais do aluno (apenas descrição e quantidade) nos planos.</h5>
                                   <h5>- Inserido botão de "adicionar item" tanto em cima do formulário quanto em baixo para o cadastro de itens do plano (materiais de consumo, didáticos, aluno e estruturas...).</h5>

                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Cadastros de Materiais do Aluno</strong></h5>
                                   <h5>- Cadastro de Materiais do aluno poderá ser importado do MXM.</h5>

                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Cadastros de Centro de Custo</strong></h5>
                                   <h5>- Atualização automática das descrições de Centros de Custos ao criar um novo registro.</h5>

                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Relatórios</strong></h5>
                                   <h5>- Inclusão do Relatório Orçamentário.</h5>
                                   <h5>- Agora no Relatório Geral é informado o ano do Curso para Planilhas cadastradas para anos anteriores.</h5><br>

                      <h4><strong style="color: #337ab7;">Correções</strong></h4>
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Cadastro de Planilhas</strong></h5>
                                    <h5>- Alterações nos cálculos de encargos das planilhas em acordo com o GGP.</h5>
                                    <h5>- Material do aluno inserido na planilha agora é multiplicado somente pela quantidade de alunos PSG.</h5>
                    </div>
            </div>

</div>
