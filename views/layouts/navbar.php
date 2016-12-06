<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use kartik\nav\NavX;

?>

    <?php

    NavBar::begin([
        'brandLabel' => 'Senac AM',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-inverse navbar-fixed-top'],
    ]);

    echo NavX::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],

        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            [
            'label' => 'Cadastros',
            'items' => [
                        '<li class="dropdown-header">Área Administrador</li>',
                         ['label' => 'Ano', 'url' => ['/cadastros/ano/index']],
                         ['label' => 'Nivel', 'url' => ['/cadastros/nivel/index']],
                         ['label' => 'Eixo', 'url' => ['/cadastros/eixo/index']],
                         ['label' => 'Segmento', 'url' => ['/cadastros/segmento/index']],
                         ['label' => 'Tipo', 'url' => ['/cadastros/tipo/index']],
                          '<li class="divider"></li>',
                         ['label' => 'Centro de Custo', 'url' => ['/cadastros/centrocusto/index']],
                       ],
            ],

            [
            'label' => 'Repositório',
            'items' => [
                         ['label' => 'Materiais Didáticos', 'url' => ['/repositorio/repositorio-materiais/index']],
                                     '<li class="divider"></li>',
                            ['label' => 'Cadastros', 'items' => [
                                  ['label' => 'Categoria', 'url' => ['/repositorio/categoria/index']],
                                  ['label' => 'Editora', 'url' => ['/repositorio/editora/index']],
                                  ['label' => 'Tipo de Material', 'url' => ['/repositorio/tipomaterial/index']],
                            ]],

                       ],
            ],

            [
            'label' => 'Plano de Ação',
            'items' => [
                         ['label' => 'Cadastro do Plano', 'url' => ['/planos/planodeacao/index']],
                                     '<li class="divider"></li>',
                            ['label' => 'Cadastros', 'items' => [
                                ['label' => 'Material do Aluno', 'url' => ['/cadastros/materialaluno/index']],
                                ['label' => 'Equipamentos / Utensílios', 'url' => ['/cadastros/estruturafisica/index']],
                                '<li class="divider"></li>',
                                ['label' => 'Material de Consumo', 'url' => ['/cadastros/materialconsumo/index']],

                            ]],

                     ],
            ],

            [
            'label' => 'Solicitações de Material',
            'items' => [
                         ['label' => 'Nova Solicitação', 'url' => ['/solicitacoes/material-copias/index']],
                                     '<li class="divider"></li>',
                            ['label' => 'Administração', 'items' => [
                                ['label' => 'Solicitações em aprovação', 'url' => ['/solicitacoes/material-copias-aut-gerencia/index']],
                                     '<li class="divider"></li>',
                                ['label' => 'Solicitações Pendentes', 'url' => ['/solicitacoes/material-copias-pendentes/index']],
                                ['label' => 'Solicitações Aprovadas', 'url' => ['/solicitacoes/material-copias-aprovadas/index']],
                                ['label' => 'Solicitações Encerradas', 'url' => ['/solicitacoes/material-copias-encerradas/index']],
                            ]],
                            ['label' => 'Cadastros', 'items' => [
                                ['label' => 'Tipos de Acabamento', 'url' => ['/solicitacoes/acabamento/index']],

                            ]],


                     ],
            ],

            [
            'label' => 'Planilhas',
            'items' => [
                         ['label' => 'Planilhas de Curso', 'url' => ['/planilhas/planilhadecurso/index']],
                                     '<li class="divider"></li>',

                         ['label' => 'Planilhas de Precificação', 'url' => ['/planilhas/precificacao/index']],
                                     '<li class="divider"></li>',
                            ['label' => 'Parâmetros', 'items' => [
                                ['label' => 'Salas', 'url' => ['/despesas/salas/index']],
                                ['label' => 'Valor Hora/Aula', 'url' => ['/despesas/despesasdocente/index']],
                                ['label' => 'Despesas da Unidade', 'url' => ['/despesas/custosunidade/index']],
                                ['label' => 'Markup', 'url' => ['/despesas/markup/batch-update']],

                            ]],
                                     '<li class="divider"></li>',
                            ['label' => 'Administração', 'items' => [
                                ['label' => 'Planilhas de Curso', 'url' => ['/planilhas/planilhadecurso-admin/index']],
                                ['label' => 'Planilhas Pendentes', 'url' => ['/planilhas/planilhadecurso-pendentes/index']],
                                ['label' => 'Planilhas Homologadas', 'url' => ['/planilhas/planilhadecurso-homologadas/index']],
                                ['label' => 'Entrada de Dados Modelo A', 'url' => ['/modeloa/modelo-a/configuracao-entrada-dados-modelo-a']],

                            ]],
                                     '<li class="divider"></li>',
                            ['label' => 'Modelo A', 'items' => [
                                ['label' => 'Listagem do Modelo A', 'url' => ['/modeloa/modelo-a/index']],

                            ]],
                                     '<li class="divider"></li>',
                            ['label' => 'Relatórios', 'items' => [
                                ['label' => 'PAAR', 'url' => ['relatorios/relatorios-paar/gerar-relatorio']],
                            ]],
                     ],
            ],

        ],
    ]);
    NavBar::end();
    ?>