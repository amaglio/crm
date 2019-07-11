<link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 
<input type="hidden" value="<?=$id_crm_persona?>" id="id_crm_persona" name="id_crm_persona">
<input type="hidden" value="<?=$id_empresa?>" id="id_empresa" name="id_empresa">

 <script type="text/javascript">
            CI_ROOT = "<?=base_url()?>";
    </script>

<div class="col-md-12">
  <div class="box box-success">



    <div class="box-header with-border">
      <h3 class="box-title">Calendario:  <strong><?=$ultima_empresa_referente->D_EMPRESA?></strong></h3>
      <div class="box-tools pull-right">

        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
 
      </div>
    </div>
    <div class="alert alert-primary" role="alert">
        <i class="fa fa-exclamation-triangle"></i> Para ingresar acciones/eventos debe hacer click en el dia correspondiente.
      </div>
    <div class="box-body" id="eventos_calendario_referente">
    </div>

  </div>
</div>

<!--/*-************   MODALES   *******************/ -->

<!-- MODAL ALTA ACCION -->
<div class="modal fade " id="modal_alta_accion_empresa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar accion</h4>
      </div>

      <form  name="form_alta_accion" id="form_alta_accion" method="POST"  action="<?=base_url()?>index.php/escuela_negocios/alta_accion_empresa/" >

        <div class="modal-body clearfix d-flex" >
     
          <!--<input type="hidden" class="form-control" id="id_crm_persona_empresa" name="id_crm_persona_empresa" value="<?=$id_crm_persona_empresa?>">-->
          <input type="hidden" class="form-control" id="id_empresa" name="id_empresa" value="<?=$ultima_empresa_referente->ID_EMPRESA?>">
          <input type="hidden" class="form-control" id="id_crm_persona" name="id_crm_persona" value="<?=$id_crm_persona?>">
          
           <div class="form-group clearfix p-1">
              <label for="cargo" class="col-sm-2 control-label">Fecha:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="fecha_accion" name="fecha_accion" placeholder="Ingresar descripcion" readonly="readonly">
              </div>
          </div>

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
        <h4 class="modal-title" id="exampleModalLabel">Modificar Acción</h4>
      </div>

      <form  name="form_modifica_accion" id="form_modifica_accion" method="POST"  action="<?=base_url()?>index.php/escuela_negocios/modifica_accion_empresa/" >

        <div class="modal-body clearfix d-flex" >
     
 
          <input type="hidden" id="id_empresa"             name="id_empresa"             value="<?=$ultima_empresa_referente->ID_EMPRESA?>">
          <input type="hidden" id="id_crm_persona"         name="id_crm_persona"         value="<?=$id_crm_persona?>">
          <input type="hidden" id="id_crm_accion"          name="id_crm_accion"  >
          
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

<!--/*-************   END MODALES   *******************/ -->



<script src="<?=base_url()?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>

<!-- Bootstrap 3.3.2 JS -->
<script src="<?=base_url()?>assets/js/bootstrap.min.js" type="text/javascript"></script>

<!-- Moment.js -->
<script src="<?php echo base_url(); ?>assets/plugins/moment/moment.js"></script>
 
<!-- fullCalendar plugin -->
<link rel='stylesheet' href='<?=base_url()?>assets/plugins/fullcalendar-3.10.0/fullcalendar.min.css' />
<script src='<?=base_url()?>assets/plugins/fullcalendar-3.10.0/fullcalendar.min.js'></script>
<script src='<?=base_url()?>assets/plugins/fullcalendar-3.10.0/locale/es.js'></script>

<!-- fullCalendar config -->
<script src='<?=base_url()?>assets/js/escuela_negocios/fullCalendar.js'></script>  

<!-- VALIDAR -->
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js"></script>

<script>
var jq = jQuery.noConflict();
</script>

<script type="text/javascript">

    /* Validar formulario */
    jq(function(){

 
        jq('#form_alta_accion').validate({

            rules :{
                    descripcion : {
                      required : true
                    } 

            },
            messages : {
                    
                    descripcion : {
                        required : "Debe ingresar una acción."
                    } 
            },
            invalidHandler: function(form, validator) {

                jq('#form_alta_accion').find(":submit").removeAttr('disabled');
            }

        });
    });

    jq(function(){

 
        jq('#form_modifica_accion').validate({

            rules :{
                    descripcion : {
                      required : true
                    } 

            },
            messages : {
                    
                    descripcion : {
                        required : "Debe ingresar una acción."
                    } 
            },
            invalidHandler: function(form, validator) {

                jq('#form_modifica_accion').find(":submit").removeAttr('disabled');
            }

        });
    });

    jq( "#btn_eliminar_accion" ).click(function(event) {
      
      //alert( "Handler for .click() called."+jq(this).val() );
      event.preventDefault();
      
      if(confirm("Seguro desea eliminar la acción"))
      {
          $.ajax({
              url: CI_ROOT+'index.php/escuela_negocios/baja_accion_empresa',
              data: { id_crm_accion: jq(this).val() },
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
                alert("error");
              }
          });


      }
    });

    jq(function(){

      jq('#modal_modifica_accion_empresa').on('show.bs.modal', function (event) {
          
          jq('#div_agregar_resultado_alarma').hide();
          jq('#descripcion_finalizar_alarma').val('');
          jq('input#alarma').attr("disabled", false );
          jq('textarea#descripcion').attr("disabled",false);

          jq('#btn_eliminar_accion').attr("disabled",false);
          jq('#btn_cancelar_accion').attr("disabled",false);
          jq('#btn_guardar_accion').attr("disabled",false);
                    
          if( jq('input#alarma').is(':checked') )
          {
            console.log("chequeado");
            jq('#btn_finalizar_alarma').show();

            if( jq('#div_ver_resultado_alarma').is(':empty') ){
              console.log("resultado vacio");
            }
            else{
              console.log("resultado lleno");
              jq('#btn_finalizar_alarma').hide();
              jq('input#alarma').attr("disabled", true );
              jq('textarea#descripcion').attr("disabled",true);
            }

          }
          else
          {
             console.log("NO chequeado");
             jq('#btn_finalizar_alarma').hide();
        
          } 

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