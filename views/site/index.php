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
                        <i class="glyphicon glyphicon-star-empty"></i> O que há de novo? - Versão 1.4 - Publicado em 30/06/2017
            </div>
                    <div class="panel-body">
                      <h4><strong style="color: #337ab7;">Implementações</strong></h4>
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilhas de Precificação</strong></h5>
                                   <h5>Aplicamos algumas regras para a planilha de precificação:</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> CH for MAIOR/IGUAL que 800 horas = <strong style="color: red;">10%</strong> reserva técnica.</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> CH for MENOR que 800 horas = <strong style="color: red;">5%</strong> reserva técnica.</h5>

                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilhas de Cursos</strong></h5>
                                   <h5>- Ocultação de alguns campos para planilhas de curso (informações sobre o markup).</h5>
                                   <h5>- Inserido novo campo para planilhas de curso: <b>% de Retorno - Preço Sugerido</b>.</h5>
                                   <h5>- Mensagem de validação do campo "Valor Sugerido" onde lia-se <strong style="color: red;">"valores maiores que 0"</strong>, leia-se <strong style="color: green;">"valores maiores que 0 e sem vírgulas"</strong>.</h5>
                                   <h5>- Alterações de nomeclaturas.</h5>
                                   <h5>- Os campos "<strong style="color: red;">Número mínimo de alunos</strong>" e "<strong style="color: red;">% de Retorno - Preço Sugerido</strong>" terão valores iguais a 0 quando a Fonte de Financiamento for igual a PSG.</h5>
                    </div>
            </div>

</div>
