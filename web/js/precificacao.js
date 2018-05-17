$(function() {

    //SEÇÃO 2
    $('#precificacao-planp_encargos').keyup(function() {
       updateTotal();
    });
    $('#precificacao-planp_cargahoraria').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_mesesdocurso').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_qntaluno').keyup(function() {
       updateTotal();
    });

    $('#precificacao-hiddenplanejamento').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_servpedagogico').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_horaaulaplanejamento').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_totalhorasdocente').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_valorhoraaula').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_diarias').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_passagens').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_pessoafisica').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_pessoajuridica').keyup(function() {
       updateTotal();
    });

    $('#precificacao-hiddenpjapostila').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_custosmateriais').keyup(function() {
       updateTotal();
    });

    $('#precificacao-hiddenmaterialdidatico').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_custosconsumo').keyup(function() {
       updateTotal();
    });

    $('#precificacao-totalhoraaulacustodireto').keyup(function() {
       updateTotal();
    });

    //SEÇÃO 3
    $('#precificacao-planp_custosindiretos').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_ipca').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_reservatecnica').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_despesadm').keyup(function() {
       updateTotal();
    });

    $('#precificacao-planp_totalincidencias').keyup(function() {
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

    var updateTotal = function () {
      //SEÇÃO 2
      var planp_encargos             = parseFloat($('#precificacao-planp_encargos').val());
      var planp_cargahoraria         = parseFloat($('#precificacao-planp_cargahoraria').val());
      var planp_mesesdocurso         = parseFloat($('#precificacao-planp_mesesdocurso').val());
      var planp_qntaluno             = parseFloat($('#precificacao-planp_qntaluno').val());
      var planp_totalhorasdocente    = parseFloat($('#precificacao-planp_totalhorasdocente').val());
      var planp_valorhoraaula        = parseFloat($('#precificacao-planp_valorhoraaula').val());
      var hiddenplanejamento         = parseFloat($('#precificacao-hiddenplanejamento').val());
      var planp_servpedagogico       = parseFloat($('#precificacao-planp_servpedagogico').val());
      var planp_horaaulaplanejamento = parseFloat($('#precificacao-planp_horaaulaplanejamento').val());
      var planp_diarias              = parseFloat($('#precificacao-planp_diarias').val());
      var planp_passagens            = parseFloat($('#precificacao-planp_passagens').val());
      var planp_pessoafisica         = parseFloat($('#precificacao-planp_pessoafisica').val());
      var planp_pessoajuridica       = parseFloat($('#precificacao-planp_pessoajuridica').val());
      var hiddenPJApostila           = parseFloat($('#precificacao-hiddenpjapostila').val());
      var planp_custosmateriais      = parseFloat($('#precificacao-planp_custosmateriais').val());
      var hiddenmaterialdidatico     = parseFloat($('#precificacao-hiddenmaterialdidatico').val());
      var planp_custosconsumo        = parseFloat($('#precificacao-planp_custosconsumo').val());
      var totalhoraaulacustodireto   = parseFloat($('#precificacao-totalhoraaulacustodireto').val());

      //SEÇÃO 3
      var planp_custosindiretos  = parseFloat($('#precificacao-planp_custosindiretos').val());
      var planp_ipca             = parseFloat($('#precificacao-planp_ipca').val());
      var planp_reservatecnica   = parseFloat($('#precificacao-planp_reservatecnica').val());
      var planp_despesadm        = parseFloat($('#precificacao-planp_despesadm').val());
      var planp_totalincidencias = parseFloat($('#precificacao-planp_totalincidencias').val());
      var planp_precosugerido    = parseFloat($('#precificacao-planp_precosugerido').val());
      var planp_parcelas         = parseFloat($('#precificacao-planp_parcelas').val());
      var planp_desconto         = parseFloat($('#precificacao-planp_desconto').val());

      //CÁLCULOS REALIZADOS
      //SEÇÃO 2
      var valor_servpedagogico        = planp_servpedagogico * hiddenplanejamento;
      var valorTotalMaoDeObra         = (planp_totalhorasdocente * planp_valorhoraaula) + valor_servpedagogico;
      var valorDecimo                 = valorTotalMaoDeObra / planp_mesesdocurso;
      var valorFerias                 = valorDecimo;
      var valorTercoFerias            = valorFerias / 3;
      var totalSalarios               = valorTotalMaoDeObra + valorDecimo + valorFerias + valorTercoFerias;
      var totalEncargos               = (totalSalarios * planp_encargos) / 100;
      var totalSalariosEncargos       = totalSalarios + totalEncargos;
      var totalMaterial               = hiddenmaterialdidatico * planp_qntaluno;
      var totalPJApostila             = hiddenPJApostila * planp_qntaluno;
      var valorTotalDireto            = totalSalariosEncargos + planp_diarias + planp_passagens + planp_pessoafisica + planp_pessoajuridica + totalPJApostila + totalMaterial + planp_custosconsumo;
      var totalhoraaulacustodireto    = valorTotalDireto / planp_cargahoraria / planp_qntaluno;

      //SEÇÃO 3
      var totalIncidencia             = planp_custosindiretos + planp_ipca + planp_reservatecnica + planp_despesadm;
      var totalCustoIndireto          = (valorTotalDireto * planp_totalincidencias) / 100;
      var despesaTotal                = totalCustoIndireto + valorTotalDireto;

      var markupDivisor               = (100 - totalIncidencia);
      var markupMultiplicador         = ((100 / markupDivisor) - 1) * 100; // Valores em %
      var precoVendaTurma             = (valorTotalDireto / markupDivisor) * 100; // Valores em %
      var precoVendaAluno             = (precoVendaTurma / planp_qntaluno);
      var valorhoraAulaAluno          = precoVendaTurma / planp_cargahoraria / planp_qntaluno; //Preço de Venda da Turma / CH TOTAL / QNT Alunos
      var retornoPrecoVenda           = precoVendaTurma - despesaTotal; // Preço de venda da turma - Despesa Total;
      var porcentagemRetorno          = (retornoPrecoVenda / precoVendaTurma) * 100; // % de Retorno / Preço de venda da Turma -- Valores em %
      var retornoPrecoSugerido        = (planp_precosugerido * planp_qntaluno) - despesaTotal; // Preço de Venda x Qnt de Alunos - Despesa Total;
      var porcentagemRetornoSugerido  = (retornoPrecoSugerido / precoVendaTurma) * 100; // % de Retorno / Preço de venda da Turma -- Valores em %
      var valorTotalPrecoDeVendaTurma = (planp_precosugerido * planp_qntaluno);

      var minimoAlunos = Math.ceil(despesaTotal / planp_precosugerido); // Despesa Total / Preço de Venda;

      var valorParcelas =  planp_precosugerido / planp_parcelas;

      //Reserva Técnica = CH do Plano >= 800  == 10 % senão == 5%;
      planp_reservatecnica = planp_cargahoraria >= 800 ? 10 : 5;

      //Aplicação do Desconto em cima do Preço Sugerido
      var valorComDesconto = planp_precosugerido - ((planp_precosugerido * planp_desconto) / 100);

        //OCULTAR O NAN
        //SEÇÃO 2
        if (isNaN(valor_servpedagogico) || valor_servpedagogico < 0) {
            valor_servpedagogico = '';
        }

        if (isNaN(valorTotalMaoDeObra) || valorTotalMaoDeObra < 0) {
            valorTotalMaoDeObra = '';
        }

        if (isNaN(valorDecimo) || valorDecimo < 0) {
            valorDecimo = '';
        }

        if (isNaN(totalMaterial) || totalMaterial < 0) {
            totalMaterial = '';
        }

        if (isNaN(totalPJApostila) || totalPJApostila < 0) {
            totalPJApostila = '';
        }

        if (isNaN(valorTotalDireto) || valorTotalDireto < 0) {
            valorTotalDireto = '';
        }

        if (isNaN(totalhoraaulacustodireto) || totalhoraaulacustodireto < 0) {
            totalhoraaulacustodireto = '';
        }

        //SEÇÃO 3

        if (isNaN(totalIncidencia) || totalIncidencia < 0) {
            totalIncidencia = '';
        }

        if (isNaN(totalCustoIndireto) || totalCustoIndireto < 0) {
            totalCustoIndireto = '';
        }

        if (isNaN(despesaTotal) || despesaTotal < 0) {
            despesaTotal = '';
        }

        if (isNaN(minimoAlunos) || minimoAlunos < 0) {
            minimoAlunos = '';
        }

        if (isNaN(valorParcelas) || valorParcelas < 0) {
            valorParcelas = '';
        }
        
      //RESULTADO DOS VALORES
      //SEÇÃO 2
      $('#precificacao-planp_horaaulaplanejamento').val(valor_servpedagogico); // Valor hora/aula Planejamento
      $('#precificacao-planp_totalcustodocente').val(valorTotalMaoDeObra); // Custo de Mão de Obra Direta
      $('#precificacao-planp_decimo').val(valorDecimo); // 1/12 de 13º
      $('#precificacao-planp_ferias').val(valorFerias); // 1/12 de Férias
      $('#precificacao-planp_tercoferias').val(valorTercoFerias); // 1/12 de 1/3 de férias
      $('#precificacao-planp_totalsalario').val(totalSalarios); // Total de Salários
      $('#precificacao-planp_totalencargos').val(totalEncargos); // Total de Salários x encargos %
      $('#precificacao-planp_totalsalarioencargo').val(totalSalariosEncargos); // Total de Salários + Total de Encargos
      $('#precificacao-planp_pjapostila').val(totalPJApostila); // Total de Material x Quantidade de Alunos
      $('#precificacao-planp_custosmateriais').val(totalMaterial); // Total de Apostilas x Quantidade de Alunos
      $('#precificacao-planp_totalcustodireto').val(valorTotalDireto); // Valor Total Custo Direto (Total Salários e encargos + custos materiais + diárias + passagens + pf + pj)
      $('#precificacao-planp_totalhoraaulacustodireto').val(totalhoraaulacustodireto); // Valor hora/aula de custo direto (Total de custo direto / CH Total / Qnt Aluno)

      //SEÇÃO 3
      $('#precificacao-planp_reservatecnica').val(planp_reservatecnica); // Reserva Técnica baseada na CH: (5% < 800 >= 10%)
      $('#precificacao-planp_totalincidencias').val(totalIncidencia); // Valor Custos indireto + IPCA/MES + reserva técnica + despesa adm
      $('#precificacao-planp_totalcustoindireto').val(totalCustoIndireto); // Valor Custo Direto x Total Incidencias
      $('#precificacao-planp_despesatotal').val(despesaTotal); // Valor Custo Indireto + Custo Direto
      $('#precificacao-planp_markdivisor').val(markupDivisor); // Markup Divisor 100 - x / 100
      $('#precificacao-planp_markmultiplicador').val(markupMultiplicador); // Markup Multiplicador  ((100 / x ) -1) * 100
      $('#precificacao-planp_vendaturma').val(precoVendaTurma); // Valor Total Direto / markupDivisor
      $('#precificacao-planp_vendaaluno').val(precoVendaAluno); // Preço de Venda por Turma /  Qnt de Alunos
      $('#precificacao-planp_horaaulaaluno').val(valorhoraAulaAluno); // Preço de Venda da Turma / CH TOTAL / QNT Alunos
      $('#precificacao-planp_retorno').val(retornoPrecoVenda); // Preço de venda da turma - Despesa Total
      $('#precificacao-planp_porcentretorno').val(porcentagemRetorno); // % de Retorno / Preço de venda da Turma
      $('#precificacao-planp_retornoprecosugerido').val(retornoPrecoSugerido); // Preço de Venda x Qnt de Alunos - Despesa Total;
      $('#precificacao-planp_minimoaluno').val(minimoAlunos); // Despesa Total / Preço de Venda;
      $('#precificacao-planp_valorparcelas').val(valorParcelas); // Preço de Venda / Quantidade de Parcelas;
      $('#precificacao-planp_valorcomdesconto').val(valorComDesconto); //Cálculo do valor com desconto aplicado

      $('#precificacao-planp_vendaturmasugerido').val(valorTotalPrecoDeVendaTurma); //Cálculo do Preço Sugerido x quantidade de alunos
      $('#precificacao-planp_porcentretornosugerido').val(porcentagemRetornoSugerido); //Cálculo do valor com desconto aplicado


      //Aplicação do Desconto de 30%
      // $('#precificacao-planp_valorcomdesconto').text($('#precificacao-desconto').val());
      //     $("#precificacao-desconto").on('change', function() {
      //      if ($(this).is(':checked')) {

      //        desconto = (planp_precosugerido * 70) / 100;
      //        $('#precificacao-planp_valorcomdesconto').val(desconto);

      //      } else {
      //         $('#precificacao-planp_valorcomdesconto').val(0);
      //      }
           
      //     });

    };
 });
