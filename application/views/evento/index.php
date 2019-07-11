<link type="text/css" href="<?php echo base_url(); ?>assets/css/evento/evento.css" rel="stylesheet" />

<div class="content-wrapper">
    <section class="content-header">

      <h4>
        <i class="fa fa-ticket"></i> Eventos
      </h4>

    </section>

    <div class="panel-body">
       <div class="callout callout-informativo">

        <h4>¡Gestione sus eventos!</h4>
        <p>
            La presente sección le permitirá <strong>crear, modificar y eliminar eventos</strong>, como asi también gestionar los <strong>incriptos y quienes asistieron</strong>.<br>
            Así mismo, al crear un evento, podrá tildar <strong>CREAR FORMULARIO</strong>, el cual enviará un email al diseñador de la página web para que cree el formulario para inscribirse al evento. Las personas
            inscriptas desde la web, deberán ser importadas <a href="<?=base_url()?>index.php/importador/index_web"><i class="fa fa-globe" aria-hidden="true"></i>  Desde la Web
            </a> y serán anotadas directamente en el evento al importarse.<br>


        </p>
      </div>

      <!-- Eventos creados -->
      <div class="col-md-6 pane">
          <div class="box box-danger">
            <div class="box-header with-border">
              <i class="fa fa-ticket"></i> <h3 class="box-title">Eventos </h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">

                <?php   if( count($eventos) > 0 ): ?>

                        <table  class="table table-striped table-bordered" id="mis_consultas" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th> Id </th>
                                  <th>Nombre</th>
                                  <th>Tipo</th>
                                  <th>Fecha/s</th>
                                  <th> </th>
                          </thead>
                          <tbody>
                             <?php  for ($i= 0; $i < count($eventos); $i++ ): ?>

                                  <tr>
                                    <td><?=$eventos[$i]['informacion_evento']['ID_EVENTO']?> </td>
                                    <td><?=$eventos[$i]['informacion_evento']['NOMBRE']?> </td>
                                    <td><?=$eventos[$i]['informacion_evento']['DESCRIPCION']?> </td>
                                    <td><?php

                                        if( count($eventos[$i]['fechas_evento']) > 0 ):

                                          $x = 0;
                                          foreach ($eventos[$i]['fechas_evento'] as $row):

                                              if($x > 0) echo ", ";

                                              echo $row['FECHA'];

                                              $x ++;

                                          endforeach;

                                        endif;

                                        ?>
                                    </td>
                                    <td>
                                          <a href="<?=base_url()?>index.php/evento/ver_evento/<?=$eventos[$i]['informacion_evento']['ID_EVENTO']?>" >
                                            <i class="fa fa-search"></i>
                                          </a>

                                          <a  onclick="eliminar_evento(<?=$eventos[$i]['informacion_evento']['ID_EVENTO']?>)">
                                            <i class="fa  fa-trash"></i>
                                          </a>
                                    </td>
                                  </tr>

                            <?php    endfor; ?>

                          </tbody>
                        </table>

                <?php   else: ?>

                        <div class="callout callout-danger">
                          Todavia no se ha cargado ningún evento.
                        </div>

                <?php   endif; ?>

            </div>
          </div>
      </div>

      <!-- Crear evento -->
      <div class="col-md-6 pane">
          <div class="box box-danger">
            <div class="box-header with-border">
              <i class="fa fa-plus"></i> <h3 class="box-title">Crear Evento </h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">

            <form name="form_alta_evento" id="form_alta_evento"  method="POST"  action="<?=base_url()?>index.php/evento/alta_evento/"   >

              <div class="row">
                <div class="form-group col-sm-12 ">
                  <label for="nombre" class="col-sm-3 control-label">Nombre</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del evento">
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

                      echo form_dropdown('id_tipo_evento', $tipo_eventos, '' ,'class="form-control" id="id_tipo_evento" name="id_tipo_evento" ' );

                    ?>
                  </div>
                </div>
              </div>

              <?php /*
              <div class="row">
                <div class="form-group col-sm-12 ">
                  <label for="nombre" class="col-sm-3 control-label">Crear Formulario: </label>

                  <div class="form-group col-sm-9 input_fields_wrap">

                      <input type="checkbox" disabled="disabled"  id="crear_formulario" name="crear_formulario"> <span style="font-style: italic; " > (en desarrollo)</span>

                  </div>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-sm-12 ">
                  <label for="nombre" class="col-sm-3 control-label">Fecha/s <button class="btn btn-block btn-default btn-xs add_field_button "><i class="fa fa-plus-square" aria-hidden="true"></i> </button>
                  </label>

                  <div class="form-group col-sm-9 input_fields_wrap">

                      <input type="text" class="form-control calendario" id="fecha_evento" name="fecha_evento[]" placeholder="Fecha del evento">

                  </div>
                </div>
              </div>
              */ ?>
              <div class="row">
                <div class="form-group col-sm-12 ">

                    <button type="submit" class="btn btn-block btn-danger"  > Crear </button>

                </div>
              </div>

            </form>


          </div>
      </div>

    </div>
</div>


<!-- DATA TABES SCRIPT -->

<link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript" ></script>

<script type="text/javascript">


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
<script src="<?=base_url()?>assets/js/consulta.js" type="text/javascript"></script>

<script type="text/javascript">




    jq_va(function(){

            jq_va('#form_alta_evento').validate({

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

                    jq_va('#form_alta_evento').find(":submit").removeAttr('disabled');
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