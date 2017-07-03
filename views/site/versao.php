<?php
/* @var $this yii\web\View */
// namespace yii\bootstrap;
use yii\helpers\Html;
use app\models\Comunicacaointerna;
use app\models\Destinocomunicacao;
use yii\helpers\ArrayHelper;

$this->title = 'Auxílio ao Planejamento';

?>

<div class="site-index">
        <h1 class="text-center"> Histórico de Versões</h1>
            <div class="body-content">
                <div class="container">

                <div class="panel panel-primary">
                <div class="panel-heading">
                            <i class="glyphicon glyphicon-star-empty"></i> Versão 1.4 - (ATUALMENTE) - Publicado em 30/06/2017
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

                <div class="panel panel-danger">
                <div class="panel-heading">
                            <i class="glyphicon glyphicon-folder-close"></i> Versão 1.3 - Publicado em 20/04/2017
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

                <div class="panel panel-danger">
                    <div class="panel-heading">
                                <i class="glyphicon glyphicon-folder-close"></i>Versão 1.2 - Publicado em 08/03/2017
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

                <div class="panel panel-danger">
                    <div class="panel-heading">
                                <i class="glyphicon glyphicon-folder-close"></i> Versão 1.1  - Publicado em 17/02/2017
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

                <div class="panel panel-danger">
                    <div class="panel-heading">
                                <i class="glyphicon glyphicon-folder-close"></i> Versão 1.0 - Publicado em 15/12/2016
                    </div>
                    <div class="panel-body">
                      <h4><strong style="color: #337ab7;">Implementações</strong></h4>
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Cadastros</strong></h5>
                                    <h5>- Cadastro de Materiais Didáticos </h5>
                                    <h5>- Cadastro de Planos </h5>
                                    <h5>- Cadastro de Planilhas de Curso (cadastro realizado pelo gerente imediato da unidade) </h5>
                                    <h5>- Cadastro de Planilhas de Precificação </h5><br>

                                    <h5><i class="glyphicon glyphicon-tag"></i><strong> Modelo A</strong></h5>
                                    <h5>- Geração do Modelo A</h5>
                                    <h5>- Atualização e Impressão do Modelo A</h5><br>

                                    <h5><i class="glyphicon glyphicon-tag"></i><strong> Solicitações de Cópias</strong></h5>
                                    <h5>- Solicitação e Acompanhamento de Cópias de Material (Apostilas)</h5><br>

                                    <h5><i class="glyphicon glyphicon-tag"></i><strong> Relatórios</strong></h5>
                                    <h5>- Visualizar Relatórios (Relatórios PAAR, MODELO B e Relatório Geral)</h5>
                    </div>
                </div>

            </div>
        </div>   
</div>