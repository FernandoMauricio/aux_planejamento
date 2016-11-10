<?php

use kartik\detail\DetailView;
use yii\helpers\Html;

?>
<div class="planilhadecurso-view">

        <table class="table table-condensed table-hover">
         <caption> Listagem de Unidades Curriculares</caption>
          <thead>
            <tr>
              <th>Descrição</th>
              <th>Quantidade</th>
              <th>Tipo</th>
            </tr>
         </thead>
           <tbody>
               <?php foreach ($modelsPlaniEquipamento as $i => $modelPlaniEquipamento): ?>
            <tr>
                <td><?= $modelPlaniEquipamento->planieq_descricao ?></td>
                <td><?= $modelPlaniEquipamento->planieq_quantidade ?></td>
                <td><?= $modelPlaniEquipamento->planieq_tipo ?></td>
            </tr>
               <?php endforeach; ?>
           </tbody>
        </table>

</div>
