<link type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url(); ?>assets/css/datatable/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="<?php echo base_url(); ?>assets/css/evento/evento.css" rel="stylesheet" />

<div class="content-wrapper">
    <section class="content-header">

      <h4>
        <i class="fa fa-ticket"></i> Eventos / Ver evento
      </h4>

    </section>



    <div class="panel-body">
      <?php  mensaje_resultado($mensaje); ?>

      <!-- Eventos e inscribir -->
      <div class="row">

          <!-- Evento -->
          <div class="col-md-4">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Informacion del Evento </h3>
                </div>
                <div class="box-body">

                    <form name="form_modifica_evento" id="form_modifica_evento"  method="POST"  action="<?=base_url()?>index.php/evento/modifica_evento/"   >
                        <input type="hidden" name="id_evento" id="id_evento" value="<?=$evento['ID_EVENTO']?>">
                         <div class="row">
                          <div class="form-group col-sm-12 ">
                            <label for="nombre" class="col-sm-3 control-label">Id</label>
                            <div class="col-sm-9">
                              <input type="text" readonly="readonly" class="form-control" id="id_crm_evento" name="id_crm_evento" value="<?=$evento['ID_EVENTO']?>" placeholder="Nombre del evento">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-sm-12 ">
                            <label for="nombre" class="col-sm-3 control-label">Nombre</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" id="nombre" name="nombre" value="<?=$evento['NOMBRE']?>" placeholder="Nombre del evento">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-sm-12 ">
                            <label for="nombre" class="col-sm-3 control-label">Tipo</label>
                            <div class="col-sm-9">
                                <?php   $tipo_eventos = array(); ?>

                                <?php   $tipo_eventos[''] = 'Seleccionar Tipo Evento'; ?>

                                <?php   foreach ($tipos_eventos as $row):

                                        $tipo_eventos[$row['ID_TIPO_EVENTO']] = $row['DESCRIPCION'];

                                    endforeach;

                                    echo form_dropdown('id_tipo_evento', $tipo_eventos, $evento['ID_TIPO_EVENTO'] ,'class="form-control" id="id_tipo_evento" name="id_tipo_evento" ' );

                                ?>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-sm-12 ">

                              <button type="submit" class="btn btn-block btn-danger"  > Modificar </button>

                          </div>
                        </div>

                    </form>

                </div>
              </div>
          </div>

          <!-- Asistentes e Inscribir evento -->
          <div class="col-md-8">

              <!-- asistentes evento -->
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title"> Asistentes al evento </h3>

                </div>
                <div class="box-body">

                    <div class="info-box bg-green">
                        <a class="link-white" href="<?php echo base_url(); ?>index.php/importador/index_web"><span class="info-box-icon"><i class="fa fa-users" aria-hidden="true"></i></span></a>

                      <div class="info-box-content">
                        <span class="info-box-text">Contactos a importar al evento</span>
                        <span class="info-box-number"><?=count($asistentes_a_importar)?></span>
                        <span class="progress-description">
                          <a class="link-white" href="<?php echo base_url(); ?>index.php/importador/index_web"> Importar / Eliminar <i class="fa fa-arrow-circle-right"></i> </a>
                        </span>
                      </div>
                    </div>

                    <?php
                  if(count($evento_asistentes) > 0): ?>

                       <table  class="table table-striped table-bordered" id="tabla_asistentes" name="tabla_asistentes" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Email</th>
                                <th>Telefono</th>
                                <th>Empresa</th>
                                <th>Cargo</th>

                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach($evento_asistentes as $row):

                              ?>
                              <tr>
                                  <td> <?=$row['nombre']?> </td>
                                  <td> <?=$row['apellido']?> </td>
                                  <td> <?=$row['email']?> </td>
                                  <td> <?=$row['telefono']?> </td>
                                  <td> <?=$row['empresa']?> </td>
                                  <td> <?=$row['cargo']?> </td>

                                  <td>
                                      <a  href="#"  onclick="eliminar_asistente('<?=$row['id_asistente_evento']?>')"  >

                                              <i class="fa fa-trash" aria-hidden="true"> </i>
                                      </a>

                                  </td>
                              </tr>


                            <?php endforeach; ?>

                          </tbody>
                        </table>



                <?php   else: ?>

                    <div class="alert alert-danger alert-dismissable">

                      El evento no tiene inscriptos
                    </div>

                <?php   endif;   ?>


                </div>
              </div>

              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Inscribir persona </h3>

                </div>
                <div class="box-body">



                      <div class="row">
                        <div class="form-group col-sm-12 ">
                          <label for="nombre" class="col-sm-3 control-label">Nombre</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="text" name="buscar_crm_persona" id="buscar_crm_persona" placeholder="Escribir el nombre, apellido o email del contacto CRM" >
                            <div id="sin_resultados"> Ningún resultado  </div>
                            <span class="warn-no-results">SOLO PERMITE USUARIO CARGADOS EN CRM</span>
                          </div>

                        </div>
                      </div>

                      <div   id="datos_persona" >

                        <form name="form_alta_asistente" id="form_alta_asistente"  method="POST"  action="<?=base_url()?>index.php/evento/alta_asistente/"   >

                          <input type="hidden" name="id_evento" id="id_evento" value="<?=$evento['ID_EVENTO']?>">

                          <span class="info-box-icon"><i class="fa fa-user" aria-hidden="true"></i></span>

                          <div class="info-box-content">
                              <label for="nombre">Nombre: </label>
                              <input class="form-control" type="text" name="nombre_completo" id="nombre_completo" readonly="readonly"  />

                              <label for="nombre">Email:</label>
                              <input class="form-control" type="text" id="email" name="email" readonly="readonly"  />

                              <input class="form-control" type="hidden" name="id_crm_persona" name="id_crm_persona" readonly="readonly"  />


                              <?php /*
                              <label for="nombre">Fechas</label>
                              <select id="fechas_evento" name="fechas_elegidas[]" multiple="multiple" >

                                  <?php   foreach($fecha_evento  as $row ): ?>

                                        <option value="<?=$row['FECHA']?>" ><?=$row['FECHA']?></option>

                                  <?php   endforeach;?>
                              </select>


                              <input class="form-control" type="hidden" name="id_crm_evento" name="id_crm_evento" readonly="readonly" value="<?=$evento['ID_EVENTO']?>" />
                              */ ?>

                          </div>


                          <div class="row">
                            <div class="form-group col-sm-12 ">

                                <input id="cargar" name="cargar" type="submit" class="btn btn-block btn-success" value="Inscribir"  />

                            </div>
                          </div>

                        </form>

                      </div>







                </div>
              </div>
          </div>

      </div>

      <?php /*
      <!-- Fechas e inscriptos -->
      <div class="row">

        <!-- Fechas -->
        <div class="col-md-8">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Fechas del Evento </h3>
                <div class="box-tools pull-right">

                </div>
              </div>
              <div class="box-body">

                  <div class="col-md-3">

                    <?php   foreach($fecha_evento->result() as $row ):

                          $fecha = $row->FECHA_ENVIAR;
                    ?>

                      <button class="btn btn-s btn-social btn-primary open-event-dates-enrolled" onclick="ver_fechas_inscriptos_evento(<?=$evento['ID_EVENTO']?>,<?=$fecha?>)">
                        <i class="fa fa-calendar"></i> <?=$row['FECHA']?>
                      </button>

                    <?php   endforeach;?>

                  </div>

                  <div class="col-md-9" id="div_fechas_inscriptos">

                  </div>

              </div>
            </div>
        </div>

        <!-- Incriptos-->
        <div class="col-md-4">
            <div class="box box-warning">
              <div class="box-header with-border">
                <h3 class="box-title">Inscriptos </h3>

              </div>
              <div class="box-body">

                  <div class="col-md-12">

                    <?php  if($inscriptos_evento->num_rows() > 0):?>
                    <table class="table table-bordered table-striped">

                    <?php   foreach($inscriptos_evento->result() as $row ): ?>
                        <tr>
                            <td><?=$row->APELLIDOS?></td>
                            <td><?=$row->NOMBRES?></td>
                            <td>
                                <a  onclick="eliminar_inscripto_evento(<?=$evento['ID_EVENTO']?>,<?=$row->ID_CRM_PERSONA?>)">
                                    <i class="fa  fa-trash"></i>
                                </a>
                            </td>
                        </tr>


                    <?php   endforeach;?>

                    </table>

                    <?php   else: ?>

                            <div class="callout callout-danger">
                                Aun no se han inscriptos para el evento
                            </div>

                    <?php   endif;  ?>


                  </div>

              </div>
            </div>
        </div>

      </div>
      */ ?>

</div>


<!-- DATA TABES SCRIPT -->

<link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript" ></script>

<script type="text/javascript">

  function eliminar_asistente(id_asistente_evento)
  {

    if (confirm('Seguro queres eliminar el asistente al evento ?'))
    {
        $.ajax({
                url: CI_ROOT+'index.php/evento/baja_asistente',
                data: { id_asistente_evento: id_asistente_evento  },
                async: true,
                type: 'POST',
                dataType: 'JSON',
                success: function(data)
                {
                  if(data.error == false)
                  {
                    location.reload();
                  }
                  else
                  {
                    location.reload();
                  }
                },
                error: function(x, status, error){
                  alert("error");
                }
          });

    }
  }

    function eliminar_evento(id_crm_evento)
    {
      if (confirm('Seguro queres eliminar el evento ? Tambien se eliminaran todos las personas inscriptas'))
      {

        $.ajax({
                    url: CI_ROOT+'index.php/evento/baja_evento',
                    data: { id_crm_evento: id_crm_evento },
                    async: true,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(data)
                    {
                      if(data.error == false)
                      {
                        alert("Se ha eliminado el eventos y sus inscriptos exitosamente");
                        location.reload();
                      }
                      else
                      {
                        alert("No se ha eliminado el evento");
                        location.reload();
                      }
                    },
                    error: function(x, status, error){
                      alert("error");
                    }
              });
      }
    }
</script>

<script>
     var q = jQuery.noConflict();
</script>

<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>

<!-- bootstrap datepicker -->
<script src="<?=base_url()?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>

<!-- Multiselect -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" type="text/css"/>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<script>
     var f = jQuery.noConflict();
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.10.custom.min.js"></script>

<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js" ></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js" ></script>

<script>
var jq_va = jQuery.noConflict();
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css
  " type="text/css"/>


<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>

<script>
var jq_sel = jQuery.noConflict();
</script>

<!-- bootstrap datepicker -->
<script src="<?=base_url()?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?=base_url()?>assets/js/evento.js" type="text/javascript"></script>

<script type="text/javascript">


    function ver_fechas_inscriptos_evento(id_crm_evento, fecha)
    {
      $('#div_fechas_inscriptos').load('<?php echo site_url("evento/ver_fechas_inscriptos_evento/")?>'+'/'+id_crm_evento+'/'+fecha, function()  {});
    }

    jq_va.validator.addMethod("seleccionar_algo",
      function(value, element)
        {

            if( jq_va( "#fechas_evento" ).val() ||
                jq_va( "#id_crm_persona" ).val()  )
            {
              return true;
            }
            else
            {
              return false;
            }

        },
       "Debe seleccionar alguna fecha del evento y una persona del listado emergente"
    );

    /*
    jq_va(function(){

            jq_va('#form_alta_asistente').validate({

                rules :{

                        email: {
                            seleccionar_algo : true
                        }
                },
                messages : {

                        email: {
                            seleccionar_algo : "Debe seleccionar alguna fecha del evento"
                        }
                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_alta_asistente').find(":submit").removeAttr('disabled');
                }

            });
    });  */


    jq_va(function(){

            jq_va('#form_modifica_evento').validate({

                rules :{


                        nombre : {
                            required : true
                        },
                        id_tipo_evento : {
                            required : true
                        },
                },
                messages : {

                        nombre : {
                            required : "Debe ingresa el nombre para el evento"
                        },
                        id_tipo_evento : {
                            required : "Debe seleccionar el tipo de evento"
                        },

                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_modifica_evento').find(":submit").removeAttr('disabled');
                }

            });
    });

</script>

<script type="text/javascript">


jq_sel(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = jq_sel(".input_fields_wrap"); //Fields wrapper
    var add_button      = jq_sel(".add_field_button"); //Add button ID

    var x = 1; //initlal text box count
    jq_sel(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            //jq_sel(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
            jq_sel(wrapper).append('<div><input type="text" class="form-control calendario" id="fecha_evento2" name="fecha_evento[]" style="display:-webkit-inline-box; width:95%" placeholder="Fecha del evento"><a href="#" class="remove_field"><i class="fa fa-times" aria-hidden="true"></i></a></div>'); //add input box
            jq_sel('.calendario').datepicker({
              autoclose: true,
              format: 'dd/mm/yyyy'
            });
        }
    });

    jq_sel(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); jq_sel(this).parent('div').remove(); x--;
    })
});


</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.12.1/jquery-ui.js"></script>


<script>
  var jq_ui = jQuery.noConflict();
</script>

<script type="text/javascript">

    jq_ui('#buscar_crm_persona').autocomplete({
          minLength: 3,
          change: function( event, ui ) {
             jq_ui('#sin_resultados').hide();
          },
          source:'<?php echo site_url('contacto/ajax_contacto_crm'); ?>',
          select: function(event, ui)
          {
              jq_ui('input[name="nombre_completo"]').val(ui.item.nombre_completo);
              jq_ui('input[name="email"]').val(ui.item.email);
              jq_ui('input[name="id_crm_persona"]').val(ui.item.id_crm_persona);
              jq_ui('#datos_persona').show();


              jq_ui("#datos_persona").effect( "shake", {times:2, distance:5}, 200 );

          },
          response: function(event, ui) {

            if (ui.content.length === 0)
            {
                 jq_ui('#sin_resultados').show();
            }
            else
            {
                 jq_ui('#sin_resultados').hide();
            }

          }

    });




</script>

<script src="<?php echo base_url(); ?>assets/js/datatable/jquery-1.12.4.js " type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/js/datatable/jquery.dataTables.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/js/datatable/dataTables.buttons.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/js/datatable/buttons.flash.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/js/datatable/jszip.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/js/datatable/pdfmake.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/js/datatable/vfs_fonts.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/js/datatable/buttons.html5.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/js/datatable/buttons.print.min.js" type="text/javascript" ></script>

<script>
     var jdata = jQuery.noConflict();
</script>


<script type="text/javascript">

q(document).ready(function() {

    var table = jdata('#tabla_asistentes').DataTable({
                dom: 'Bfrtip',
                buttons: [
                      'excel', 'pdf', 'print'
                  ],
                "paging":   true,
                "ordering": true,
                "info":     true,
                "bFilter": true,
                "language": {
                    "lengthMenu": "Mostrando _MENU_ eventos pagina.",
                    "zeroRecords": "Ningun evento fue encontrado.",
                    "info": "<b> Mostrando pagina _PAGE_ de _PAGES_ </b>",
                    "infoEmpty": "Ningun evento disponible",
                    "infoFiltered": "(Filtrado de _MAX_ eventostotales)",
                    "sSearch": " Buscar    ",
                    "oPaginate": {
                                    "sNext": "Pag. sig.",
                                    "sPrevious": "Pag. ant."
                                  }
                },
                "lengthMenu": [[-1, 10, 25, 50], ["All", 10, 25, 50]]

            });


} );

</script>