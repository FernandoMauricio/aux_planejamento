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
                        <i class="glyphicon glyphicon-star-empty"></i> O que há de novo? - Versão 1.1 - Publicado em 17/02/2017
            </div>

                  <div class="panel-body">
              <h4><strong style="color: #337ab7;">Implementações</strong></h4>
                        <h5><i class="glyphicon glyphicon-tag"></i><strong> Cadastros de Material de Consumo - Importação MXM</strong></h5>
                            <h5>- Foi implementado a importação de produtos diretamente do MXM seguindo algumas regras, são elas:</h5>
                            <ul>
                              <li>Apenas produtos que contenham valor financeiro <strong style="color: red;">maior que 0</strong> serão importados.</li>
                              <li>Produtos já cadastrados anteriormente apenas sofrerão alterações caso o valor a ser importado seja maior que 0, se não, permanecerá o valor cadastrado pelo usuário.</li>
                              <li>Produtos que contenham divergências na descrição, serão atualizados automaticamente conforme a descrição do MXM.</li>
                              <li>Produtos que não tiverem o código do MXM não sofrerão nenhum tipo de atualização.</li>
                            </ul>
                        <h5>- Todos os produtos que sofrerem atualizações em seus valores, automaticamente serão atualizados onde estiverem inseridos nos Planos.</h5><br>
                        
                        <h5><i class="glyphicon glyphicon-tag"></i><strong> Planos de Ação</strong></h5>
                        <h5>- Alterado a nomenclatura da situação do Plano de: <strong style="color: red;">Ativo/Inativo</strong> para <strong style="color: green;">Liberado/Em elaboração</strong>. </h5>
                        <h5>- Informações de Níveis, Eixos, Segmentos e Tipos de Ação por enquanto, não poderão ser editadas. Caso necessite, informe à GIC para realizar a alteração. (*Obs.: Essa ação foi tomada pois a cada atualização do plano, o usuário tinha que incluir novamente as informações de Segmentos e Tipos de Ação. Nas próximas atualizações iremos corrigir para que o próprio usuário edite informações de Segmento e Tipo de Ação).</h5>
                  </div>
            </div>

</div>
