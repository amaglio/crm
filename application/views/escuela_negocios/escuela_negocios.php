<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" />
<link   rel='stylesheet' href='<?=base_url()?>assets/css/escuela_negocios/escuela_negocios.css' />

<meta charset="UTF-8"> 
<div class="content-wrapper">

  <section class="content-header">
    <h4>
      <i class="fa fa-handshake-o"></i>
      <span>Escuela de negocios</span>
      <span class="pull-right" data-toggle="tooltip" data-placement="bottom" data-original-title="Ver ayuda">
          <a href="#" data-toggle="control-sidebar" ><i class="fa fa-2x fa-history" style="padding-right:10px;"></i>Últimas acciones</a>
      </span>
    </h4>
  </section>


  <div class="panel-body">

    <?php  mensaje_resultado($mensaje); ?>
    
    <!-- Ultimos referentes -->
    <div class="col-md-4">
			<div class="box box-primary">

        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-fw fa-users"></i> Últimos referentes trabajados</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
           </div>
        </div>

        <div class="box-body">
          <table id="tabla_ultimos_referentes" class="display">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Última Empresa</th>
                <th> </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($referentes as $row): ?>

                        <tr>
                          <td class="referente-nombre"><?=$row['datos_referente']['NOMBRE']?></td> 
                          <td class="referente-apellido"><?=$row['datos_referente']['EMPRESA']?></td>
                          <td class="referente-ver">
                            <a href="<?=base_url()?>index.php/escuela_negocios/ver_referente/<?=$row['datos_referente']['ID_CRM_PERSONA']?>">
                              <button type="button" class="btn btn-primary btn-s btn-ver-referente" data-toggle="tooltip" data-placement="top"
                      data-original-title="Ver referente ">
                                <i class="fa fa-fw fa-search"></i> 
                              </button>
                            </a>
                           
                          </td>
                        </tr>


              <?php endforeach; ?>
            </tbody>
          </table>

          <a data-toggle="modal" data-target="#modal_agregar_referente" data-whatever="">
            <button data-toggle="tooltip" data-placement="top"
                    data-original-title="Da de alta un nuevo referente de una empresa" type="button" class="btn btn-primary
                    ">
              <i class="fa fa-plus-square" aria-hidden="true"></i>
              <span>Agregar referente</span>
            </button>
          </a>

        </div>

      </div>
		</div>
    
    <!-- Proximas alarmas -->
    <div class="col-md-5">
      <div class="box box-success">

        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-fw fa-bell"></i> Próximas alarmas</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>

        <div class="box-body">
          <table id="tabla_proximas_alarmas" class="display">
            <thead>
              <tr>
                <th style="width: 35px;">Fecha</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Empresa</th>
                <th>Descripción</th>
                <th style="width: 83px;"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($alarmas as $row): ?>

                <tr>
                  <td><?=$row['FECHA_ACCION']?></td>
                  <td><?=$row['NOMBRE']?></td>
                  <td><?=$row['APELLIDO']?></td>
                  <td><?=$row['D_EMPRESA']?></td>
                  <td><?=$row['DESCRIPCION']?></td>
                  <td class="referente-ver">
                    <a href="<?=base_url()?>index.php/escuela_negocios/ver_referente/<?=$row['ID_CRM_PERSONA']?>">
                      <button type="button" class="btn btn-success btn-s btn-ver-referente" data-toggle="tooltip" data-placement="top"
                      data-original-title="Ver referente">
                        <i class="fa fa-fw fa-search"></i>
 
                      </button>
            
                    </a>
                    
                    <a data-toggle="modal" data-target="#modal_modifica_accion_empresa" data-whatever="<?=$row['ID_CRM_ACCION']?>">
                      <button type="button" class="btn btn-success btn-s btn-editar-alarma"   data-toggle="tooltip" data-placement="top"
                      data-original-title="Editar alarma">
                        <i class="fa fa-fw fa-edit"></i>
 
                      </button>
                    </a>



                  </td>
                </tr>
                    
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
 
    <!-- Ultimas empresas y camaras -->
    <div class="col-md-3">
      <div class="box box-warning">

        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-building"></i> Empresas</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>

        <div class="box-body">
            
          <table id="tabla_ultimas_empresas" class="display dataTable" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th> </th>
                </tr>  
            </thead>
            <tfoot>
                <tr>
                    <th>Nombre</th>
                    <th> </th>
                </tr>
            </tfoot>
          </table>
 
        </div>

      </div>

       <div class="box box-warning">

        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-building"></i> Camaras Asociaciones</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>

        <div class="box-body">
            
          <table id="tabla_ultimas_camaras" class="display dataTable" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th> </th>
                </tr>  
            </thead>
            <tfoot>
                <tr>
                    <th>Nombre</th>
                    <th> </th>
                </tr>
            </tfoot>
          </table>

           <a data-toggle="modal" data-target="#modal_agregar_camara" data-whatever="">
            <button data-toggle="tooltip" data-placement="top"
                    data-original-title="Da de alta un nuevo referente de una empresa" type="button" class="btn btn-warning
                    ">
              <i class="fa fa-plus-square" aria-hidden="true"></i>
              <span>Agregar camara</span>
            </button>
          </a>
 
        </div>

      </div>
    </div>  

  </div>

  <div class="panel-body">

      <div class="col-md-12">
        <div class="box box-danger">

          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-calendar" aria-hidden="true"></i> Calendario de referentes</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div>
          <div class="alert alert-primary" role="alert">
            <i class="fa fa-exclamation-triangle"></i> Para ver las acciones hechas en un dia para un referente debes hacer click sobre el nombre
          </div>
          <div class="box-body" id="eventos_calendario_global">
          </div>

        </div>
      </div>

  </div>

</div>



<!-- ################# MODALES ################# -->

<!-- MODAL ALTA REFERENTE -->
<div class="modal fade " id="modal_agregar_referente" tabindex="-1" role="dialog" aria-labelledby="modal_agregar_referente">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar referente</h4>
      </div>

      <form  name="form_alta_referente" id="form_alta_referente" method="POST"  action="<?=base_url()?>index.php/escuela_negocios/alta_referente/" >

        <div class="modal-body clearfix d-flex" >

          <div class="form-group clearfix p-1">
            <label for="nombre" class="col-sm-2 control-label">Nombre:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresar nombre">
            </div>
          </div>
          <div class="form-group clearfix p-1">
            <label for="apellido" class="col-sm-2 control-label">Apellido:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingresar apellido">
            </div>
          </div>
           <div class="form-group clearfix p-1">
            <label for="email" class="col-sm-2 control-label">Email:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="email" name="email" placeholder="Ingresar email">
            </div>
          </div>
          <div class="form-group clearfix p-1">
            <label for="telefono" class="col-sm-2 control-label">Teléfono:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingresar teléfono">
            </div>
          </div>
          
          <div id="div_usuario_encontrado">
              <input type="hidden" name="flag_es_referente" id="flag_es_referente" value="0">  
              <input type="hidden" name="flag_no_es_referente" id="flag_no_es_referente"  value="0"> 

              <div class="form-group clearfix p-1">
                <h4> <i onclick="cerrar_div_existe_email()" class="fa fa-window-close" aria-hidden="true">
                    </i> El email ya existe en CRM para el siguiente usuario: 
                    
                    <span id="label_es_referente">( el usuario ya es referente ) </span> 
                </h4>  
                
              </div>
              <input type="hidden" class="form-control" id="id_crm_persona_encontrado" name="id_crm_persona_encontrado"  readonly="readonly">
              
              <div class="form-group clearfix p-1">
                <div class="row">
                  <label for="apellido" class="col-sm-2 control-label">Apellido:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="apellido_encontrado" name="apellido_encontrado" placeholder="Ingresar nombre" readonly="readonly">
                  </div>

                  <label for="apellido" class="col-sm-2 control-label">Nombre:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="nombre_encontrado" name="nombre_encontrado" placeholder="Ingresar nombre" readonly="readonly">
                  </div>
              
                </div>
                <div class="row">
                 <!--
                 <div class="col-sm-12 " style="padding:10px; float:center" >
                   <a class="btn btn-primary"  href="<?=base_url()?>index.php/escuela_negocios/ver_referente/" id="usar_referente" type="submit" class="btn btn-primary">Usar referente</a>
                 </div> -->
                </div>
              </div>
        </div>

            
          <hr noshade="noshade" />
          
            <div class="form-group clearfix p-1">
              <span  style="font-size: 13px; background-color: #a10000; font-weight: bold; padding: 10px; color: white;">Importante: si la empresa no se encuentra en la lista de sugerencia, se debe dar el alta desde SIGEU.</span>
      
            </div>
            <div class="form-group clearfix p-1">
              <label for="empresa" class="col-sm-2 control-label">Empresa:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="empresa" name="empresa" placeholder="Tipee el nombre de la empresa..">
                  <img class="img_loading" src="<?=base_url()?>assets/images/loading.gif" alt="">
                  <div class="col-sm-10" id="sin_resultado_empresa">
                          No hay resultado para la busqueda realizada. Cambie la busqueda o cargue la empresa desde SIGEU.
                   </div>
              </div>
            </div>
        
            <div class="form-group clearfix p-1" id="div_empresa_sigeu">
                <label  class="col-sm-2 control-label">Empresa SIGEU</label>
                <label  class="col-sm-1 control-label"> <a onclick="ocultar_empresa_sigeu()"> <i onclick="cerrar_div_existe_email()" class="fa fa-window-close" aria-hidden="true"></i> </a></label>
                
                <div class="col-sm-8">
                    <input readonly="readonly" type="text" class="form-control" id="id_empresa" name="id_empresa" placeholder="Empresa saleccionada"> <br>
                    <input readonly="readonly" type="text" class="form-control" id="empresa_sigeu" name="empresa_sigeu" placeholder="Empresa Manual"> <br>
                </div>
            </div>

            <div class="form-group clearfix p-1">
                <label for="cargo" class="col-sm-2 control-label">Cargo:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Ingresar cargo">
                </div>
            </div>

        </div>

        <div class="modal-footer">
          <button  type="submit" class="btn btn-primary">Aceptar</button>
        </div>

      </form>

        

    </div>
  </div>
</div>

<!-- MODAL ALTA CAMARA -->
<div class="modal fade " id="modal_agregar_camara" tabindex="-1" role="dialog" aria-labelledby="modal_agregar_referente">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar camara</h4>
      </div>

      <form  name="form_alta_camara" id="form_alta_camara" method="POST"  action="<?=base_url()?>index.php/escuela_negocios/alta_camara/" >

        <div class="modal-body clearfix d-flex" >

          <div class="form-group clearfix p-1">
            <label for="nombre" class="col-sm-2 control-label">Nombre:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresar nombre">
            </div>
          </div>
          
        </div>
 

        <div class="modal-footer">
          <button  type="submit" class="btn btn-primary">Aceptar</button>
        </div>

      </form>

        

    </div>
  </div>
</div>



<!-- VER ACCION -->
<div class="modal fade " id="modal_ver_accion" tabindex="-1" role="dialog" aria-labelledby="modal_ver_accion">
  <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="exampleModalLabel">Acción</h4>
        </div>

   
        <div class="modal-body clearfix d-flex" >

            <div class="form-group clearfix p-1">
              <label for="nombre" class="col-sm-2 control-label">Nombre:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresar nombre" readonly="readonly">
              </div>
            </div>
            <div class="form-group clearfix p-1">
              <label for="email" class="col-sm-2 control-label">Descripcion:</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="descripcion" name="descripcion" readonly="readonly"></textarea>
              </div>
            </div>

        </div>
         <div class="modal-footer">
            <button type="submit" data-dismiss="modal" class="btn btn-warning">Cancelar</button>
            <a class="btn btn-primary" id="ir_referente_accion">Ver</a>
          </div>
    </div>
  </div>
</div>

<!-- MODAL MODIFICA ACCION -->
<div class="modal fade " id="modal_modifica_accion_empresa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header" style="background-color: #88be8b; border: 1px solid #859786;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Modificar Acción 1</h4>
      </div>

      <form  name="form_modifica_accion" id="form_modifica_accion" method="POST"  action="<?=base_url()?>index.php/escuela_negocios/modifica_accion_empresa/" >

        <div class="modal-body clearfix d-flex" >
      
          <input type="hidden" id="id_empresa" name="id_empresa" >
          <input type="hidden" id="id_crm_persona" name="id_crm_persona" >
          <input type="hidden" id="id_crm_accion" name="id_crm_accion"  >
          
          <div class="form-group clearfix p-1">
              <label for="cargo" class="col-sm-2 control-label">Descripcion:</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Ingresar descripcion"></textarea> 
              </div>
          </div>

          <div class="form-group clearfix p-1">
              <label for="cargo" class="col-sm-2 control-label">Alarma:</label>
              <div class="col-sm-10">
                <input  type="checkbox" id="alarma" name="alarma"  >
                <button  id="btn_finalizar_alarma" class="btn btn-default btn-xs" style="float:left;" >Finalizar Alarma</button>
              </div>
          </div>

          <div class="jumbotron " style="padding:10px 10px" id="div_agregar_resultado_alarma" >
            
            <div class="form-group">
              <label for="descripcion_finalizar_alarma">Resultado</label>
              <textarea class="form-control" id="descripcion_finalizar_alarma" name="descripcion_finalizar_alarma"></textarea> <br>
              <div id="sin_descripcion_finalizar">Debe escribir un resultado</div>
            </div>
            <div class="form-group">
              <button  id="agregar_resultado_accion" class="btn btn-info btn-xs" style="float:left;" >Aceptar</button>
              <button  id="cerrar_resultado_accion" class="btn btn-danger btn-xs" style="float:left; padding-left:10px;" >Cerrar</button>
            </div>

          </div>

          <div class="jumbotron " id="div_ver_resultado_alarma" style="padding:10px 10px">
            
          </div>
          

        </div>


        <div class="modal-footer" id="footer-acciones">
          <button id="btn_eliminar_accion" class="btn btn-danger" style="float:left;" >Eliminar</button>
          <button id="btn_cancelar_accion" type="submit" data-dismiss="modal" class="btn btn-warning">Cancelar</button>
          <button id="btn_guardar_accion" type="submit" class="btn btn-primary">Guardar</button>
          


        </div>

      </form>

    </div>
  </div>
</div>
<!-- ################### Librerias ################### -->



<!-- jQuery 2.2.3 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<!-- Moment.js -->
<script src="<?php echo base_url(); ?>assets/plugins/moment/moment.js"></script>

<!-- fullCalendar plugin -->
<link rel='stylesheet' href='<?=base_url()?>assets/plugins/fullcalendar-3.10.0/fullcalendar.min.css' />
<script src='<?=base_url()?>assets/plugins/fullcalendar-3.10.0/fullcalendar.min.js'></script>
<script src='<?=base_url()?>assets/plugins/fullcalendar-3.10.0/locale/es.js'></script>

<!-- fullCalendar config  -->
<script src='<?=base_url()?>assets/js/escuela_negocios/fullCalendar_global.js'></script>

<!-- DataTables plugin -->
<link href="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>

<!-- DataTables config -->
<script src='<?=base_url()?>assets/js/escuela_negocios/datatables.js'></script>


<!-- Validar -->
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js"></script>

<script>
  var jq = jQuery.noConflict();
</script>



<script type="text/javascript">

    // Validar  modifica datos persona

    jq(function(){

        jq(function() {
          jq('[data-toggle="tooltip"]').tooltip()
        });
 
        jq.validator.addMethod("seleccion_empresa",

            function(value, element)
            { 
              var id_empresa = jq( "#id_empresa" ).val().length;
              var empresa = jq( "#empresa" ).val().length; 

              //console.log("Falta empresa");

              //if( id_empresa <= 0  && empresa > 0 )
              if( id_empresa <= 0  )
              {
                console.log("Falta empresa");
                return false;
              }
              else
              {
                console.log("Perfecto");
                return true;
              } 

            },
           "Debe seleccionar una empresa del listado"
        );

        // Validar alta referente
        var prueba = jq('#form_alta_referente').validate({
            onkeyup: false, 
            onfocusout: false,
            rules :{

                    nombre : {
                        required : true
                    },
                    apellido: {
                        required : true
                    },
                    email: {
                        email : true
                    },
                    empresa : {
                      seleccion_empresa : true
                    } 

            },
            messages : {

                    nombre : {
                        required : "Debe ingresar el nombre del referente."
                    },
                    apellido: {
                        required : "Debe apellido del nombre del referente."
                    },
                    email: {
                        email : "El formato de email es incorrecto"
                    },
                    empresa : {
                        seleccion_empresa : "Debe seleccionar una empresa del listado emergente."
                    } 

            },
            invalidHandler: function(form, validator) {

                jq('#form_alta_referente').find(":submit").removeAttr('disabled');
            }

        });

        
        jq('#form_alta_camara').validate({
            onkeyup: false, 
            onfocusout: false,
            rules :{

                    nombre : {
                        required : true
                    } 

            },
            messages : {

                    nombre : {
                        required : "Debe ingresar el nombre de la camara/asociacion."
                    } 

            },
            invalidHandler: function(form, validator) {

                jq('#form_alta_camara').find(":submit").removeAttr('disabled');
            }

        });

        // Modal alta referente
        jq('#modal_agregar_referente').on('show.bs.modal', function (event) {
        
            prueba.resetForm();
            jq('#label_es_referente').hide();
            jq('#nombre').prop( "disabled", false );
            jq('#apellido').prop( "disabled", false );
            jq('#email').prop( "disabled", false );
            jq('#telefono').prop( "disabled", false );
            jq('#empresa').prop( "disabled", false );
            jq('#id_empresa').prop( "disabled", false );
            jq('#empresa').prop('readonly', false);


            jq('#nombre').val('');
            jq('#apellido').val('');
            jq('#email').val('');
            jq('#telefono').val('');
            jq('#empresa').val('');
            jq('#cargo').val('');

            jq('#nombre_encontrado').val('');
            jq('#apellido_encontrado').val('');
            jq('#id_crm_persona_encontrado').val('');
            jq('#div_usuario_encontrado').hide();

            jq('#div_empresa_sigeu').hide();     
            jq('#id_empresa').val('');  
            jq('#empresa_sigeu').val('');  
                 
        });

        // Email outfocus
        jq(function(){

          jq( "#email" ).focusout(function() {
 
         
            var email = jq(this).val().trim();
 
            //alert('Email: '+email)

            jq.ajax({
                url: CI_ROOT+'index.php/escuela_negocios/existe_email_referente',
                data: { email: email },
                async: true,
                type: 'POST',
                dataType: 'JSON',
                success: function(data)
                {
                  console.log(data);

                  if(data.error == true)
                  {
                     prueba.resetForm();
                    jq('#modal_agregar_referente #nombre_encontrado').val(data.nombre);
                    jq('#modal_agregar_referente #apellido_encontrado').val(data.apellido);
                    jq('#modal_agregar_referente #id_crm_persona_encontrado').val(data.id_crm_persona);
                    jq('#modal_agregar_referente  #div_usuario_encontrado').show();

                    jq('#modal_agregar_referente  #nombre').prop( "disabled", true );
                    jq('#modal_agregar_referente  #apellido').prop( "disabled", true );
                    jq('#modal_agregar_referente  #email').prop( "disabled", true );
                    jq('#modal_agregar_referente  #telefono').prop( "disabled", true );

                    //jq('#form_alta_referente').find(":submit").prop( "disabled", true );

                    if( data.es_referente )
                    {
                        
                        jq('#modal_agregar_referente  #usar_referente').attr('href', CI_ROOT+'index.php/escuela_negocios/ver_referente/'+data.id_crm_persona );
                        jq('#modal_agregar_referente  #label_es_referente').show();
                        jq('#modal_agregar_referente  #usar_referente').show();
                        jq('#modal_agregar_referente  #agregar_referente').hide();
                        jq('#modal_agregar_referente  #flag_es_referente').val("1");
                        jq('#modal_agregar_referente  #flag_no_es_referente').val("0");
                    }
                    else
                    {
                        jq('#modal_agregar_referente  #usar_referente').hide();
                        jq('#modal_agregar_referente  #agregar_referente').show();
                        jq('#modal_agregar_referente  #flag_no_es_referente').val("1");
                        jq('#modal_agregar_referente  #flag_es_referente').val("0");
                    }

                  }
                },
                error: function(x, status, error){
                  alert(error);
                }
            });
            });
        });

    });
  
    
    // Cierra div email    
    function cerrar_div_existe_email()
    { 
        jq('#nombre').prop( "disabled", false );
        jq('#apellido').prop( "disabled", false );
        jq('#email').prop( "disabled", false );
        jq('#telefono').prop( "disabled", false );

        jq('#email').val('');
        jq('#nombre_encontrado').val('');
        jq('#apellido_encontrado').val('');
        jq('#id_crm_persona_encontrado').val('');
        jq('#div_usuario_encontrado').hide();

        jq('#label_es_referente').hide();
        jq('#form_alta_referente').find(":submit").removeAttr('disabled');
    }


    jq(function(){

        jq('#modal_modifica_accion_empresa').on('show.bs.modal', function (event) {
            var button = jq(event.relatedTarget)
            var id_crm_accion = button.data('whatever')

            jq('#modal_modifica_accion_empresa #id_empresa').val('');
            jq('#modal_modifica_accion_empresa #id_crm_persona').val('');
            jq('#modal_modifica_accion_empresa #id_crm_accion').val('');
            jq('#modal_modifica_accion_empresa #descripcion_finalizar_alarma').val('');
            jq('#modal_modifica_accion_empresa #div_agregar_resultado_alarma').hide();
            jq('#modal_modifica_accion_empresa #btn_eliminar_accion').attr("disabled", false);
            jq('#modal_modifica_accion_empresa #btn_cancelar_accion').attr("disabled", false);
            jq('#modal_modifica_accion_empresa #btn_guardar_accion').attr("disabled", false);
           
            
            jq.ajax({
                url: CI_ROOT+'index.php/escuela_negocios/get_informacion_accion',
                data: { id_crm_accion: id_crm_accion },
                async: true,
                type: 'POST',
                dataType: 'JSON',
                success: function(data)
                {
                  console.log(data);

                  if(data.error == false)
                  {   
                      console.log(data);
                      jq('#modal_modifica_accion_empresa #id_empresa').val(data.id_empresa);
                      jq('#modal_modifica_accion_empresa #id_crm_persona').val(data.id_crm_persona);
                      jq('#modal_modifica_accion_empresa #id_crm_accion').val(data.id_crm_accion);
                      jq('#modal_modifica_accion_empresa #descripcion').val(data.descripcion);

                      if( data.alarma == 1)
                          jq('#modal_modifica_accion_empresa #alarma').attr('checked',true);
                      else
                          jq('#modal_modifica_accion_empresa #alarma').attr('checked',false);

                      jq('#modal_modifica_accion_empresa #btn_finalizar_alarma').show();


                  }
                  else
                  {
                    //alert("No se ha eliminado la accion, intente mas tarde.");
                    //location.reload();
                  }
                },
                error: function(x, status, error){
                  alert(error);
                }
            });  
             
        });
    });
    
    jq(function(){

       jq('#btn_finalizar_alarma').click(function(event){

          event.preventDefault();

          jq('#div_agregar_resultado_alarma').css("display", "block");
          jq('#btn_eliminar_accion').attr("disabled", "disabled");
          jq('#btn_cancelar_accion').attr("disabled", "disabled");
          jq('#btn_guardar_accion').attr("disabled", "disabled");

       });
    });


    jq(function(){

       jq('#cerrar_resultado_accion').click(function(event){

          event.preventDefault();

          jq('#btn_eliminar_accion').attr("disabled", false);
          jq('#btn_cancelar_accion').attr("disabled", false);
          jq('#btn_guardar_accion').attr("disabled", false);

          jq('#descripcion_finalizar_alarma').val('');
          jq('#div_agregar_resultado_alarma').hide();
       });
    });


    jq(function(){

       jq('#agregar_resultado_accion').click(function(event){

          event.preventDefault();
          //alert(jq('textarea#descripcion_finalizar_alarma').val());

          if( !jq('textarea#descripcion_finalizar_alarma').val() )
          { 
              console.log("Text area vacio");
              jq('#sin_descripcion_finalizar').show();
              return false;
          }
          else
          {
              console.log("Text area NO vacio");
              jq('#sin_descripcion_finalizar').hide();
          }
 
          jq.ajax({
              url: CI_ROOT+'index.php/escuela_negocios/alta_accion_resultado',
              data: { descripcion_finalizar_alarma: jq('#descripcion_finalizar_alarma').val(),  
                      id_crm_accion: jq('#id_crm_accion').val(),
                      id_crm_persona: jq('#id_crm_persona').val() },
              async: true,
              type: 'POST',
              dataType: 'JSON',
              success: function(data)
              {
                if(data.error == false)
                {
                  //alert("Se ha eliminado la accion exitosamente");
                  location.reload();
                }
                else
                {
                  //alert("No se ha eliminado la accion, intente mas tarde.");
                  location.reload();
                }
              },
              error: function(x, status, error){
                alert(error);
              }
          }); 

       });
    });
 
</script>

<script src="<?=base_url()?>assets/js/bootstrap.min.js" type="text/javascript"></script> 

<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.12.1/jquery-ui.js"></script>
<!--<script src="<?=base_url()?>assets/js/escuela_negocios/escuela_negocios.js" type="text/javascript"></script> -->
<script type="text/javascript">
  var jq = jQuery.noConflict();

 // Ver desplegable empresas
jq('#empresa').autocomplete({

          minLength: 3,
          change: function( event, ui ) {
             //jq('#empresa_manual').hide();
          },
          source: CI_ROOT+'index.php/consulta/ajax_empresa',
          select: function(event, ui)
          {   
              console.log(ui);
              jq("#div_empresa_sigeu").show();
 
              jq("#form_alta_referente #id_empresa").val(ui.item.id_empresa);
              jq("#form_alta_referente #empresa_sigeu").val(ui.item.value);

              jq('#form_alta_referente #empresa').attr('readonly', true);
  
              //return false; // Importante, si esto no borra el input

          },
          search: function( event, ui ) {
              
            jq('.img_loading').show();
          },

          response: function(event, ui) {

            //alert("cantidad:" + ui.content.length);

            jq('.img_loading').hide();

            if (ui.content.length === 0)
            {
                 jq('#sin_resultado_empresa').show(); 
            }
            else
            {
                 jq('#sin_resultado_empresa').hide();
            }

          }

  });


  // Ocultar empresa sigeu
  function ocultar_empresa_sigeu()
  {
      jq('#form_alta_referente #sin_resultado_empresa').hide();
      jq('#form_alta_referente #div_empresa_sigeu').hide();

      jq('#form_alta_referente #id_empresa').val("");
      jq('#form_alta_referente #empresa_sigeu').val("");

      jq('#form_alta_referente #empresa').val("");
      jq('#form_alta_referente #empresa').attr('readonly', false);
  }

</script>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark"  >
    
    <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Línea de tiempo de la empresa</h3>
        </div>
        <div class="box-body">
          <div class="callout callout-info">
            <p> <strong>La línea de tiempo</strong> de todas las acciones
            </p>
          </div>

          <div class="nav-tabs-custom">

              <ul class="timeline">

                  <?php  foreach ($ultimas_acciones as $row_log): ?>
                      
                      <?php if($row_log['ID_CRM_PERSONA']){
                              $clase="accion_con_referente";
                              $con_refente = 1;
                            } 
                            else{
                              $clase="";
                              $con_refente = 0;
                            }
                      ?>

                      <li class="<?=$clase?>">

                          <?php if($con_refente == 1 ): ?>

                                  <i class="fa fa-user" style="color:#0097bc"></i> 

                          <?php else: ?>

                                  <i class="fa fa-building"></i> 

                          <?php endif; ?>
                          
                          <span style="padding-left:65px; font-weight:bold" class="datos" >
                            <?=$row_log['FECHA']?>  
                            
                            <?php if($row_log['ID_CRM_PERSONA']): ?>
                                      <span> 
                                           - <?=$row_log['NOMBRE'].", ".$row_log['APELLIDO']?>
                                      </span>
                            <?php endif; ?>

                          </span>
                          <div class="timeline-item">
                              <span class="time" style="font-size:10px" ><i class="fa fa-user"> <?=$row_log['C_USUARIOALT']?></i></span>
                              <h3 class="timeline-header" style="font-size:12px !important;"> <?=$row_log['DESCRIPCION']?> </h3>

                              <?php if( $row_log['FECHA_RESULTADO']  ): ?>
                                  
                                      <div style="padding: 10px; background-color: #80808033; font-size: 12px;">
                                          <strong> <?=$row_log['FECHA_RESULTADO']?> </strong> -   <?=$row_log['DESCRIPCION_RESULTADO']?>
                                      </div>

                              <?php endif; ?>
                          </div>
                      </li>

                  <?php   endforeach; ?>


              </ul>

          </div>

        </div>
    </div>

</aside>