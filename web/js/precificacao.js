$(function() {

    //SEÇÃO 2 
    $('#precificacao-planp_cargahoraria').keyup(function() {  
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

    $('#precificacao-planp_custosmateriais').keyup(function() {  
       updateTotal();
    });

    $('#precificacao-totalhoraaulacustodireto').keyup(function() {  
       updateTotal();
    });

    var updateTotal = function () {
      //SEÇÃO 2  
      var planp_cargahoraria         = parseFloat($('#precificacao-planp_cargahoraria').val());
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
      var planp_custosmateriais      = parseFloat($('#precificacao-planp_custosmateriais').val());
      var totalhoraaulacustodireto   = parseFloat($('#precificacao-totalhoraaulacustodireto').val());

      //CÁLCULOS REALIZADOS
      //SEÇÃO 2
      var valor_servpedagogico     = planp_servpedagogico * hiddenplanejamento;
      var valorTotalMaoDeObra      = (planp_totalhorasdocente * planp_valorhoraaula) + valor_servpedagogico;
      var valorDecimo              = valorTotalMaoDeObra / 12;
      var valorTercoFerias         = valorTotalMaoDeObra / 12 / 3;
      var totalSalarios            = valorTotalMaoDeObra + valorDecimo + valorDecimo + valorTercoFerias;
      var totalEncargos            = (totalSalarios * 32.7) / 100;
      var totalSalariosEncargos    = totalSalarios + totalEncargos;
      var valorTotalDireto         = totalSalariosEncargos + planp_diarias + planp_passagens + planp_pessoafisica + planp_pessoajuridica + planp_custosmateriais;
      var totalhoraaulacustodireto = valorTotalDireto / planp_cargahoraria / planp_qntaluno;

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

        if (isNaN(valorTotalDireto) || valorTotalDireto < 0) {
            valorTotalDireto = '';
        }

        if (isNaN(totalhoraaulacustodireto) || totalhoraaulacustodireto < 0) {
            totalhoraaulacustodireto = '';
        }

      //RESULTADO DOS VALORES
      //SEÇÃO 2 
      $('#precificacao-planp_horaaulaplanejamento').val(valor_servpedagogico); // Valor hora/aula Planejamento

      $('#precificacao-planp_totalcustodocente').val(valorTotalMaoDeObra); // Custo de Mão de Obra Direta

      $('#precificacao-planp_decimo').val(valorDecimo); // 1/12 de 13º

      $('#precificacao-planp_ferias').val(valorDecimo); // 1/12 de Férias

      $('#precificacao-planp_tercoferias').val(valorTercoFerias); // 1/12 de 1/3 de férias

      $('#precificacao-planp_totalsalario').val(totalSalarios); // Total de Salários

      $('#precificacao-planp_totalencargos').val(totalEncargos); // Total de Salários x 32.7% (encargos)

      $('#precificacao-planp_totalsalarioencargo').val(totalSalariosEncargos); // Total de Salários + Total de Encargos 

      $('#precificacao-planp_totalcustodireto').val(valorTotalDireto); // Valor Total Custo Direto (Total Salários e encargos + custos materiais + diárias + passagens + pf + pj)

      $('#precificacao-planp_totalhoraaulacustodireto').val(totalhoraaulacustodireto); // Valor hora/aula de custo direto (Total de custo direto / CH Total / Qnt Aluno)

    };
 });