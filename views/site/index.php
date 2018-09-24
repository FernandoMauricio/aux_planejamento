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
                        <i class="glyphicon glyphicon-star-empty"></i> O que há de novo? - Versão 1.9 - Publicado em 15/08/2017
            </div>
                    <div class="panel-body">

                    <div class="panel-body">
                      <h4><strong style="color: #337ab7;">Implementações</strong></h4>
                        <h5><i class="glyphicon glyphicon-tag"></i><strong> Planos de Cursos</strong></h5>
                                <h5>- Inclusão do campo "Qnt de Alunos" no cadastro de Planos.</h5>
                                <h5>- Inclusão do campo "Nível de Docente" no cadastro de Planos.</h5>
                                <h5>- Realizado a inclusão do nível de docente igual a "Docente Nível Superior" via bando de dados, para todos os planos já criados, conforme acertado em reunião com DEP, GPO e DIF no mesmo dia desta publicação. Para novos planos, essa inclusão se fará normalmente no cadastro.</h5><br>

                        <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilhas de Precificação</strong></h5>
                                <h5>- Na criação das planilhas de precificações, o sistema trará "qnt de alunos" e "nível do docente" de forma automática no momento que for escolhido o plano a ser precificado.</h5><br>

                        <h5><i class="glyphicon glyphicon-tag"></i><strong> Relatórios</strong></h5>
                                <h5>- Incluido na tela de relatórios DEP, o relatório em Excel que informa as planilhas de precificações criadas para as unidades, juntamente com a quantidade mínima de alunos.</h5>
                    </div>
                                <p><a href="index.php?r=site/versao" class="btn btn-warning" role="button">Histórico de Versões</a></p>
                    </div>
            </div>
</div>
