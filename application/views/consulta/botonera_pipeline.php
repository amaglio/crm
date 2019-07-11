
<div class="margin ml-0 pipeline">

 
		<?php  foreach($array_pipeline as $row): ?>

              <?php
                $datos = json_decode(get_clase_estado_pipeline($row['estado']->DESCRIPCION));
                //var_dump($datos->class);

              ?>

                <div class="btn-group" data-toggle="tooltip" data-placement="top"  data-original-title="<?=$datos->descripcion?>">

                    <a href="<?=base_url()?>index.php/consulta/pipeline/<?=$row['estado']->ID_ESTADO?>"> <button type="button" class="btn   <?=$datos->class?> "><i class="fa fa-search"></i>   <?=$row['estado']->DESCRIPCION?></button> </a>
                  
                    <span class="label label-warning cantidad_pipeline">&nbsp;<?=$row['cantidad']?>&nbsp;</span>


                </div>


          <?php  endforeach; ?>
	
 

    <div class="btn-group pull-right">
			<button type="button" class="btn btn-warning mr-10px"><a href="<?=base_url()?>index.php/consulta/pipeline"> <i class="fa fa-list-ul" aria-hidden="true"></i>  Resumen </a> </button>
			<!-- <button data-toggle="tooltip" data-placement="bottom" data-original-title="Exportar Pipiline a un Excel" type="button" class="btn btn-warning "   ><a href="<?=base_url()?>index.php/consulta/pipeline"><i class="fa fa-file-excel-o fa-1x" aria-hidden="true"></i> </a> </button>  -->

    </div>


</div>