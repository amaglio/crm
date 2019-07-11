<link   type="text/css" href="<?php echo base_url(); ?>assets/css/home.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/consulta/consulta.css" rel="stylesheet" />


<div class="content-wrapper">
    <section class="content-header">
      <h4>
         <i class="fa fa-home"></i>  <a href="<?=base_url()?>index.php/home/"> Home </a>
      </h4>
    </section>
    <div class="panel-body">
          
   
          <div class="col-md-8">

              <div class="box box-warning pipeline">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-clock-o" aria-hidden="true"></i> Mi pipeline</h3>
                <div class="box-tools pull-right">
                  <a href="<?=base_url()?>index.php/consulta" class="btn btn-warning btn-xs load-queries"><i class="fa fa-plus"></i> Ver mas pipeline</a>
                </div>
              </div>
              <div class="box-body " style="padding:20px">

                  <?php  foreach($pipeline as $row): ?>

                      <?php
                        $datos = json_decode(get_clase_estado_pipeline($row['estado']->DESCRIPCION));
                        //var_dump($datos->class);

                      ?>

                        <div class="btn-group" data-toggle="tooltip" data-placement="top"  data-original-title="<?=$datos->descripcion?>">

                            <a href="<?=base_url()?>index.php/consulta/pipeline/<?=$row['estado']->ID_ESTADO?>"> <button type="button" class="btn   <?=$datos->class?> "><i class="fa fa-search"></i>   <?=$row['estado']->DESCRIPCION?></button> </a>
                          
                            <span class="label label-warning cantidad_pipeline">&nbsp;<?=$row['cantidad']?>&nbsp;</span>
 

                        </div>


                  <?php  endforeach; ?>
                                
              </div>

            </div>

            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-clock-o" aria-hidden="true"></i> Últimas consultas de mis programas</h3>
                <div class="box-tools pull-right">
                  <a href="<?=base_url()?>index.php/consulta" class="btn btn-primary btn-xs load-queries"><i class="fa fa-plus"></i> Ver mas consultas</a>
                </div>
              </div>
              <div class="box-body ">
                <ul class="users-list clearfix">

                  <?php  if( count($consultas) > 0 ): 

                  ?>
                            <table  class="table search-result table-striped table-bordered" id="consultas_generales" cellspacing="0" width="100%">
                              <thead>
                                  <th>ID</th>
                                  <th>Fecha</th>
                                  <th>Nombre</th>
                                  <th>Programas</th>
                                  <th>Ver</th>
                              </thead>
                              <tbody>
                                
                                <?php  for ($i=0; $i < count($consultas); $i++): ?>
                                
                                <?php
                                        $consultas_sin_asignar=0;
                                        if( ! isset($row['OPERADOR_A_CARGO'] ) )
                                          $consultas_sin_asignar++;
                                ?>


                                <tr>
                                    <td><?=$consultas[$i]['ID_CRM_CONSULTA']?></td>
                                    <td><?=$consultas[$i]['FECHA_CONSULTA']?></td>
                                    <td><?=$consultas[$i]['NOMBRE_APELLIDO']?></td>
                                    <td>
                                        <?php

                                          $programas = explode("/", $consultas[$i]['PROGRAMAS_INTERESADOS']);

                                          foreach ($programas as $programa) 
                                          {
                                            echo "<span class='label label-warning' style='margin-ritgh:5px' >".$programa."</span>";
                                          }

                                        ?>
                                    </td>
                                    <td>
                                        <a  data-toggle="tooltip" data-placement="bottom" data-original-title="Ir a la consulta" href="<?=base_url()?>index.php/consulta/ver_consulta/<?=$consultas[$i]['ID_CRM_CONSULTA']?>">
                                            
                                                <i class="fa fa-2x fa-search" aria-hidden="true" style="color: #00a65a;"> </i>
                                         
                                        </a>
                                    </td>
                                </tr>

                                <?php  endfor; ?>

                              </tbody>
                            </table>

                   <?php   else: ?>

                        <div class="  danger">
                          <i class="fa fa-exclamation-circle"> </i> Todavía no se ha cargado/importado ninguna consulta con sus <strong>programas</strong> de interés. <br>
                          Puede ver/agregar/eliminar los programas que gestiona desde:
                           
                          <a href="<?php echo base_url(); ?>index.php/configuracion/programas" style="font-weight:bold;  padding-left:10px;">
                            <i class="fa fa-graduation-cap" aria-hidden="true"></i> Mis programas.
                          </a>
                          
                        </div>

                  <?php   endif;  ?>
    
                   

                </ul>
              </div>

            </div>

          </div>
          
          <!-- Botones -->
          <div class="col-md-4 right-pane">

              <div class="col-md-6">

                   <div class="info-box bg-green not-imported">
                      <a href="<?=base_url()?>index.php/importador/index_web"><span class="info-box-icon"><i class="fa fa-globe" aria-hidden="true"></i></span></a>

                      <div class="info-box-content">
                        <span class="info-box-text">Consultas web sin importar</span>
                        <span class="info-box-number">
                            <?=$cantidad_contactos_pendientes?>
                            <?php if($cantidad_asistentes_pendientes)
                                    echo "<span class='text-danger small'> (".$cantidad_asistentes_pendientes." asistente a evento)</span> ";

                            ?>
                        </span>
                        <span class="progress-description">
                            <a href="<?=base_url()?>index.php/importador/index_web"> Importar / Eliminar <i class="fa fa-arrow-circle-right"></i> </a>
                        </span>
                        </div>
                    </div>

              </div>
              
              <div class="col-md-6">


                  <div class="info-box bg-blue my-queries">
                       <a href="<?=base_url()?>index.php/consulta/mis_consultas">  <span class="info-box-icon"> <i class="fas fa-clipboard-check"></i> </span> </a>

                      <div class="info-box-content">
                        <span class="info-box-text">Mis consultas</span>
                        <span class="info-box-number"><?=$mis_consultas_a_cargo?></span>
                        <span class="progress-description">
                          <a href="<?=base_url()?>index.php/consulta/mis_consultas"> Ver<i class="fas fa-arrow-circle-right"></i> </a>
                        </span>
                      </div>
                  </div>

              </div>

              <div class="col-md-6">
                  
                  <div class="info-box bg-red active-events">
                      <span class="info-box-icon"> <i class="fas fa-ticket-alt"></i> </span>
                      <div class="info-box-content">
                        <span class="info-box-text">Eventos activos</span>
                        <span class="info-box-number"><?=$eventos_activos?></span>
                        <span class="progress-description">
                          <a href="<?=base_url()?>index.php/evento/index"> Ver <i class="fa fa-arrow-circle-right"></i> </a>
                        </span>
                      </div>
                  </div>

              </div>

              <div class="col-md-6">

                  <div class="info-box bg-yellow unchecked-queries">
                      <span class="info-box-icon"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">Consultas sin ver</span>
                        <span class="info-box-number"><?=$cantidad_consultas_sin_ver?></span>
                        <span class="progress-description">
                          <!--<a href="<?=base_url()?>index.php/evento/index"> Ver <i class="fa fa-arrow-circle-right"></i> </a> -->
                        </span>
                      </div>
                  </div>

              </div>

               <div class="col-md-6">

                  <div class="info-box bg-purple unchecked-queries">
                      <span class="info-box-icon"><i class="fa fa-external-link-alt"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">Consultas sin asignar</span>
                        <span class="info-box-number"><?=$consultas_sin_asignar?></span>
                        <span class="progress-description">
                          <!--<a href="<?=base_url()?>index.php/evento/index"> Ver <i class="fa fa-arrow-circle-right"></i> </a> -->
                          <a href="<?=base_url()?>index.php/consulta/mis_consultas"> Ver<i class="fas fa-arrow-circle-right"></i> </a>
                        </span>
                      </div>
                  </div>

              </div>
              
                     
              <div class="col-md-12">

                    <a   href="<?=base_url()?>index.php/consulta/ver_alta_consulta_1/">
                        <button type="button" class="btn  btn-danger  btn-block btn-lg">
                            <i class="fa fa-plus"></i> Cargar consulta
                        </button>
                    </a>

                    <a   href="<?=base_url()?>index.php/consulta/pipeline/">
                        <button type="button" class="btn  btn-warning btn-lg btn-block">
                            <i class="fa fa-road"></i> Ver pipeline
                        </button>
                    </a>

                    <a   href="<?=base_url()?>index.php/consulta/index/">
                        <button type="button" class="btn  btn-purple btn-lg btn-block">
                            <i class="fa fa-search"></i> Buscar consultas
                        </button>
                    </a>

                    <a   href="<?=base_url()?>index.php/consulta/mis_consultas">
                        <button type="button" class="btn  btn-primary btn-lg btn-block">
                            <i class="fa fa-angle-right" aria-hidden="true"></i> Mis consultas
                        </button>
                    </a>


              </div>

              <div class="col-md-12">

                    <div class="box box-success">
                      <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-clock-o" aria-hidden="true"></i> Acciones / Alarma</h3>
                      
                      </div>
                      <div class="box-body ">
                      </div>
                    </div>

              </div>

          </div>

    </div>
</div>


<link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery-1.12.4.js " type="text/javascript" ></script>

<script>
     var q = jQuery.noConflict();
</script>

 <!-- DATA TABES SCRIPT -->
<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>

<script type="text/javascript">

q(document).ready(function() {
    q('#consultas_generales').dataTable({
                "paging":   true,
                "ordering": true,
                "info":     true,
                "bFilter": true,
                "language": {
                    "lengthMenu": "Mostrando _MENU_ universidades por pagina.",
                    "zeroRecords": "Ninguna postulacion fue encontrada.",
                    "info": "<b> Mostrando pagina _PAGE_ de _PAGES_ </b>",
                    "infoEmpty": "Ninguna postulacion disponible",
                    "infoFiltered": "(Filtrado de _MAX_ universidades totales)",
                    "sSearch": " Buscar    ",
                    "oPaginate": {
                                    "sNext": "Pag. sig.",
                                    "sPrevious": "Pag. ant."
                                  }
                }

            });
} );


</script>