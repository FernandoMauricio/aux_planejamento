$(function() {

    //Carga Horária
    $('#planilhadecurso-placu_cargahorariaplano').keyup(function() {
       updateTotal();
    });

    //Quantidade de Alunos Pagantes, Isentos e PSG 
    $('#planilhadecurso-placu_quantidadealunos').keyup(function() {
       updateTotal();
    });

    $('#planilhadecurso-placu_quantidadealunosisentos').keyup(function() {
       updateTotal();
    });

    $('#planilhadecurso-placu_quantidadealunospsg').keyup(function() {
       updateTotal();
    });

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
    //Materiais Didáticos / Apostilas
    $('#planilhadecurso-placu_custosmateriais').keyup(function() {
       updateTotal();
    });

    $('#precificacao-placu_hiddenmaterialdidatico').keyup(function() {
       updateTotal();
    });

    $('#planilhadecurso-placu_pjapostila').keyup(function() {
       updateTotal();
    });

    $('#precificacao-placu_hiddenpjapostila').keyup(function() {
       updateTotal();
    });

    $('#planilhadecurso-placu_diarias').keyup(function() {
       updateTotal();
    });

    $('#planilhadecurso-placu_passagens').keyup(function() {
       updateTotal();
    });

    $('#planilhadecurso-placu_pessoafisica').keyup(function() {
       updateTotal();
    });

    $('#planilhadecurso-placu_pessoajuridica').keyup(function() {
       updateTotal();
    });

    $('#planilhadecurso-placu_custosconsumo').keyup(function() {
       updateTotal();
    });

    var updateTotal = function () {

      //Carga Horária do Plano
      var placu_cargahorariaplano       = parseFloat($('#planilhadecurso-placu_cargahorariaplano').val());

      //Quantidade de Alunos Pagantes, Isentos e PSG 
      var placu_quantidadealunos        = parseFloat($('#planilhadecurso-placu_quantidadealunos').val());
      var placu_quantidadealunosisentos = parseFloat($('#planilhadecurso-placu_quantidadealunosisentos').val());
      var placu_quantidadealunospsg     = parseFloat($('#planilhadecurso-placu_quantidadealunospsg').val());

      //Materiais Didáticos / Apostilas
      var placu_custosmateriais        = parseFloat($('#planilhadecurso-placu_custosmateriais').val());
      var placu_hiddenmaterialdidatico = parseFloat($('#planilhadecurso-placu_hiddenmaterialdidatico').val());
      var placu_pjapostila             = parseFloat($('#planilhadecurso-placu_pjapostila').val());
      var placu_hiddenpjapostila       = parseFloat($('#planilhadecurso-placu_hiddenpjapostila').val());

      //Hora/Aula
      var planides_valorhoraaula0 = parseFloat($('#planilhadespesadocente-0-planides_valorhoraaula').val());
      var planides_valorhoraaula1 = parseFloat($('#planilhadespesadocente-1-planides_valorhoraaula').val());
      var planides_valorhoraaula2 = parseFloat($('#planilhadespesadocente-2-planides_valorhoraaula').val());
      var planides_valorhoraaula3 = parseFloat($('#planilhadespesadocente-3-planides_valorhoraaula').val());
      var planides_valorhoraaula4 = parseFloat($('#planilhadespesadocente-4-planides_valorhoraaula').val());
      var planides_valorhoraaula5 = parseFloat($('#planilhadespesadocente-5-planides_valorhoraaula').val());
      //Carga Horária
      var planides_cargahoraria0  = parseFloat($('#planilhadespesadocente-0-planides_cargahoraria').val());
      var planides_cargahoraria1  = parseFloat($('#planilhadespesadocente-1-planides_cargahoraria').val());
      var planides_cargahoraria2  = parseFloat($('#planilhadespesadocente-2-planides_cargahoraria').val());
      var planides_cargahoraria3  = parseFloat($('#planilhadespesadocente-3-planides_cargahoraria').val());
      var planides_cargahoraria4  = parseFloat($('#planilhadespesadocente-4-planides_cargahoraria').val());
      var planides_cargahoraria5  = parseFloat($('#planilhadespesadocente-5-planides_cargahoraria').val());

      //Despesas Diretas
      var placu_diarias        = parseFloat($('#planilhadecurso-placu_diarias').val());
      var placu_passagens      = parseFloat($('#planilhadecurso-placu_passagens').val());
      var placu_pessoafisica   = parseFloat($('#planilhadecurso-placu_pessoafisica').val());
      var placu_pessoajuridica = parseFloat($('#planilhadecurso-placu_pessoajuridica').val());
      var placu_custosconsumo  = parseFloat($('#planilhadecurso-placu_custosconsumo').val());
      
    //CÁLCULOS REALIZADOS

      //Total Quantidade de Alunos
      var valorTotalQntAlunos = placu_quantidadealunos + placu_quantidadealunosisentos + placu_quantidadealunospsg;


      //Custo de Mão de Obra Direta = Valor Hora/Aula * Carga Horária
      var valorTotalMaoDeObra0 = planides_valorhoraaula0 * planides_cargahoraria0;
      var valorTotalMaoDeObra1 = planides_valorhoraaula1 * planides_cargahoraria1;
      var valorTotalMaoDeObra2 = planides_valorhoraaula2 * planides_cargahoraria2;
      var valorTotalMaoDeObra3 = planides_valorhoraaula3 * planides_cargahoraria3;
      var valorTotalMaoDeObra4 = planides_valorhoraaula4 * planides_cargahoraria4;
      var valorTotalMaoDeObra5 = planides_valorhoraaula5 * planides_cargahoraria5;
      var valorTotalMaoDeObra  = valorTotalMaoDeObra0 + valorTotalMaoDeObra1 + valorTotalMaoDeObra2 + valorTotalMaoDeObra3 + valorTotalMaoDeObra4 + valorTotalMaoDeObra5;

      //Despesas Diretas
      var valorDecimo              = valorTotalMaoDeObra / 12;
      var valorFerias              = valorTotalMaoDeObra / 12;
      var valorTercoFerias         = valorTotalMaoDeObra / 12 / 3;
      var totalSalarios            = valorTotalMaoDeObra + valorDecimo + valorFerias + valorTercoFerias;
      var totalEncargos            = (totalSalarios * 32.7) / 100;
      var totalSalariosEncargos    = totalSalarios + totalEncargos;
      var totalMaterial            = placu_hiddenmaterialdidatico * valorTotalQntAlunos;
      var totalPJApostila          = (placu_hiddenpjapostila * valorTotalQntAlunos) + placu_pessoajuridica;
      var valorTotalDireto         = totalSalariosEncargos + placu_diarias + placu_passagens + placu_pessoafisica + totalPJApostila + totalMaterial + placu_custosconsumo;
      var totalhoraaulacustodireto = valorTotalDireto / placu_cargahorariaplano / valorTotalQntAlunos;

      //RESULTADO DOS VALORES
      //Despesa Docente
      $('#planilhadecurso-placu_totalcustodocente').val(valorTotalMaoDeObra); // Custo de Mão de Obra Direta = Valor Hora/Aula * Carga Horária
      $('#planilhadecurso-placu_decimo').val(valorDecimo); // 1/12 de 13º
      $('#planilhadecurso-placu_ferias').val(valorFerias); // 1/12 de Férias
      $('#planilhadecurso-placu_tercoferias').val(valorTercoFerias); // 1/12 de 1/3 de férias
      $('#planilhadecurso-placu_totalsalario').val(totalSalarios); // Total de Salários
      $('#planilhadecurso-placu_totalencargos').val(totalEncargos); // Total de Encargos
      $('#planilhadecurso-placu_totalsalarioencargo').val(totalSalariosEncargos); // Total de Salários + Encargos
      $('#planilhadecurso-placu_pjapostila').val(totalPJApostila); // Total Mat. Didático (Apost./plano A)
      $('#planilhadecurso-placu_custosmateriais').val(totalMaterial); // Total Mat. Didático (Livros/plano A)
      $('#planilhadecurso-placu_totalcustodireto').val(valorTotalDireto); // Total de Custo Direto
      $('#planilhadecurso-placu_totalhoraaulacustodireto').val(totalhoraaulacustodireto); // V. Hora/Aula de Custo Direto
      
    };
 });
