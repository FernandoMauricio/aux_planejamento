$(function() {

    //DESPESAS COM DOCENTE
    //Hora/Aula
    $('#planilhadespesadocente-0-planides_valorhoraaula').keyup(function() {
       updateTotal();
    });

    $('#planilhadespesadocente-1-planides_valorhoraaula').keyup(function() {
       updateTotal();
    });
    $('#planilhadespesadocente-2-planides_valorhoraaula').keyup(function() {
       updateTotal();
    });

    $('#planilhadespesadocente-3-planides_valorhoraaula').keyup(function() {
       updateTotal();
    });
    $('#planilhadespesadocente-4-planides_valorhoraaula').keyup(function() {
       updateTotal();
    });
    $('#planilhadespesadocente-5-planides_valorhoraaula').keyup(function() {
       updateTotal();
    });

    //Carga Horária
    $('#planilhadespesadocente-0-planides_cargahoraria').keyup(function() {
       updateTotal();
    });

    $('#planilhadespesadocente-1-planides_cargahoraria').keyup(function() {
       updateTotal();
    });

    $('#planilhadespesadocente-2-planides_cargahoraria').keyup(function() {
       updateTotal();
    });
    
    $('#planilhadespesadocente-3-planides_cargahoraria').keyup(function() {
       updateTotal();
    });
    
    $('#planilhadespesadocente-4-planides_cargahoraria').keyup(function() {
       updateTotal();
    });
    
    $('#planilhadespesadocente-5-planides_cargahoraria').keyup(function() {
       updateTotal();
    });
    
    //Despesas Diretas
    // $('#planilhadecurso-placu_decimo').keyup(function() {
    //    updateTotal();
    // });

    // $('#planilhadecurso-placu_ferias').keyup(function() {
    //    updateTotal();
    // });

    // $('#planilhadecurso-placu_tercoferias').keyup(function() {
    //    updateTotal();
    // });

    // $('#planilhadecurso-placu_totalsalario').keyup(function() {
    //    updateTotal();
    // });


    var updateTotal = function () {
      //Hora/Aula
      var planides_valorhoraaula0  = parseFloat($('#planilhadespesadocente-0-planides_valorhoraaula').val());
      var planides_valorhoraaula1  = parseFloat($('#planilhadespesadocente-1-planides_valorhoraaula').val());
      var planides_valorhoraaula2  = parseFloat($('#planilhadespesadocente-2-planides_valorhoraaula').val());
      var planides_valorhoraaula3  = parseFloat($('#planilhadespesadocente-3-planides_valorhoraaula').val());
      var planides_valorhoraaula4  = parseFloat($('#planilhadespesadocente-4-planides_valorhoraaula').val());
      var planides_valorhoraaula5  = parseFloat($('#planilhadespesadocente-5-planides_valorhoraaula').val());
      //Carga Horária
      var planides_cargahoraria0   = parseFloat($('#planilhadespesadocente-0-planides_cargahoraria').val());
      var planides_cargahoraria1   = parseFloat($('#planilhadespesadocente-1-planides_cargahoraria').val());
      var planides_cargahoraria2   = parseFloat($('#planilhadespesadocente-2-planides_cargahoraria').val());
      var planides_cargahoraria3   = parseFloat($('#planilhadespesadocente-3-planides_cargahoraria').val());
      var planides_cargahoraria4   = parseFloat($('#planilhadespesadocente-4-planides_cargahoraria').val());
      var planides_cargahoraria5   = parseFloat($('#planilhadespesadocente-5-planides_cargahoraria').val());

      //Despesas Diretas
      // var placu_decimo       = parseFloat($('#planilhadecurso-placu_decimo').val());
      // var placu_ferias       = parseFloat($('#planilhadecurso-placu_ferias').val());
      // var placu_tercoferias  = parseFloat($('#planilhadecurso-placu_tercoferias').val());
      // var placu_totalsalario = parseFloat($('#planilhadecurso-placu_totalsalario').val());


    //CÁLCULOS REALIZADOS
      //Custo de Mão de Obra Direta = Valor Hora/Aula * Carga Horária
      var valorTotalMaoDeObra0  = planides_valorhoraaula0  * planides_cargahoraria0;
      var valorTotalMaoDeObra1  = planides_valorhoraaula1  * planides_cargahoraria1;
      var valorTotalMaoDeObra2  = planides_valorhoraaula2  * planides_cargahoraria2;
      var valorTotalMaoDeObra3  = planides_valorhoraaula3  * planides_cargahoraria3;
      var valorTotalMaoDeObra4  = planides_valorhoraaula4  * planides_cargahoraria4;
      var valorTotalMaoDeObra5  = planides_valorhoraaula5  * planides_cargahoraria5;
      var valorTotalMaoDeObra   = valorTotalMaoDeObra0 + valorTotalMaoDeObra1 + valorTotalMaoDeObra2 + valorTotalMaoDeObra3 + valorTotalMaoDeObra4 + valorTotalMaoDeObra5;

      //Despesas Diretas
      var valorDecimo              = valorTotalMaoDeObra / 12;
      var valorFerias              = valorTotalMaoDeObra / 12;
      var valorTercoFerias         = valorTotalMaoDeObra / 12 / 3;
      var totalSalarios            = valorTotalMaoDeObra + valorDecimo + valorFerias + valorTercoFerias;
      var totalEncargos            = (totalSalarios * 32.7) / 100;
      var totalSalariosEncargos    = totalSalarios + totalEncargos;
      // var totalMaterial            = hiddenmaterialdidatico * planp_qntaluno;
      // var totalPJApostila          = hiddenPJApostila * planp_qntaluno;
      // var valorTotalDireto         = totalSalariosEncargos + planp_diarias + planp_passagens + planp_pessoafisica + totalPJApostila + totalMaterial + planp_custosconsumo;
      // var totalhoraaulacustodireto = valorTotalDireto / planp_cargahoraria / planp_qntaluno;


        //OCULTAR O NAN
        //SEÇÃO 2
        // if (isNaN(valorTotalMaoDeObra) || valorTotalMaoDeObra < 0) {
        //     valorTotalMaoDeObra = '';
        // }
        
      //RESULTADO DOS VALORES
      //Despesa Docente
      $('#planilhadecurso-placu_totalcustodocente').val(valorTotalMaoDeObra); // Custo de Mão de Obra Direta = Valor Hora/Aula * Carga Horária
      $('#planilhadecurso-placu_decimo').val(valorDecimo); // 1/12 de 13º
      $('#planilhadecurso-placu_ferias').val(valorFerias); // 1/12 de Férias
      $('#planilhadecurso-placu_tercoferias').val(valorTercoFerias); // 1/12 de 1/3 de férias
      $('#planilhadecurso-placu_totalsalario').val(totalSalarios); // Total de Salários
      $('#planilhadecurso-placu_totalencargos').val(totalEncargos); // Total de Encargos
      $('#planilhadecurso-placu_totalsalarioencargo').val(totalSalariosEncargos); // Total de Salários + Encargos
      

    };
 });
