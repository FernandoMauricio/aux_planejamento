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
            <i class="glyphicon glyphicon-star-empty"></i> O que há de novo? - Versão 2.0 - Publicado em 26/11/2018
        </div>
        <div class="panel-body">
            <h4><strong style="color: #337ab7;">Implementações</strong></h4>
            <h5><i class="glyphicon glyphicon-tag"></i><strong> Precificação</strong></h5>
                <h5>- Alterado cálculo da taxa de retorno: <strong style="color: #e74c3c;">(Retorno R$ / Preço de venda total da turma)</strong> -> <strong style="color: #27ae60;">(Retorno R$ / Despesa Total)</strong>.</h5>
                <h5>- Reserva técnica >= 800(CH) <strong style="color: #3498db;">será igual a 8%</strong>, se valor da CH for menor, <strong style="color: #3498db;">será igual a 3%</strong>. </h5>
                <h5>- Alterado campo <strong style="color: #e74c3c;">Total de meses do curso</strong> -> <strong style="color: #27ae60;">Provisão de Ano</strong>.</h5>
                <h5>- Alterado cálculo de Provisão de Ano para 12 meses.</h5>
                <h5>- Melhoria na listagem das unidades na aba: Preço de Venda por Unidade.</h5>
                <h5>- Implementado o recálculo da planilha caso o valor hora/aula do docente seja atualizado.</h5>
                <h5>- Implementado cálculos especificos para capital e municípios do interior.</h5>
            <h5><i class="glyphicon glyphicon-tag"></i><strong> Solicitações de Cópias</strong></h5>
                <h5>- Solicitações de Cópias migrado para o módulo de Reprografia.</h5>

            <h5><i class="glyphicon glyphicon-tag"></i><strong> Plano de Curso</strong></h5>
                <h5>- Melhorado sistema de busca por Eixos no cadastro de Segmento.</h5><br>

            <h4><strong style="color: #337ab7;">Correções</strong></h4>
            <h5><i class="glyphicon glyphicon-tag"></i><strong> Relatórios</strong></h5>
                <h5>- Correção no cálculo da CH no relatório PAAR.</h5>
            <h5><i class="glyphicon glyphicon-tag"></i><strong> Centro de Custo</strong></h5>
                <h5>- Correção na listagem dos Centros de Custos.</h5><br>

            <p><a href="index.php?r=site/versao" class="btn btn-warning" role="button">Histórico de Versões</a></p>

        </div>
    </div>
</div>
