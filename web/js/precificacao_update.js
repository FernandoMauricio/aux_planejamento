$(function() {

    $('#precificacao-planp_qntaluno').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_despesatotal').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_precosugerido').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_parcelas').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_desconto').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_totalincidencias').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_totalcustodireto').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_retornoprecosugerido').keyup(function() {
       updateTotal();
    });


    var updateTotal = function () {

      //SEÇÃO 3
      var planp_qntaluno       = parseFloat($('#precificacao-planp_qntaluno').val());
      var planp_precosugerido  = parseFloat($('#precificacao-planp_precosugerido').val());
      var planp_parcelas       = parseFloat($('#precificacao-planp_parcelas').val());
      var planp_desconto       = parseFloat($('#precificacao-planp_desconto').val());
      var despesaTotal         = parseFloat($('#precificacao-planp_despesatotal').val());
      var totalIncidencia      = parseFloat($('#precificacao-planp_totalincidencias').val());
      var valorTotalDireto     = parseFloat($('#precificacao-planp_totalcustodireto').val());

      //CÁLCULOS REALIZADOS

      //SEÇÃO 3
      var RetornoPrecoSugerido        = (planp_precosugerido * planp_qntaluno) - despesaTotal; // Preço de Venda x Qnt de Alunos - Despesa Total;
      var MinimoAlunos                = Math.ceil(despesaTotal / planp_precosugerido); // Despesa Total / Preço de Venda;
      var ValorParcelas               =  planp_precosugerido / planp_parcelas;
    
      var MarkupDivisor               = (100 - totalIncidencia);
      var PrecoVendaTurmaSugerido     = (valorTotalDireto / MarkupDivisor) * 100; // Valores em %
      var ValorTotalPrecoDeVendaTurma = (planp_precosugerido * planp_qntaluno);
      var PorcentagemRetornoSugerido  = (RetornoPrecoSugerido / ValorTotalPrecoDeVendaTurma) * 100; // % de Retorno / Preço de venda da Turma -- Valores em %

      //Aplicação do Desconto em cima do Preço Sugerido
      var ValorComDesconto = planp_precosugerido - ((planp_precosugerido * planp_desconto) / 100);

      //SEÇÃO 3
      $('#precificacao-planp_retornoprecosugerido').val(RetornoPrecoSugerido); // Preço de Venda x Qnt de Alunos - Despesa Total;
      $('#precificacao-planp_minimoaluno').val(MinimoAlunos); // Despesa Total / Preço de Venda;
      $('#precificacao-planp_valorparcelas').val(ValorParcelas); // Preço de Venda / Quantidade de Parcelas;
      $('#precificacao-planp_valorcomdesconto').val(ValorComDesconto); //Cálculo do valor com desconto aplicado
      $('#precificacao-planp_vendaturmasugerido').val(ValorTotalPrecoDeVendaTurma); //Cálculo do Preço Sugerido x quantidade de alunos
      $('#precificacao-planp_porcentretornosugerido').val(PorcentagemRetornoSugerido); //Cálculo do valor com desconto aplicado

    };
 });
