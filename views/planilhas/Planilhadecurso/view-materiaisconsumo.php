<?php

use kartik\detail\DetailView;
use yii\helpers\Html;

?>
<div class="planilhadecurso-view">

        <table class="table table-condensed table-hover">
         <caption> Listagem de Unidades Curriculares</caption>
          <thead>
            <tr>
              <th>Cód MXM</th>
              <th>Descrição</th>
              <th>Valor Unitário</th>
              <th>Quantidade</th>
              <th>Unidade</th>
            </tr>
         </thead>
           <tbody>
               <?php foreach ($modelsPlaniConsumo as $i => $modelPlaniConsumo): ?>
            <tr>
                <td><?= $modelPlaniConsumo->planico_codMXM ?></td>
                <td><?= $modelPlaniConsumo->planico_descricao ?></td>
                <td><?= $modelPlaniConsumo->planico_quantidade ?></td>
                <td><?= $modelPlaniConsumo->planico_valor ?></td>
                <td><?= $modelPlaniConsumo->planico_tipo ?></td>
            </tr>
               <?php endforeach; ?>
           </tbody>
        </table>

</div>
