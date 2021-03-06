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
                        <i class="glyphicon glyphicon-star-empty"></i> Versão 3.0 - Publicado em 22/04/2021
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
                    </div>
                </div>

                <div class="panel panel-danger">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-star-empty"></i> Versão 2.0 - Publicado em 26/11/2018
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
                    </div>
                </div>

                <div class="panel panel-danger">
                <div class="panel-heading">
                            <i class="glyphicon glyphicon-folder-close"></i> Versão 1.9 - Publicado em 15/08/2017
                </div>
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
                    <p><a href="index.php?r=site/versao" class="btn btn-warning" role="button">Histórico de Versões</a></p>
                </div>
                </div>

                <div class="panel panel-danger">
                <div class="panel-heading">
                            <i class="glyphicon glyphicon-folder-close"></i> Versão 1.8 - Publicado em 03/08/2017
                </div>
                    <div class="panel-body">
                      <h4><strong style="color: #337ab7;">Implementações</strong></h4>
                        <h5><i class="glyphicon glyphicon-tag"></i><strong> Markup</strong></h5>
                                <h5>- Markup passará a permitir unidades móveis com custo 0.</h5>
                        <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilha de Curso</strong></h5>
                                <h5>- Despesas com docentes agora podem ter custo 0.</h5>
                                <h5>- Agora é permitido que o "Preço de Venda" seja igual a 0.</h5><br>
                                
                      <h4><strong style="color: #337ab7;">Correções</strong></h4>
                        <h5><i class="glyphicon glyphicon-tag"></i><strong> Custos da Unidade</strong></h5>
                                <h5>- Correção de bug que não estava deletando os itens no cadastro de custos da unidade.</h5>
                        <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilha de Curso</strong></h5>
                                <h5>- Somente aparecerão planos ativos na listagem de planos.</h5>
                        <h5><i class="glyphicon glyphicon-tag"></i><strong> Relatórios</strong></h5>
                                <h5>- Corrigido valores da coluna "Taxa de Retorno" do Relatório Geral.</h5>
                    </div>
                </div>

                <div class="panel panel-danger">
                <div class="panel-heading">
                            <i class="glyphicon glyphicon-folder-close"></i> Versão 1.7 - Publicado em 01/08/2017
                </div>
                    <div class="panel-body">
                      <h4><strong style="color: #337ab7;">Implementações</strong></h4>
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilha de Precificação</strong></h5>
                                <h5>- Opção para EXCLUIR planilhas de precificação.</h5>
                                <h5>- Códigos dos Planos agora são visívies nas planilhas de precificações.</h5>
                                <h5>- Incluído um campo chamado "Valor com Desconto".</h5>
                                <h5>- Incluido um checkbox para que se marcado, realize descontos de 30% com relação ao "Preço Sugerido" e informe no campo "Valor com Desconto".</h5>
                                <h5>- Incluido nova coluna chamada "Preço de Venda" na aba "Preço de Venda por Unidade" para informar o preço de venda para todas as unidades.</h5>
                      <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilha de Curso</strong></h5>
                                <h5>- Incluído cores nas informações das colunas de "Planejamento" e "Produtividade" para destacar os cálculos que serão realizados para "Mão de Obra Direta" e "Outras Desp. Variáveis".</h5><br>
                                
                      <h4><strong style="color: #337ab7;">Correções</strong></h4>
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilha de Precificação</strong></h5>
                                <h5>- Correções no cálculo de valor hora aula.</h5>
                    </div>
                </div>

                <div class="panel panel-danger">
                <div class="panel-heading">
                            <i class="glyphicon glyphicon-folder-close"></i> Versão 1.6 - Publicado em 21/07/2017
                </div>
                    <div class="panel-body">
                      <h4><strong style="color: #337ab7;">Implementações</strong></h4>
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Relatórios PAAR</strong></h5>
                                   <h5>- Ordem alfabética dos tipos de relatórios do PAAR.</h5>
                                   <h5>- Novos relatórios do PAAR foram incluídos: </h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Carga Horária Aluno por Eixos Tecnológicos</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Carga Horária Aluno por Segmento</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Carga Horária Aluno por Ações de Educação Profissional</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Carga Horária Aluno por Ações Extensivas</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Carga Horária Aluno por Unidade</h5><br>
                                   
                      <h4><strong style="color: #337ab7;">Correções</strong></h4>
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilha de Precificação</strong></h5>
                                   <h5>- Alterações de nomeclatura dos campos:</h5>
                                    <h5>&nbsp;&nbsp;&nbsp;&nbsp;- <strong style="color: red;">"Preço sugerido"</strong> => <strong style="color: green;">"Preço de venda"</strong></h5>
                                    <h5>&nbsp;&nbsp;&nbsp;&nbsp;- <strong style="color: red;">"Preço de venda total por aluno"</strong> => <strong style="color: green;">"Preço sugerido pela planilha"</strong></h5><br>
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilha de Curso</strong></h5>
                                   <h5>- Inclusão do campo: "Orçamento" (será um campo para incluir o ano orçamentário, onde os relatórios se basearão).</h5>
                                   <h5>- Alterações de nomeclatura dos campos:</h5>
                                    <h5>&nbsp;&nbsp;&nbsp;&nbsp;- <strong style="color: red;">"Ano da planilha"</strong> => <strong style="color: green;">"Início da Turma".</strong></h5>
                    </div>
                </div>

                <div class="panel panel-danger">
                <div class="panel-heading">
                            <i class="glyphicon glyphicon-folder-close"></i> Versão 1.5 - Publicado em 04/07/2017
                </div>
                    <div class="panel-body">
                      <h4><strong style="color: #337ab7;">Implementações</strong></h4>
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Relatórios PAAR</strong></h5>
                                   <h5>Novos relatórios do PAAR foram incluídos: </h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Receita x Despesa por Unidade</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Receita x Segmento x Tipo Ação</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Listagem de Cursos Previstos</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Matrículas por Segmento e Tipo de Ação</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Matrículas PSG por Segmento</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> Quantidade Hora Aluno por Segmento</h5>
                    </div>
                </div>

                <div class="panel panel-danger">
                <div class="panel-heading">
                            <i class="glyphicon glyphicon-folder-close"></i> Versão 1.4 - Publicado em 30/06/2017
                </div>
                    <div class="panel-body">
                      <h4><strong style="color: #337ab7;">Implementações</strong></h4>
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilhas de Precificação</strong></h5>
                                   <h5>Aplicamos algumas regras para a planilha de precificação:</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> CH for MAIOR/IGUAL que 800 horas = <strong style="color: red;">10%</strong> reserva técnica.</h5>
                                   <h5>&nbsp;&nbsp;&nbsp;&nbsp;-> CH for MENOR que 800 horas = <strong style="color: red;">5%</strong> reserva técnica.</h5>

                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Planilhas de Cursos</strong></h5>
                                   <h5>- Ocultação de alguns campos para planilhas de curso (informações sobre o markup).</h5>
                                   <h5>- Inserido novo campo para planilhas de curso: <b>% de Retorno - Preço de Venda</b>.</h5>
                                   <h5>- Mensagem de validação do campo "Valor Sugerido" onde lia-se <strong style="color: red;">"valores maiores que 0"</strong>, leia-se <strong style="color: green;">"valores maiores que 0 e sem vírgulas"</strong>.</h5>
                                   <h5>- Alterações de nomeclaturas.</h5>
                                   <h5>- Os campos "<strong style="color: red;">Número mínimo de alunos</strong>" e "<strong style="color: red;">% de Retorno - Preço de Venda</strong>" terão valores iguais a 0 quando a Fonte de Financiamento for igual a PSG.</h5>
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
                                
                                <h5><i class="glyphicon glyphicon-tag"></i><strong> Planos de Curso</strong></h5>
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