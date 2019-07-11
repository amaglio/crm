<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" />

<link   type="text/css" href="<?php echo base_url(); ?>assets/css/consulta/alta_consulta.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/base.css" rel="stylesheet" />


<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <section class="content-header">
      <h4>
         <i class="fa fa-address-card" aria-hidden="true"></i>  <a href="<?=base_url()?>index.php/home/"> Consultas / 2º Verificar persona</a>
      </h4>
    </section>
    <div class="panel-body">

        <?php
        //var_dump($usuario_buscado);
        ?>

        <div class="callout callout-informativo">
            <h4>2do PASO</h4>
            <p>Seleccione si es una persona <strong>nueva</strong> o si ya esta <strong>cargada en el sistema</strong>.<p>

        </div>


        <form class="form-horizontal" name="form_alta_consulta" id="form_alta_consulta"  method="POST"  action="<?=base_url()?>index.php/consulta/ver_alta_consulta_3/"   >
          <div class="col-md-12 msg-pane">

            <ul class="nav nav-tabs nav-justified">
              <li><a class="disabled"> 1º Cargar persona</a></li>
              <li class="active"><a data-toggle="tab"> 2º Verificar persona</a></li>
              <li><a data-toggle="tab" class="disabled" >3º Cargar consulta</a></li>
            </ul>

            <div class="tab-content">


            <?php // var_dump($usuario_buscado)?>

                <?php   if(count($array_coincidencias) > 0): // HAY coincidencias  ?>

                    <div class="callout callout-danger">
                          La persona ingresada tiene <strong>COINCIDENCIAS</strong> con otras personas cargadas en el sistema. Usted puede: <br>
                          <strong>1</strong>- Si es una persona del listado, seleccionarla de <strong> COINCIDENTES</strong>. <br>
                          <strong>2</strong>- Si no es ninguna del listado, seleccionarla como <strong> NUEVA </strong>.
                    </div>

                    <div >

                      <!-- COINCIDENTES -->
                      <span class="span-header"><i class="fa fa-arrow-right" aria-hidden="true"></i><strong> COINCIDENTES</strong>:</span>
                      <table class="table coinciding-table">

                        <?php   for ($i=0; $i < count($array_coincidencias)  ; $i++ ):  ?>
                              <?php
                                  $datos_coincidentes['apellido'] = utf8_encode($array_coincidencias[$i]['datos_usuario']->APELLIDO);
                                  $datos_coincidentes['nombre'] = utf8_encode($array_coincidencias[$i]['datos_usuario']->NOMBRE);
                                  $datos_coincidentes['email'] = utf8_encode($usuario_buscado->EMAIL);
                                  $datos_coincidentes['telefono'] = utf8_encode($usuario_buscado->TELEFONO);

                                  if(isset($usuario_buscado->ID_EDUCACION)):
                                      $datos_coincidentes['id_educacion'] = utf8_encode($usuario_buscado->ID_EDUCACION);
                                  elseif(isset($usuario_buscado->EDUCACION_MANUAL)):
                                      $datos_coincidentes['educacion_manual'] = utf8_encode($usuario_buscado->EDUCACION_MANUAL);
                                  endif;

                                  if(isset($usuario_buscado->ID_NIVEL)):
                                      $datos_coincidentes['id_nivel'] = utf8_encode($usuario_buscado->ID_NIVEL);
                                  endif;

                                  if(isset($usuario_buscado->ID_EMPRESA)):
                                      $datos_coincidentes['id_empresa'] = utf8_encode($usuario_buscado->ID_EMPRESA);
                                  elseif(isset($usuario_buscado->EDUCACION_MANUAL)):
                                      $datos_coincidentes['empresa_manual'] = utf8_encode($usuario_buscado->EDUCACION_MANUAL);
                                  endif;

                                  $datos_coincidentes['empresa'] = utf8_encode($usuario_buscado->EMPRESA);

                                  if(isset($usuario_buscado->CARGO))
                                    $datos_coincidentes['cargo'] = utf8_encode($usuario_buscado->CARGO);

                                  $datos_coincidentes['origen'] = $array_coincidencias[$i]['datos_usuario']->ORIGEN;
                                  $datos_coincidentes['id_usuario'] = $array_coincidencias[$i]['datos_usuario']->ID_USUARIO;
                                  $datos_coincidentes['accion'] = 'fusionar';

                                  $datos_json_coincidentes = json_encode($datos_coincidentes);
                                  $datos_json_coincidentes = str_replace("\"", "&", $datos_json_coincidentes);

                                  //echo $datos_json_coincidentes;

                              ?>

                              <tr>
                                  <th ><?=utf8_encode($array_coincidencias[$i]['datos_usuario']->APELLIDO)?></th>
                                  <th ><?=utf8_encode($array_coincidencias[$i]['datos_usuario']->NOMBRE)?></th>
                                  <th ><?=$array_coincidencias[$i]['datos_usuario']->EMAILS?></th>
                                  <th ><?=$array_coincidencias[$i]['datos_usuario']->TELEFONOS?></th>
                                  <th class="check-radio">
                                        <input type="radio"
                                         value="<?=$datos_json_coincidentes?>"
                                         id="datos_persona"
                                         name="datos_persona">
                                  </th>
                              </tr>


                        <?php  endfor; ?>
                        </table>
                    </div>
                <?php   else:   ?>

                      <div class="callout callout-success">
                        <h5>Contacto sin coincidencias. </h5>
                      </div>

                <?php   endif;  ?>

                <!-- NUEVA -->
                <span class="span-header"><i class="fa fa-arrow-right" aria-hidden="true"></i> <strong> NUEVA </strong>: </span>
                <div>
                    <?php
                        $datos['apellido'] = $usuario_buscado->APELLIDO;
                        $datos['nombre'] = $usuario_buscado->NOMBRE;
                        $datos['email'] = $usuario_buscado->EMAIL;
                        $datos['telefono'] = $usuario_buscado->TELEFONO;

                        if(isset($usuario_buscado->ID_EDUCACION)):
                            $datos['id_educacion'] = $usuario_buscado->ID_EDUCACION;
                        elseif(isset($usuario_buscado->EDUCACION_MANUAL)):
                            $datos['educacion_manual'] = $usuario_buscado->EDUCACION_MANUAL;
                        endif;

                        if(isset($usuario_buscado->ID_NIVEL)):
                            $datos['id_nivel'] = utf8_encode($usuario_buscado->ID_NIVEL);
                        endif;

                        if(isset($usuario_buscado->ID_EMPRESA)):
                            $datos['id_empresa'] = $usuario_buscado->ID_EMPRESA;
                        elseif(isset($usuario_buscado->EMPRESA_MANUAL)):
                            $datos['empresa_manual'] = $usuario_buscado->EMPRESA_MANUAL;
                        endif;

                        $datos['empresa'] = $usuario_buscado->EMPRESA;

                        if(isset($usuario_buscado->CARGO))
                          $datos['cargo'] = $usuario_buscado->CARGO;

                        $datos['accion'] = 'nuevo';

                        //var_dump($datos);
                        $datos_json = json_encode($datos);
                        $datos_json = str_replace("\"", "&", $datos_json);

                    ?>
                    <table class="table table-new">
                        <tr>
                            <th ><?=$usuario_buscado->APELLIDO?></th>
                            <th ><?=$usuario_buscado->NOMBRE?></th>
                            <th ><?=$usuario_buscado->EMAIL?></th>
                            <th ><?=$usuario_buscado->TELEFONO?></th>
                            <th class="check-radio">
                                  <input type="radio"
                                   value="<?=$datos_json?>"
                                   id="datos_persona" class="datos_persona"
                                   name="datos_persona" >
                            </th>
                        </tr>
                    </table>
                </div>

            </div>
          </div>

          <button  disabled="disabled" type="submit" class="btn btn-block btn-primary">Siguiente <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
        </form>


    </div>
</div>




 <!-- DATA TABES SCRIPT -->

<link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript" ></script>

<script>
     var q = jQuery.noConflict();
</script>

<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>



<script type="text/javascript">

q(document).ready(function() {
    q('#universidades_convenios').dataTable({
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

    $('input[type=radio][name=datos_persona]').change(function(){

        //alert(this.value);
        var cadena = this.value;
        var objeto = this;

        cadena_json_correcta = cadena.replace(/&/g, "\"");
        var obj = jQuery.parseJSON(cadena_json_correcta);

        var id = obj.id_usuario;
        var origen = obj.origen;

        //alert(id+'-'+origen);

        if( obj.accion != 'nuevo' )
        {   
           
            $.ajax({
                  url: CI_ROOT+'index.php/consulta/existe_consulta_activa',
                  data: { id: id, origen: origen },
                  dataType: 'JSON',
                  type: 'POST',
                  success: function(data)
                  {
                    if( data.error == true ){
                      objeto.checked = false;
                      alert("ERROR: el usuario no puede ser seleccionado. El usuario ya tiene una consulta activa.")
                    }
                                  
                  }, 
                  error: function(x, status, error)
                  {
                    alert(error);
                  }
          }); 
        }


    });


} );


</script>


<!-- bootstrap datepicker -->
<script src="<?=base_url()?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">

  q('.calendario').datepicker({
    autoclose: true,
    format: 'dd/mm/yyyy'
  });

</script>



<!-- Multiselect  -->


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

  $(document).on("click", ".eliminar_programa", function() {
          q('#'+$(this).attr("id")).remove();
    });


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

            jq_va.validator.addMethod('id_programa', function(value, element) {

                if(jq_va('#id_codigo').val())
                  return true;
                else
                  return false;

            }, 'id_programaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');

            jq_va('#form_alta_consulta').validate({

                rules :{

                        datos_persona : {
                            required : true
                        },
                        programa_buscado : {
                           id_programa: true
                        }
                },
                messages : {

                        datos_persona : {
                            required : "Debe seleccionar alguna opcion"
                        },
                        programa_buscado : {
                            id_programa : "Debe seleccionar algun programa del listado"
                        }
                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_alta_consulta').find(":submit").removeAttr('disabled');
                }
            });
    });

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
              $("#programa_buscado").val("");
          }

    });





</script>
