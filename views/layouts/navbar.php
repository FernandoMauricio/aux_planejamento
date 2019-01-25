<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use kartik\nav\NavX;

?>
    <?php

    $session = Yii::$app->session;

    NavBar::begin([
        'brandLabel' => '<img src="css/img/logo_senac_topo.png"/>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-inverse navbar-fixed-top'],
    ]);

    if($session['sess_codunidade'] == 51 && $session['sess_responsavelsetor'] == 1){ //ÁREA GERENTE DO GPO 

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
                         ['label' => 'Tipos de Ação', 'url' => ['/cadastros/tipo/index']],
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
                                  // ['label' => 'Tipo de Material', 'url' => ['/repositorio/tipomaterial/index']],
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
                     ],
            ],

            [
            'label' => 'Relatórios',
            'items' => [
                            ['label' => 'Relatórios', 'items' => [
                                ['label' => 'PAAR', 'url' => ['relatorios/relatorios-paar/gerar-relatorio']],
                                ['label' => 'Relatório Geral', 'url' => ['relatorios/relatorio-geral/gerar-relatorio']],
                                ['label' => 'Modelo B', 'url' => ['relatorios/relatorio-modelo-b/gerar-relatorio']],
                                ['label' => 'Relatórios DEP', 'url' => ['relatorios/relatorios-dep/gerar-relatorio']],
                                ['label' => 'Relatórios em Excel', 'url' => ['relatorios/relatorios-excel/gerar-relatorio']],
                            ]],
                     ],
            ],

            [
            'label' => 'Usuário (' . utf8_encode(ucwords(strtolower($session['sess_nomeusuario']))) . ')',
            'items' => [
                         '<li class="dropdown-header">Área Usuário</li>',
                                //['label' => 'Alterar Senha', 'url' => ['usuario-usu/update', 'id' => $sess_codusuario]],
                                ['label' => 'Versões Anteriores', 'url' => ['/site/versao']],
                                ['label' => 'Sair', 'url' => 'https://portalsenac.am.senac.br/portal_senac/control_base_vermodulos/control_base_vermodulos.php'],
                    
                        ],
            ],
        ],
    ]);

     }else if($session['sess_codunidade'] == 51) { //ÁREA USUÁRIOS DO GPO

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
                         ['label' => 'Tipos de Ação', 'url' => ['/cadastros/tipo/index']],
                          '<li class="divider"></li>',
                         ['label' => 'Centro de Custo', 'url' => ['/cadastros/centrocusto/index']],
                       ],
            ],

            // [
            // 'label' => 'Repositório',
            // 'items' => [
            //              ['label' => 'Materiais Didáticos', 'url' => ['/repositorio/repositorio-materiais/index']],
            //                          '<li class="divider"></li>',
            //                 ['label' => 'Cadastros', 'items' => [
            //                       ['label' => 'Categoria', 'url' => ['/repositorio/categoria/index']],
            //                       ['label' => 'Editora', 'url' => ['/repositorio/editora/index']],
            //                       // ['label' => 'Tipo de Material', 'url' => ['/repositorio/tipomaterial/index']],
            //                 ]],

            //            ],
            // ],

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
                     ],
            ],

            [
            'label' => 'Relatórios',
            'items' => [
                            ['label' => 'Relatórios', 'items' => [
                                ['label' => 'PAAR', 'url' => ['relatorios/relatorios-paar/gerar-relatorio']],
                                ['label' => 'Relatório Geral', 'url' => ['relatorios/relatorio-geral/gerar-relatorio']],
                                ['label' => 'Modelo B', 'url' => ['relatorios/relatorio-modelo-b/gerar-relatorio']],
                                ['label' => 'Relatórios DEP', 'url' => ['relatorios/relatorios-dep/gerar-relatorio']],
                                ['label' => 'Relatórios em Excel', 'url' => ['relatorios/relatorios-excel/gerar-relatorio']],
                                ['label' => 'Relatório Elemento de Despesa - Orc', 'url' => ['relatorios/relatorio-orcamento/gerar-relatorio']],
                            ]],
                     ],
            ],

            [
            'label' => 'Usuário (' . utf8_encode(ucwords(strtolower($session['sess_nomeusuario']))) . ')',
            'items' => [
                         '<li class="dropdown-header">Área Usuário</li>',
                                //['label' => 'Alterar Senha', 'url' => ['usuario-usu/update', 'id' => $sess_codusuario]],
                                ['label' => 'Versões Anteriores', 'url' => ['/site/versao']],
                                ['label' => 'Sair', 'url' => 'https://portalsenac.am.senac.br/portal_senac/control_base_vermodulos/control_base_vermodulos.php'],
                    
                        ],
            ],
        ],
    ]);

    }else if($session['sess_codunidade'] == 11) { //ÁREA DA DEP

    echo NavX::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],

        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],

            [
            'label' => 'Repositório',
            'items' => [
                         ['label' => 'Materiais Didáticos', 'url' => ['/repositorio/repositorio-materiais/index']],
                                     '<li class="divider"></li>',
                            ['label' => 'Cadastros', 'items' => [
                                  ['label' => 'Categoria', 'url' => ['/repositorio/categoria/index']],
                                  ['label' => 'Editora', 'url' => ['/repositorio/editora/index']],
                                  // ['label' => 'Tipo de Material', 'url' => ['/repositorio/tipomaterial/index']],
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
            'label' => 'Planilhas',
            'items' => [
                         ['label' => 'Planilhas de Precificação', 'url' => ['/planilhas/precificacao/index']],
                     ],
            ],
            
            [
            'label' => 'Relatórios',
            'items' => [
                            ['label' => 'Relatórios', 'items' => [
                                ['label' => 'PAAR', 'url' => ['relatorios/relatorios-paar/gerar-relatorio']],
                                ['label' => 'Relatório Geral', 'url' => ['relatorios/relatorio-geral/gerar-relatorio']],
                                ['label' => 'Modelo B', 'url' => ['relatorios/relatorio-modelo-b/gerar-relatorio']],
                                ['label' => 'Relatórios DEP', 'url' => ['relatorios/relatorios-dep/gerar-relatorio']],
                                ['label' => 'Relatórios em Excel', 'url' => ['relatorios/relatorios-excel/gerar-relatorio']],
                            ]],
                     ],
            ],

            [
            'label' => 'Usuário (' . utf8_encode(ucwords(strtolower($session['sess_nomeusuario']))) . ')',
            'items' => [
                         '<li class="dropdown-header">Área Usuário</li>',
                                //['label' => 'Alterar Senha', 'url' => ['usuario-usu/update', 'id' => $sess_codusuario]],
                                ['label' => 'Versões Anteriores', 'url' => ['/site/versao']],
                                ['label' => 'Sair', 'url' => 'https://portalsenac.am.senac.br/portal_senac/control_base_vermodulos/control_base_vermodulos.php'],
                        ],
            ],
        ],
    ]);

    }else if($session['sess_responsavelsetor'] == 1 || $session['sess_codusuario'] == 48 || $session['sess_codusuario'] == 74) {//ÁREA DE GERENTES E PARA A SAIANA E ELENI PODER ENTRAR EM CADA UNIDADE E VISUALIZAR COMO GERENTE

    echo NavX::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],

        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],

            [
            'label' => 'Plano de Ação',
            'items' => [
                         ['label' => 'Cadastro do Plano', 'url' => ['/planos/planodeacao/index']],
                     ],
            ],

            [
            'label' => 'Planilhas',
            'items' => [
                         ['label' => 'Planilhas de Curso', 'url' => ['/planilhas/planilhadecurso/index']],
                                     '<li class="divider"></li>',

                         ['label' => 'Planilhas de Precificação', 'url' => ['/planilhas/precificacao/index']],
                                     '<li class="divider"></li>',
                            ['label' => 'Modelo A', 'items' => [
                                ['label' => 'Listagem do Modelo A', 'url' => ['/modeloa/modelo-a/index']],

                            ]],
                     ],
            ],

            [
            'label' => 'Relatórios',
            'items' => [
                            ['label' => 'Relatórios', 'items' => [
                                ['label' => 'PAAR', 'url' => ['relatorios/relatorios-paar/gerar-relatorio']],
                                ['label' => 'Relatório Geral', 'url' => ['relatorios/relatorio-geral/gerar-relatorio']],
                                ['label' => 'Modelo B', 'url' => ['relatorios/relatorio-modelo-b/gerar-relatorio']],
                                ['label' => 'Relatórios DEP', 'url' => ['relatorios/relatorios-dep/gerar-relatorio']],
                                ['label' => 'Relatórios em Excel', 'url' => ['relatorios/relatorios-excel/gerar-relatorio']],
                            ]],
                     ],
            ],

            [
            'label' => 'Usuário (' . utf8_encode(ucwords(strtolower($session['sess_nomeusuario']))) . ')',
            'items' => [
                         '<li class="dropdown-header">Área Usuário</li>',
                                //['label' => 'Alterar Senha', 'url' => ['usuario-usu/update', 'id' => $sess_codusuario]],
                                ['label' => 'Versões Anteriores', 'url' => ['/site/versao']],
                                ['label' => 'Sair', 'url' => 'https://portalsenac.am.senac.br/portal_senac/control_base_vermodulos/control_base_vermodulos.php'],
                    
                        ],
            ],
        ],
    ]);

    }else if($session['sess_codunidade'] == 12) {//ÁREA DA REPROGRAFIA - GMT

    echo NavX::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],

        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],

            [
            'label' => 'Usuário (' . utf8_encode(ucwords(strtolower($session['sess_nomeusuario']))) . ')',
            'items' => [
                         '<li class="dropdown-header">Área Usuário</li>',
                                //['label' => 'Alterar Senha', 'url' => ['usuario-usu/update', 'id' => $sess_codusuario]],
                                ['label' => 'Versões Anteriores', 'url' => ['/site/versao']],
                                ['label' => 'Sair', 'url' => 'https://portalsenac.am.senac.br/portal_senac/control_base_vermodulos/control_base_vermodulos.php'],
                    
                        ],
            ],
        ],
    ]);

    }else {//ÁREA DE USUÁRIOS

    echo NavX::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],

        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],

            [
            'label' => 'Plano de Ação',
            'items' => [
                         ['label' => 'Cadastro do Plano', 'url' => ['/planos/planodeacao/index']],
                     ],
            ],

            [
            'label' => 'Planilhas',
            'items' => [
                         ['label' => 'Planilhas de Precificação', 'url' => ['/planilhas/precificacao/index']],
                     ],
            ],
            
            [
            'label' => 'Relatórios',
            'items' => [
                            ['label' => 'Relatórios', 'items' => [
                                ['label' => 'PAAR', 'url' => ['relatorios/relatorios-paar/gerar-relatorio']],
                                ['label' => 'Relatório Geral', 'url' => ['relatorios/relatorio-geral/gerar-relatorio']],
                                ['label' => 'Modelo B', 'url' => ['relatorios/relatorio-modelo-b/gerar-relatorio']],
                                ['label' => 'Relatórios DEP', 'url' => ['relatorios/relatorios-dep/gerar-relatorio']],
                                ['label' => 'Relatórios em Excel', 'url' => ['relatorios/relatorios-excel/gerar-relatorio']],
                            ]],
                     ],
            ],
               
            [
            'label' => 'Usuário (' . utf8_encode(ucwords(strtolower($session['sess_nomeusuario']))) . ')',
            'items' => [
                         '<li class="dropdown-header">Área Usuário</li>',
                                //['label' => 'Alterar Senha', 'url' => ['usuario-usu/update', 'id' => $sess_codusuario]],
                                ['label' => 'Versões Anteriores', 'url' => ['/site/versao']],
                                ['label' => 'Sair', 'url' => 'https://portalsenac.am.senac.br/portal_senac/control_base_vermodulos/control_base_vermodulos.php'],
                    
                        ],
            ],
        ],
    ]);

}
    NavBar::end();
    ?>