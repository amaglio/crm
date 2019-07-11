<?php
  $datos_per =  str_replace( "&", "\"", $datos_persona);
  $datos_per = json_decode($datos_per);
?>

<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" />

<link   type="text/css" href="<?php echo base_url(); ?>assets/css/consulta/alta_consulta.css" rel="stylesheet" />

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <section class="content-header">
      <h4>
         <i class="fa fa-address-card" aria-hidden="true"></i>  <a href="<?=base_url()?>index.php/home/"> Consultas / 3º Cargar consulta</a>
      </h4>
    </section>
    <div class="panel-body">
        <?php //=var_dump($datos_per);?>
        <div class="callout callout-informativo">
            <h4>3er PASO</h4>
            <p>Cargar toda la información que tenga de la consulta. La misma podrá ser modificada desde la sección:
                <a href="<?php echo base_url(); ?>index.php/consulta/index">
                    <i class="fa fa-address-card" aria-hidden="true"></i>
                    <span>Consultas</span>
                </a>.
            <p>

        </div>
        <div class="col-md-12 msg-pane">


            <ul class="nav nav-tabs nav-justified">
              <li><a class="disabled"> 1º Cargar persona </a></li>
              <li><a data-toggle="tab" class="disabled"> 2º Verificar persona </a></li>
              <li class="active"><a data-toggle="tab"> 3º Cargar consulta </a></li>
            </ul>

            <div class="tab-content">

                <!-- Div Datos persona -->
                    <div class="form-group col-sm-12 person-data">

                        <div class="row">
                          <div class="form-group col-sm-6 ">
                            <label for="apellido" class="col-sm-2 control-label label-mb">Apellido</label>
                            <div class="col-sm-10">
                              <input disabled="disabled" value="<?=$datos_per->apellido?>" type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido">
                            </div>
                          </div>
                          <div class="form-group col-sm-6 ">
                            <label for="nombre" class="col-sm-2 control-label label-mb">Nombre</label>
                            <div class="col-sm-10">
                              <input disabled="disabled" value="<?=$datos_per->nombre?>" type="text" class="form-control" id="nombre"  name="nombre" placeholder="Nombre">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="form-group col-sm-6 ">
                            <label for="apellido" class="col-sm-2 control-label label-mb">Email</label>
                            <div class="col-sm-10">
                              <input disabled="disabled" value="<?=$datos_per->email?>" type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido">
                            </div>
                          </div>
                          <div class="form-group col-sm-6 ">
                            <label for="telefono" class="col-sm-2 control-label label-mb">Telefono</label>
                            <div class="col-sm-10">
                              <input disabled="disabled" value="<?=$datos_per->telefono?>" type="text" class="form-control" id="telefono"  name="telefono" >
                            </div>
                          </div>
                        </div>

                        <div class="row">

                          <?php   if(isset($id_educacion)):?>
                            <div class="form-group col-sm-6 ">
                              <label for="ecudacion" class="col-sm-2 control-label label-mb">Educacion</label>
                              <div class="col-sm-10">
                                <?php   if(isset($id_educacion)):?>

                                    <input readonly="readonly" type="text" class="form-control" id="id_educacion" name="id_educacion" placeholder="Educacion Manual" value="<?=$id_educacion?>"> <br>
                                    <input readonly="readonly" type="text" class="form-control" id="nombre_educacion_sigeu" name="nombre_educacion_sigeu" placeholder="Educacion Manual" value="<?=utf8_encode($nombre_educacion)?>">

                                <?php   elseif(isset($educacion_manual)):?>

                                    <input readonly="readonly" type="text" class="form-control" id="educacion_manual" name="educacion_manual" placeholder="Educacion Manual" value="<?=$educacion_manual?>"> <br>

                                <?php   endif;  ?>

                                <?php   if(isset($id_nivel)):?>

                                    <input readonly="readonly" type="hidden" class="form-control" id="id_nivel" name="id_nivel" placeholder="Educacion Manual" value="<?=$id_nivel?>"> <br>

                                <?php   endif;  ?>
                              </div>
                            </div>
                          <?php  endif; ?>

                          <?php   if(isset($id_empresa)):?>
                          <div class="form-group col-sm-6 ">
                            <label for="empresa" class="col-sm-2 control-label label-mb">Empresa</label>
                            <div class="col-sm-10">
                              <?php   if(isset($id_empresa)):?>

                                  <input readonly="readonly" type="text" class="form-control" id="id_empresa" name="id_empresa" placeholder="Educacion Manual" value="<?=$id_empresa?>">
                                  <input readonly="readonly" type="text" class="form-control" id="nombre_empresa_sigeu" name="nombre_empresa_sigeu" placeholder="Educacion Manual" value="<?=utf8_encode($nombre_empresa)?>">

                              <?php   elseif(isset($empresa_manual)):?>

                                  <input readonly="readonly" type="text" class="form-control" id="empresa_manual" name="empresa_manual" placeholder="Educacion Manual" value="<?=$empresa_manual?>"> <br>

                              <?php   endif;  ?>


                              </br>
                              <label for="empresa" class="col-sm-2 control-label label-mb">Cargo</label>
                              <div class="col-sm-10">
                                <?php   if(isset($datos_per->cargo)):?>

                                     <input readonly="readonly" type="text" class="form-control" id="cargo" name="cargo" placeholder="Educacion Manual" value="<?=$datos_per->cargo?>"> <br>

                                <?php   endif;  ?>
                              </div>
                             </div>

                          </div>
                          <?php   endif;  ?>

                        </div>

                        <div class="row">
                          <div class="form-group col-sm-12 ">
                            <label for="apellido" class="col-sm-1 control-label label-mb">Accion</label>
                            <div class="col-sm-10">
                              <input disabled="disabled" value="<?=$datos_per->accion?>" type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido">
                            </div>
                          </div>
                        </div>

                    </div>

                <form class="form-horizontal" name="form_alta_consulta" id="form_alta_consulta"  method="POST"  action="<?=base_url()?>index.php/consulta/alta_consulta/"   >

                    <input type="hidden" value="<?=$datos_persona?>" name="datos_persona" id="datos_persona">

                    <div class="col-sm-4">
                      <label class="label-mb" for="buscar_programa">Programas que le interesan</label> <a onclick="agregar_mis_programas()" class="btn btn-primary btn-xs"> Agregar mis programas </a>
                      <input class="form-control" type="text" name="programa_buscado" id="programa_buscado" placeholder="Escribir el programa: nombre entero o su sigla" >
                      <div id="sin_resultados"> Ningún resultado  </div>
                      <div id="programas_elegidos">
                      <!--<input readonly='readonly' class='form-control' type='text' name='id_codigo[]' id='id_codigo'>-->
                      </div>
                    </div>

                    <div class="col-sm-3" >

                      <label class="label-mb" for="como_contactarlo">Como contactarlo</label>

                      <?php  foreach ($como_contactar->result() as $row):  ?>

                        <div class="form-group col-sm-12">

                          <?php     $data = array(
                                      'name'        => 'id_contactenme[]',
                                      'id'          => 'id_contactenme'.$row->ID_CONTACTENME,
                                      'value'       => $row->ID_CONTACTENME,
                                      'checked'     => FALSE,
                                      'style'       => 'form-control' ,
                                      'class'       => 'check_contactenme'
                                    );

                                $style = ' style = "display:none" ';
                          ?>

                          <?php     echo form_checkbox(  $data);  ?>

                          <span for="id_estado" class="control-label"><?=$row->DESCRIPCION?></span>

                                <?php   $horarios['9 a 18'] = '9 a 18';  ?>
                                <?php   $horarios['9 a 12'] = '9 a 12';  ?>
                                <?php   $horarios['12 a 15'] = '12 a 15';  ?>
                                <?php   $horarios['15 a 18'] = '15 a 18';  ?>
                          <?php

                                switch ($row->DESCRIPCION): // Busco si hay que mostrar horario

                                  case 'Telefono':

                                          echo form_dropdown('horario_telefono', $horarios, '' ," class='form-control' id='horario_telefono' name='horario_telefono' $style" );

                                        break;

                                   case 'Whatsapp':


                                          echo form_dropdown('horario_what', $horarios, '' ," class='form-control' id='horario_what' name='horario_what' $style" );

                                        break;

                                endswitch
                          ?>


                        </div>


                      <?php  endforeach; ?>

                      <div class="form-group col-sm-12">
                        <label class="label-mb" for="cuando_ingresaria form-group">Cuando ingresaria</label>
                      </div>
                      <div class="form-group">
                        <span for="anio" class="col-sm-2 control-label">Año</span>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="anio" name="anio" placeholder="Ingresar Anio">
                        </div>
                      </div>

                      <div class="form-group">
                        <span for="carrera" class="col-sm-2 control-label">Periodo</span>
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


                    <div class="col-sm-3" >
                      <label class="label-mb" for="cuando_ingresaria">Que informacion quiere recibir </label> <input type="checkbox" name="todos" id="todos">

                      <table class="table" id="tabla_roles" name="tabla_roles" >

                        <?php  if($informacion_interes->num_rows() > 0) : ?>

                            <tbody>

                            <?php  foreach ($informacion_interes->result() as $row): ?>

                                <tr>
                                  <td> <?=$row->DESCRIPCION?> </td>
                                  <td>
                                    <?php

                                        $data = array(
                                                'name'        => 'id_info_interes[]',
                                                'id'          => 'id_info_interes',
                                                'value'       => $row->ID_INFO_INTERES,
                                                'checked'     => FALSE,
                                                'style'       => 'form-control',
                                                'class'       => 'id_info_interes'
                                                );


                                        echo form_checkbox($data);
                                    ?>

                                  </td>

                                </tr>

                            <?php  endforeach; ?>

                        <?php  endif; ?>

                        </tbody>

                      </table>
                    </div>

                    <div class="col-sm-2">
                      <label class="label-mb" for="buscar_programa">Comentario</label>
                      <textarea rows="8" id="comentario" name="comentario" class="form-control" ></textarea>
                    </div>

                    <button  disabled="disabled" type="submit" class="btn btn-block btn-primary btn-sm">Cargar Consulta <i class="fa fa-arrow-right" aria-hidden="true"></i></button>

                </form>

            </div>





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

     q('.check_contactenme').change(function(){

        if(this.value == 2) // Telefono
        {
            if( this.checked )
            {
              q('#horario_telefono').show();
            }
            else
            {
              q('#horario_telefono').hide();
            }
        }

        if(this.value == 3)
        {
            if( this.checked )
            {
              q('#horario_what').show();
            }
            else
            {
              q('#horario_what').hide();
            }
        }

    });


} );

q(document).ready(function() {

    q('#todos').change(function(){


        var checkboxes = $(this).closest('form').find('.id_info_interes');

        if($(this).prop('checked'))
        {
          checkboxes.prop('checked', true);
        }
        else
        {
          checkboxes.prop('checked', false);
        }

    });
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
                            id_programa : "Debe seleccionar algun programa del listado emergente"
                        }
                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_alta_consulta').find(":submit").removeAttr('disabled');
                },
                submitHandler: function(form) {
                    //$(form).ajaxSubmit();
                    if (confirm('Seguro queres cargar la consulta ?'))
                    {
                      form.submit();
                    }

                }
            });
    });

</script>


<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.4.4.min.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.12.1/jquery-ui.js"></script>

<script>
  var jq_ui = jQuery.noConflict();
</script>



<script type="text/javascript">

    jq_ui('#programa_buscado').autocomplete({

          minLength: 3,
          change: function( event, ui ) {
             jq_ui('#sin_resultados').hide();
          },
          source:'<?php echo site_url('consulta/ajax_programa'); ?>',
          select: function(event, ui)
          {
              jq_ui(ui.item.mensaje).appendTo("#programas_elegidos");

              jq_ui("#programa_buscado").blur();
              jq_ui(this).val("");
              return false; // Importante, si esto no borra el input

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

  function agregar_mis_programas()
  {
          $.ajax({
                  url: CI_ROOT+'index.php/consulta/agregar_mis_programas_consulta',
                  async: true,
                  dataType: 'JSON',
                  success: function(data)
                  {
                    console.log(data);

                    if(!data.error)
                      $(data.mensaje).appendTo("#programas_elegidos");
                    else
                      alert("Aún no tiene programas cargados. Puede cargarlos desde CONFIGURACIÓN -> MIS PROGRAMAS o agregarlos manualmente.");
 
                  },
                  error: function(x, status, error)
                  {
                    alert(error);
                  }
          });

  }


</script>