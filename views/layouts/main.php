<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\nav\NavX;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
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
                         ['label' => 'Cadastro de Planilhas', 'url' => ['#']],
                                     '<li class="divider"></li>',

                         ['label' => 'Precificação de Custos', 'url' => ['#']],
                                     '<li class="divider"></li>',
                            ['label' => 'Parâmetros', 'items' => [
                                ['label' => 'Despesas da Unidade', 'url' => ['/despesas/custosunidade/index']],
                                ['label' => 'Salas', 'url' => ['/despesas/salas/index']],

                            ]],


                     ],
            ],

        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Gerência de Informática Corporativa <?= date('Y') ?></p>

        <p class="pull-right">Versão 1.0</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
