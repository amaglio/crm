<link type="text/css" href="<?php echo base_url(); ?>assets/css/contacto/ver_contacto.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url(); ?>assets/css/contacto/contacto.css" rel="stylesheet" />

<div class="content-wrapper">
    <section class="content-header">
    <h4>
      <i class="fa fa-users"></i> Personas /  <a class="ver-contacto-header" href="<?=base_url()?>index.php/contacto/ver_contacto/<?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>/"> <?=utf8_encode($info_persona['datos_usuario']->NOMBRE).", ".utf8_encode($info_persona['datos_usuario']->APELLIDO)?> </a>
       <span class="pull-right" data-toggle="tooltip" data-placement="bottom" data-original-title="Ver ayuda">
        <a href="#" data-toggle="control-sidebar" ><i class="fa fa-1x fa-history" style="padding-right:10px;"></i>Ver linea de tiempo de la persona</a>
        </span>
    </h4>
   
    </section>
    <div class="panel-body">

        <?php  mensaje_resultado($mensaje); ?>

        <!-- INFORMACION CONTACTO -->
        <div class="col-md-4">

            <!-- Ver contacto -->
            <div class="box box-primary">

                <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;" >
                    <i class="fa fa-address-card" aria-hidden="true"></i> <h3 class="box-title">Informacion persona</h3>
                </div>

                <div class="box-body">

                    <div  class="row" style="padding-bottom:20px;">

                      <div class="col-md-12">

                        <?=buscar_foto_persona($info_persona['datos_usuario']->ID_PERSONA);?>

                        <form style="display:inline"   method="post" action="<?=base_url()?>index.php/contacto/procesar_contactos_encontrados"  >

                          <input type="hidden" id="id_contacto" name="id_contacto[]" value="<?=$valores?>">

                          <input data-toggle="tooltip" data-placement="bottom" data-original-title="Cargar una consulta a la persona seleccionada" type="submit" name="cargar_consulta" id="submit_cargar_consulta" class="btn btn-danger btn-sm btn-accion-usuario" value='+ Cargar Consulta' >
                          <!-- Este hidden lo usa para cargar_consulta -->
                          <input type="hidden" value="Cargar"  name="cargar_consulta" id="cargar_consulta">

                        </form>

                        <?php   if( !isset($info_persona['datos_usuario']->ID_PERSONA) ): ?>


                                <a  href="<?=base_url()?>index.php/contacto/enviar_persona_sigeu/<?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>">
                                  <button data-toggle="tooltip" data-placement="top" data-original-title="Enviar esta persona a SIGEU" class="btn  btn-success btn-sm">
                                      <i class="fa fa-fw fa-fighter-jet"></i> Enviar a SIGEU
                                  </button>
                                </a>

                                <?php  /*onclick="eliminar_persona( <?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>)"*/  ?>
                              <!--   <button disabled="disabled"  onclick="eliminar_persona( <?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>)" data-toggle="tooltip" data-placement="top" data-original-title="Eliminar esta persona y todas sus consultas" type="button" class="btn  btn-black btn-sm">
                                   <i class="fa fa-at" aria-hidden="true"></i> Eliminar persona
                                </button> -->

                        <?php   endif; ?>

                      </div>

                    </div>



                    <div  class="row">

                        <div class="col-md-6">

                            <div class="form-group">
                              <label for="exampleInputEmail1">ID CRM</label>
                              <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-user"></i>
                                </div>
                                <input readonly="readonly"  type="text" class="form-control pull-right" id="id_crm" id="id_crm"  value="<?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>">
                              </div>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="exampleInputEmail1">ID SIGEU</label>
                                <div class="input-group date">
                                  <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                  </div>
                                  <input readonly="readonly"  type="text" class="form-control pull-right" id="id_sigeu" id="id_sigeu"  value="<?=$info_persona['datos_usuario']->ID_PERSONA?>">
                                </div>
                            </div>

                        </div>

                    </div>

                    <div  class="row">

                        <div class="col-md-12">

                          <div class="form-group">
                              <label for="exampleInputEmail1">Nombre y Apellido</label>
                              <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-user"></i>
                                </div>
                                <input readonly="readonly" type="text" class="form-control pull-right" id="nombre" name="nombre" value="<?=utf8_encode($info_persona['datos_usuario']->NOMBRE.", ".$info_persona['datos_usuario']->APELLIDO)?>">
                              </div>
                          </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Sexo</label>
                                <div class="input-group date">
                                  <label class="radio-inline"><input disabled="disable" type="radio" name="sexo" id="sexo" value="Masculino" <?php  if($info_persona['datos_usuario']->SEXO == 'M') echo "checked='checked'; " ?> > Masculino</label>
                                  <label class="radio-inline"><input disabled="disable" type="radio" name="sexo" id="sexo" value="Femenino"  <?php  if($info_persona['datos_usuario']->SEXO == 'F') echo "checked='checked'; " ?> >Femenino</label>
                                </div>
                            </div>

                        </div>


                        <div class="col-md-6">

                          <div class="form-group">
                            <label for="exampleInputEmail1">Documento</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                               #
                              </div>
                              <?php
                                  $documento = '';
                                  foreach ($info_persona['datos_documentos'] as $row):

                                      $documento .= $row['TIPO']."-".$row['NUMERO'].";" ;

                                  endforeach;
                              ?>
                              <input readonly="readonly" type="text" class="form-control pull-right" id="nombre" name="nombre" value="<?=$documento?>">
                            </div>
                        </div>

                        </div>

                    </div>
                    
                    <!--
                    <div  class="row">

                        <div class="col-md-6">

                          <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="fa fa-at"></i>
                              </div>
                              <input readonly="readonly" type="text" class="form-control pull-right" id="nombre" name="nombre" value="<?=$info_persona['datos_usuario']->EMAILS?>">
                            </div>
                        </div>

                        </div>

                        <div class="col-md-6">

                          <div class="form-group">
                              <label for="exampleInputEmail1">Telefonos</label>
                              <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-phone"></i>
                                </div>
                                <input readonly="readonly" type="text" class="form-control pull-right" id="nombre" name="nombre" value="<?=$info_persona['datos_usuario']->TELEFONOS?>">
                              </div>
                          </div>

                        </div>

                    </div>-->

 

                    <div class="col-md-12">

                        <?php   if(isset($info_persona['datos_usuario']->ID_PERSONA) ): ?>

                              <div class="callout callout-danger">
                                <h5>El usuario esta en  <strong>SIGEU</strong>, solo puede modificarse desde <strong>SIGEU</strong>.</h5>
                              </div>

                        <?php   else: ?>

                            <div class="form-group">
                                <a style="color:white" class="btn btn-primary btn-block" style="color:#000; font-size: 13px" href="<?=base_url()?>index.php/contacto/ver_modificar_contacto/<?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>/"> Ver / Modificar </a>
                            </div>

                        <?php   endif;  ?>

                    </div>




                </div>

            </div>
            

            <!-- Ver consultas -->
            <div class="box box-warning">
                
                <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;" >
                    <i class="fa fa-address-card" aria-hidden="true"></i> <h3 class="box-title">Consultas de la persona</h3>
                </div>
                <div class="box-body"  >

                   
                         
                        
                    
                    <?php if(  $consultas_persona->num_rows() > 0 ): ?>

                      <table class="table table-responsive table-stripped">
                          <thead>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Estado consulta</th>
                            
                            
                          </thead>
                          <tbdoy>

                             <?php foreach ($consultas_persona->result() as $consulta): ?>
     
                                    <tr>
                                      <td>
                                        <a  class="btn   btn-primary" href="<?=base_url()?>/index.php/consulta/ver_consulta/<?=$consulta->ID_CRM_CONSULTA?>"> <i class="fa fa-search" aria-hidden="true"></i> <?=$consulta->ID_CRM_CONSULTA?> </a>
                                      </td>
                                      <td><?=$consulta->FECHA_CONSULTA?></td>
                                      <td><?=$consulta->ESTADO_CONSULTA?></td>
                                    </tr>
                      

                              <?php
                                endforeach;
                              ?>

                          </tbdoy>
                      
                      </table>

                  <?php endif; ?>

                </div>
            </div>
            
            <!-- Ver eventos -->
            <div class="box box-danger">
                
                <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;" >
                    <i class="fa fa-address-card" aria-hidden="true"></i> <h3 class="box-title">Eventos de la persona</h3>
                </div>
                <div class="box-body"  >
                        
                    
                    <?php if(  $consultas_persona->num_rows() > 0 ): ?>

                      <table class="table table-responsive table-stripped">
                          <thead>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Estado consulta</th>
                            
                            
                          </thead>
                          <tbdoy>

                             <?php foreach ($consultas_persona->result() as $consulta): ?>
     
                                    <tr>
                                      <td>
                                        <a  class="btn   btn-primary" href="<?=base_url()?>/index.php/consulta/ver_consulta/<?=$consulta->ID_CRM_CONSULTA?>"> <i class="fa fa-search" aria-hidden="true"></i> <?=$consulta->ID_CRM_CONSULTA?> </a>
                                      </td>
                                      <td><?=$consulta->FECHA_CONSULTA?></td>
                                      <td><?=$consulta->ESTADO_CONSULTA?></td>
                                    </tr>
                      

                              <?php
                                endforeach;
                              ?>

                          </tbdoy>
                      
                      </table>

                  <?php endif; ?>

                </div>
            </div>
        </div>

        <div class="col-md-8">
            
             <div class="box box-success">

                <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;" >
                    <i class="fa fa-address-card" aria-hidden="true"></i> <h3 class="box-title">Informacion complementaria</h3>
                </div> 

                <div class="box-body">
                    
                    <!-- Emails -->
                    <div class="col-md-3 informacion_complementaria">

                       <label for="exampleInputEmail1"> Email </label>   <br>
                    
                          <?php  if( count($info_persona['datos_emails'])> 0): ?>
 
                                      <?php   foreach ($info_persona['datos_emails'] as $row):

                                                echo $row['EMAIL']."<br>";
                                                    
                                               endforeach; ?>

                            <?php   else: ?>

                                  <div class="callout danger">
                                    Aun no se han cargado emails.
                                  </div>

                            <?php   endif; ?>

                    </div>

                    <!-- Telefonos -->
                    <div class="col-md-3 informacion_complementaria">

                       <label for="exampleInputEmail1"> Telefonos </label>   <br>
                    
                          <?php  if( count($info_persona['datos_telefonos'])> 0): ?>
 
                                      <?php   foreach ($info_persona['datos_telefonos'] as $row):

                                                echo $row['TELEFONO']."<br>";
                                                    
                                               endforeach; ?>

                            <?php   else: ?>

                                  <div class="callout danger">
                                    Aun no se han cargado telefonos.
                                  </div>

                            <?php   endif; ?>

                    </div>


                    <!-- Educacion -->
                    <div class="col-md-3 informacion_complementaria">

                       <label for="exampleInputEmail1"> Educación </label>   <br>
                    
                          <?php  if( count($info_persona['datos_educacion'])> 0): ?>
 
                                      <?php   foreach ($info_persona['datos_educacion'] as $row):

                                                echo "<div><strong>".$row['NOMBRE']."</strong> - ".$row['DESCRIPCION']."</div>";
                                                    
                                               endforeach; ?>

                            <?php   else: ?>

                                  <div class="danger">
                                    Aun no se han cargado educación.
                                  </div>

                            <?php   endif; ?>

                    </div>


                    <!-- Experiencia laboral -->
                    <div class="col-md-3 informacion_complementaria">

                       <label for="exampleInputEmail1">  Experiencia laboral </label>   <br>
                    
                          <?php  if( count($info_persona['datos_experiencia_laboral'])> 0): ?>
 
                                      <?php   foreach ($info_persona['datos_experiencia_laboral'] as $row):

                                                 echo "<div><strong>". $row['NOMBRE']."</strong> -".$row['CARGO']."</div>";
                                                    
                                               endforeach; ?>

                            <?php   else: ?>

                                  <div class="  danger">
                                    Aun no se han cargado experiencias laborales.
                                  </div>

                            <?php   endif; ?>

                    </div>


                </div>


              </div>
      
        </div>
        
        <!-- CONSULTAS 
        <div class="col-md-2">
          
          <div class="box box-primary">

                <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;" >
 
                    <h3 class="box-title">Consultas de la persona</h3>

                </div>
                <div class="box-body"  >
                  <?php if(  $consultas_persona->num_rows() > 0 ):

                        foreach ($consultas_persona->result() as $consulta): ?>
 
                                <span class="col-md-4 "> 
                                      <a  class="btn   btn-primary" href="<?=base_url()?>/index.php/consulta/ver_consulta/<?=$consulta->ID_CRM_CONSULTA?>"> 
                                        <i class="fa fa-search" aria-hidden="true"></i> Ver
                                      </a>
                                </span>

                                <div class="col-md-6">
                                  
                                  <span class="info-box-number"><?=$consulta->ID_CRM_CONSULTA?></span>
                                  <span class="info-box-text"> <?=$consulta->FECHA_CONSULTA?></span>
                                  <span class="info-box-text"> <?=$consulta->ESTADO_CONSULTA?></span>
 
                                </div>
                  

                      <?php
                        endforeach;
                      ?>

                  <?php endif; ?>

                </div>
          </div>  
        </div>

       
        <!-- LINEA  
        <div class="col-md-5">

            <div class="box box-primary">

                <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;" >
                    <h3 class="box-title">Línea de tiempo de la persona</h3>
                </div>

                <div class="box-body" style="padding:0px">

                    <div class="callout callout-informativo timeline-info">
                      <p> <strong>La línea de tiempo</strong> muestra los eventos ocurridos con la persona.
                      </p>
                    </div>

                    <div class="nav-tabs-custom">

                      <ul class="timeline" style="padding-top:10px">

                        <?php

                          if(count($log_persona) > 0):

                                for ( $i=0; $i < count($log_persona) ; $i++ ):

                                    $texto =  str_replace("'","&#39;",$log_persona[$i]['comentario']); // addslashes($log_persona[$i]['comentario']);
                                  ?>

                                  <li>
                                      <?=devolver_icono_tipo_log($log_persona[$i]['informacion_log']->ID_TIPO_LOG_CONSULTA)?>
                                      <div class="timeline-item">
                                          <span class="time"><i class="fa fa-calendar"></i> <?=$log_persona[$i]['informacion_log']->FECHA?></span>

                                          <h3 class="timeline-header"><a href="#"><?=$log_persona[$i]['informacion_log']->DESCRIPCION?></a>

                                          <?php if(isset($log_persona[$i]['id_crm_evento'])) echo "<a  data-toggle='tooltip' data-placement='bottom' data-original-title='".$texto."'  class='btn btn-xs btn-primary mensaje_evento' href='".base_url()."index.php/evento/ver_evento/".$log_persona[$i]['id_crm_evento']."' > <i class='fa fa-search' aria-hidden='true'></i> &nbsp; ".$log_persona[$i]['id_crm_evento']." </a>"; ?>

                                          <?php if(isset($log_persona[$i]['id_crm_consulta'])) echo "<a  data-toggle='tooltip' data-placement='bottom' data-original-title='".$texto."'  class='btn btn-xs btn-primary mensaje_evento' href='".base_url()."index.php/consulta/ver_consulta/".$log_persona[$i]['id_crm_consulta']."' > <i class='fa fa-search' aria-hidden='true'></i> &nbsp; ".$log_persona[$i]['id_crm_consulta']." </a>"; ?>

                                          </h3>



                                          <strong><?=$log_persona[$i]['informacion_log']->USUARIO?></strong>

                                      <?php
                                          if(isset($log_persona[$i]['informacion_log']->TEXTO)): ?>

                                            <div class="timeline-body" style="font-size:11px;">
                                                <?php  echo $log_persona[$i]['informacion_log']->TEXTO?> 
                                            </div>

                                      <?php   endif; ?>

                                      <?php if($log_persona[$i]['informacion_log']->ID_TIPO_LOG_CONSULTA == 1 ): // Log consulta ?>

                                            <?php if($log_persona[$i]['log_consulta']->num_rows() > 0): ?>

                                                      <ul class="timeline" style="padding-top:10px">

                                                          <?php  foreach ($log_persona[$i]['log_consulta']->result() as $row_log): ?>

                                                              <li>
                                                                  <?=devolver_icono_tipo_log($row_log->ID_TIPO_LOG_CONSULTA, 'bg-red')?>
                                                                  <div class="timeline-item">
                                                                      <span class="time"><i class="fa fa-calendar"></i> <?=$row_log->FECHA?></span>
                                                                      <h3 class="timeline-header"><a href="#"><?=$row_log->DESCRIPCION?></a></h3>
                                                                      <strong><?=$row_log->USUARIO?></strong>

                                                                  <?php
                                                                      if(isset($row_log->TEXTO)): ?>

                                                                        <div class="timeline-body" style="font-size:11px;">
                                                                            <?php  echo $row_log->TEXTO?>
                                                                        </div>
                                                                  <?php   endif; ?>

                                                                  </div>
                                                              </li>

                                                          <?php   endforeach; ?>


                                                      </ul>


                                            <?php endif; ?>

                                      <?php endif; ?>

                                      </div>
                                  </li>

                          <?php endfor;

                          else: ?>

                          <li>
                          <div class="timeline-item">
                            <div class="alert alert-danger alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <h5><i class="icon fa fa-ban"></i> Aun no hay eventos en la linea!</h5>
                            </div>
                          </div>
                          </li>
                        <?php

                          endif;

                        ?>

                      </ul>

                    </div>

                </div>


                </div>
            </div>

        </div> -->
    </div>
</div>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark"  >
    
  <div class="col-md-12 query-timeline">
      
      <div class="box box-primary">

                <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;" >
                    <h3 class="box-title">Línea de tiempo de la persona</h3>
                </div>

                <div class="box-body" style="padding:0px">

                    <div class="callout callout-informativo timeline-info">
                      <p> <strong>La línea de tiempo</strong> muestra los eventos ocurridos con la persona.
                      </p>
                    </div>

                    <div class="nav-tabs-custom">

                      <ul class="timeline" style="padding-top:10px">

                        <?php

                          if(count($log_persona) > 0):

                                for ( $i=0; $i < count($log_persona) ; $i++ ):

                                    $texto =  str_replace("'","&#39;",$log_persona[$i]['comentario']); // addslashes($log_persona[$i]['comentario']);
                                  ?>

                                  <li>
                                      <?=devolver_icono_tipo_log($log_persona[$i]['informacion_log']->ID_TIPO_LOG_CONSULTA)?>
                                      <div class="timeline-item">
                                          <span class="time"><i class="fa fa-calendar"></i> <?=$log_persona[$i]['informacion_log']->FECHA?></span>

                                          <h3 class="timeline-header"><a href="#"><?=$log_persona[$i]['informacion_log']->DESCRIPCION?></a>

                                          <?php if(isset($log_persona[$i]['id_crm_evento'])) echo "<a  data-toggle='tooltip' data-placement='bottom' data-original-title='".$texto."'  class='btn btn-xs btn-primary mensaje_evento' href='".base_url()."index.php/evento/ver_evento/".$log_persona[$i]['id_crm_evento']."' > <i class='fa fa-search' aria-hidden='true'></i> &nbsp; ".$log_persona[$i]['id_crm_evento']." </a>"; ?>

                                          <?php if(isset($log_persona[$i]['id_crm_consulta'])) echo "<a  data-toggle='tooltip' data-placement='bottom' data-original-title='".$texto."'  class='btn btn-xs btn-primary mensaje_evento' href='".base_url()."index.php/consulta/ver_consulta/".$log_persona[$i]['id_crm_consulta']."' > <i class='fa fa-search' aria-hidden='true'></i> &nbsp; ".$log_persona[$i]['id_crm_consulta']." </a>"; ?>

                                          </h3>



                                          <strong><?=$log_persona[$i]['informacion_log']->USUARIO?></strong>

                                      <?php
                                          if(isset($log_persona[$i]['informacion_log']->TEXTO)): ?>

                                            <div class="timeline-body" style="font-size:11px;">
                                                <?php  echo $log_persona[$i]['informacion_log']->TEXTO?> 
                                            </div>

                                      <?php   endif; ?>

                                      <?php if($log_persona[$i]['informacion_log']->ID_TIPO_LOG_CONSULTA == 1 ): // Log consulta ?>

                                            <?php if($log_persona[$i]['log_consulta']->num_rows() > 0): ?>

                                                      <ul class="timeline" style="padding-top:10px">

                                                          <?php  foreach ($log_persona[$i]['log_consulta']->result() as $row_log): ?>

                                                              <li>
                                                                  <?=devolver_icono_tipo_log($row_log->ID_TIPO_LOG_CONSULTA, 'bg-red')?>
                                                                  <div class="timeline-item">
                                                                      <span class="time"><i class="fa fa-calendar"></i> <?=$row_log->FECHA?></span>
                                                                      <h3 class="timeline-header"><a href="#"><?=$row_log->DESCRIPCION?></a></h3>
                                                                      <strong><?=$row_log->USUARIO?></strong>

                                                                  <?php
                                                                      if(isset($row_log->TEXTO)): ?>

                                                                        <div class="timeline-body" style="font-size:11px;">
                                                                            <?php  echo $row_log->TEXTO?>
                                                                        </div>
                                                                  <?php   endif; ?>

                                                                  </div>
                                                              </li>

                                                          <?php   endforeach; ?>


                                                      </ul>


                                            <?php endif; ?>

                                      <?php endif; ?>

                                      </div>
                                  </li>

                          <?php endfor;

                          else: ?>

                          <li>
                          <div class="timeline-item">
                            <div class="alert alert-danger alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <h5><i class="icon fa fa-ban"></i> Aun no hay eventos en la linea!</h5>
                            </div>
                          </div>
                          </li>
                        <?php

                          endif;

                        ?>

                      </ul>

                    </div>

                </div>


                </div>
      </div>

  </div>

</aside>


<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->

<script src="<?=base_url()?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js" type="text/javascript"></script>



<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.10.custom.min.js"></script>

<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js" ></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js" ></script>

<script>
var jq = jQuery.noConflict();
</script>

<script type="text/javascript">

    /*
    jq(function(){

        jq("#datos_alumno").hide();

    });*/

    jq('#profesor').autocomplete({

          source:'<?php echo site_url('postulacion/ajax_alumno'); ?>',
          select: function(event, ui)
          {
              jq('input[name="nombre_completo"]').val(ui.item.value);
              jq('input[name="id_usuario"]').val(ui.item.id);
              jq('input[name="email"]').val(ui.item.email);
              jq('#datos_alumno').show();

              jq( "#datos_alumno" ).animate({
                backgroundColor: "#E6E0F8",
                color: "#000",
                width: "100%"
              }, 200 );
              jq("#datos_alumno").effect( "shake", {times:2, distance:5}, 200 );

          }

    });


    jq(function(){

            jq('#profesores_form').validate({

                rules :{

                        profesor : {
                            required : true
                        },
                        id_usuario: {
                            required : true
                        }
                },
                messages : {

                        profesor : {
                            required : "Debe ingresar el profesor."
                        },
                        id_usuario: {
                            required : "Debe seleccionar un profesor de la lista."
                        }
                },
                submitHandler: function(form) {


                    jq("#div_loadding_aceptar_busqueda").show();

                    if ( jq('input[name="id_usuario"]').val() != "" ){ // si eligio al usuario del listado
                        form.submit();
                    }
                    else // si tipio y no eligio al usuario
                    {
                        alert( "El usuario debe ser seleccionado del listado" );
                    }


                }

            });
    });
</script>


<link href="<?=base_url()?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />


<script src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript" ></script>

<script>
     var q = jQuery.noConflict();
</script>



 <!-- DATA TABES SCRIPT -->
<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>

<script type="text/javascript">

q(document).ready(function() {
    q('.table.table-striped.table-bordered.alumnos').dataTable({
                "paging":   true,
                "ordering": true,
                "info":     true,
                "bFilter": true,
                "language": {
                    "lengthMenu": "Mostrando _MENU_ postulaciones por pagina.",
                    "zeroRecords": "Ninguna postulacion fue encontrada.",
                    "info": "<b> Mostrando pagina _PAGE_ de _PAGES_ </b>",
                    "infoEmpty": "Ninguna postulacion disponible",
                    "infoFiltered": "(Filtrado de _MAX_ postulaciones totales)",
                    "sSearch": " Buscar    ",
                    "oPaginate": {
                                    "sNext": "Proxima pagina",
                                    "sPrevious": "<i class='fa fa-fw fa-arrow-left'></i>"
                                  }
                }

            });
} );

q(function(){

    q(".form_cambiar_estado").submit(function(e) {

        var values = $(this).serialize();

        e.preventDefault();

        $.ajax({
                url: CI_ROOT+'index.php/postulacion/procesa_cambiar_estado',
                async: true,
                data: values,
                type: 'POST' ,
                dataType: 'JSON',
                success: function(data)
                {
                    if(data.error == false)
                    {
                        alert("Se cambio el estado exitosamente");
                        location.reload();
                    }
                    else
                    {
                        alert("No se cambio el estado exitosamente");
                    }
                  },
                  error: function(x, status, error){
                    alert("No se ejecuto el cambio, intente mas tarde.");
                }

            });
    });
} );



function eliminar_persona( id_crm_persona )
{
  if (confirm('Seguro que desea eliminar el usuario y sus consultas ?'))
  {
      location.href = CI_ROOT+'index.php/contacto/eliminar_persona/'+id_crm_persona;

      /*
      $.ajax({
              url: CI_ROOT+'index.php/contacto/eliminar_persona',
              data: { id_crm_persona: id_crm_persona },
              async: true,
              type: 'POST',
              dataType: 'JSON',
              success: function(data)
              {
                if(data.error == false)
                {
                  alert("Se ha eliminado la persona");
                  location.reload();
                }
                else
                {
                  alert("No se ha podido eliminar la persona, intente mas tarde.");
                }
              },
              error: function(x, status, error){
                alert("error");
              }
        });
      */
  }
}

</script>

<script src="<?=base_url()?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js" type="text/javascript"></script>

<script type="text/javascript">



$(document).ready(function(){


    $('.mensaje_evento').tooltip(
      {
          placement: "left",
          html: true,
           container: 'body',
          open: function (event, ui) {
              ui.tooltip.css("max-width", "800px");
          }

      }

    );



});

</script>