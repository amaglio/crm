 <?php 
     
    $seccion = $this->uri->segment(4);

    if ( $seccion )
    {
      $seccion_show =  $seccion;
    }
    else
    {
      $seccion_show = 0;
    }
   
?>

<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" />

<style type="text/css">
  
  .ui-autocomplete { position: absolute; cursor: default; z-index:4000 !important; 
padding:10px !important;}   


  .callout{

    padding: 20px;
    margin-bottom: 5px;
  }

  .btn-bitbucket
  {
    background-color:#dd4b39;
  }

  .bg-green, .callout.callout-success, .alert-success, .label-success, .modal-success .modal-body
  {

    background-color: rgba(60, 141, 188, 0.84) !important;
    color: black;
  }

  .callout.callout-success{
    border-color: #2d6f94;
  }

   .disabled {
        pointer-events: none;
        cursor: default;
        opacity: 0.6;
    }

  .btn-app {
    min-width:50px;
    background-color:#E6E6E6;
    border:1px solid #BDBDBD;
  }

    #sin_resultado{
      display: none;
    }

    #div_educacion_sigeu{
      display: none;
      background-color: rgba(60, 141, 188, 0.55);
      padding: 20px 20px 0px 20px;
      margin-left: 0px;
      border-top:1px solid silver;
      border:1px solid silver;
    }

    #div_educacion_manual{
      display: none;
      background-color: rgba(60, 141, 188, 0.55);
      padding: 20px 20px 20px 20px;
      margin-left: 0px;
      border-top:1px solid silver;
      border:1px solid silver;
    }

    #sin_resultado_empresa{
      display: none;
    }

    #div_empresa_sigeu{
      display: none;
      background-color: rgba(60, 141, 188, 0.55);
      padding: 20px 20px 0px 20px;
      margin-left: 0px;
      border-top:1px solid silver;
      border:1px solid silver;
    }

    #div_empresa_manual{
      display: none;
      background-color: rgba(60, 141, 188, 0.55);
      padding: 20px 20px 20px 20px;
      margin-left: 0px;
      border-top:1px solid silver;
      border:1px solid silver;
    }

    .fa-remove:before, .fa-close:before, .fa-times:before{
      color:red;
    }

    .li_menu{
      border-right:2px solid #ecf0f5;
    }
</style>

<div class="content-wrapper">

    <section class="content-header">
    <h4>
      <i class="fa fa-users"></i> Contactos /  <a style="color:#000; font-weight:bold; " href="<?=base_url()?>index.php/contacto/ver_contacto/<?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>/"> <?=$info_persona['datos_usuario']->NOMBRE.", ".$info_persona['datos_usuario']->APELLIDO?> </a>
    </h4>
    </section>
    <div class="panel-body">

         

          <?php  mensaje_resultado($mensaje); ?>

          <?php  if( isset($info_persona['datos_usuario']->ID_PERSONA)): ?>

                <div class="callout callout-danger">
                  <h5>El usuario esta en  <strong>SIGEU</strong>, solo puede modificarse desde <strong>SIGEU</strong>.</h5>
                </div>

          <?php  else: ?>

          <div class="panel-body">

             <div  style="margin-bottom:20px;">

              <form style="display:inline"   method="post" action="<?=base_url()?>index.php/contacto/procesar_contactos_encontrados">

                <input type="hidden" id="id_contacto" name="id_contacto[]" value="<?=$valores?>">

                <input data-toggle="tooltip" data-placement="bottom" data-original-title="Cargar una consulta a la persona seleccionada" type="submit" name="cargar_consulta" id="cargar_consulta" class="btn btn-danger btn-sm btn-accion-usuario" value='+ Cargar Consulta'>
                <!-- Este hidden lo usa para cargar_consulta -->
                <input type="hidden" value="Cargar"  name="cargar_consulta" id="cargar_consulta">

              </form>

              <?php   if(isset($info_persona['datos_usuario']->ID_PERSONA) ): ?>

                      <button disabled="disabled"  data-toggle="tooltip" data-placement="top" data-original-title="El usuario ya está en SIGEU" class="btn  btn-success btn-sm" href="<?=base_url()?>index.php/contacto/enviar_persona_sigeu/<?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>">
                          <i class="fa fa-fw fa-fighter-jet"></i> Enviar a SIGEU
                      </button>
                      <!--
                      <button disabled="disabled" data-toggle="tooltip" data-placement="top" data-original-title="No se puede eliminar un usuario de SIGEU" type="button" class="btn  btn-black btn-sm">
                         <i class="fa fa-at" aria-hidden="true"></i> Eliminar persona
                      </button>-->

              <?php   else: ?>

                      <a  href="<?=base_url()?>index.php/contacto/enviar_persona_sigeu/<?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>">
                        <button data-toggle="tooltip" data-placement="top" data-original-title="Enviar esta persona a SIGEU" class="btn  btn-success btn-sm">
                            <i class="fa fa-fw fa-fighter-jet"></i> Enviar a SIGEU
                        </button>
                      </a>

                      <?php  /*onclick="eliminar_persona( <?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>)" ?>
                      <button disabled="disabled"  onclick="eliminar_persona( <?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>)" data-toggle="tooltip" data-placement="top" data-original-title="Eliminar esta persona y todas sus consultas" type="button" class="btn  btn-black btn-sm">
                         <i class="fa fa-at" aria-hidden="true"></i> Eliminar persona
                      </button> */ ?>

              <?php   endif; ?>



            </div>

            <ul class="nav nav-pills nav-justified" id="contacto_tab"  style="background-color: white;">
                <li class="active li_menu">
                    <a href="#informacion_personal" data-toggle="tab"> <i class="fa  fa-user"></i>Informacion Personal</a>
                </li>

                <li class="li_menu">
                    <a href="#emails" data-toggle="tab"> <i class="fa fa-at"></i>Emails</a>
                </li>
                <li class="li_menu">
                    <a href="#telefonos" data-toggle="tab"> <i class="fa fa-phone-square"></i> Telefonos</a>
                </li>
                <li class="li_menu">
                    <a href="#documentos" data-toggle="tab"> <i class="fa fa-id-badge" aria-hidden="true"></i> Documentos</a>
                </li>
                <li class="li_menu">
                    <a href="#div_educacion" data-toggle="tab"> <i class="fa fa-graduation-cap"></i> Educacion</a>
                </li>
                <li class="li_menu">
                    <a href="#div_laboral" data-toggle="tab"> <i class="fa fa-wrench" aria-hidden="true"></i> Exp. Laboral</a>
                </li>
            </ul>
            <div class="tab-content" style="margin-top:20px">

              <!-- INFORMACION PERSONAL -->
                <div class="tab-pane fade in active" id="informacion_personal" style="margin-top:20px">

                    <div class="box box-primary">
                      <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;">
                          <h3 class="box-title">Modificar datos personal</h3>
                      </div>

                      <div class="box-body">

                        <form class="form-horizontal" name="form_modifica_crm_persona" id="form_modifica_crm_persona" method="post" action="<?=base_url()?>index.php/contacto/modifica_datos_crm_persona/">

                            <div class="form-group">
                              <label for="id_crm" class="col-sm-2 control-label">ID</label>
                              <div class="col-sm-9">
                                  <input readonly="readonly"  type="text" class="form-control pull-right" id="id_crm_persona" name="id_crm_persona"  value="<?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="id_sigeu" class="col-sm-2 control-label">ID SIGEU</label>
                              <div class="col-sm-9">
                                  <input readonly="readonly"  type="text" class="form-control pull-right" id="id_sigeu" id="id_sigeu"  value="<?=$info_persona['datos_usuario']->ID_PERSONA?>">
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="id_sigeu" class="col-sm-2 control-label">Fecha Alta</label>
                              <div class="col-sm-9">
                                  <input readonly="readonly"  type="text" class="form-control pull-right" id="fecha_alta" id="fecha_alta"  value="<?=$info_persona['datos_usuario']->FECHA_ALTA?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                              <div class="col-sm-9">
                                  <input   type="text" class="form-control pull-right" id="nombre" name="nombre"  value="<?=$info_persona['datos_usuario']->NOMBRE?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="apellido" class="col-sm-2 control-label">Apellido</label>
                              <div class="col-sm-9">
                                  <input   type="text" class="form-control pull-right" id="apellido" name="apellido"  value="<?=$info_persona['datos_usuario']->APELLIDO?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="apellido" class="col-sm-2 control-label">Sexo</label>
                              <div class="col-sm-9">
 
                                  <label class="radio-inline"><input type="radio" name="sexo" id="sexo" value="M" <?php  if($info_persona['datos_usuario']->SEXO && $info_persona['datos_usuario']->SEXO == 'M') echo 'checked="checked"'; ?> >Masculino</label>
                                  <label class="radio-inline"><input type="radio" name="sexo" id="sexo" value="F"   <?php  if($info_persona['datos_usuario']->SEXO && $info_persona['datos_usuario']->SEXO == 'F') echo 'checked="checked"'; ?>>Femenino</label>
 
                              </div>
                            </div>

                            <?php  if( !isset($info_persona['datos_usuario']->ID_PERSONA)): ?>

                                <input type="submit" class="btn btn-primary  btn-block"   value="Modificar">

                            <?php  endif; ?>
                        </form>
                      </div>
                    </div>
                </div>

              <!-- EDUCACION  -->
                <div class="tab-pane  fade in " id="div_educacion">

                  <!-- Educaciones -->
                  <div class="col-md-6" id="aa" style="padding-left:0px;">

                      <div class="box box-primary">
                          <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;">
                              <h3 class="box-title">Educacion</h3>
                          </div>

                          <div class="box-body">
                              <div class="callout callout-warning" style="padding:8px">
                                  No se puede <strong>EDITAR</strong> la educación, se debe eliminar y crear otra.
                              </div>

                               <?php  if(count($info_persona['datos_educacion'])> 0): ?>

                                  <table class="table">
                                      <thead style="background-color:#e4e4e4;">
                                        <th>Nombre</th>
                                        <!-- <th>Carrera</th> -->
                                        <th>Nivel</th>
                                        <th> </th>
                                        <th> </th>
                                      </thead>

                                      <tbody>

                                        <?php   foreach ( $info_persona['datos_educacion'] as $row):

                                                $cadena = armar_json_educacion_modal($row);
                                        ?>

                                                 <tr>
                                                      <td><?=$row['NOMBRE']?></td>
                                                      <td><?=$row['DESCRIPCION']?></td>
                                                      <td>
                                                          <?php /* if( !isset($info_persona['datos_usuario']->ID_PERSONA)): ?>
                                                            <button type="button" class="btn btn-app" data-toggle="modal" data-target="#modal_editar_educacion"  data-whatever="<?=$cadena?>">
                                                              <i   data-toggle="tooltip" data-placement="bottom" data-original-title="Editar la eduacion" class="fa fa-edit"></i>
                                                            </button>
                                                          <?php  endif; */?>

                                                      </td>
                                                      <td>

                                                          <?php  if( !isset($info_persona['datos_usuario']->ID_PERSONA)): ?>

                                                            <button data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar la educacion"  type="button" class="btn btn-app" onclick="eliminar_educacion_contacto(<?=$row['ID_EDUCACION_CRM']?>)">
                                                              <i class="fa fa-2x fa-trash" aria-hidden="true"></i>
                                                            </button>

                                                          <?php  endif ?>


                                                      </td>
                                                 </tr>

                                        <?php   endforeach; ?>

                                      </tbody>
                                  </table>

                              <?php   else: ?>

                                  <div class="callout callout-danger">
                                    Aun no se ha cargado educación.
                                  </div>

                              <?php   endif; ?>

                           </div>
                      </div>
                  </div>

                  <!-- Crear Educacion -->
                  <?php  if( !isset($info_persona['datos_usuario']->ID_PERSONA)): ?>

                  <div class="col-md-6" id="ff" style="padding-right:0px;">

                    <!-- Cargar Educacion -->
                    <div class="box box-primary">
                        <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;">
                            <h3 class="box-title">Agregar educacion</h3>
                        </div>

                        <div class="box-body">

                          <form class="form-horizontal" name="form_alta_educacion" id="form_alta_educacion" method="post" action="<?=base_url()?>index.php/contacto/alta_educacion_contacto/">

                              <input   type="hidden" class="form-control" name="id_crm_persona" id="id_crm_persona" value="<?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>">


                              <div class="form-group">
                                <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                                <div class="col-sm-9">
                                    <input   type="text" class="form-control pull-right" name="educacion" id="educacion">
                                </div>
                                <div class="col-sm-10" id="sin_resultado" style="padding:5px; color:red; text-align:center">
                                      No hay resultado <a  onclick="mostrar_educacion_manual()"  class="btn btn-xs btn-primary">Cargar manualmente</a>
                                </div>
                              </div>

                              <div class="form-group col-sm-12 " id="div_educacion_sigeu">
                                <label  class="col-sm-2 control-label">Educacion SIGEU</label>
                                <label  class="col-sm-1 control-label"> <a onclick="ocultar_educacion_sigeu()"> <i class="fa fa-times" aria-hidden="true"></i></label></a>
                                <div class="col-sm-8">
                                     <input readonly="readonly" type="text" class="form-control" id="id_educacion" name="id_educacion" placeholder="Educacion Manual"> <br>
                                     <input readonly="readonly" type="text" class="form-control" id="educacion_sigeu" name="educacion_sigeu" placeholder="Educacion Manual"> <br>
                                </div>
                              </div>

                              <div class="form-group col-sm-12 " id="div_educacion_manual">
                                <label  class="col-sm-2 control-label">Educacion Manual</label>
                                <label  class="col-sm-1 control-label"> <a onclick="ocultar_educacion_manual()"> <i class="fa fa-times" aria-hidden="true"></i></a></label>
                                <div class="col-sm-8">
                                   <input type="text" class="form-control" id="educacion_manual" name="educacion_manual" placeholder="Educacion Manual">
                                </div>
                              </div>

                              <!--
                              <div class="form-group">
                                <label for="carrera" class="col-sm-2 control-label">Carrera</label>
                                <div class="col-sm-9">
                                    <input   type="text" class="form-control pull-right" name="carrera" id="carrera">
                                </div>
                              </div>-->


                              <div class="form-group">
                                <label for="carrera" class="col-sm-2 control-label">Nivel</label>
                                <div class="col-sm-9">

                                    <?php   $niveles = array(); ?>

                                    <?php   $niveles[''] = 'Seleccionar Nivel'; ?>

                                    <?php   foreach ($niveles_educacion->result() as $row):

                                            $niveles[$row->ID_NIVEL_EDUCACION] = $row->DESCRIPCION;

                                        endforeach;

                                      echo form_dropdown('id_nivel', $niveles, '' ,'class="form-control" id="id_nivel" name="id_nivel" ' );

                                    ?>

                                </div>
                              </div>



                                <button class="btn btn-primary btn-block" type="submit"> <i class='fa fa-plus-square' style="padding-right:6px;"></i> Agregar Educacion </button>


                          </form>

                        </div>
                    </div>
                  </div>

                  <?php  endif; ?>


                </div>

              <!-- EMAILS  -->
                <div class="tab-pane  fade in  " id="emails">

                  <!-- Lista de emails -->
                  <div class="col-md-6" id="aa" style="padding-left:0px;">

                    <div class="box box-primary ">
                        <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;">
                            <h3 class="box-title">Emails</h3>
                        </div>

                        <div class="box-body">

                            <?php  if( count($info_persona['datos_emails'])> 0): ?>

                                <table class="table">
                                    <thead style="background-color:#e4e4e4;">
                                      <th>Email</th>
                                      <th> </th>
                                      <th> </th>
                                    </thead>

                                    <tbody>

                                      <?php   foreach ($info_persona['datos_emails'] as $row):

                                              $cadena = armar_json_email_modal($row);
                                        ?>

                                               <tr>
                                                    <td><?=$row['EMAIL']?></td>
                                                    <td>
                                                          <?php  if( !isset($info_persona['datos_usuario']->ID_PERSONA)): ?>
                                                            <button  type="button" class="btn btn-app" data-toggle="modal" data-target="#modal_editar_email"  data-whatever="<?=$cadena?>">
                                                              <i data-toggle="tooltip" data-placement="bottom" data-original-title="Editar el email" class="fa fa-edit"></i>
                                                            </button>
                                                          <?php  endif; ?>

                                                      </td>
                                                      <td>

                                                          <?php  if( !isset($info_persona['datos_usuario']->ID_PERSONA)): ?>

                                                            <button data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar el email" type="button" class="btn btn-app" onclick="eliminar_email_contacto(<?=$row['ID_EMAIL_CRM']?>)">
                                                              <i class="fa fa-2x fa-trash" aria-hidden="true"></i>
                                                            </button>

                                                          <?php  endif ?>


                                                      </td>
                                               </tr>

                                      <?php   endforeach; ?>

                                    </tbody>
                                </table>

                            <?php   else: ?>

                                  <div class="callout callout-danger">
                                    Aun no se han cargado emails.
                                  </div>

                            <?php   endif; ?>


                         </div>
                    </div>

                  </div>

                  <?php  if( !isset($info_persona['datos_usuario']->ID_PERSONA)): ?>

                  <div class="col-md-6" id="aa" style="padding-right:0px;">

                    <div class="box box-primary">
                        <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;">
                            <h3 class="box-title">Agregar email</h3>
                        </div>

                        <div class="box-body">

                          <form class="form-horizontal" name="form_alta_email" id="form_alta_email" method="post" action="<?=base_url()?>index.php/contacto/alta_email_contacto/">

                              <input   type="hidden" class="form-control" name="id_crm_persona" id="id_crm_persona" value="<?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>">

                              <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input   type="text" class="form-control pull-right" id="email" name="email">
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="carrera" class="col-sm-2 control-label">Tipos</label>
                                <div class="col-sm-9">

                                    <?php   $tipos_emails = array(); ?>

                                    <?php   $tipos_emails[''] = 'Seleccionar Tipo Email'; ?>

                                    <?php   foreach ($tipos_email->result() as $row):

                                            $tipos_emails[$row->ID_TIPO_EMAIL] = $row->DESCRIPCION;

                                        endforeach;

                                      echo form_dropdown('id_tipo_email', $tipos_emails, '' ,'class="form-control" id="id_tipo_email" name="id_tipo_email" ' );

                                    ?>

                                </div>
                              </div>

                              <button class="btn btn-primary btn-block "  type="submit"> <i class='fa fa-plus-square' style="padding-right:6px;"></i> Agregar Email </button>


                          </form>

                        </div>
                    </div>

                  </div>

                   <?php  endif; ?>

                </div>

              <!-- TELEFONOS  -->
                <div class="tab-pane  fade in  " id="telefonos">

                  <div class="col-md-6" id="aa" style="padding-left:0px;">

                    <div class="box box-primary ">
                        <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;">
                            <h3 class="box-title">Telefonos</h3>
                        </div>

                        <div class="box-body">

                          <?php  if( count($info_persona['datos_telefonos'])> 0): ?>

                                <table class="table">
                                    <thead style="background-color:#e4e4e4;">
                                      <th>Telefono</th>
                                      <th> </th>
                                      <th> </th>
                                    </thead>

                                    <tbody>

                                      <?php   foreach ($info_persona['datos_telefonos'] as $row):
                                            $cadena = armar_json_telefono_modal($row);
                                      ?>

                                            <tr>
                                                <td><?=$row['TELEFONO']?></td>
                                                <td>
                                                      <?php  if( !isset($info_persona['datos_usuario']->ID_PERSONA)): ?>
                                                        <button type="button" class="btn btn-app" data-toggle="modal" data-target="#modal_editar_telefono"  data-whatever="<?=$cadena?>">
                                                          <i data-toggle="tooltip" data-placement="bottom" data-original-title="Editar el telefono" class="fa fa-edit"></i>
                                                        </button>
                                                      <?php  endif; ?>

                                                  </td>
                                                  <td>

                                                      <?php  if( !isset($info_persona['datos_usuario']->ID_PERSONA)): ?>

                                                        <button data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar el telefono" type="button" class="btn btn-app" onclick="eliminar_telefono_contacto(<?=$row['ID_TELEFONO_CRM']?>)">
                                                          <i class="fa fa-2x fa-trash" aria-hidden="true"></i>
                                                        </button>

                                                      <?php  endif ?>


                                                  </td>
                                           </tr>

                                      <?php   endforeach; ?>

                                    </tbody>
                                </table>

                          <?php   else: ?>

                                  <div class="callout callout-danger">
                                    Aun no se han cargado telefonos.
                                  </div>

                          <?php   endif; ?>

                         </div>
                    </div>

                  </div>

                  <?php  if( !isset($info_persona['datos_usuario']->ID_PERSONA)): ?>

                  <div class="col-md-6" id="aa" style="padding-right:0px;">

                    <div class="box box-primary">
                        <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;">
                            <h3 class="box-title">Agregar telefono</h3>
                        </div>

                        <div class="box-body">

                          <form class="form-horizontal" name="form_alta_telefono" id="form_alta_telefono" method="post" action="<?=base_url()?>index.php/contacto/alta_telefono_contacto/">

                              <input   type="hidden" class="form-control" name="id_crm_persona" id="id_crm_persona" value="<?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>">

                              <div class="form-group">
                                <label for="telefono" class="col-sm-2 control-label">Telefono</label>
                                <div class="col-sm-9">
                                    <input   type="text" class="form-control pull-right" id="telefono" name="telefono">
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="carrera" class="col-sm-2 control-label">Tipos</label>
                                <div class="col-sm-9">

                                    <?php   $tipos_telefonos = array(); ?>

                                    <?php   $tipos_telefonos[''] = 'Seleccionar Tipo Telefono'; ?>

                                    <?php   foreach ($tipos_telefono->result() as $row):

                                            $tipos_telefonos[$row->ID_TIPO_TELEFONO] = $row->DESCRIPCION;

                                        endforeach;

                                      echo form_dropdown('id_tipo_telefono', $tipos_telefonos, '' ,'class="form-control" id="id_tipo_telefono" name="id_tipo_telefono" ' );

                                    ?>

                                </div>
                              </div>

                              <button class="btn btn-primary btn-block "  type="submit"> <i class='fa fa-plus-square' style="padding-right:6px;"></i> Agregar Telefono </button>

                          </form>

                        </div>
                    </div>

                  </div>

                   <?php  endif; ?>

                </div>

              <!-- DOCUMENTOS  -->
                <div class="tab-pane  fade in  " id="documentos">

                  <div class="col-md-6" id="aa" style="padding-left:0px;">

                    <div class="box box-primary ">
                        <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;">
                            <h3 class="box-title">Documentos</h3>
                        </div>

                        <div class="box-body">

                            <?php  if( count($info_persona['datos_documentos'])> 0): ?>

                              <table class="table">
                                  <thead style="background-color:#e4e4e4;">
                                    <th>Documento</th>
                                    <th>Tipo</th>
                                    <th> </th>
                                    <th> </th>
                                  </thead>

                                  <tbody>

                                    <?php   foreach ($info_persona['datos_documentos'] as $row):

                                            $cadena = armar_json_documento_modal($row);
                                    ?>

                                               <tr>
                                                  <td><?=$row['NUMERO']?></td>
                                                  <td><?=$row['TIPO']?></td>
                                                  <td>
                                                        <?php  if( !isset($info_persona['datos_usuario']->ID_PERSONA)): ?>
                                                          <button type="button" class="btn btn-app" data-toggle="modal" data-target="#modal_editar_documento"  data-whatever="<?=$cadena?>">
                                                            <i data-toggle="tooltip" data-placement="bottom" data-original-title="Edigar el documento" class="fa fa-edit"></i>
                                                          </button>
                                                        <?php  endif; ?>

                                                    </td>
                                                    <td>

                                                        <?php  if( !isset($info_persona['datos_usuario']->ID_PERSONA)): ?>

                                                          <button data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar el documento" type="button" class="btn btn-app" onclick="eliminar_documento_contacto(<?=$row['ID_CRM_DOCUMENTO']?>)">
                                                            <i class="fa fa-2x fa-trash" aria-hidden="true"></i>
                                                          </button>

                                                        <?php  endif ?>


                                                    </td>
                                             </tr>

                                    <?php   endforeach; ?>

                                  </tbody>
                              </table>

                            <?php   else: ?>

                                  <div class="callout callout-danger">
                                    Aun no se han cargado documentos.
                                  </div>

                            <?php   endif; ?>

                         </div>
                    </div>

                  </div>

                  <?php  if( !isset($info_persona['datos_usuario']->ID_PERSONA)): ?>

                  <div class="col-md-6" id="aa" style="padding-right:0px;">

                    <div class="box box-primary">
                        <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;">
                            <h3 class="box-title">Agregar Documento</h3>
                        </div>

                        <div class="box-body">

                          <form class="form-horizontal" name="form_alta_documento" id="form_alta_documento" method="post" action="<?=base_url()?>index.php/contacto/alta_documento_contacto/">

                              <input   type="hidden" class="form-control" name="id_crm_persona" id="id_crm_persona" value="<?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>">

                              <div class="form-group">
                                <label for="documento" class="col-sm-2 control-label">Documento</label>
                                <div class="col-sm-9">
                                    <input   type="text" class="form-control pull-right" id="documento" name="documento">
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="carrera" class="col-sm-2 control-label">Tipos</label>
                                <div class="col-sm-9">

                                    <?php   $tipos_documento = array(); ?>

                                    <?php   $tipos_documento[''] = 'Seleccionar Tipo Documento'; ?>

                                    <?php   foreach ($tipos_documentos->result() as $row):

                                            $tipos_documento[$row->ID_TIPO_DOCUMENTO] = $row->DESCRIPCION;

                                        endforeach;

                                      echo form_dropdown('id_tipo_documento', $tipos_documento, '' ,'class="form-control" id="id_tipo_documento" name="id_tipo_documento" ' );

                                    ?>

                                </div>
                              </div>

                              <button class="btn btn-primary btn-block "  type="submit"> <i class='fa fa-plus-square' style="padding-right:6px;"></i> Agregar Documento </button>

                          </form>

                        </div>
                    </div>

                  </div>

                   <?php  endif; ?>

                </div>

              <!-- EXP LABORAL  -->
                <div class="tab-pane  fade in  " id="div_laboral">

                  <div class="col-md-6" id="aa" style="padding-left:0px;">

                    <div class="box box-primary ">
                        <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;">
                            <h3 class="box-title">Experiencia Laboral</h3>
                        </div>

                        <div class="box-body">
                            <!--
                             <div class="callout callout-warning" style="padding:8px">
                                  No se puede <strong>EDITAR</strong> la experiencia laborarl, se debe eliminar y crear otra.
                              </div> -->

                            <?php  if( count($info_persona['datos_experiencia_laboral'])> 0): ?>

                              <table class="table">
                                  <thead style="background-color:#e4e4e4;">
                                    <th>Empresa</th>
                                    <th>Cargo</th>
                                    <th>Descripcion</th>
                                    <th> </th>
                                    <th> </th>
                                  </thead>

                                  <tbody>

                                    <?php   foreach ($info_persona['datos_experiencia_laboral'] as $row):

                                            $cadena = armar_json_experiencia_laboral_modal($row);
                                    ?>

                                               <tr>
                                                  <td><?=$row['NOMBRE']?></td>
                                                  <td><?=$row['CARGO']?></td>
                                                  <td><?=$row['DESCRIPCION_CARGO']?></td>
                                                  <td>
                                                      <?php  if( !isset($info_persona['datos_usuario']->ID_PERSONA)): ?>
                                                        <button type="button" class="btn btn-app" data-toggle="modal" data-target="#modal_editar_experiencia_laboral"  data-whatever="<?=$cadena?>">
                                                          <i data-toggle="tooltip" data-placement="bottom" data-original-title="Edigar el documento" class="fa fa-edit"></i>
                                                        </button>
                                                      <?php  endif; ?>

                                                  </td>
                                                  <td>

                                                        <?php  if( !isset($info_persona['datos_usuario']->ID_PERSONA)): ?>

                                                          <button data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar la experiencia laboral" type="button" class="btn btn-app" onclick="eliminar_experiencia_laboral(<?=$row['ID']?>)">
                                                            <i class="fa fa-2x fa-trash" aria-hidden="true"></i>
                                                          </button>

                                                        

                                                        <?php  endif ?>


                                                  </td>
                                             </tr>

                                    <?php   endforeach; ?>

                                  </tbody>
                              </table>

                            <?php   else: ?>

                                  <div class="callout callout-danger">
                                    Aun no se han cargado experiencias laborales.
                                  </div>

                            <?php   endif; ?>

                         </div>
                    </div>

                  </div>

                  <?php  if( !isset($info_persona['datos_usuario']->ID_PERSONA)): ?>

                  <div class="col-md-6" id="aa" style="padding-right:0px;">

                    <div class="box box-primary">
                        <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;">
                            <h3 class="box-title">Agregar Experiencia Laboral</h3>
                        </div>

                        <div class="box-body">

                          <form class="form-horizontal" name="form_alta_experiencia_laboral" id="form_alta_experiencia_laboral" method="post" action="<?=base_url()?>index.php/contacto/alta_experiencia_laboral/">

                              <input   type="hidden" class="form-control" name="id_crm_persona" id="id_crm_persona" value="<?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>">

                              <div class="form-group">
                                <label for="empresa" class="col-sm-2 control-label">Empresa</label>
                                <div class="col-sm-9">
                                    <input   type="text" class="form-control pull-right" id="empresa" name="empresa">
                                </div>
                                 <div class="col-sm-10" id="sin_resultado_empresa" style="padding:5px; color:red; text-align:center">
                                      No hay resultado <a  onclick="mostrar_empresa_manual()"  class="btn btn-xs btn-primary">Cargar manualmente</a>
                                </div>
                              </div>

                              <div class="form-group col-sm-12 " id="div_empresa_sigeu">
                                <label  class="col-sm-2 control-label">Empresa SIGEU</label>
                                <label  class="col-sm-1 control-label"> <a onclick="ocultar_empresa_sigeu()"> <i class="fa fa-times" aria-hidden="true"></i></label>
                                <div class="col-sm-8">
                                     <input readonly="readonly" type="text" class="form-control" id="id_empresa" name="id_empresa" placeholder="Empresa Manual"> <br>
                                     <input readonly="readonly" type="text" class="form-control" id="empresa_sigeu" name="empresa_sigeu" placeholder="Empresa Manual"> <br>
                                </div>
                              </div>

                              <div class="form-group col-sm-12 " id="div_empresa_manual">
                                <label  class="col-sm-2 control-label">Empresa Manual</label>
                                <label  class="col-sm-1 control-label"> <a onclick="ocultar_empresa_manual()"> <i class="fa fa-times" aria-hidden="true"></i></a></label>
                                <div class="col-sm-8">
                                   <input type="text" class="form-control" id="empresa_manual" name="empresa_manual" placeholder="Empresa Manual">
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="cargo" class="col-sm-2 control-label">Cargo</label>
                                <div class="col-sm-9">
                                    <input   type="text" class="form-control pull-right" id="cargo" name="cargo">
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="descripcion" class="col-sm-2 control-label">Descripcion</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control pull-right" id="descripcion" name="descripcion"></textarea>
                                </div>
                              </div>


                              <button class="btn btn-primary btn-block "  type="submit"> <i class='fa fa-plus-square' style="padding-right:6px;"></i> Agregar Exp. Laboral </button>

                          </form>

                        </div>
                    </div>

                  </div>

                   <?php  endif; ?>

                </div>

            </div>
          </div>

          <?php  endif; ?>
    </div>








<!-- MODAL MODIFICA EDUCACION -->
<div class="modal fade " id="modal_editar_educacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#3c8dbc; color:white">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Editar educacion</h4>
      </div>

      <!--<form  name="certificado_form_mod" id="certificado_form_mod" method="POST" action="<?=base_url()?>index.php/certificado_idioma/editar_certificado/">-->

      <form  name="form_modifica_educacion" id="form_modifica_educacion" method="POST"  action="<?=base_url()?>index.php/contacto/modifica_educacion_contacto/">

        <div class="modal-body">

            <input type="hidden" class="form-control" id="id_educacion_crm"  name="id_educacion_crm">
            <input type="hidden" class="form-control" id="id_crm_persona" name="id_crm_persona"  value="<?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>">


             <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresar Sigla">
              </div>

              <!--
              <div class="form-group">
                <label for="carrera">Carrera</label>
                <textarea class="form-control" id="carrera" name="carrera" rows="3" placeholder="Ingresar Descripcion"></textarea>
              </div>-->

               <div class="form-group">
                <label for="duracion">Duracion (años)</label>
                <?php   $niveles = array(); ?>

                <?php   $niveles[''] = 'Seleccionar Nivel'; ?>

                <?php   foreach ($niveles_educacion->result() as $row):

                $niveles[$row->ID_NIVEL_EDUCACION] = $row->DESCRIPCION;

                endforeach;

                echo form_dropdown('id_nivel', $niveles, '' ,'class="form-control" id="id_nivel" name="id_nivel" ' );

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


<!-- MODAL MODIFICAR EMAIL -->
<div class="modal fade " id="modal_editar_email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#3c8dbc; color:white">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Editar email</h4>
      </div>

      <!--<form  name="certificado_form_mod" id="certificado_form_mod" method="POST" action="<?=base_url()?>index.php/certificado_idioma/editar_certificado/">-->

      <form  name="form_modifica_email" id="form_modifica_email" method="POST"  action="<?=base_url()?>index.php/contacto/modifica_email_contacto/">

        <div class="modal-body">

            <input type="hidden" class="form-control" id="id_email_crm"  name="id_email_crm">
            <input type="hidden" class="form-control" id="id_crm_persona" name="id_crm_persona"  value="<?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>">


             <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Ingresar email">
              </div>

              <div class="form-group">
                <label for="email">Tipo Email</label>
                <?php   $tipos_emails = array(); ?>

                <?php   $tipos_emails[''] = 'Seleccionar Tipo Email'; ?>

                <?php   foreach ($tipos_email->result() as $row):

                        $tipos_emails[$row->ID_TIPO_EMAIL] = $row->DESCRIPCION;

                    endforeach;

                  echo form_dropdown('id_tipo_email', $tipos_emails, '' ,'class="form-control" id="id_tipo_email" name="id_tipo_email" ' );

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

<!-- MODAL MODIFICAR TELEFONO -->
<div class="modal fade " id="modal_editar_telefono" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#3c8dbc; color:white">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Editar telefono</h4>
      </div>

      <!--<form  name="certificado_form_mod" id="certificado_form_mod" method="POST" action="<?=base_url()?>index.php/certificado_idioma/editar_certificado/">-->

      <form  name="form_modifica_telefono" id="form_modifica_telefono" method="POST"  action="<?=base_url()?>index.php/contacto/modifica_telefono_contacto/">

        <div class="modal-body">

            <input type="hidden" class="form-control" id="id_telefono_crm"  name="id_telefono_crm">
            <input type="hidden" class="form-control" id="id_crm_persona" name="id_crm_persona"  value="<?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>">


             <div class="form-group">
                <label for="telefono">Telefono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingresar telefono">
              </div>

              <div class="form-group">
                <label for="email">Tipo Telefono</label>
                <?php   $tipos_telefonos = array(); ?>

                <?php   $tipos_telefonos[''] = 'Seleccionar tipo telefono'; ?>

                <?php   foreach ($tipos_telefono->result() as $row):

                        $tipos_telefonos[$row->ID_TIPO_TELEFONO] = $row->DESCRIPCION;

                    endforeach;

                  echo form_dropdown('id_tipo_telefono', $tipos_telefonos, '' ,'class="form-control" id="id_tipo_telefono" name="id_tipo_telefono" ' );

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

<!-- MODAL MODIFICAR DOCUMENTO -->
<div class="modal fade " id="modal_editar_documento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#3c8dbc; color:white">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Editar documento</h4>
      </div>

       <form  name="form_modifica_documento" id="form_modifica_documento" method="POST"  action="<?=base_url()?>index.php/contacto/modifica_documento_contacto/">

        <div class="modal-body">

            <input type="hidden" class="form-control" id="id_documento_crm"  name="id_documento_crm">
            <input type="hidden" class="form-control" id="id_crm_persona" name="id_crm_persona"  value="<?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>">


             <div class="form-group">
                <label for="telefono">Documento</label>
                <input type="text" class="form-control" id="documento" name="documento" placeholder="Ingresar numero">
              </div>

              <div class="form-group">
                <label for="email">Tipo Documento</label>
                <?php   $tipos_documento = array(); ?>

                <?php   $tipos_documento[''] = 'Seleccionar tipo documento'; ?>

                <?php   foreach ($tipos_documentos->result() as $row):

                        $tipos_documento[$row->ID_TIPO_DOCUMENTO] = $row->DESCRIPCION;

                    endforeach;

                  echo form_dropdown('id_tipo_documento', $tipos_documento, '' ,'class="form-control" id="id_tipo_documento" name="id_tipo_documento" ' );

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


<!-- MODAL MODIFICAR EXPERIENCIA LABORAL -->
<div class="modal fade " id="modal_editar_experiencia_laboral"   aria-labelledby="modal_editar_experiencia_laboral">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#3c8dbc; color:white">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Editar experiencia laboral</h4>
      </div>
      <form  name="form_modifica_experiencia_laboral" id="form_modifica_experiencia_laboral" method="post" action="<?=base_url()?>index.php/contacto/modifica_experiencia_laboral/">
      <div class="modal-body">

            <input type="hidden" class="form-control" id="id_crm_persona_empresa"  name="id_crm_persona_empresa">
            <input type="hidden" class="form-control" id="id_crm_persona" name="id_crm_persona"  value="<?=$info_persona['datos_usuario']->ID_CRM_PERSONA?>">

              <div class="form-group">
                <label for="empresa" class="col-sm-2 control-label">Empresa</label>
                <div class="col-sm-9">
                    <input   type="text" class="form-control pull-right" id="empresa" name="empresa" readonly="true">
                </div>
                 <div class="col-sm-12" id="sin_resultado_empresa" style="padding:5px; color:red; text-align:center">
                      No hay resultado <a  onclick="mostrar_empresa_manual_modal()"  class="btn btn-xs btn-primary">Cargar manualmente</a>
                </div>
              </div>

              <div class="form-group  col-sm-12" id="div_empresa_sigeu" style="margin: 20px 0px;">
                <label  class="col-sm-2 control-label">Empresa SIGEU</label>
                <label  class="col-sm-2 control-label">
                     <a href="#" onclick="ocultar_empresa_sigeu_modal()"> <i class="fa fa-times" aria-hidden="true"></i></a>
                </label>
                <div class="col-sm-8">
                     <input readonly="readonly" type="text" class="form-control" id="id_empresa" name="id_empresa" placeholder="Id empresa"> <br>
                     <input readonly="readonly" type="text" class="form-control" id="empresa_sigeu" name="empresa_sigeu" placeholder="Empresa SIGEU"> <br>
                </div>
              </div>

              <div class="   col-sm-12 " id="div_empresa_manual" style="margin: 20px 0px;">
                <label  class="col-sm-2 control-label">Empresa Manual</label>
                <label  class="col-sm-1 control-label"> <a onclick="ocultar_empresa_manual_modal()"> <i class="fa fa-times" aria-hidden="true"></i></a></label>
                <div class="col-sm-8">
                   <input type="text" class="form-control" id="empresa_manual" name="empresa_manual" placeholder="Empresa Manual">
                </div>
              </div>

              <div class="form-group ">
                <label for="cargo" class="col-sm-2 control-label">Cargo</label>
                <div class="col-sm-9">
                    <input   type="text" class="form-control pull-right" id="cargo" name="cargo">
                </div>
              </div>

              <div class="form-group">
                <label for="descripcion" class="col-sm-2 control-label">Descripcion</label>
                <div class="col-sm-9">
                    <textarea class="form-control pull-right" id="descripcion" name="descripcion"></textarea>
                </div>
              </div>
      </div>
      <div class="modal-footer" style="border-top-color: #f4f4f4; display: inline-block; width: -moz-available;" >
          <button type="submit" data-dismiss="modal" class="btn btn-warning">Cancelar</button>
          <button class="btn btn-primary" type="submit"  > 
              <i class='fa fa-plus-square' style="padding-right:6px;"></i> Modificar Exp. Laboral
          </button>
      </div>   
      </form>
    </div>
  </div>
 </div>

<!-- VALIDAR -->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.10.custom.min.js"></script>

<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js"></script>

<script>
var jq = jQuery.noConflict();
</script>

<script type="text/javascript">

   // Modifica datos persona
    jq(function(){

        jq('#form_modifica_crm_persona').validate({

            rules :{

                    nombre : {
                        required : true
                    },
                    apellido: {
                        required : true
                    },
                    sexo: {
                        required : true
                    }
            },
            messages : {

                    nombre : {
                        required : "Debe ingresar el nombre del contacto."
                    },
                    apellido: {
                        required : "Debe apellido del nombre del contacto."
                    },
                    sexo: {
                        required : "Debe elegir el sexo del contacto."
                    }
            },
            invalidHandler: function(form, validator) {

                jq('#form_modifica_crm_persona').find(":submit").removeAttr('disabled');
            }

        });
    });

    // Funcion para el alta educacion
    jq.validator.addMethod("nombre_educacion",

          function(value, element)
          {
                console.log("nombre_educacion: ");

                if(  ( jq('#id_educacion').val() == "") && ( jq('#educacion_manual').val() == "")  )
                {
                    return false;
                }
                else
                {
                    return true;
                }

          },
         "Debe seleccionar una educacion del listado o ingresarla manualmente"
    );


    // Alta educacion
    jq(function(){

        jq('#form_alta_educacion').validate({
            onfocusout: function (element) {
              $(element).valid();
            },
            rules :{

                    educacion : {
                        nombre_educacion : true
                    },
                    id_nivel: {
                        required : true
                    }
            },
            messages : {

                    educacion : {
                        nombre_educacion : "Debe seleccionar una institucion del listado o ingresarla manualmente"
                    },
                    id_nivel: {
                        required : "Debe seleccionar un nivel de educacion"
                    }
            },
            invalidHandler: function(form, validator) {

                jq('#form_alta_educacion').find(":submit").removeAttr('disabled');
            }

        });
    });

    // Modifica educacion
    jq(function(){

        jq('#form_modifica_educacion').validate({

            rules :{

                    nombre : {
                        required : true
                    },
                    id_nivel: {
                        required : true
                    }
            },
            messages : {

                    nombre : {
                        required : "Debe ingresar el nombre de la institucion."
                    },
                    id_nivel: {
                        required : "Debe seleccionar un nivel de educacion"
                    }
            }

        });
    });

    // Alta Email
    jq(function(){

          jq('#form_alta_email').validate({

              rules :{

                      email : {
                          required : true
                      },
                      id_tipo_email: {
                          required : true
                      }
              },
              messages : {

                      email : {
                          required : "Debe ingresar el email del contacto."
                      },
                      id_tipo_email: {
                          required : "Debe seleccionar el tipo de email"
                      }
              },
              invalidHandler: function(form, validator) {

                  jq('#form_alta_email').find(":submit").removeAttr('disabled');
              }

          });
    });

    // Modifica Email
    jq(function(){

            jq('#form_modifica_email').validate({

                rules :{

                        email : {
                            required : true
                        },
                        id_tipo_email: {
                            required : true
                        }
                },
                messages : {

                        email : {
                            required : "Debe ingresar el email del contacto."
                        },
                        id_tipo_email: {
                            required : "Debe seleccionar el tipo de email"
                        }
                },
                invalidHandler: function(form, validator) {

                    jq('#form_modifica_email').find(":submit").removeAttr('disabled');
                }

            });
    });

    // Alta telefono
    jq(function(){

            jq('#form_alta_telefono').validate({

                rules :{

                        telefono : {
                            required : true
                        },
                        id_tipo_telefono: {
                            required : true
                        }
                },
                messages : {

                        telefono : {
                            required : "Debe ingresar el telefono del contacto."
                        },
                        id_tipo_telefono: {
                            required : "Debe seleccionar el tipo de telefono"
                        }
                },
                invalidHandler: function(form, validator) {

                    jq('#form_alta_telefono').find(":submit").removeAttr('disabled');
                }

            });
    });

    // Modifica telefono
    jq(function(){

            jq('#form_modifica_telefono').validate({

                rules :{

                        telefono : {
                            required : true
                        },
                        id_tipo_telefono: {
                            required : true
                        }
                },
                messages : {

                        telefono : {
                            required : "Debe ingresar el telefono del contacto."
                        },
                        id_tipo_telefono: {
                            required : "Debe seleccionar un nivel de educacion"
                        }
                },
                invalidHandler: function(form, validator) {

                    jq('#form_modifica_telefono').find(":submit").removeAttr('disabled');
                }

            });
    });

    // Alta documento
    jq(function(){

            jq('#form_alta_documento').validate({

                rules :{

                        documento : {
                            required : true
                        },
                        id_tipo_documento: {
                            required : true
                        }
                },
                messages : {

                        documento : {
                            required : "Debe ingresar el documento del contacto."
                        },
                        id_tipo_documento: {
                            required : "Debe seleccionar el tipo de documento"
                        }
                },
                invalidHandler: function(form, validator) {

                    jq('#form_alta_documento').find(":submit").removeAttr('disabled');
                }

            });
    });

    // Modifica documento
    jq(function(){

            jq('#form_modifica_documento').validate({

                rules :{

                        documento : {
                            required : true
                        },
                        id_tipo_documento: {
                            required : true
                        }
                },
                messages : {

                        documento : {
                            required : "Debe ingresar el numero de documento."
                        },
                        id_tipo_documento: {
                            required : "Debe seleccionar un tipo de documento"
                        }
                },
                invalidHandler: function(form, validator) {

                    jq('#form_modifica_documento').find(":submit").removeAttr('disabled');
                }

            });
    });

    // Funcion para el alta empresa
    jq.validator.addMethod("nombre_empresa",

          function(value, element)
          {
                console.log("nombre_empresa: ");

                if(  ( jq('#id_empresa').val() == "") && ( jq('#empresa_manual').val() == "")  )
                {
                    return false;
                }
                else
                {
                    return true;
                }

          },
         "Debe seleccionar una educacion del listado o ingresarla manualmente"
    );

    // Alta educacion
    jq(function(){

        jq('#form_alta_experiencia_laboral').validate({
            onfocusout: function (element) {
              jq(element).valid();
            },
            rules :{

                    empresa : {
                        nombre_empresa : true
                    }
            },
            messages : {

                    empresa : {
                        nombre_empresa : "Debe seleccionar una empresa del listado o ingresarla manualmente"
                    }
            },
            invalidHandler: function(form, validator) {

                jq('#form_alta_experiencia_laboral').find(":submit").removeAttr('disabled');
            }


        });
    });


    function eliminar_educacion_contacto(id_educacion_crm)
    {
      if (confirm('Seguro queres eliminar la educacion ?'))
      {

            $.ajax({
                    url: CI_ROOT+'index.php/contacto/baja_educacion_contacto',
                    data: { id_educacion_crm: id_educacion_crm },
                    async: true,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(data)
                    {
                      if(data.error == false)
                      {
                        //alert("Se ha eliminado el area exitosamente");
                        location.reload();
                      }
                      else
                      {
                        //alert("No se ha eliminado el area");
                        location.reload();
                      }
                    },
                    error: function(x, status, error){
                      alert(error);
                    }
              });

      }
    }

    function eliminar_experiencia_laboral(id_crm_persona_empresa)
    {
      if (confirm('Seguro queres eliminar la experiencia laboral ?'))
      {

            $.ajax({
                    url: CI_ROOT+'index.php/contacto/baja_experiencia_laboral',
                    data: { id_crm_persona_empresa: id_crm_persona_empresa },
                    async: true,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(data)
                    {
                      if(data.error == false)
                      {
                        //alert("Se ha eliminado el area exitosamente");
                        location.reload();
                      }
                      else
                      {
                        //alert("No se ha eliminado el area");
                        location.reload();
                      }
                    },
                    error: function(x, status, error){
                      alert(error);
                    }
              });

      }
    }

    function eliminar_email_contacto(id_email_crm)
    {
      if (confirm('Seguro queres eliminar el email ?'))
      {

            $.ajax({
                    url: CI_ROOT+'index.php/contacto/baja_email_contacto',
                    data: { id_email_crm: id_email_crm },
                    async: true,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(data)
                    {
                      if(data.error == false)
                      {
                        //alert("Se ha eliminado el area exitosamente");
                        location.reload();
                      }
                      else
                      {
                        //alert("No se ha eliminado el area");
                        location.reload();
                      }
                    },
                    error: function(x, status, error){
                      alert(error);
                    }
              });

      }
    }


    function eliminar_telefono_contacto(id_telefono_crm)
    {
      if (confirm('Seguro queres eliminar el telefono ?'))
      {

            $.ajax({
                    url: CI_ROOT+'index.php/contacto/baja_telefono_contacto',
                    data: { id_telefono_crm: id_telefono_crm },
                    async: true,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(data)
                    {
                      if(data.error == false)
                      {
                        //alert("Se ha eliminado el area exitosamente");
                        location.reload();
                      }
                      else
                      {
                        //alert("No se ha eliminado el area");
                        location.reload();
                      }
                    },
                    error: function(x, status, error){
                      alert(error);
                    }
              });

      }
    }

    function eliminar_documento_contacto(id_documento_crm)
    {
      if (confirm('Seguro queres eliminar el documento ?'))
      {

            $.ajax({
                    url: CI_ROOT+'index.php/contacto/baja_documento_contacto',
                    data: { id_documento_crm: id_documento_crm },
                    async: true,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(data)
                    {
                      if(data.error == false)
                      {
                        //alert("Se ha eliminado el area exitosamente");
                        location.reload();
                      }
                      else
                      {
                        //alert("No se ha eliminado el area");
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


<script src="<?=base_url()?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js" type="text/javascript"></script>

<script type="text/javascript">
  
  $("#contacto_tab li:eq(<?=$seccion_show?>) a").tab('show');

</script>

<script>
   var jq_m = jQuery.noConflict();
</script>

<script type="text/javascript">

 
jq_m('#modal_editar_experiencia_laboral').on('show.bs.modal', function (event) {

    var cadena_json_correcta;
    var button = jq(event.relatedTarget);
    var array_json;

    var cadena_json_recibida = button.data('whatever');

    console.dir(cadena_json_recibida);

    cadena_json_correcta = cadena_json_recibida.replace(/&/g, "\"");

    console.dir(cadena_json_correcta);

    array_json = JSON.parse(cadena_json_correcta);

    var id_crm_persona_empresa = array_json.id_crm_persona_empresa;
    var empresa = array_json.empresa;
    var cargo = array_json.cargo;

    if(array_json.id_empresa != null)
      var id_empresa = array_json.id_empresa;
    else
      var id_empresa = 0;
    
    var descripcion = array_json.descripcion;
 
    var modal = $(this)

    modal.find('#id_empresa').val(id_empresa);

    if( id_empresa != 0 ) // SI ESTA EN SIGEU
    {
        modal.find('#div_empresa_sigeu').show();
        modal.find('#div_empresa_manual').hide(); 
        modal.find('#empresa_sigeu').val(empresa);
    }
    else
    {
        modal.find('#div_empresa_manual').show(); 
        modal.find('#div_empresa_sigeu').hide();
        modal.find('#empresa_manual').val(empresa);
    }

    modal.find('#empresa').val(empresa);
    modal.find('#cargo').val(cargo);
    modal.find('#id_crm_persona_empresa').val(id_crm_persona_empresa);
    modal.find('#id_empresa').val(id_empresa);
    modal.find('#descripcion').val(descripcion);

});


jq_m('#modal_editar_email').on('show.bs.modal', function (event) {

    var cadena_json_correcta;
    var button = jq(event.relatedTarget);
    var array_json;

    var cadena_json_recibida = button.data('whatever');

    console.dir(cadena_json_recibida);

    cadena_json_correcta = cadena_json_recibida.replace(/&/g, "\"");

    console.dir(cadena_json_correcta);

    array_json = JSON.parse(cadena_json_correcta);

    var id_email_crm = array_json.id_email_crm;
    var id_tipo_email = array_json.id_tipo_email;
    var email = array_json.email;


    console.log(id_email_crm);

    var modal = $(this)

    modal.find('#id_email_crm').val(id_email_crm);
    modal.find('#id_tipo_email').val(id_tipo_email);
    modal.find('#email').val(email);


});

jq_m('#modal_editar_telefono').on('show.bs.modal', function (event) {

    var cadena_json_correcta;
    var button = jq(event.relatedTarget);
    var array_json;

    var cadena_json_recibida = button.data('whatever');

    console.dir(cadena_json_recibida);

    cadena_json_correcta = cadena_json_recibida.replace(/&/g, "\"");

    console.dir(cadena_json_correcta);

    array_json = JSON.parse(cadena_json_correcta);

    var id_telefono_crm = array_json.id_telefono_crm;
    var id_tipo_telefono = array_json.id_tipo_telefono;
    var telefono = array_json.telefono;


    console.log(id_telefono_crm);

    var modal = $(this)

    modal.find('#id_telefono_crm').val(id_telefono_crm);
    modal.find('#id_tipo_telefono').val(id_tipo_telefono);
    modal.find('#telefono').val(telefono);


});

jq_m('#modal_editar_documento').on('show.bs.modal', function (event) {

    var cadena_json_correcta;
    var button = jq(event.relatedTarget);
    var array_json;

    var cadena_json_recibida = button.data('whatever');

    console.dir(cadena_json_recibida);

    cadena_json_correcta = cadena_json_recibida.replace(/&/g, "\"");

    console.dir(cadena_json_correcta);

    array_json = JSON.parse(cadena_json_correcta);


    var id_documento_crm = array_json.id_documento_crm;
    var id_tipo_documento = array_json.id_tipo_documento;
    var numero = array_json.numero;


    console.log(id_telefono_crm);

    var modal = $(this)

    modal.find('#id_documento_crm').val(id_documento_crm);
    modal.find('#id_tipo_documento').val(id_tipo_documento);
    modal.find('#documento').val(numero);


});


</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.12.1/jquery-ui.js"></script>

<script>
  var jq_ui = jQuery.noConflict();
</script>



<script type="text/javascript">

//--- EDUCACION ----

jq_ui('#educacion').autocomplete({

      minLength: 3,
      change: function( event, ui ) {
         //jq_ui('#educacion_manual').hide();
      },
      source:'<?php echo site_url('consulta/ajax_educacion'); ?>',
      select: function(event, ui)
      {
          jq_ui('#educacion').attr('readonly', true);
          jq_ui('#educacion').val("");
          jq_ui("#div_educacion_sigeu").show();
          jq_ui("#id_educacion").val(ui.item.id_empresa);
          jq_ui("#educacion_sigeu").val(ui.item.value);
          jq_ui(this).val("");
          $("label.error").hide();

          return false; // Importante, si esto no borra el input

      },
      response: function(event, ui) {

        if (ui.content.length === 0)
        {
             jq_ui('#sin_resultado').show();
             $("label.error").hide();
        }
        else
        {
             jq_ui('#sin_resultado').hide();
        }

      }

});

function ocultar_educacion_manual()
{
    jq_ui('#educacion').val("");
    jq_ui('#educacion_manual').val("");
    jq_ui('#div_educacion_manual').hide();
    jq_ui('#educacion').attr('readonly', false);
}

function mostrar_educacion_manual()
{

    $("label.error").hide();

    jq_ui('#sin_resultado').hide();

    jq_ui('#educacion').val("");

    jq_ui('#educacion').attr('readonly', true);
    jq_ui('#div_educacion_manual').show();

    return false;
}

function ocultar_educacion_sigeu()
{
    jq_ui('#sin_resultado').hide();
    jq_ui('#div_educacion_sigeu').hide();

    jq_ui('#id_educacion').val("");
    jq_ui('#educacion_sigeu').val("");

    jq_ui('#educacion').val("");
    jq_ui('#educacion').attr('readonly', false);
}


 //--- EMPRESA ----

jq_ui('#empresa').autocomplete({

      minLength: 3,
      change: function( event, ui ) {
         //jq_ui('#educacion_manual').hide();
      },
      source:'<?php echo site_url('consulta/ajax_empresa'); ?>',
      select: function(event, ui)
      {   

          jq_ui.ajax({
                  url: CI_ROOT+'index.php/contacto/existe_persona_empresa',
                  data: { id_empresa: ui.item.id_empresa, id_crm_persona: jq_ui('#id_crm_persona').val() },
                  async: true,
                  type: 'POST',
                  dataType: 'JSON',
                  success: function(data)
                  {     
                      console.log( data.error );

                      if( data.error )
                      {
                      
                        jq_ui('#empresa').attr('readonly', true);
                        jq_ui('#empresa').val("");

                        jq_ui("#div_empresa_sigeu").show();
                        jq_ui("#id_empresa").val(ui.item.id_empresa);
                        jq_ui("#empresa_sigeu").val(ui.item.value);

                        jq_ui(this).val("");
                        jq_ui("label.error").hide();
                      }
                      else
                      {
                         alert("el usuario ya tiene la empresa elija otra");
                      }

                       return false;  
                  },
                  error: function(x, status, error){
                    alert(error);
                  }
          });

      },
      response: function(event, ui) {

        if (ui.content.length === 0)
        {
             jq_ui('#sin_resultado_empresa').show();
             $("label.error").hide();
        }
        else
        {
             jq_ui('#sin_resultado_empresa').hide();
        }

      }

});

function ocultar_empresa_manual()
{
    jq_ui('#empresa').val("");
    jq_ui('#empresa_manual').val("");
    jq_ui('#div_empresa_manual').hide();
    jq_ui('#empresa').attr('readonly', false);
}

function mostrar_empresa_manual()
{

    $("label.error").hide();

    jq_ui('#sin_resultado_empresa').hide();

    jq_ui('#empresa').val("");

    jq_ui('#empresa').attr('readonly', true);
    jq_ui('#div_empresa_manual').show();

    return false;
}

function ocultar_empresa_sigeu()
{   

    jq_ui('#sin_resultado_empresa').hide();
    jq_ui('#div_empresa_sigeu').hide();

    jq_ui('#id_empresa').val("");
    jq_ui('#empresa_sigeu').val("");

    jq_ui('#empresa').val("");
    jq_ui('#empresa').attr('readonly', false);
}

// Funciones Modal

function ocultar_empresa_sigeu_modal()
{   
   
    jq_ui('#modal_editar_experiencia_laboral #sin_resultado_empresa').hide();
    jq_ui('#modal_editar_experiencia_laboral #div_empresa_sigeu').hide();

    jq_ui('#modal_editar_experiencia_laboral #id_empresa').val("");
    jq_ui('#modal_editar_experiencia_laboral #empresa_sigeu').val("");

    jq_ui('#modal_editar_experiencia_laboral #empresa').val("");
    jq_ui('#modal_editar_experiencia_laboral #empresa').attr('readonly', false);  
}

jq_ui('#modal_editar_experiencia_laboral #empresa').autocomplete({

      minLength: 3,
      change: function( event, ui ) {
         //jq_ui('#educacion_manual').hide();
      },
      source:'<?php echo site_url('consulta/ajax_empresa'); ?>',
      select: function(event, ui)
      {
          jq_ui('#modal_editar_experiencia_laboral #empresa').attr('readonly', true);
          jq_ui('#modal_editar_experiencia_laboral #empresa').val("");

          jq_ui("#modal_editar_experiencia_laboral #div_empresa_sigeu").show();
          jq_ui("#modal_editar_experiencia_laboral #id_empresa").val(ui.item.id_empresa);
          jq_ui("#modal_editar_experiencia_laboral #empresa_sigeu").val(ui.item.value);

          jq_ui(this).val("");
          $("label.error").hide();

          return false; // Importante, si esto no borra el input

      },
      response: function(event, ui) {

        if (ui.content.length === 0)
        {
             jq_ui('#modal_editar_experiencia_laboral #sin_resultado_empresa').show();
             $("label.error").hide();
        }
        else
        {
             jq_ui('#modal_editar_experiencia_laboral #sin_resultado_empresa').hide();
        }

      }

});

function mostrar_empresa_manual_modal()
{

    $("label.error").hide();

    jq_ui('#modal_editar_experiencia_laboral #sin_resultado_empresa').hide();

    jq_ui('#modal_editar_experiencia_laboral #empresa').val("");

    jq_ui('#modal_editar_experiencia_laboral #empresa').attr('readonly', true);
    jq_ui('#modal_editar_experiencia_laboral #div_empresa_manual').show();

    return false;
}

function ocultar_empresa_manual_modal()
{
    jq_ui('#modal_editar_experiencia_laboral #empresa').val("");
    jq_ui('#modal_editar_experiencia_laboral #empresa_manual').val("");
    jq_ui('#modal_editar_experiencia_laboral #div_empresa_manual').hide();
    jq_ui('#modal_editar_experiencia_laboral #empresa').attr('readonly', false);
}


</script>