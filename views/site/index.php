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
                        <i class="glyphicon glyphicon-star-empty"></i> O que há de novo? - Versão 1.2 - Publicado em 08/03/2017
            </div>

                    <div class="panel-body">
                      <h4><strong style="color: #337ab7;">Implementações</strong></h4>
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Cadastros de Planos</strong></h5>
                                   <h5>- Incluido o botão <strong>IMPRIMIR</strong> para planilhas de curso.</h5>
                                   <h5>- Alterado tipo de dado da quantidade de materiais de consumo no cadastrado do <strong>PLANO</strong> para permitir números reais (0.3 / 2.4 / 1.6 ...).</h5>

                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Cadastros de Planilhas</strong></h5>
                                   <h5>- Incluido regra para que não seja permitido criação de planilhas para PSG com <strong style="color: red;"> CH inferior a 40 horas</strong>.</h5>
                                   <h5>- Alterado tipo de dado da quantidade de materiais de consumo no cadastrado da <strong>PLANILHA</strong> para permitir números reais (0.3 / 2.4 / 1.6 ...).</h5><br>

                      <h4><strong style="color: #337ab7;">Correções</strong></h4>
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Cadastros de Planos</strong></h5>
                                    <h5>- Corrigido problema ao gerar relatório geral de todas as unidades.</h5>
                                    <h5>- Corrigido campos de valores monetários e quantitativos para padrão brasileiro no Relatório Geral.</h5>

                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Cadastro de Planilhas</strong></h5>
                                    <h5>- Corrigido problema na gravação de informações do campo "Observação" na atualização da Planilha Gerencial.</h5>
                                    <h5>- Corrigido cálculos internos na criação da Planilha.</h5>
                                    <h5>- Corrigido problema na exclusão de planilhas que estão em elaboração e que tenham justificativas.</h5>

                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Modelo A</strong></h5>

                                <h5>- Corrigido cálculos internos no MODELO A.</h5>
                                    <h5>- Corrigido arredondamentos automáticos para valores menores que 1000 reais no MODELO A.</h5>
                    </div>
            </div>

</div>
