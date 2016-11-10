<?php

use kartik\detail\DetailView;
use yii\helpers\Html;

?>
<div class="planilhadecurso-view">

        <table class="table table-condensed table-hover">
         <caption> Listagem de Unidades Curriculares</caption>
          <thead>
            <tr>
              <th>Nivel UC</th>
              <th>Descrição</th>
              <th>Carga Horária</th>
            </tr>
         </thead>

           <tbody>
               <?php foreach ($modelsPlaniUC as $i => $modelPlaniUC): ?>
            <tr>
                <td><?= $modelPlaniUC->planiuc_nivelUC ?></td>
                <td><?= $modelPlaniUC->planiuc_descricao ?></td>
                <td><?= $modelPlaniUC->planiuc_cargahoraria ?></td>
            </tr>
               <?php endforeach; ?>
           </tbody>
        </table>

</div>
