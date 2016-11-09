$(function() {

    //DESPESAS COM DOCENTE
    $('#planilhadespesadocente-0-planides_valorhoraaula').keyup(function() {
       updateTotal();
    });

    $('#planilhadespesadocente-0-planides_cargahoraria').keyup(function() {
       updateTotal();
    });


    var updateTotal = function () {
      //SEÇÃO 2
      var planides_valorhoraaula         = parseFloat($('#planilhadespesadocente-0-planides_valorhoraaula').val());
      var planides_cargahoraria          = parseFloat($('#planilhadespesadocente-0-planides_cargahoraria').val());


      //CÁLCULOS REALIZADOS
      //SEÇÃO 2
      var valorTotalMaoDeObra      = (planides_valorhoraaula * planides_cargahoraria);
      // var valorDecimo              = valorTotalMaoDeObra / 12;
      // var valorFerias              = valorTotalMaoDeObra / 12;
      // var valorTercoFerias         = valorTotalMaoDeObra / 12 / 3;
      // var totalSalarios            = valorTotalMaoDeObra + valorDecimo + valorFerias + valorTercoFerias;
      // var totalEncargos            = (totalSalarios * 32.7) / 100;
      // var totalSalariosEncargos    = totalSalarios + totalEncargos;
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
      //SEÇÃO 2
      $('#planilhadecurso-placu_totalcustodocente').val(valorTotalMaoDeObra); // Valor hora/aula Planejamento

    };
 });
