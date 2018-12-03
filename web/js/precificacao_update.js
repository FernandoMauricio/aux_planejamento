$(function() {

    $('#precificacao-planp_qntaluno').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_despesatotal').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_mesesdocurso').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_precosugerido').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_parcelas').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_parcelasinterior').keyup(function() {
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

      var planp_mesesdocurso    = parseFloat($('#precificacao-planp_mesesdocurso').val());


      //SEÇÃO 3
      var planp_qntaluno       = parseFloat($('#precificacao-planp_qntaluno').val());
      var planp_precosugerido  = parseFloat($('#precificacao-planp_precosugerido').val());
      var planp_parcelas       = parseFloat($('#precificacao-planp_parcelas').val());
      var planp_parcelasinterior = parseFloat($('#precificacao-planp_parcelasinterior').val());
      var planp_desconto       = parseFloat($('#precificacao-planp_desconto').val());
      var despesaTotal         = parseFloat($('#precificacao-planp_despesatotal').val());
      var totalIncidencia      = parseFloat($('#precificacao-planp_totalincidencias').val());
      var valorTotalDireto     = parseFloat($('#precificacao-planp_totalcustodireto').val());

      //CÁLCULOS REALIZADOS
      //SEÇÃO 3
      var retornoPrecoSugerido        = (planp_precosugerido * planp_qntaluno) - despesaTotal; // Preço de Venda x Qnt de Alunos - Despesa Total;
      var minimoAlunos                = Math.ceil(despesaTotal / planp_precosugerido); // Despesa Total / Preço de Venda;
      var valorParcelas               =  planp_precosugerido / planp_parcelas;
    
      var markupDivisor               = (100 - totalIncidencia);
      var precoVendaTurmaSugerido     = (valorTotalDireto / markupDivisor) * 100; // Valores em %
      var valorTotalPrecoDeVendaTurma = (planp_precosugerido * planp_qntaluno);
      var porcentagemRetornoSugerido  = (retornoPrecoSugerido / despesaTotal) * 100; // % de Retorno / Despesa Total -- Valores em %

      //Aplicação do Desconto em cima do Preço Sugerido
      var valorComDesconto = planp_precosugerido - ((planp_precosugerido * planp_desconto) / 100);

      //Valores do Interior
      var retornoPrecoSugeridoInterior = (valorComDesconto * planp_qntaluno) - despesaTotal; // Preço de Venda x Qnt de Alunos - Despesa Total; (Interior)
      var valorTotalPrecoDeVendaTurmaInterior = (valorComDesconto * planp_qntaluno);
      var porcentagemRetornoSugeridoInterior  = (retornoPrecoSugeridoInterior / despesaTotal) * 100; // % de Retorno / Despesa Total -- Valores em %
      var valorParcelasInterior =  valorComDesconto / planp_parcelasinterior;
      var minimoAlunosInterior = Math.ceil(despesaTotal / valorComDesconto); // Despesa Total / Preço de Venda;
      
      //SEÇÃO 3
      $('#precificacao-planp_retornoprecosugerido').val(retornoPrecoSugerido); // Preço de Venda x Qnt de Alunos - Despesa Total;
      $('#precificacao-planp_minimoaluno').val(minimoAlunos); // Despesa Total / Preço de Venda;
      $('#precificacao-planp_valorparcelas').val(valorParcelas); // Preço de Venda / Quantidade de Parcelas;
      $('#precificacao-planp_valorcomdesconto').val(valorComDesconto); //Cálculo do valor com desconto aplicado
      $('#precificacao-planp_vendaturmasugerido').val(valorTotalPrecoDeVendaTurma); //Cálculo do Preço Sugerido x quantidade de alunos
      $('#precificacao-planp_porcentretornosugerido').val(porcentagemRetornoSugerido);  //% de Retorno com preço sugerido

      //Informações do Interior
      $('#precificacao-planp_retornoprecosugeridointerior').val(retornoPrecoSugeridoInterior); // Preço de Venda x Qnt de Alunos - Despesa Total; (MUNICIPIOS DO INTERIOR)
      $('#precificacao-planp_vendaturmasugeridointerior').val(valorTotalPrecoDeVendaTurmaInterior); //Cálculo do Preço Sugerido x quantidade de alunos
      $('#precificacao-planp_porcentretornosugeridointerior').val(porcentagemRetornoSugeridoInterior); //% de Retorno com preço sugerido
      $('#precificacao-planp_valorparcelasinterior').val(valorParcelasInterior); // Preço de Venda / Quantidade de Parcelas;
      $('#precificacao-planp_minimoalunointerior').val(minimoAlunosInterior); // Despesa Total / Preço de Venda;


    };
 });
