<?php

use kartik\detail\DetailView;
use yii\helpers\Html;

?>
<div class="planilhadecurso-view">

        <table class="table table-condensed table-hover">
         <caption> Listagem de Materiais Didáticos</caption>
          <thead>
            <tr>
              <th>Descrição</th>
              <th>Nivel UC</th>
              <th>Valor Unitário</th>
              <th>Tipo Material</th>
              <th>Editora</th>
              <th>Plano</th>
              <th>Observação</th>
              <th>Arquivo</th>
            </tr>
         </thead>
           <tbody>
               <?php foreach ($modelsPlaniMaterial as $i => $modelPlaniMaterial): ?>
            <tr>
                <td><?= $modelPlaniMaterial->planima_titulo ?></td>
                <td><?= $modelPlaniMaterial->planima_nivelUC ?></td>
                <td><?= $modelPlaniMaterial->planima_valor ?></td>
                <td><?= $modelPlaniMaterial->planima_tipomaterial ?></td>
                <td><?= $modelPlaniMaterial->planima_editora ?></td>
                <td><?= $modelPlaniMaterial->planima_tipoplano ?></td>
                <td><?= $modelPlaniMaterial->planima_observacao ?></td>
                <td><a target="_blank" href="http://localhost/aux_planejamento/web/uploads/repositorio/<?php echo $modelPlaniMaterial->planima_arquivo ?>"> <?php echo $modelPlaniMaterial->planima_arquivo ?></a></td>
            </tr>
               <?php endforeach; ?>
           </tbody>
        </table>

</div>
