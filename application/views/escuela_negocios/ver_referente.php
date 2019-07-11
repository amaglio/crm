<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" />




<div class="content-wrapper">

 
  <section class="content-header">
    <h4>
      <i class="fa fa-handshake-o"></i>
            <span>
                <a href="<?=base_url()?>index.php/escuela_negocios" data-toggle="tooltip" data-placement="top"
                      data-original-title="Ir a escuela de negocios ">Escuela de negocios</a>
            </span> 
            / Referente / 
            <span>
                <a style="font-weight:bold" href="<?=base_url()?>index.php/contacto/ver_contacto/<?=$datos_referente->ID_CRM_PERSONA?>" data-toggle="tooltip" data-placement="top"
                      data-original-title="Ir al contacto " > 
                <?=$datos_referente->NOMBRE.", ".$datos_referente->APELLIDO?> </a>
            </span>
            <span class="pull-right" data-toggle="tooltip" data-placement="bottom" data-original-title="Ver las acciones del referente">
                <a href="#" data-toggle="control-sidebar">
                    <i class="fa fa-2x fa-history" style="padding-right:10px;"></i> Acciones del referente
                </a>
            </span>
    </h4>
  </section>


  <div class="panel-body">
    
    <div class="row">

      <div class="col-md-7">

          <?php  mensaje_resultado($mensaje); ?>
           

        <div class="box box-primary">

          <div class="box-header with-border" style="padding-bottom:10px; background-color:#E4E4E4;" >
            <i class="fa fa-address-card" aria-hidden="true"></i> <h3 class="box-title">Informacion persona</h3>
          </div>


          <div class="box-body">


            <div  class="row">

                <div class="col-md-5">

                  <div class="form-group">
                    <label for="exampleInputEmail1">Nombre</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                          <i class="fa fa-user"></i>
                      </div>
                      <input readonly="readonly" type="text" class="form-control pull-right" id="nombre" name="nombre" value="<?=$datos_referente->NOMBRE?>">
                      <input readonly="readonly" type="hidden" class="form-control pull-right" id="id_crm_persona" name="id_crm_persona" value="<?=$datos_referente->ID_CRM_PERSONA?>">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Apellido</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                          <i class="fa fa-user"></i>
                      </div>
                      <input readonly="readonly" type="text" class="form-control pull-right" id="apellido" name="apellido" value="<?=$datos_referente->APELLIDO?>">
                    </div>
                  </div>

                </div>

                <div class="col-md-5">

                  <div class="form-group">
                    <label for="exampleInputEmail1">Telefono</label>
                    <div class="input-group date">
        

                      <?php if( count($telefonos_referente) > 0): ?>
                            
                            <div class="input-group-addon">
                              <i class="fa fa-phone"></i>
                            </div>
                            <?php for( $x = 0; $x < count($telefonos_referente); $x++ ): ?>
                          
                              <input readonly="readonly" type="text" class="form-control pull-right" id="telefono" name="telefono" value="<?=$telefonos_referente[$x]['TELEFONO']?>">

                            <?php endfor; ?>
                      
                      <?php else: ?>

                        <div class="col-md-12">
                          <div class="danger"  >
                            Aún no se han cargado ningún telefono.
                          </div>
                        </div>

                      <?php endif; ?>

                    </div>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                      <div class="input-group date">
                        <?php if( count($emails_referente) > 0): ?>
                              <div class="input-group-addon">
                                <i class="fa fa-at"></i>
                              </div>
                        
                              
                              <?php for( $x = 0; $x < count($emails_referente); $x++ ): ?>
                              
                                <input readonly="readonly" type="text" class="form-control pull-right" id="telefono" name="telefono" value="<?=$emails_referente[$x]['EMAIL']?>">

                              <?php endfor; ?>
                        
                        <?php else: ?>

                            <div class="col-md-12">
                              <div class="danger">
                                Aún no se han cargado ningún email.
                              </div>
                            </div>


                        <?php endif; ?>
                      </div>
                  </div>

                </div>

                <div class="col-md-2">

                    <a data-toggle="modal"  href="<?=base_url()?>index.php/contacto/ver_modificar_contacto/<?=$datos_referente->ID_CRM_PERSONA?>/0" >
                        <button data-toggle="tooltip" data-placement="top"
                              data-original-title="Modificar datos de la persona" type="button" class="btn btn-primary btn-block btn-referente ">
                       <i class="fa fa-edit"></i>
                        <span> Modificar datos </span>
                      </button>
                    </a>

                    
                    <button data-toggle="tooltip" data-placement="top"   data-original-title="Eliminar el referente" id="eliminar_referente" type="button" class="btn btn-primary btn-block btn-referente">
                        <i class="fa fa-times"></i>
                        <span> Eliminar referente </span>
                    </button>
                    

                </div>
 

            </div>
 

          </div>
        </div>

      </div>

      <div class="col-md-5">
        <div class="box box-danger">

          <div class="box-header with-border">
            <h3 class="box-title">Empresas del referente</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>            </div>
          </div>

          <div class="box-body">
            <!-- body -->

            <div class="row">
              
              <?php if(count($experiencia_laboral)): ?>

                    <div class=" ">

                      <div class="col-md-5">
                        <label>Empresa:</label>
                      </div>

                      <div class="col-md-5">
                        <label>Cargo:</label>
                      </div>

                      <div class="col-md-1">
                        
                      </div>

                       <div class="col-md-1">
               
                      </div>

                    </div>

                      <?php foreach ( $experiencia_laboral as $key ): 

                              $array_referente['id_empresa'] = $key['ID_EMPRESA'];
                              $array_referente['id_crm_persona'] = $key['ID_CRM_PERSONA'];
                              $datos = htmlspecialchars(json_encode($array_referente));
                               // if($key['ID_EMPRESA']): // Si es una empresa con ID y no a mano
                              ?>
                                
                                 <div class="col-md-12">
                                    <div class="col-md-5">

                                      <div class="form-group">
                                        <div class="input-group date">
                                          <div class="input-group-addon">
                                            <i class="fa fa-building"></i>
                                          </div>
                                          <input readonly="readonly" type="text" class="form-control pull-right" name="empresa" value="<?=$key['D_EMPRESA']?>">
                                        </div>
                                      </div>

                                    </div>

                                    <div class="col-md-4">

                                      <div class="form-group">
                                        <div class="input-group date">
                                          <div class="input-group-addon">
                                            <i class="fa fa-briefcase"></i>
                                          </div>
                                          <input readonly="readonly" type="text" class="form-control pull-right"  value="<?=$key['CARGO']?>">
                                        </div>
                                      </div>

                                    </div>

                                    <div class="col-md-1">
                                      <div class="remove-button  ">
                                        <button type="button" value="<?=$datos?>" class="btn btn-danger btn_ver_referente_empresa"  data-toggle="tooltip" data-placement="top" data-original-title="Ver calendario " ><i class="fa fa-search"></i></button>
                                      </div>
                                    </div>

                                    <div class="col-md-1">
                                      <div class="remove-button ">
                                        <button class="btn btn-danger btn_ver_referente_empresa" id="eliminar_referente_empresa" data-toggle="tooltip" data-placement="top" data-original-title="Eliminar empresa del referente" value="<?=$key['ID_EMPRESA']?>" ><i class="fa fa-trash"></i></button>
                                      </div>
                                    </div>

                                    <div class="col-md-1">
                                      <div class="remove-button ">
                                        <a href="<?=base_url()?>index.php/escuela_negocios/ver_empresa/<?=$key['ID_EMPRESA']?>" class="btn btn-danger btn_ver_referente_empresa"  data-toggle="tooltip" data-placement="top" data-original-title="Ver empresa" ><i class="fa fa-building"></i></a>
                                      </div>
                                    </div>
                                 </div>

                          <?php // endif; ?>

                      <?php endforeach; ?>
              
              <?php else: ?>
                      
                    <div class="col-md-12">
                      <div class="alert alert-warning" role="alert">
                        Aún no se han cargado empresas al referente
                      </div>
                    </div>


              <?php endif; ?>


            

            </div>
        
            <a data-toggle="modal" data-target="#modal_alta_empresa_referente" data-whatever="">
              <button data-toggle="tooltip" data-placement="top"
                      data-original-title="Da de alta una nueva empresa para este referente" type="button" class="btn btn-danger">
                <i class="fa fa-plus" aria-hidden="true"></i>
                <span> Agregar empresa</span>
              </button>
            </a>


          </div>

        </div>
      </div>

    </div>
 
    <div class="row" id="calendario_referente_empresa">
      
    </div>

  </div>

</div>



<!-- ################# MODALES ################# -->

<!-- MODAL ALTA EMPRESA -->
<div class="modal fade " id="modal_alta_empresa_referente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar empresa al referente</h4>
      </div>

      <form  name="form_alta_empresa_referente" id="form_alta_empresa_referente" method="POST"  action="<?=base_url()?>index.php/escuela_negocios/alta_empresa_referente/" >

        <div class="modal-body clearfix d-flex" >
     
          <input type="hidden" class="form-control" id="id_crm_persona"  name="id_crm_persona" value="<?=$datos_referente->ID_CRM_PERSONA?>" >

       
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
           <button type="submit" data-dismiss="modal" class="btn btn-warning">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>

      </form>

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

<link rel='stylesheet' href='<?=base_url()?>assets/css/escuela_negocios/escuela_negocios.css' />

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>

<!-- Moment.js -->
<script src="<?php echo base_url(); ?>assets/plugins/moment/moment.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.12.1/jquery-ui.js"></script>

<script>
  var jq_ui = jQuery.noConflict();
</script>

<script type="text/javascript">


  // Ver calendario AJAX
  jq_ui(function(){

        jq_ui( ".btn_ver_referente_empresa" ).click(function() {

          //var id_crm_persona_empresa = jq_ui(this).val();
          //var id_crm_persona = jq_ui('#id_crm_persona').val();
          const datos = jq_ui(this).val();
          var obj = jQuery.parseJSON(datos);

          const id_empresa = obj.id_empresa;
          const id_crm_persona = obj.id_crm_persona;
 
          jq_ui('#calendario_referente_empresa').show();
          //jq_ui('#calendario_referente_empresa').load('<?php echo site_url('escuela_negocios/ver_calendario_referente_empresa/')?>', {  id_crm_persona_empresa : id_crm_persona_empresa,  id_crm_persona : id_crm_persona });
          jq_ui('#calendario_referente_empresa').load('<?php echo site_url('escuela_negocios/ver_calendario_referente_empresa/')?>', {  id_empresa : id_empresa,  id_crm_persona : id_crm_persona });
    
        });
  
  });
  

</script>


<!-- VALIDAR -->
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js"></script>

<script>
var jq = jQuery.noConflict();
</script>

<script type="text/javascript">

    // Modifica datos persona
    jq.validator.addMethod("seleccion_empresa",

      function(value, element)
        { 
          var id_empresa = jq( "#form_alta_empresa_referente #id_empresa" ).val().length;
          var empresa = jq( "#form_alta_empresa_referente #empresa" ).val().length; 

          //console.log("Falta empresa");

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

    jq(function(){

 
        jq('#form_alta_empresa_referente').validate({
            onkeyup: false, 
            onfocusout: false,
            rules :{
                    empresa : {
                      seleccion_empresa : true
                    } 

            },
            messages : {
                    
                    empresa : {
                        seleccion_empresa : "Debe seleccionar una empresa del listado emergente."
                    } 
            },
            invalidHandler: function(form, validator) {

                jq('#form_alta_empresa_referente').find(":submit").removeAttr('disabled');
            }

        });
    });

    jq(function(){

 
        jq('#eliminar_referente').on('click',function(){

            if(confirm(" ¿ Seguro desea eliminar al referente y todas sus acciones ?"))
            {

                jq.ajax({
                          url: CI_ROOT+"index.php/escuela_negocios/baja_referente",
                          data: { id_crm_persona: <?=$datos_referente->ID_CRM_PERSONA?>  },
                          async: true,
                          type: 'POST',
                          dataType: 'JSON',
                          success: function(data)
                          {
                              window.location.replace(CI_ROOT+'index.php/escuela_negocios/');
                          },
                          error: function(x, status, error)
                          {
                              alert(error);
                          }
                });
            }
        });
    });
 
    jq('#eliminar_referente_empresa').on('click',function(){

        const id_empresa = jq(this).val();
        
 
        if(confirm(" ¿ Seguro desea eliminar la empresa (y sus acciones ) de este referente ?"))
        {

                jq.ajax({
                          url: CI_ROOT+"index.php/escuela_negocios/baja_empresa_referente",
                          data: { id_crm_persona: <?=$datos_referente->ID_CRM_PERSONA?>, id_empresa: id_empresa   },
                          async: true,
                          type: 'POST',
                          dataType: 'JSON',
                          success: function(data)
                          {
                              window.location.replace(CI_ROOT+'index.php/ver_referente/<?=$datos_referente->ID_CRM_PERSONA?>');
                          },
                          error: function(x, status, error)
                          {
                              alert(error);
                          }
                });
        } 

       
    });
        
 
</script>
 


<!-- Para volver al calendario si es que se agrego un evento -->

<?php if(isset($id_empresa) && !empty($id_empresa) ): ?>
 
        <script type="text/javascript">
 
 
           jq_ui('#calendario_referente_empresa').show();
           jq_ui('#calendario_referente_empresa').load('<?php echo site_url('escuela_negocios/ver_calendario_referente_empresa/')?>', {  id_empresa : <?=$id_empresa?>,  id_crm_persona: <?=$datos_referente->ID_CRM_PERSONA?> });
        
  
        </script>


<?php endif; ?>

<!--<script src="<?=base_url()?>assets/js/escuela_negocios/escuela_negocios.js" type="text/javascript"></script> -->


<script type="text/javascript">

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
 
              jq("#modal_alta_empresa_referente #id_empresa").val(ui.item.id_empresa);
              jq("#modal_alta_empresa_referente #empresa_sigeu").val(ui.item.value);

              jq('#modal_alta_empresa_referente #empresa').attr('readonly', true);
  
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
      jq('#form_alta_empresa_referente #sin_resultado_empresa').hide();
      jq('#form_alta_empresa_referente #div_empresa_sigeu').hide();

      jq('#form_alta_empresa_referente #id_empresa').val("");
      jq('#form_alta_empresa_referente #empresa_sigeu').val("");

      jq('#form_alta_empresa_referente #empresa').val("");
      jq('#form_alta_empresa_referente #empresa').attr('readonly', false);
  }


</script>



<!-- MODAL -->
<script src="<?=base_url()?>assets/js/bootstrap.min.js" type="text/javascript"></script> 
<script type="text/javascript">
    
    jq('#modal_alta_empresa_referente').on('show.bs.modal', function (event) {
        
 
        jq('#form_alta_empresa_referente #empresa').val('');
        jq('#form_alta_empresa_referente #id_empresa').val(''); 
        jq('#form_alta_empresa_referente #empresa_sigeu').val(''); 
        jq('#form_alta_empresa_referente #cargo').val(''); 


        jq('#form_alta_empresa_referente #empresa').attr("readonly",false); 
        jq('#form_alta_empresa_referente #id_empresa').attr("readonly",false); 
        jq('#form_alta_empresa_referente #empresa_sigeu').attr("readonly",false); 
        jq('#form_alta_empresa_referente #cargo').attr("readonly",false); 
        jq('#form_alta_empresa_referente #div_empresa_sigeu').hide();

    });

</script>








<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark"  >
    
    <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Línea de tiempo con las acciones del referente</h3>
        </div>
        <div class="box-body">
          <div class="callout callout-info">
            <p> <strong>La línea de tiempo</strong> muestra las acciones en el referente
            </p>
          </div>

          <div class="nav-tabs-custom">

              <ul class="timeline">

                  <?php  foreach ($acciones_referente as $row_log): ?>

                      <li >
 
                          <i class="fa fa-user" style="color:#0097bc"></i>                          
                          <span style="padding-left:65px; font-weight:bold" class="datos" >
                            <?=$row_log['FECHA']?> - <span style="color:#0097bc"> <?=$row_log['D_EMPRESA']?>  </span>
                      
                          </span>
                          <div class="timeline-item">
                              <span class="time" style="font-size:10px" ><i class="fa fa-user"> <?=$row_log['C_USUARIOALT']?></i></span>
                              <h3 class="timeline-header"> <?=$row_log['DESCRIPCION']?> </h3>
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