<?php
    $datos['anio'] = $consulta->ANIO_INGRESO;
    $datos['periodo'] = $consulta->PERIODO_INGRESO;
    $datos['id_periodo'] = $consulta->ID_PERIODO_INGRESO;
    $cadena = json_encode($datos);
    $cadena = str_replace("\"", "&", $cadena);

    if ($consulta->ID_ESTADO_CONSULTA == 0)
      $estado_disabled = ' disabled';
    else
      $estado_disabled = '';
?>

<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/consulta/ver_consulta.css" rel="stylesheet" />

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <section class="content-header" >
    
        <h4>
          <i class="fa fa-address-card" aria-hidden="true"></i>  <a href="<?=base_url()?>index.php/consulta/ver_consulta/<?=$consulta->ID_CRM_CONSULTA?>"> Consultas / Nº <?=$consulta->ID_CRM_CONSULTA?> </a>
          <span class="pull-right" data-toggle="tooltip" data-placement="bottom" data-original-title="Ver historial de la consulta">
            <a href="#" data-toggle="control-sidebar" ><i class="fa fa-21 fa-history" style="padding-right:10px;"></i>Ver historial consulta</a>
          </span>
        </h4>
      
     <!--  <div style="margin: 8px; height: 45px">
        <span style="width: 50%"><?php  mensaje_resultado($mensaje); ?></span>
      </div> -->
    </section>
    <div class="panel-body">
      
      <?php  mensaje_resultado($mensaje); ?>

      <?php if ( $consulta->ID_ESTADO_CONSULTA == 0 ): // // Si esta inactiva, muestra banner de consulta finalizada ?>
        <div class="col-md-12"  >
            <div class="alert alert-danger finished-query">
                <span> <i class="icon fa fa-ban"></i> <strong>Consulta finalizada</strong></span>
                <p> Ultima edición: <b><?=strtolower($consulta->C_USUARIO_MODI)?></b> - <?=$consulta->F_FECHA_MODI?> hs </p>
            </div>
        </div>
      <?php endif; ?>

        <!-- MENU -->
        <div class="col-md-12 nav-items">

          <a href="<?=base_url()?>index.php/contacto/ver_contacto/<?=$persona['datos_usuario']->ID_CRM_PERSONA?>" >
                  <button data-toggle="tooltip" data-placement="top" data-original-title="Ver a la persona"  type="button" class="btn btn-warning " >
                    <i class="fa fa-user-circle" aria-hidden="true"></i>  Ir a la persona
                  </button>
          </a>

        <?php if ( $consulta->ID_ESTADO_CONSULTA == 1 ): // Si la consulta esta activa, muestra todos los botones menos el de "Ver persona" ?>
          <a data-toggle="modal" data-target="#modal_enviar_email"  data-whatever="<?=$cadena?>"  >
                  <button data-toggle="tooltip" data-placement="top" data-original-title="Enviar email a la persona" type="button" class="btn btn-primary " >
                     <i class="fa fa-at" aria-hidden="true"></i> Enviar Email
                  </button>
          </a>
          <a href="<?=base_url()?>index.php/consulta/tomar_consulta/<?=$consulta->ID_CRM_CONSULTA?>" >
            <button  data-toggle="tooltip" data-placement="top" data-original-title="Enviar la consulta a 'mis consultas'"  type="button" class="btn btn-danger ">
                <i class="fa fa-handshake-o" ></i> Tomar consulta
            </button>
          </a>
          <a data-toggle="modal" data-target="#modal_editar_periodo"  data-whatever="<?=$cadena?>"  >
                  <button data-toggle="tooltip" data-placement="top" data-original-title="Cambiar el periodo de ingreso" type="button" class="btn btn-purple " >
                     <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Cambiar ingreso
                  </button>
          </a>
          <a data-toggle="modal" data-target="#modal_agregar_prg"  data-whatever="<?=$cadena?>"  >
                  <button  data-toggle="tooltip" data-placement="top" data-original-title="Agrega o elimina PRG de Interes de la consulta" type="button" class="btn btn-celeste " >
                     <i class="fa fa-plus-square" aria-hidden="true"></i> Agregar Prg
                  </button>
          </a>
          <a data-toggle="modal" data-target="#modal_como_contactar"  data-whatever="<?=$cadena?>"  >
                  <button data-toggle="tooltip" data-placement="top" data-original-title="Modifica como contactar a la persona" t type="button" class="btn btn-naranja " >
                     <i class="fa fa-share-square" aria-hidden="true"></i> Como contactar
                  </button>
          </a>

          <?php
                $datos['id_crm_consulta'] = $consulta->ID_CRM_CONSULTA;
                $cadena = json_encode($datos);
                $cadena = str_replace("\"", "&", $cadena);
          ?>
           <a data-toggle="modal" data-target="#modal_agregar_alarma"  data-whatever="<?=$cadena?>"  >
                  <button data-toggle="tooltip" data-placement="top" data-original-title="Agregar alarma" t type="button" class="btn btn-success " >
                     <i class="fas fa-stopwatch"></i> Agregar alarma
                  </button>
          </a>
      
        <!-- <span class="pull-right" data-toggle="tooltip" data-placement="bottom" data-original-title="Ver ayuda">
            <a href="#" data-toggle="control-sidebar" ><i class="fa fa-2x fa-history" style="padding-right:10px;"></i>Ver historial consulta</a>
        </span> -->

        <?php endif; ?>
        </div>

        <!-- INFORMACION DE LA CONSULTA, PRG INTERES, INFO INTERES, TIMELINE PRG -->
        <div class="col-md-12 info-wrapper">

            <!-- INFORMACION DE LA CONSULTA -->
            <div class="col-md-3 query-info">


              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Informacion de la consultas</h3>
                </div>
                <div class="box-body ">

                      <div class="form-group">
                        <div class="col-sm-3">
                          <?=buscar_foto_persona($persona['datos_usuario']->ID_PERSONA);?>
                        </div>
                        <div class="col-sm-9">
                          <div class="form-group id-query-wrapper">
                            <label for="id_consulta" class="col-sm-3 control-label">ID</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="id_consulta" value="<?=$consulta->ID_CRM_CONSULTA?>" readonly="readonly">
                            </div>
                          </div>

                        </div>
                      </div>
                      <div class="form-group">
                        <label for="nombre" class="col-sm-3 control-label">Estado</label>
                         <form  method="POST" class="col-sm-9" name="form_cambiar_estado_consulta" id="form_cambiar_estado_consulta" action="<?=base_url()?>index.php/consulta/procesa_cambiar_estado_consulta/" >

                              <input type="hidden" id="id_crm_consulta" name="id_crm_consulta" value="<?=$consulta->ID_CRM_CONSULTA?>" />


                              <div class="input-group">


                                  <?php   $estados_coconsulta = array(); ?>

                                  <?php   foreach ($estado_consulta->result() as $row):

                                              $estados_coconsulta[$row->ID_ESTADO_CONSULTA] = $row->DESCRIPCION;

                                      endforeach;

                                      echo form_dropdown('id_estado_consulta', $estados_coconsulta, $consulta->ID_ESTADO_CONSULTA ,'class="form-control select_estado" id="id_estado_consulta" name="id_estado_consulta"' );

                                  ?>

                                  <div id="div_consulta_inactiva" class="jumbotron" >

                                      <label for="resultados" style="padding-top:20px;">Resultado</label>
                                      <select>
                                        <option value="Admitido">Admitido</option>
                                        <option value="noAdmitido">No admitido</option>
                                      </select>
                                      <br>
                                      <label for="resultados">Comentario</label>
                                      <textarea name="motivo" id="motivo" cols="30" rows="5"></textarea>
                                    
                                  </div>
                                  
                             
                                  <span >
                                      <input type="submit" class="btn btn-primary btn-s btn_cambiar_estado" value="Cambiar" id="submit_estado">
                                  </span>

                              </div>
                          </form>

                      </div>

                      <div class="form-group">
                        <label for="nombre" class="col-sm-3 control-label">Apellido</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="nombre" value="<?=$persona['datos_usuario']->APELLIDO?>" readonly="readonly">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="nombre" class="col-sm-3 control-label">Nombre</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="nombre" value="<?=$persona['datos_usuario']->NOMBRE?>" readonly="readonly">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="periodo_ingreso" class="col-sm-3 control-label">Ingreso</label>
                        <div class="col-sm-9">
                          <?php   if(isset($consulta->PERIODO_INGRESO)): ?>
                                <input type="text" class="form-control" id="periodo_ingreso" value="<?=$consulta->PERIODO_INGRESO.", ".$consulta->ANIO_INGRESO?>" readonly="readonly">
                          <?php   else: ?>
                                <p class="text-red">Aún no se ingreso el periodo de ingreso</p>
                          <?php   endif;  ?>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="comentario" class="col-sm-3 control-label">Comentario</label>
                        <div class="col-sm-9">
                          <textarea readonly="readonly"  class="form-control" id="comentario" ><?=$consulta->COMENTARIO_CONSULTA?></textarea>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="comentario" class="col-sm-3 control-label">Operador a cargo</label>
                        <div class="col-sm-9">
                            <!--<input type="text" class="form-control" id="periodo_ingreso" value="<?=$consulta->PERIODO_INGRESO.", ".$consulta->ANIO_INGRESO?>" readonly="readonly">-->
                            <?php   if($operador_cargo->num_rows()>0): ?>

                                  <?php   foreach($operador_cargo->result() as $row ): ?>

                                          <input type="text" class="form-control" id="operador_cargo[]" value="<?=$row->USER_ORACLE?>" readonly="readonly">

                                  <?php   endforeach; ?>

                          <?php   else: ?>
                                <p class="text-red">Aún no hay operadores a cargo</p>

                            <?php   endif; ?>
                        </div>
                      </div>
 

                </div>
              </div>

              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Solicitudes de Admision</h3>
                </div>
                <div class="box-body admission-application-wrapper">


                <?php if( count($programas) > 0 ): 


                        
                        $flag = false; ?>

                        <?php   for ($i=0; $i < count($programas) ; $i++): ?>


                             

                            <?php if( $programas[$i]['solicitud_admision_con_prg']->num_rows() > 0 ): 
                                      
                                    $flag = true;

                                  endif ?>

                        <?php   endfor; ?>
                        
                        <?php if( $flag ): ?>

                          <table class="table table-striped">
                              <thead>
                                  <th>ID</th>
                                  <th>Fecha</th>
                                  <th>Programa</th>
                                  <th>Resultado</th>
                              </thead>

                              <tbody>


                              <?php   for ($i=0; $i < count($programas) ; $i++): ?>
                                

                                <?php if( $programas[$i]['solicitud_admision_con_prg']->num_rows() > 0 ): ?>


                                  <?php foreach ($programas[$i]['solicitud_admision_con_prg']->result() as $row_sol): ?>

                                      <tr>
                                          <td class="request-id"><?=$row_sol->N_ID_SOLICITUD?></td>
                                          <td class="request-date"><?=$row_sol->F_SOLICITUD?></td>
                                          <td><?=$row_sol->D_DESCINF?></td>
                                          <td><?php if(isset($row_sol->C_RESULTADO_ADMIN)) echo $row_sol->C_RESULTADO_ADMIN; ?></td>
                                      </tr>

                                  <?php endforeach; ?>

                                <?php endif; ?>

                              <?php   endfor; ?>


                          </tbody>
                        </table>
                       <?php else: ?>

                           <p class="text-red">No hay solicitudes de admisión</p>
  
                        <?php endif; ?>

                  <?php else: ?>


                       <p class="text-red">No hay solicitudes de admisión</p>

                  <?php endif; ?>
                </div>
              </div>

               <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Entrevistas</h3>
                </div>
                <div class="box-body admission-application-wrapper">

                            No hay entrevistas
                </div>
              </div>

            </div>



            <!-- PROGRAMAS Y ESTADOS -->
            <div class="col-md-3 programs-status-info">
              
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Alarmas</h3>
                </div>
                <div class="box-body ">
                  
                  <?php if(count($alarmas) > 0): ?>
                      
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Fecha</th>
                            <th>Descripcion</th>
                            <th> </th>
                          </tr>
                        </thead>
                        <tbody>
                                  
                          <?php foreach ($alarmas as $row ): ?>
                                    
                              <tr>
                                <td><?=$row['FECHA']?></td>
                                <td><?=$row['DESCRIPCION']?> </td>
                                <td>
       
                                   <a data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar alarma" onclick="eliminar_alarma(<?=$row['ID_CRM_CONSULTA_ALARMA']?>)"> <i class="fas fa-trash-alt"></i>  </a>
                                </td>
                              </tr>

                          <?php endforeach; ?>

                        </tbody>
                      </table>


                  <?php else: ?>
                          
                        <div class="danger">Aún no se han cargado </div>

                  <?php endif; ?>
 

                </div>
              </div>

              <!-- Programas de interes -->
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Programas de interes</h3>
                </div>
                <div class="box-body ">
                  

                  <?php if ( count($programas) > 0 ): ?>

                      <table class="table table-responsive">
          

                        <?php

                            for( $i=0; $i < count($programas) ; $i++):
                        ?>
                              <?php   $estados = array(); ?>

                              <form method="post" class="cambiar_estado" name="cambiar_estado_<?=$i?>" id="cambiar_estado_<?=$i?>">
                                  <input type="hidden" name="id_crm_consulta_prg" value="<?=$programas[$i]['informacion_programa']->ID_CRM_CONSULTA_PROGRAMA?>">
                                  <tr>

                                    <td class="program-title"><?=$programas[$i]['informacion_programa']->D_DESCRED?></td>

                                    <td>

                                        <select class="form-control select_estado" name='id_estado_cons_prg_<?=$i?>' id="id_estado_cons_prg_<?=$i?>">

                                        <?php    foreach ($estado_consulta_prg->result() as $row):


                                                  $selected = '';
                                                  $disabled = '';

                                                  if( $row->ID_ESTADO == $programas[$i]['informacion_programa']->ID_ESTADO){
                                                      $selected = "selected";
                                                  }

                                                  if( $row->ID_ESTADO == 5 || $row->ID_ESTADO == 6)
                                                    $disabled = " disabled='disabled' ";

                                        ?>
                                                  <option value="<?=$row->ID_ESTADO?>" <?=$selected?> <?=$disabled?> > <?=$row->DESCRIPCION?> </option>


                                        <?php    endforeach;  ?>

                                       </select>


                                    </td>
     
     
                                    </td> 
     
                                    <td class="program-change-btn">
                                      <?php

                                      if ($consulta->ID_ESTADO_CONSULTA != 0):
                                        echo '<button class="btn btn-bloc btn-primary" name="submit" value="Cambiar">Cambiar</button>';
                                      endif;

                                      ?>
                                    </td>

                                   </tr>
                              </form>

                        <?php   endfor; ?>

                      </table>

                  <?php else: ?>
                            
                            <div class="danger">Aún no se han cargados programas de interes para esta consulta </div>

                  <?php endif; ?>

                </div>
              </div>

              <!-- INFORMACION DE INTERES -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Informacion de interes</h3>
                </div>
                <div class="box-body ">

                     <?php  $attributes = array('class' => 'form', 'id' => 'form_info_interes_consulta', 'name' => 'form_info_interes_consulta');
                        echo form_open('consulta/asignar_info_interes', $attributes); ?>

                        <input type="hidden" class="form-control" id="id_crm_consulta" name="id_crm_consulta" value="<?=$consulta->ID_CRM_CONSULTA?>" readonly="readonly">


                        <table class="table" id="tabla_roles" name="tabla_roles">
                          <?php  if($informacion_interes->num_rows() > 0) : ?>

                              <tbody>

                              <?php  foreach ($informacion_interes->result() as $row): ?>

                                  <tr>
                                    <td>
                                      <label for="id_info_interes_<?=$row->ID_INFO_INTERES?>">
                                        <?=$row->DESCRIPCION?>
                                      </label>
                                    </td>
                                    <td>

                                      <?php
                                          $exito = 0;

                                          $data = array(
                                                  'name'        => 'id_info_interes[]',
                                                  'id'          => 'id_info_interes_'.$row->ID_INFO_INTERES,
                                                  'value'       => $row->ID_INFO_INTERES,
                                                  'checked'     => FALSE,
                                                  'style'       => 'form-control'
                                                  );

                                        foreach ($informacion_interes_consulta->result() as $row2):

                                                    if($row->ID_INFO_INTERES == $row2->ID_INFO_INTERES):

                                                      $exito = 1;

                                                    endif;

                                          endforeach;

                                          if( $exito == 1):

                                            $data['checked'] = TRUE;

                                          endif;




                                          echo form_checkbox($data, NULL, NULL, $estado_disabled);
                                      ?>

                                    </td>

                                  </tr>

                              <?php  endforeach; ?>

                          <?php  endif; ?>

                          </tbody>

                        </table>

                        <?php
                          if ($consulta->ID_ESTADO_CONSULTA != 0):
                            $data = array(
                                          'name'        => 'submit',
                                          'type'        => 'submit',
                                          'value'       => 'Modificar',
                                          'checked'     => FALSE,
                                          'class'       => 'btn btn-primary btn-block btn-xs'
                                          );

                            echo form_input($data, NULL, $estado_disabled);
                          endif;
                        ?>
                    </form>

                </div>
              </div>
            </div>

            <!-- LINEA DE PROGRAMA DE CONSULTA -->
            <div class="col-md-6 program-comments">
                <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title">Comentarios </h3>
                  </div>
                  <div class="box-body ">

                      <?php
                        
                        $datos['id_crm_consulta'] = $consulta->ID_CRM_CONSULTA;
                        $cadena = json_encode($datos);
                        $cadena = str_replace("\"", "&", $cadena);

                      ?>

                      <a data-toggle="modal" data-target="#modal_agregar_comentario_general"  data-whatever="<?=$cadena?>"  >
                          <button style="margin-bottom:10px"  data-toggle="tooltip" data-placement="top" data-original-title="Escribi un comentario general" t type="button" class="btn btn-primary " >
                             <i class="fa fa-edit" aria-hidden="true"></i> Escribir comentario general
                          </button>
                      </a> 

                      

                      <?php if( count($comentarios_generales_consulta) > 0 ): ?>
                              
                              <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th>Fecha</th>
                                    <th>Comentario</th>
                                    <th>Usuario</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php foreach ($comentarios_generales_consulta as $row): ?>

                                            <tr>
                                              <td><?=$row['FECHA']?></td>
                                              <td><?=$row['COMENTARIO']?></td>
                                              <td><?=$row['USUARIO_ORACLE']?></td>
                                            </tr>

                                    <?php endforeach; ?>

                                </tbody>
                              </table>

                            
                        
                      <?php endif; ?>

                    <div class="callout callout-informativo">
                      <p> <strong>La línea de tiempo por programa</strong> muestra los eventos de cada programa de la consulta. Cada programa tiene su propia línea de tiempo y es independiente de los demás programas
                      </p>
                    </div>

                    <div class="nav-tabs-custom">
                      <ul class="nav nav-tabs">

                          <?php   for ($i=0; $i < count($programas) ; $i++): ?>

                                <li <?php if($i==0) echo 'class="active"';?> ><a href="#<?=str_replace(" ", "_",$programas[$i]['informacion_programa']->D_DESCRED)?>" data-toggle="tab"><?=$programas[$i]['informacion_programa']->D_DESCRED?></a></li>

                          <?php   endfor; ?>


                      </ul>

                      <div class="tab-content">



                          <?php   for ($i=0; $i < count($programas) ; $i++): ?>

                                <?php
                                  $datos['id_crm_consulta_programa'] = $programas[$i]['informacion_programa']->ID_CRM_CONSULTA_PROGRAMA;

                                  $cadena = json_encode($datos);
                                  $cadena = str_replace("\"", "&", $cadena);

                                ?>

                                <div  class="tab-pane <?php if($i==0) echo 'active';?>" id="<?=str_replace(" ", "_",$programas[$i]['informacion_programa']->D_DESCRED)?>">


                                    <div class="program-info">

                                      <?php   if( $programas[$i]['informacion_programa']->ID_ESTADO != 3 ): ?>


                                          <a data-toggle="modal" data-target="#modal_agregar_comentario"  data-whatever="<?=$cadena?>">

                                            <?php if( $consulta->ID_ESTADO_CONSULTA != 0): ?>
                                              <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-fw fa-edit"></i> Escribir comentario <?=$programas[$i]['informacion_programa']->D_DESCRED?> </button>
                                            <?php endif; ?>

                                          </a>

                                          <?php if( $consulta->ID_ESTADO_CONSULTA != 0): ?>

                                            <button class="btn btn-danger btn-xs"
                                              onclick="desestimar_programa( <?=$programas[$i]['informacion_programa']->ID_CRM_CONSULTA_PROGRAMA?>  )">
                                              <i class="fa fa-edit"></i> Desestimar <?=$programas[$i]['informacion_programa']->D_DESCRED?> (cambia el estado)
                                            </button>

                                          <?php endif; ?>

                                      <?php   else:   ?>

                                          <div class="hover">
                                                 <div class="alert alert-danger">
                                                      <span> <i class="icon fa fa-ban"></i> <strong> Programa desestimado </strong> </span>
                                                  </div>

                                           </div>
                                           <a data-toggle="modal" data-target="#modal_agregar_comentario"  data-whatever="<?=$cadena?>"  >
                                                <button type="button" class="btn  btn-primary btn-xs"><i class="fa fa-fw fa-edit"></i> Escribir comentario <?=$programas[$i]['informacion_programa']->D_DESCRED?> </button>
                                          </a>



                                      <?php   endif;  ?>

                                    </div>


                                    <ul class="timeline">

                                        <!-- timeline time label -->
                                        <li class="time-label">
                                            <span class="bg-green">
                                                <?=$consulta->FECHA_CONSULTA.": ".$programas[$i]['informacion_programa']->D_DESCRED?>
                                            </span>
                                        </li>
                                        <!-- /.timeline-label -->


                                        <?php  foreach ($programas[$i]['eventos_linea_tiempo']->result() as $row): ?>

                                             <li>
                                                <?php   if($row->TIPO == 'email'):  ?>
                                                      <i class="fa fa-at bg-blue"></i>
                                                <?php   elseif($row->TIPO == 'comentario'):  ?>
                                                      <i class="fa fa-comment-o bg-green"></i>
                                                <?php   endif;?>

                                                <div class="timeline-item">
                                                     <span class="time ora-user"><strong><?=$row->USUARIO_ORACLE?></strong></span>
                                                    <span class="time"><?=$row->FECHA?> </span>

                                                    <h3 class="timeline-header timeline-comment"><?=$row->COMENTARIO?></h3>

                                                </div>
                                            </li>

                                        <?php  endforeach ?>



                                    </ul>


                                </div>


                          <?php   endfor; ?>


                      </div>
                      <!-- /.tab-content -->
                    </div>
                  </div>
                </div>
            </div>

        </div>
        
    

    </div>

<!-- MODAL ENVIAR EMAIL -->
<div class="modal fade" id="modal_enviar_email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Enviar email</h4>
      </div>

        <form  name="form_enviar_email" id="form_enviar_email" method="POST" action="<?=base_url()?>index.php/consulta/enviar_email_consulta/" >

            <input type="hidden" class="form-control" id="id_crm_consulta"  name="id_crm_consulta" value="<?=$consulta->ID_CRM_CONSULTA?>" >

            <div class="modal-body" >

                <div class="box-body">

                    <?php   foreach ($persona['datos_emails'] as $row): ?>
                            
            
                            <div class="form-group">
                              <input type="text" class="form-control" name="email[]" placeholder="Email to:" value="<?=$row['EMAIL']?>">
                            </div>

                    <?php   endforeach; ?>

                    <div class="form-group">
                      <input type="text" class="form-control" name="email[]" placeholder="Email to:">
                    </div>

                    <div class="form-group">
                      <input type="text" class="form-control" name="subject" placeholder="Subject" value="UCEMA">
                    </div>
                    <div>
                      <textarea name="mensaje_email" id="mensaje_email" rows="10" cols="100">

                      <table class="table">
                          <tr>
                            <td class="mail-logo"><img alt="UCEMA" src="https://www.ucema.edu.ar/sites/default/files/ucema_logo.png"/></td>
                            <td class="mail-signature">
                              Av. C&#243;rdoba 374, (C1054AAP) <br>
                              Ciudad de Buenos Aires, Argentina <br>
                              Tel.: (54-11) 6314-3000 | Fax: (54-11) 4314-1654 <br>
                              info@ucema.edu.ar - www.ucema.edu.ar
                            </td>
                          </tr>
                          <tr>
                            <td>Estimado/a  <?php  echo $persona['datos_usuario']->APELLIDO.", ".$persona['datos_usuario']->NOMBRE; ?>:</td>
                            <td class="mail-date"> <?php  echo date('d')." de ".date('F')." de ".date('Y'); ?> </td>
                          </tr>
                          <tr>
                            <td colspan="2">


                              <br><br>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <br>
                              <?=$this->session->userdata('nombre')?><br>
                              <?=$this->session->userdata('email')?><br>
                              UNIVERSIDAD DEL CEMA <br>
                              Av. Córdoba 374 (C1054AAP) Buenos Aires ARGENTINA <br>
                              TEL: (54-11) 6314-3000     <br>
                              Mail: exchange@ucema.edu.ar <br>
                            </td>
                            <td></td>
                          </tr>
                        </table>

                      </textarea>

                    </div>

                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Enviar <i class="fa fa-arrow-circle-right"></i></button>
            </div>

        </form>
    </div>
  </div>
</div>

<!-- MODAL MODIFICAR PERIODO INGRESO -->
<div class="modal fade " id="modal_editar_periodo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Editar periodo ingreso</h4>
      </div>

      <form  name="form_modificar_periodo" id="form_modificar_periodo" method="POST"  action="<?=base_url()?>index.php/consulta/modifica_periodo_ingreso/" >

        <div class="modal-body" >

              <input type="hidden" class="form-control" id="id_crm_consulta"  name="id_crm_consulta" value="<?=$consulta->ID_CRM_CONSULTA?>" >

              <div class="form-group">
                <label for="anio" class="col-sm-2 control-label">Año</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="anio" name="anio" placeholder="Ingresar Anio">
                </div>
              </div>

              <div class="form-group">
                <label for="carrera" class="col-sm-2 control-label">Periodo</label>
                <div class="col-sm-9">

                    <?php   $periodos = array(); ?>

                    <?php   $periodos[''] = 'Seleccionar periodo'; ?>

                    <?php   foreach ($periodo_ingreso->result() as $row):

                            $periodos[$row->ID_PERIODO_INGRESO] = $row->DESCRIPCION;

                        endforeach;

                      echo form_dropdown('id_periodo', $periodos, '' ,'class="form-control" id="id_periodo" name="id_periodo" ' );

                    ?>

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

<!-- MODAL FUSIONAR CONTACTO -->
<div class="modal fade " id="modal_fusionar_contacto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Fusionar contactos</h4>
      </div>

      <form  name="form_fusionar_contacto" id="form_fusionar_contacto" method="POST"  action="<?=base_url()?>index.php/contacto/fusionar_contacto/" >

        <div class="modal-body" >

              <input type="text" class="form-control" id="id_crm_persona"  name="id_crm_persona" readonly="readonly" value="<?=$persona['datos_usuario']->ID_CRM_PERSONA?>" >


              <div class="form-group">
                <label for="carrera" class=" control-label">ID CRM PERSONA</label>

                  <input type="text" class="form-control" id="id_crm_persona_fusionar"  name="id_crm_persona_fusionar" >

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

<!-- MODAL MODIFICAR ESTADO -->
<div class="modal fade " id="modal_editar_estado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Modificar Estado consulta</h4>
      </div>

        <form  name="form_modificar_estado" id="form_modificar_estado" method="POST"  action="<?=base_url()?>index.php/consulta/modificar_estado_consulta/" >

        <input type="hidden" class="form-control" id="id_crm_consulta"  name="id_crm_consulta" value="<?=$consulta->ID_CRM_CONSULTA?>" >

        <div class="modal-body" >

              <div class="form-group">
                <label for="id_estado" class=" control-label">Estado</label>


                    <?php /*  $estados = array(); ?>

                    <?php   $estados[''] = 'Seleccionar estado'; ?>

                    <?php   foreach ($estado_consulta->result() as $row):

                            $estados[$row->ID_ESTADO] = $row->DESCRIPCION;

                        endforeach;

                      echo form_dropdown('id_estado', $estados, '' ,'class="form-control" id="id_estado" name="id_estado" ' );
                      */
                    ?>

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

<!-- MODAL COMO CONTACTAR -->
<div class="modal fade " id="modal_como_contactar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Como contactar</h4>
      </div>

        <form  name="form_como_contactar" id="form_como_contactar" method="POST"  action="<?=base_url()?>index.php/consulta/modificar_como_contactar/" >

        <input type="hidden" class="form-control" id="id_crm_consulta"  name="id_crm_consulta" value="<?=$consulta->ID_CRM_CONSULTA?>" >

        <div class="modal-body" >

          <?php  foreach ($como_contactar->result() as $row):

              $exito = 0;
              $horario = 0;

            ?>

              <div class="form-group">

                <?php   /*
                     $data = array(
                                    'name'        => 'id_como_contactar[]',
                                    'id'          => 'id_como_contactar',
                                    'value'       => $row->ID_CONTACTENME,
                                    'checked'     => FALSE,
                                    'style'       => 'form-control'
                                  ); */?>



                <?php     $data = array(
                                              'name'        => 'id_contactenme[]',
                                              'id'          => 'id_contactenme',
                                              'value'       => $row->ID_CONTACTENME,
                                              'checked'     => FALSE,
                                              'style'       => 'form-control' ,
                                              'class'       => 'check_contactenme'
                                              );


                ?>

                <?php     // Fijarme si esta chequeado

                      foreach ($contactenme_consulta->result() as $row2):

                          if($row->ID_CONTACTENME == $row2->ID_MEDIO_CONTACTENME):

                              $exito = 1;

                              if($row2->HORARIO != NULL)
                                 $horario = $row2->HORARIO;

                          endif;

                      endforeach;  ?>

                <?php      if( $exito == 1):

                          $data['checked'] = TRUE;

                        endif;

                      echo form_checkbox($data);  ?>
                      <label for="id_estado" class=" control-label"><?=$row->DESCRIPCION?></label>
                      <?php   $horarios['9 a 18'] = '9 a 18';  ?>
                      <?php   $horarios['9 a 12'] = '9 a 12';  ?>
                      <?php   $horarios['12 a 15'] = '12 a 15';  ?>
                      <?php   $horarios['15 a 18'] = '15 a 18';  ?>
                <?php

                      if ($exito == 0)
                          $style = ' style = "display:none" ';
                      else
                          $style =' ';

                      switch ($row->DESCRIPCION): // Busco si hay que mostrar horario

                        case 'Telefono':

                                echo form_dropdown('horario_telefono', $horarios, $horario ," class='form-control' id='horario_telefono' name='horario_telefono' $style" );

                              break;

                         case 'Whatsapp':


                                echo form_dropdown('horario_what', $horarios, $horario ," class='form-control' id='horario_what' name='horario_what' $style" );

                              break;

                      endswitch

                ?>




              </div>


            <?php  endforeach; ?>




        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Aceptar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL AGREGAR PROGRAMAS -->
<div class="modal fade " id="modal_agregar_prg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar programas</h4>
      </div>

        <form  name="form_modificar_programas" id="form_modificar_programas" method="POST"  action="<?=base_url()?>index.php/consulta/modificar_programas/" >

          <input type="hidden" class="form-control" id="id_crm_consulta"  name="id_crm_consulta" value="<?=$consulta->ID_CRM_CONSULTA?>" >

          <div class="modal-body" >

              <input class="form-control" type="text" name="programa_buscado" id="programa_buscado" >

              <div id="programas_elegidos">

                <?php   $i = 0; ?>

                 <?php   for ($i=0; $i < count($programas) ; $i++): ?>

                      <?php
                        $id = rand();
                        $codigo = $programas[$i]['informacion_programa']->C_IDENTIFICACION.'-'.$programas[$i]['informacion_programa']->C_PROGRAMA.'-'.$programas[$i]['informacion_programa']->C_ORIENTACION;
                      ?>

                      <div class="form-group eliminar_programa" id="<?=$id?>" >
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-trash " value="aaa" aria-hidden="true"></i>
                          </div>
                              <input readonly="readonly" class="form-control" type="text" name="programa[]" id="programa" value="<?=$programas[$i]['informacion_programa']->D_DESCRED?>">
                              <input class='form-control codigo_programa' type='text' name='id_codigo[]' id="id_codigo" value='<?=$codigo?>' >
                        </div>
                      </div>

                <?php   endfor; ?>


              </div>

          </div>

          <div class="modal-footer">
            <button onClick="history.go(0)" type="button" class="btn btn-warning pull-left" data-dismiss="modal">Resetear</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Aceptar</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL AGREGAR COMENTARIO GENERAL -->
<div class="modal fade " id="modal_agregar_comentario_general" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar comentario general </h4>
      </div>

        <form  name="form_agregar_comentario_general" id="form_agregar_comentario_general" method="POST"  action="<?=base_url()?>index.php/consulta/agregar_comentario_general/" >
          <input type="text" class="form-control" id="id_crm_consulta"  name="id_crm_consulta" value="<?=$consulta->ID_CRM_CONSULTA?>" >

          <div class="modal-body" >

                  <textarea   class="form-control" id="comentario" name="comentario" ></textarea>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Aceptar</button>
          </div>
        </form>

    </div>
  </div>
</div>

<!-- MODAL AGREGAR COMENTARIO PROGRAMA -->
<div class="modal fade " id="modal_agregar_comentario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar comentario </h4>
      </div>

        <form  name="form_agregar_comentario_programa" id="form_agregar_comentario_programa" method="POST"  action="<?=base_url()?>index.php/consulta/agregar_comentario_programa/" >

          <input type="hidden" class="form-control" id="id_crm_consulta_programa"  name="id_crm_consulta_programa" >
          <input type="text" class="form-control" id="id_crm_consulta"  name="id_crm_consulta" value="<?=$consulta->ID_CRM_CONSULTA?>" >

          <div class="modal-body" >

                  <textarea   class="form-control" id="comentario" name="comentario" ></textarea>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Aceptar</button>
          </div>
      </form>
    </div>
  </div>
</div>


<!-- MODAL AGREGAR ALARMA -->
<div class="modal fade " id="modal_agregar_alarma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar alarma </h4>
      </div>

        <form  name="form_agregar_alarma" id="form_agregar_alarma" method="POST"  action="<?=base_url()?>index.php/consulta/alta_alarma/" >

          <input type="hidden" class="form-control" id="id_crm_consulta"  name="id_crm_consulta" value="<?=$consulta->ID_CRM_CONSULTA?>" >
                 

          <div class="modal-body" >

               <label>Fecha Alarma</label> 
                <input type="text" class="form-control calendario" id="fecha_alarma" name="fecha_alarma"> <br>
              
              <label>Descripcion</label> 
                <textarea   class="form-control" id="descripcion" name="descripcion" ></textarea>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Aceptar</button>
          </div>
      </form>
    </div>
  </div>
</div>


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark"  >
    
  <div class="col-md-12 query-timeline">

          <div class="box box-warning">
              <div class="box-header with-border">
                <h3 class="box-title">Línea de tiempo de la consulta</h3>
              </div>
              <div class="box-body">
                <div class="callout callout-informativo">
                  <p> <strong>La línea de tiempo</strong> muestra los eventos ocurridos en la consulta.
                  </p>
                </div>

                <div class="nav-tabs-custom">

                    <ul class="timeline">

                        <?php  foreach ($log_consulta->result() as $row_log): ?>

                            <li>
                                <?=devolver_icono_tipo_log($row_log->ID_TIPO_LOG_CONSULTA)?>
                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-calendar"></i> <?=$row_log->FECHA?></span>
                                    <h3 class="timeline-header"><a href="#"><?=$row_log->DESCRIPCION?></a></h3>
                                    <strong><?=$row_log->USUARIO?></strong>

                                <?php
                                    if(isset($row_log->TEXTO)): ?>

                                      <div class="timeline-body">
                                          <?php  echo $row_log->TEXTO; ?>
                                      </div>
                                <?php   endif; ?>

                                </div>
                            </li>

                        <?php   endforeach; ?>


                    </ul>

                </div>

              </div>
          </div>
        </div>

</aside>

<!-- jQuery 2.1.4 -->
<script src="<?=base_url()?>assets/js/jQuery-2.1.4.min.js"></script>

<!-- bootstrap datepicker -->
<script src="<?=base_url()?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>

<script type="text/javascript">

$('.calendario').datepicker({
  autoclose: true,
  format: 'dd/mm/yyyy'
});


</script>

<!-- CK Editor -->
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="<?=base_url()?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script>

$(function () {

  CKEDITOR.replace( 'mensaje_email',
    {
        height: 300
    }
  );

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

jq_m('#modal_editar_periodo').on('show.bs.modal', function (event) {


    var cadena_json_correcta;
    var button = jq_m(event.relatedTarget);
    var array_json;

    var cadena_json_recibida = button.data('whatever');

    console.dir(cadena_json_recibida);

    cadena_json_correcta = cadena_json_recibida.replace(/&/g, "\"");

    console.dir(cadena_json_correcta);

    array_json = JSON.parse(cadena_json_correcta);

    var anio = array_json.anio;
    var id_periodo = array_json.id_periodo;


    var modal = $(this)

    modal.find('#anio').val(anio);
    modal.find('#id_periodo').val(id_periodo);

});

jq_m('#modal_editar_estado').on('show.bs.modal', function (event) {


    var cadena_json_correcta;
    var button = jq_m(event.relatedTarget);
    var array_json;

    var id_estado = button.data('whatever');

    console.dir(id_estado);
    /*
    cadena_json_correcta = cadena_json_recibida.replace(/&/g, "\"");

    console.dir(cadena_json_correcta);

    array_json = JSON.parse(cadena_json_correcta);*/


    var modal = $(this)
     modal.find('#id_estado').val(id_estado);

});

jq_m('#modal_agregar_comentario').on('show.bs.modal', function (event) {


   var cadena_json_correcta;
    var button = jq_m(event.relatedTarget);
    var array_json;

    var cadena_json_recibida = button.data('whatever');

    console.dir(cadena_json_recibida);

    cadena_json_correcta = cadena_json_recibida.replace(/&/g, "\"");

    console.dir(cadena_json_correcta);

    array_json = JSON.parse(cadena_json_correcta);

    var id_crm_consulta_programa = array_json.id_crm_consulta_programa;

    var modal = $(this)

    modal.find('#id_crm_consulta_programa').val(id_crm_consulta_programa);

});


 
jq_m('#modal_agregar_comentario_general').on('show.bs.modal', function (event) {


   var cadena_json_correcta;
    var button = jq_m(event.relatedTarget);
    var array_json;

    var cadena_json_recibida = button.data('whatever');

    console.dir(cadena_json_recibida);

    cadena_json_correcta = cadena_json_recibida.replace(/&/g, "\"");

    console.dir(cadena_json_correcta);

    array_json = JSON.parse(cadena_json_correcta);

    var id_crm_consulta = array_json.id_crm_consulta;

    var modal = $(this)

    modal.find('#id_crm_consulta').val(id_crm_consulta);

}); 


jq_m('#modal_agregar_alarma').on('show.bs.modal', function (event) {


   var cadena_json_correcta;
    var button = jq_m(event.relatedTarget);
    var array_json;

    var cadena_json_recibida = button.data('whatever');

    //console.log(cadena_json_recibida);

    //console.dir(cadena_json_recibida);

    cadena_json_correcta = cadena_json_recibida.replace(/&/g, "\"");

    console.dir(cadena_json_correcta);

    array_json = JSON.parse(cadena_json_correcta);

    var id_crm_consulta = array_json.id_crm_consulta;

    //alert(id_crm_consulta);

    var modal = $(this);

    modal.find('#id_crm_consulta').val(id_crm_consulta);



}); 
</script>


<script type="text/javascript">

  // MOVER!!
  $(document).ready(function() {
      $(document).on("click", ".eliminar_programa", function() {
            $('#'+$(this).attr("id")).remove();
    });
  });

  function desestimar_programa(id_crm_consulta_programa)
  {
    if (confirm('Seguro que desea desestimar el programa ?'))
    {
        $.ajax({
                url: CI_ROOT+'index.php/consulta/desestimar_programa',
                data: { id_crm_consulta_programa: id_crm_consulta_programa },
                async: true,
                type: 'POST',
                dataType: 'JSON',
                success: function(data)
                {
                  if(data.error == false)
                  {
                    alert("Se ha desestimado el programa exitosamente");
                    location.reload();
                  }
                  else
                  {
                    alert("No se ha podido desestimar el programa, intente mas tarde.");
                  }
                },
                error: function(x, status, error){
                  alert("error");
                }
          });

    }
  }

  $('.cambiar_estado').submit(function( e ) {

    e.preventDefault();

    var values = $(this).serializeArray();
    var id_crm_consulta_prg;
    var id_estado_cons_prg;

    $.each(values, function(i, field)
    {

        if(i == 0){
          id_crm_consulta_prg = field.value;
          console.log("es cero");
        }
        else{
          id_estado_cons_prg = field.value;
          console.log("es uno");

        }

    });


    $.ajax({
            url: CI_ROOT+'index.php/consulta/procesa_cambiar_estado_cons_prg',
            async: true,
            data: { id_crm_consulta_prg: id_crm_consulta_prg, id_estado_cons_prg: id_estado_cons_prg },
            type: 'POST' ,
            dataType: 'JSON',
            success: function(data)
            {
                //alert(data);

                if(data.error == false)
                {
                    //alert("Se cambio el estado exitosamente");
                    location.reload();
                }
                else
                {
                    //alert("No se cambio el estado exitosamente");
                    location.reload();
                }
              },
              error: function(x, status, error){
                alert("No se ejecuto el cambio, intente mas tarde.");
            }

        });

  });

</script>



<!-- Multiselect -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" type="text/css"/>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<script>
     var f = jQuery.noConflict();
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>


<script>


f(document).ready(function(){
  f('#informacion_a_recibir').multiselect({

              nonSelectedText: 'Selecciona la/las carreras',
              nSelectedText: 'Seleccionados',
              allSelectedText: 'Todos seleccionados',
              buttonWidth: '220px',
              numberDisplayed: 1,
              includeSelectAllOption: true,
              selectAllText: 'Selecciona Todas!'

  });

  f('.select_estado option[value="5"]').attr("disabled", true);
  f('.select_estado option[value="6"]').attr("disabled", true);


 });
</script>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.10.custom.min.js"></script>

<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js" ></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js" ></script>

<script>
var jq_va = jQuery.noConflict();
</script>

<script type="text/javascript">


  jq_va(function(){

            jq_va('#form_info_interes_consulta').validate({

                rules :{

                        'id_info_interes[]' : {
                            required : true
                        }
                },
                messages : {

                        'id_info_interes[]' : {
                            required : "Debe seleccionar alguna informacion de interes"
                        }
                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_info_interes_consulta').find(":submit").removeAttr('disabled');
                }

            });
  });

  jq_va(function(){

            jq_va('#form_enviar_email').validate({

                rules :{

                        'email[]' : {
                            required : true
                        }
                },
                messages : {

                        'email[]' : {
                            required : "Debe ingresar un email"
                        }
                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_enviar_email').find(":submit").removeAttr('disabled');
                }

            });
  });

  jq_va(function(){

          jq_va('#form_modificar_periodo').validate({

              rules :{

                      anio : {
                          required : true,
                          number: true,
                          minlength: 4,
                          maxlength: 4
                      }
              },
              messages : {

                      anio : {
                          required : "Debe ingresar el año. Ej:2016",
                          number: "Debe ser solo numeros",
                          minlength: "Debe ser formato 4 digitos. Ej: 2016",
                          maxlength: "Debe ser formato 4 digitos. Ej: 2016"
                      }
              },
              invalidHandler: function(form, validator) {

                  jq_va('#form_modificar_periodo').find(":submit").removeAttr('disabled');
              }

          });
  });

  jq_va(function(){

          jq_va('#form_modificar_estado').validate({

              rules :{

                      id_estado : {
                          required : true,
                          number: true
                      }
              },
              messages : {

                      id_estado : {
                          required : "Debe seleccionar un estado",
                          number: "Debe ser solo numeros"
                      }
              }

          });
  });

  jq_va(function(){

          jq_va('#form_como_contactar').validate({

              rules :{

                      'id_contactenme[]' : {
                          required : true
                      }
              },
              messages : {

                      'id_contactenme[]' : {
                          required : "Debe seleccionar una forma de contacto"
                      }
              },
              invalidHandler: function(form, validator) {

                  jq_va('#form_como_contactar').find(":submit").removeAttr('disabled');
              }

          });
  });

  jq_va(function(){

          jq_va.validator.addMethod('id_programa', function(value, element) {

                if(jq_va('#id_codigo').val())
                  return true;
                else
                  return false;

          }, 'id_programaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');

          jq_va('#form_modificar_programas').validate({

              rules :{

                      programa_buscado : {
                          id_programa : true
                      }
              },
              messages : {

                      programa_buscado : {
                          id_programa : "Debe seleccionar al menos un programa"
                      }
              },
              invalidHandler: function(form, validator) {

                  jq_va('#form_modificar_programas').find(":submit").removeAttr('disabled');
              }

          });
  });

  jq_va(function(){

            jq_va('#form_agregar_comentario_programa').validate({

                rules :{

                        comentario : {
                            required : true
                        }
                },
                messages : {

                        comentario  : {
                            required : "Debe agregar un comentario 2"
                        }
                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_agregar_comentario_programa').find(":submit").removeAttr('disabled');
                }

            });
  });

   jq_va(function(){

            jq_va('#form_agregar_comentario_general').validate({

                rules :{

                        comentario : {
                            required : true
                        }
                },
                messages : {

                        comentario  : {
                            required : "Debe agregar un comentario"
                        }
                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_agregar_comentario_general').find(":submit").removeAttr('disabled');
                }

            });
  });


  jq_va(function(){

            jq_va('#form_agregar_alarma').validate({

                rules :{

                        comentario : {
                            required : true
                        },
                        fecha_alarma: {
                            required : true
                        }
                },
                messages : {

                        comentario  : {
                            required : "Debe agregar un comentario"
                        },
                        fecha_alarma: {
                            required : "Debe agregar una fecha "
                        }
                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_agregar_alarma').find(":submit").removeAttr('disabled');
                }

            });
  });




  jq_va(function(){

    jq_va('#id_estado_consulta').change(function(){

          var id = <?=$persona['datos_usuario']->ID_CRM_PERSONA?>;
          var id_consulta = <?=$consulta->ID_CRM_CONSULTA?>;

          var origen = 'CRM';

          alert(jq_va(this).val());

          $.ajax({
                url: CI_ROOT+'index.php/consulta/existe_consulta_activa',
                data: { id: id, origen: origen, id_consulta: id_consulta },
                dataType: 'JSON',
                type: 'POST',
                success: function(data)
                {
                  if( data.error == true )
                  {
                    alert("ERROR: el usuario tiene una consulta activa y solamente se puede tener una consulta activa por usuario.")

                    $('#id_estado_consulta').val('0');
                    $('#id_estado_consulta').prop('disabled', true);
                    $('#submit_estado').prop('disabled', true);
                  }
                  else
                  {
                      $('div_consulta_inactiva').show();
                  }

                },

                error: function(x, status, error)
                {
                  alert(error);
                }

          });


      });
  });

</script>

<script type="text/javascript">

    function eliminar_alarma( id_crm_consulta_alarma )
    {
      if (confirm('Seguro querés eliminar la alarma ?'))
      {   
          //alert(id_crm_consulta_alarma);

          $.ajax({
                  url: CI_ROOT+'index.php/consulta/baja_alarma',
                  data: { id_crm_consulta_alarma: id_crm_consulta_alarma},
                  async: true,
                  type: 'POST',
                  dataType: 'JSON',
                  success: function(data)
                  {
                    if(data.error == false)
                    {
                      alert("Se ha eliminado la alarma");
                      location.reload();
                    }
                    else
                    {
                      alert("No se ha podido eliminar la alarma");
                      location.reload();
                    }
                  },
                  error: function(x, status, error){
                    alert(error);
                  }
            });
      }

    }

</script>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.10.custom.min.js"></script>


<script>
  var jq_ui = jQuery.noConflict();
</script>



<script type="text/javascript">

    jq_ui('#programa_buscado').autocomplete({
          source:'<?php echo site_url('consulta/ajax_programa'); ?>',
          select: function(event, ui)
          {
              $(ui.item.mensaje).appendTo("#programas_elegidos");
          }

    });

</script>

