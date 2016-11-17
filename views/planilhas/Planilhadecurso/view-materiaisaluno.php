<?php

use kartik\detail\DetailView;
use yii\helpers\Html;

?>
<div class="planilhadecurso-view">

        <table class="table table-condensed table-hover">
         <caption> Listagem de Materiais do Aluno</caption>
          <thead>
            <tr>
              <th>Descrição</th>
              <th>Quantidade</th>
              <th>Valor Unitário</th>
              <th>Unidade</th>
              <th>Fonte de Recursos</th>
            </tr>
         </thead>
           <tbody>
               <?php foreach ($modelsPlaniMateriaisAluno as $i => $modelPlaniMateriaisAluno): ?>
            <tr>
                <td><?= $modelPlaniMateriaisAluno->planimatalun_descricao ?></td>
                <td><?= $modelPlaniMateriaisAluno->planimatalun_quantidade ?></td>
                <td><?= $modelPlaniMateriaisAluno->planimatalun_valor ?></td>
                <td><?= $modelPlaniMateriaisAluno->planimatalun_unidade ?></td>
                <td><?= $modelPlaniMateriaisAluno->planimatalun_tipo ?></td>
            </tr>
               <?php endforeach; ?>
           </tbody>
        </table>

</div>
