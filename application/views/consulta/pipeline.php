<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/consulta/consulta.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/base.css" rel="stylesheet" />

<link href="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/plugins/datatables/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />


<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <section class="content-header">
      <h4>
        <i class="fa fa-road" aria-hidden="true"></i>
        <a href="<?=base_url()?>index.php/home/">
            Consultas  / Pipeline
        </a>

         <span class="pull-right" data-toggle="tooltip" data-placement="bottom" data-original-title="Ver ayuda">
            <a href="#" data-toggle="control-sidebar" ><i class="fa fa-question-circle"></i> Ayuda </a>
          </span>

      </h4>
      


    </section>
    <div class="panel-body">
      
     

      <?php  mensaje_resultado($mensaje); ?>

      <?php
        if(isset($botonera)):
            echo $botonera;
        endif;
      ?>

        <?php   // Contar cantidad de consultas standby y activas

            $consulta_standby = 0;
            $consulta_activas = 0;

            if(isset($consultas)):

              for($i=0; $i < count($consultas); $i++ ):
                  if(isset($consultas[$i]['consulta_programa']->FECHA_STANDBY))
                    $consulta_standby++;
                  else
                    $consulta_activas++;
              endfor;

              $titulo = "Consultas Activas: ".$consulta_activas;

            else:

              $titulo = "<i class='fa fa-th-list' aria-hidden='true'></i> Resumen de Consultas/Programas";

            endif;

        ?>

        <!-- Consulta activas o resumen -->
        <div class="box box-primary box-summary">

          <div class="box-header with-border">
            <h3 class="box-title"> <?=$titulo?>  </h3>
          </div>
          <div class="box-body">


            <?php   if(isset($consultas)):  ?> <!-- MOSTRAR PIPELINE ESTADO -->

                 <!-- action="<?=base_url()?>index.php/consulta/procesar_cambiar_consulta_pipeline" -->
                <form class="form-inline" method="post" name="form_procesar_consultas" id="form_procesar_consultas"   >


                <div class="row mb-10px">

                  <div class="box-tools pull-left ml-15px">

                        <button     data-toggle="tooltip" data-placement="bottom" data-original-title="Enviar email a las consultas seleccionadas"
                                    type="submit" class="btn btn-primary" id="submit_email" name="submit_email" value="1">
                            <i class="fa fa-at" aria-hidden="true"></i>
                            Enviar Email
                        </button>

                  </div>

                  <div class="box-tools pull-right mr-25px">

                      <!-- Input hidden fecha -->
                      <input    data-toggle="tooltip" data-placement="bottom"
                                data-original-title="Llegada esta fecha la consulta saldrá del STANDBY y volvera a estar activa"
                                type="text" class="form-control pull-right calendario ml-10px" placeholder="Fecha Standby"
                                id="fecha_standby" name="fecha_standby">

                      <select   data-toggle="tooltip" data-placement="bottom" data-original-title="Estado al que desea enviar la consulta"
                                class="form-control btn-verde_azulado" name="id_estado" id="id_estado">

                      <?php  foreach($estado_consulta->result() as $row): ?>

                            <?php  if($row->ID_ESTADO != 5 && $row->ID_ESTADO != 6): ?>

                              <option value="<?=$row->ID_ESTADO?>">Enviar a <?=$row->DESCRIPCION?></option>

                            <?php  endif; ?>

                      <?php  endforeach; ?>

                      <option class="standby" value="-1">Enviar a STANDBY</option>

                      </select>

                      <!--
                      <button type="submit" class="btn btn-verde_azulado" id="submit_pipeline" name="submit_pipeline" value="submit_pipeline" >
                          <i class="fa fa-chevron-circle-right" > </i> Enviar
                      </button>-->

                      <input type="submit" class="btn btn-verde_azulado"  id="submit_pipeline" name="submit_pipeline" value="Enviar" >


                    </div>
                </div>

                <table  class="table table-striped table-bordered" id="pipeline" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                          <th><input type="checkbox" name="todos" id="todos"> </th>
                          <th>Fecha</th>
                          <th></th>
                          <th>ID</th>
                          <th>Foto</th>
                          <th>Apellido</th>
                          <th>Nombre</th>
                          <th>Programa</th>
                          <th>Email</th>
                          <th>Telefono</th>
                          <th>Ingreso</th>
                          <th>Comentario</th>
                      </tr>
                  </thead>

                  <?php   if(isset($consultas)): ?>

                      <?php   if( count($consultas) > 0): ?>

                          <tbody>

                              <?php   for($i=0; $i < count($consultas); $i++ ): ?>

                                <?php   if(!isset($consultas[$i]['consulta_programa']->FECHA_STANDBY)):  ?>

                                      <tr>
                                        <td class="w-10px"> <input class="clase_consulta" value="<?=$consultas[$i]['consulta_programa']->ID_CRM_CONSULTA_PROGRAMA?>" type="checkbox" id="id_consulta_prg" name="id_consulta_prg[]"> </td>
                                        <td><?=$consultas[$i]['consulta_programa']->FECHA_CONSULTA?></td>
                                        <!-- La columna td-date-sort no es visible, la datatable oculta esta columna y la usa como criterio de orden de la columna td-date -->
                                        <!-- Esta columna parsea la FECHA_CONSULTA en formato ISO8601 para que la datatable pueda ordenar bien la fecha -->
                                        <td class="td-date-sort"><?= date_format(date_create(str_replace("/", "-", $consultas[$i]['consulta_programa']->FECHA_CONSULTA)), 'c'); ?></td>
                                        <td><a  data-toggle="tooltip" data-placement="bottom" data-original-title="Ir a la consulta" target="_blank" href="<?=base_url()?>index.php/consulta/ver_consulta/<?=$consultas[$i]['consulta_programa']->ID_CRM_CONSULTA?>"> <?=$consultas[$i]['consulta_programa']->ID_CRM_CONSULTA?>  </td>
                                        <td><a  data-toggle="tooltip" data-placement="bottom" data-original-title="Ir a la persona" target="_blank" href="<?=base_url()?>index.php/contacto/ver_contacto/<?=$consultas[$i]['persona']['datos_usuario']->ID_CRM_PERSONA?>">
                                                <?=buscar_foto_persona($consultas[$i]['persona']['datos_usuario']->ID_PERSONA);?>
                                            </a>
                                        </td>
                                        <td><?=utf8_encode($consultas[$i]['persona']['datos_usuario']->APELLIDO)?></td>
                                        <td><?=utf8_encode($consultas[$i]['persona']['datos_usuario']->NOMBRE)?></td>
                                        <td>
                                            <strong><?=utf8_encode($consultas[$i]['consulta_programa']->PROGRAMA)?></strong> <br>

                                            <?php if( $consultas[$i]['consulta_programa']->ID_ESTADO_CONS_PRG == 6): ?>
                                                
                                                       <?php echo $consultas[$i]['solicitud_admision']->row()->F_SOLICITUD." - ".utf8_encode($consultas[$i]['solicitud_admision']->row()->C_RESULTADO_ADMIN); ?>


                                            <?php     endif;  ?>
                                        </td>
                                        <td>
                                            <?php   foreach ($consultas[$i]['persona']['datos_emails'] as $email): ?>
                                                    <?=$email['EMAIL']."</br>"?>
                                            <?php   endforeach; ?>

                                        </td>
                                        <td>
                                            <?php   foreach ($consultas[$i]['persona']['datos_telefonos']  as $telefono): ?>
                                                    <?=$telefono['TELEFONO']."</br>"?>
                                            <?php   endforeach; ?>

                                        </td>
                                        <td>
                                          <small class="year-description"><?=$consultas[$i]['consulta_programa']->ANIO."-".$consultas[$i]['consulta_programa']->DESCRIPCION?></small>

                                        </td>
                                        <td>
                                            <?php   foreach ($consultas[$i]['comentarios'] as $comentarios): ?>
                                                    <span class="date-user"><strong> <?="[".$comentarios['FECHA']." | ".$comentarios['USUARIO_ORACLE']."]"?> </strong></span>
                                                    <?=$comentarios['COMENTARIO']?><br>
                                            <?php   endforeach; ?>

                                            <?php

                                            ?>
                                            <a data-toggle="modal" data-target="#modal_agregar_comentario"  data-whatever="<?=$consultas[$i]['consulta_programa']->ID_CRM_CONSULTA_PROGRAMA?>"  >
                                                    <button data-toggle="tooltip" data-placement="bottom" data-original-title="Agregar un comentario" type="button" class="btn  btn-purple btn-sm" >
                                                      <i class="fa fa-comment" aria-hidden="true"></i>
                                                    </button>
                                            </a>


                                        </td>
                                      </tr>

                                <?php   endif; ?>

                              <?php   endfor; ?>

                          </tbody>

                      <?php   endif;  ?>

                  <?php   endif; ?>
                </table>


                </form>


            <?php    else:   ?>  <!-- RESUMEN -->

                <?php   if(isset($cantidad_consultas_estado) && !empty($cantidad_consultas_estado)): ?>

                      <table class="table table-striped table-bordered summary-table" cellspacing="0" width="100%">

                          <?php   foreach ($cantidad_consultas_estado as $key => $value): ?>

                                <tr>
                                  <td><strong><?=$key?></strong></td>
                                  <td><?=$value?></td>
                                </tr>

                          <?php   endforeach; ?>


                      </table>

                <?php   else: ?>

                        <div class="callout callout-danger">
                           Ninguna de sus consultas tiene este estado
                        </div>

                <?php   endif; ?>

            <?php   endif;  ?>
          </div>

        </div>



        <!-- Consulta standby o resumen -->
        <?php   if(isset($consultas)):  ?>

          <form class="form-inline" method="post" name="form_cambiar_standby" id="form_cambiar_standby" action="<?=base_url()?>index.php/consulta/sacar_consulta_standby">


            <div class="box box-danger collapsed-box">

                <div class="box-header with-border">
                  <h3 class="box-title">Consultas STANDBY : <strong> <?=$consulta_standby?> </strong> </h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">

                      <div class="row mb-10px">

                          <div class="box-tools pull-right mr-25px">

                              <input class="btn btn-danger mb-10px" type="submit" id="submit_standby" name="submit_standby" value="Quitar de Standby">
                          </div>
                      </div>


                      <table  class="table table-striped table-bordered" id="pipeline_standby" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="th-checkbox"><input type="checkbox" name="todos_standby" id="todos_standby"></th>
                                <th class="th-date">Fecha</th>
                                <th></th>
                                <th class="th-standby">Stand By hasta</th>
                                <th class="th-id">ID</th>
                                <th class="th-picture">Foto</th>
                                <th class="th-surname">Apellido</th>
                                <th class="th-name">Nombre</th>
                                <th>Programa</th>
                                <th class="th-email">Email</th>
                                <th class="th-phone">Telefono</th>
                                <th class="th-entry-date">Ingreso</th>
                                <th>Comentario</th>
                            </tr>
                        </thead>

                        <?php   if(isset($consultas)): ?>

                            <?php   if( count($consultas) > 0): ?>

                                <tbody>

                                    <?php   for($i=0; $i < count($consultas); $i++ ): ?>

                                      <?php   if(isset($consultas[$i]['consulta_programa']->FECHA_STANDBY)):  ?>

                                            <tr>
                                              <td> <input class="clase_consulta_standby" value="<?=$consultas[$i]['consulta_programa']->ID_CRM_CONSULTA_PROGRAMA?>" type="checkbox" id="id_consulta_prg" name="id_consulta_prg[]"> </td>
                                              <td><?=$consultas[$i]['consulta_programa']->FECHA_CONSULTA?></td>
                                              <!-- La columna td-date-sort no es visible, la datatable oculta esta columna y la usa como criterio de orden de la columna td-date -->
                                              <!-- Esta columna parsea la FECHA_CONSULTA en formato ISO8601 para que la datatable pueda ordenar bien la fecha -->
                                              <td class="td-date-sort"><?= date_format(date_create(str_replace("/", "-", $consultas[$i]['consulta_programa']->FECHA_CONSULTA)), 'c'); ?></td>
                                              <td><?=$consultas[$i]['consulta_programa']->FECHA_STANDBY?></td>

                                            <td><a  data-toggle="tooltip" data-placement="bottom" data-original-title="Ir a la consulta" target="_blank" href="<?=base_url()?>index.php/consulta/ver_consulta/<?=$consultas[$i]['consulta_programa']->ID_CRM_CONSULTA?>"> <?=$consultas[$i]['consulta_programa']->ID_CRM_CONSULTA?>  </td>
                                            <td><a  data-toggle="tooltip" data-placement="bottom" data-original-title="Ir a la persona" target="_blank" href="<?=base_url()?>index.php/contacto/ver_contacto/<?=$consultas[$i]['persona']['datos_usuario']->ID_CRM_PERSONA?>">
                                                    <?=buscar_foto_persona($consultas[$i]['persona']['datos_usuario']->ID_PERSONA);?>
                                                </a>
                                            </td>



                                              <td><?=$consultas[$i]['persona']['datos_usuario']->APELLIDO?></td>
                                              <td><?=$consultas[$i]['persona']['datos_usuario']->NOMBRE?></td>
                                              <td>
                                                  <strong><?=utf8_encode($consultas[$i]['consulta_programa']->PROGRAMA)?></strong>
                                              </td>
                                              <td>
                                                  <?php   foreach ($consultas[$i]['persona']['datos_emails']  as $email): ?>
                                                          <?=$email['EMAIL']."</br>"?>
                                                  <?php   endforeach; ?>

                                              </td>
                                              <td>
                                                  <?php   foreach ($consultas[$i]['persona']['datos_telefonos']  as $telefono): ?>
                                                          <?=$telefono['TELEFONO']."</br>"?>
                                                  <?php   endforeach; ?>

                                              </td>
                                              <td>
                                                <small><?=$consultas[$i]['consulta_programa']->ANIO."-".$consultas[$i]['consulta_programa']->DESCRIPCION?></small>
                                              </td>
                                              <td>
                                                  <?php   foreach ($consultas[$i]['comentarios'] as $comentarios): ?>
                                                          <span class="fs-12px"><strong> <?="[".$comentarios['FECHA']." | ".$comentarios['USUARIO_ORACLE']."]"?> </strong></span>
                                                          <?=$comentarios['COMENTARIO']?><br>
                                                  <?php   endforeach; ?>

                                                   <a data-toggle="modal" data-target="#modal_agregar_comentario"  data-whatever="<?=$consultas[$i]['consulta_programa']->ID_CRM_CONSULTA_PROGRAMA?>"  >
                                                          <button type="button" class="btn  btn-purple btn-sm" >
                                                            <i class="fa fa-comment" aria-hidden="true"></i>
                                                          </button>
                                                  </a>


                                              </td>
                                            </tr>

                                      <?php   endif; ?>

                                    <?php   endfor; ?>

                                </tbody>

                            <?php   endif;  ?>

                         <?php   endif;  ?>
                      </table>

                </div>


            </div>

          </form>

        <?php   endif;  ?>


    </div>


</div>



<aside class="control-sidebar control-sidebar-dark"  >
   <div class="callout callout-informativo pb-10px pt-10px">
        <h4>Gestione más fácil las consultas!</h4>
        <p> La sección "Pipeline" le permitirá operar sobre los programas de sus consultas. Una consulta puede tener mas de un programa asociado y cada programa de esa consulta estar en un estado distinto.
        <br>Los estados: <strong>nuevo</strong>, <strong>potencial</strong> y <strong>desestimado</strong> son elegidos a discreción por usted. Mientras que <strong>entrevista</strong> y <strong>solicitud de admisión</strong> son definidos automáticamente por el sistema cuando se carga desde SIGEU, una entrevista o una solicitud de admision para un programa de esa consulta.
        </p>

      </div>
</aside>

<!-- MODAL  -->
<div class="modal fade " id="modal_agregar_comentario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar comentario</h4>
      </div>

      <form  name="form_agregar_comentario" id="form_agregar_comentario" method="POST"  action="<?=base_url()?>index.php/consulta/agregar_comentario_programa/" >

        <div class="modal-body mb-20px">

              <input type="hidden" name="id_crm_consulta_programa" id="id_crm_consulta_programa">


              <div class="form-group pb-50px">
                <label for="anio" class="col-sm-2 control-label">Programa</label>
                <div class="col-sm-9">
                   <input class="form-control"  type="text" name="programa" id="programa" readonly="readonly">
                </div>
              </div>

              <div class="form-group pb-50px">
                <label for="carrera" class="col-sm-2 control-label">Comentario</label>
                <div class="col-sm-9">

                    <textarea  class="form-control" name="comentario" id="comentario"></textarea>

                </div>
              </div>



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Aceptar</button>
        </div>

      </form>
    </div>
  </div>
</div>



 <!-- DATA TABES SCRIPT -->

<!-- <link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" /> -->

<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery-1.12.4.js " type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.buttons.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.flash.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jszip.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/pdfmake.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/vfs_fonts.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.html5.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.print.min.js" type="text/javascript" ></script>



<script>
     var q = jQuery.noConflict();
</script>

<!--
<script src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript" ></script>
<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>-->


<script type="text/javascript">

/* Tablas pipeline y standby */
q(document).ready(function() {

    q('#pipeline').dataTable({
                dom: 'Bfrtip',
                buttons: [
                      'excel', 'pdf', 'print'
                  ],
                "paging":   true,
                "ordering": true,
                "info":     true,
                "bFilter": true,
                "language": {
                    "lengthMenu": "Mostrando _MENU_ consultas por pagina.",
                    "zeroRecords": "Ninguna consulta fue encontrada.",
                    "info": "<b> Mostrando pagina _PAGE_ de _PAGES_ </b>",
                    "infoEmpty": "Ninguna consulta disponible",
                    "infoFiltered": "(Filtrado de _MAX_ consultas totales)",
                    "sSearch": " Buscar    ",
                    "oPaginate": {
                                    "sNext": "Pag. sig.",
                                    "sPrevious": "Pag. ant."
                                  }
                },
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [0, 4, 11] },
                    {
                        "targets": [ 2 ],
                        "visible": false,
                        "searchable": false
                    },
                    { "orderData":[ 2 ],   "targets": [ 1 ] }
                ],
                "order": [[1, "desc"]]

            });

    q('#pipeline_standby').dataTable({
                dom: 'Bfrtip',
                buttons: [
                      'excel', 'pdf', 'print'
                  ],
                "paging":   true,
                "ordering": true,
                "info":     true,
                "bFilter": true,
                "language": {
                    "lengthMenu": "Mostrando _MENU_ consultas por pagina.",
                    "zeroRecords": "Ninguna consulta fue encontrada.",
                    "info": "<b> Mostrando pagina _PAGE_ de _PAGES_ </b>",
                    "infoEmpty": "Ninguna consulta disponible",
                    "infoFiltered": "(Filtrado de _MAX_ consultas totales)",
                    "sSearch": " Buscar    ",
                    "oPaginate": {
                                    "sNext": "Pag. sig.",
                                    "sPrevious": "Pag. ant."
                                  }
                },
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [0, 5, 12] },
                    {
                        "targets": [ 2 ],
                        "visible": false,
                        "searchable": false
                    },
                    { "orderData":[ 2 ],   "targets": [ 1 ] }
                ],
                "order": [[1, "desc"]]

            });

} );


q(function(){

    pipeline_tabla = q('#pipeline').dataTable();

    if(pipeline_tabla.fnSettings().aoData.length===0)
    {
       q("#submit_pipeline").attr("disabled", true);
       q("#id_estado").attr("disabled", true);
    }



    standby_tabla = q('#pipeline_standby').dataTable();

    if(standby_tabla.fnSettings().aoData.length===0)
    {
       q("#submit_standby").attr("disabled", true);
    }


});

</script>

<!-- bootstrap datepicker -->
<script src="<?=base_url()?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">

  q('.calendario').datepicker({
    autoclose: true,
    format: 'dd/mm/yyyy'
  });

</script>



<!-- VALIDAR FORMULARIOS -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.10.custom.min.js"></script>

<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js" ></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js" ></script>

<script>
var jq_va = jQuery.noConflict();
</script>

<script type="text/javascript">


  jq_va(function(){

      jq_va('#form_agregar_comentario').validate({

          rules :{

                  id_crm_consulta_programa : {
                      required : true
                  },
                  comentario: {
                      required : true
                  }
          },
          messages : {

                  id_crm_consulta_programa : {
                      required : "Debe elegir el programa para el comentario."
                  },
                  comentario: {
                      required : "Debe ingresar un comentario"
                  }
          },
          invalidHandler: function(event, validator) {
              jq_va('#form_agregar_comentario').find(":submit").removeAttr('disabled');
          }

      });
  });

  /* Valida procesar consulta */
  jq_va(function(){

            jq_va('#form_procesar_consultas').validate({

                rules :{

                        'id_consulta_prg[]' : {
                            required : true
                        },
                        fecha_standby : {
                            required : true
                        }
                },
                messages : {

                        'id_consulta_prg[]' : {
                            required : "Debe elegir alguna consulta/prg"
                        },
                        fecha_standby : {
                            required : "Debe elegir la fecha de standby"
                        }
                } ,
                invalidHandler: function(event, validator) {
                    jq_va('#form_procesar_consultas').find(":submit").removeAttr('disabled');
                }

            });
  });

   /* Valida sacar consulta del standby */
  jq_va(function(){

            jq_va('#form_cambiar_standby').validate({

                rules :{

                        'id_consulta_prg[]' : {
                            required : true
                        }
                },
                messages : {

                        'id_consulta_prg[]' : {
                            required : "Debe elegir alguna consulta/prg"
                        }
                },
                invalidHandler: function(event, validator) {
                    jq_va('#form_cambiar_standby').find(":submit").removeAttr('disabled');
                }

            });
  });

</script>




<!-- ;PDAÑ -->
<script src="<?=base_url()?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js" type="text/javascript"></script>


<!-- Bootstrap WYSIHTML5 -->
<script src="<?=base_url()?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>


<script>
   var jq_m = jQuery.noConflict();
</script>

<script type="text/javascript">

jq_m('#modal_agregar_comentario').on('show.bs.modal', function (event)
{

    var button = jq_m(event.relatedTarget);
    var id_consulta_programa = button.data('whatever');
    var modal = jq_m(this);
    //alert(id_consulta_programa);
    //modal.find('#id_crm_consulta').val(id_consulta_programa);
     jq_m.ajax({
                url: CI_ROOT+'index.php/consulta/buscar_info_consulta_programa',
                data: { id_consulta_programa: id_consulta_programa },
                async: true,
                type: 'POST',
                dataType: 'JSON',
                success: function(data)
                {
                  //modal.find('#id_crm_consulta_programa').empty();
                  modal.find('#id_crm_consulta_programa').val(id_consulta_programa);
                  modal.find('#programa').val(data.programa);


                },
                error: function(x, status, error){
                  alert(error);
                }
      });
});


jq_m(document).ready(function()
{

      /* Chequea todas las consultas de la tabla pipeline*/
      jq_m('#todos').change(function(){

          var checkboxes = $(this).closest('form').find('.clase_consulta');
          if($(this).prop('checked')) {
            checkboxes.prop('checked', true);
            jq_m("#submit_email").show();
          } else {
            checkboxes.prop('checked', false);
            jq_m("#submit_email").hide();
          }

      });

      /* Chequea todas las consultas de la tabla standby*/
      jq_m('#todos_standby').change(function(){


          var checkboxes = $(this).closest('form').find('.clase_consulta_standby');
          if($(this).prop('checked')) {
            checkboxes.prop('checked', true);
          } else {
            checkboxes.prop('checked', false);
          }

      });
});

jq_m(document).ready(function()
{

    jq_m('.clase_consulta').change(function(){

        if( jq_m('.clase_consulta:checkbox:checked').length == 0) // No hay nada seleccionado
        {
            jq_m("#submit_email").hide();

        }
        else
        {
            jq_m("#submit_email").show();

        }

    });
});

</script>

<script type="text/javascript">

jq_m('#submit_pipeline').click(function(){
    //alert("submit_pipeline");
    jq_m('#form_procesar_consultas').attr('action', "<?=base_url()?>index.php/consulta/procesar_cambiar_consulta_pipeline" );
});

jq_m('#submit_email').click(function(){
    //alert("submit_email");
    jq_m('#form_procesar_consultas').attr('action', "<?=base_url()?>index.php/consulta/ver_enviar_email_masivo_prg" );
});

jq_m(document).ready(function() {

    jq_m('#id_estado').change(function(){

        if($(this).val() == -1)
        {
          jq_m('#fecha_standby').show();
          jq_m('#id_motivo').hide();
        }
        else
        {
            jq_m('#fecha_standby').hide();
            jq_m('#id_motivo').hide();

        }


    });
});

</script>