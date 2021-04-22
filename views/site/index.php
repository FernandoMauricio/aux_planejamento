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
            <i class="glyphicon glyphicon-star-empty"></i> O que há de novo? - Versão 3.0 - Publicado em 22/04/2021
        </div>
        <div class="panel-body">
            <h4><strong style="color: #337ab7;">Implementações</strong></h4>
            <h5><i class="glyphicon glyphicon-tag"></i><strong> Alterações Gerais</strong></h5>
                <h5>- Criado uma categoria na tela de Material Didático para Biblioteca Digital.</h5><br />

            <h5><i class="glyphicon glyphicon-tag"></i><strong> Planos de Curso</strong></h5>
                <h5>- Alterado a nomenclatura <strong style="color: #e74c3c;">Plano de Ação</strong> -> <strong style="color: #27ae60;">Plano de Curso</strong>.</h5>
                <h5>- Implementado o campo Escola Interativa.</h5>
                <h5>- Implementado a opção de atualização para os campos de  <strong style="color: #3498db;">eixo, segmento e tipo de ação</strong>.</h5>
                <h5>- O campo <strong style="color: #27ae60;">Perfil Profissional de Conclusão</strong> agora é opcional.</h5>
                <h5>- Implementado a busca por código DN na listagem de Planos de Curso.</h5>
                <h5>- Alterado campo <strong style="color: #e74c3c;">Categorias do Plano</strong> -> <strong style="color: #27ae60;">Fonte de Recursos</strong>.</h5>
                <h5>- O campo <strong style="color: #3498db;">código do plano DN</strong> será bloqueado se tiver sido usado em outro cadastro. Poderá ser inserido 0, caso não haja código de plano DN.</h5>
                <h5>- Implementado a pontuação no campo <strong style="color: #3498db;">Código do plano DN</strong>.</h5><br />

            <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilhas de Curso</strong></h5>
                <h5>- Alterado a nomenclatura <strong style="color: #e74c3c;">Carga Horária Realizada </strong> -> <strong style="color: #27ae60;">Carga Horária Realizada no Exercicio Anterior</strong>.</h5>
                <h5>- Agora será Exibido a informação se é <strong style="color: #3498db;">Escola Interativa</strong>.</h5>
                <h5>- Incluído campo <strong style="color: #27ae60;">Novo Modelo Pedagógico</strong> na informação das planilhas de curso.</h5>
                <h5>- Excluído financiamento <strong style="color: #e74c3c;">PRONATEC, PRONATEC/PSG e Recurso da empresa </strong> das opções de Recursos Financeiros</h5>
                <h5>- Alterado a nomenclatura <strong style="color: #e74c3c;">Preço de Venda </strong> -> <strong style="color: #27ae60;">Preço de Venda da Precificação</strong>.</h5><br />

            <h5><i class="glyphicon glyphicon-tag"></i><strong> Relatórios DEP</strong></h5>
                <h5>- Implementado o relatório solicitado pela GDE sobre Planos de Curso.</h5><br />

            <h4><strong style="color: #337ab7;">Correções</strong></h4>
            <h5><i class="glyphicon glyphicon-tag"></i><strong> MODELO A</strong></h5>
                <h5>- Pequenas correções em algumas nomenclaturas do Modelo A.</h5><br />

            <p><a href="index.php?r=site/versao" class="btn btn-warning" role="button">Histórico de Versões</a></p>

        </div>
    </div>
</div>
