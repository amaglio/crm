<link type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url(); ?>assets/css/contacto/contacto.css" rel="stylesheet" />

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <section class="content-header">
      <h4>
          <i class="fa fa-users"></i>  <a href="<?=base_url()?>index.php/home/"> Personas </a>
          <span class="pull-right" data-toggle="tooltip" data-placement="bottom" data-original-title="Ver ayuda">
            <a href="#" data-toggle="control-sidebar" ><i class="fa fa-question-circle"></i> Ayuda </a>
          </span>
      </h4>
    </section>
    <div class="panel-body">

        

          <?php  mensaje_resultado($mensaje); ?>

           <!-- Buscador personas -->
          <div class="col-md-4 pane">

            <div class="box box-danger">
              <div class="box-header with-border">
                 <i class="fa fa-search" aria-hidden="true"></i> <h3 class="box-title">Buscador simple</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                  </button>
                </div>
              </div>
              <form name="form_buscar_persona_simple" id="form_buscar_persona_simple" role="form" method="post" action="<?=base_url()?>index.php/contacto/buscar_contacto">
                <div class="box-body ">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Apellidos/ Nombre/ Email</label>
                      <input type="text" name="dato_buscado" name="dato_buscado" class="form-control" id="exampleInputEmail1" placeholder="Ingresar nombre, email o apellido">
                    </div>
                </div>
                <div class="box-footer">
                  <button type="submit" class="btn btn-danger btn-block"><i class="fa fa-fw fa-search"></i> Buscar</button>
                </div>
              </form>
            </div>

          </div>

          <!-- Ultimos contactos -->
          <div class="col-md-8" class="pane">

             <div class="box box-danger">
              <div class="box-header with-border">
                <i class="fa fa-clock-o" aria-hidden="true"></i> <h3 class="box-title">Ultimas personas que consultaron</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="box-body no-padding">


                <?php  if( isset($contactos) ): ?>

                    <ul class="users-list clearfix">

                    <?php   for ($i=0; $i < count($contactos); $i++): ?>

                        <a data-toggle="tooltip" data-placement="bottom" data-original-title="Ir a la persona" href="<?=base_url()?>index.php/contacto/ver_contacto/<?=$contactos[$i]['datos_usuario']->ID_CRM_PERSONA?>">
                          <li>
                            <?=buscar_foto_persona($contactos[$i]['datos_usuario']->ID_PERSONA);?>
                            <a data-toggle="tooltip" data-placement="bottom" data-original-title="Ir a la persona" class="users-list-name" href="<?=base_url()?>index.php/contacto/ver_contacto/<?=$contactos[$i]['datos_usuario']->ID_CRM_PERSONA?>"><?=utf8_encode($contactos[$i]['datos_usuario']->APELLIDO).", ".utf8_encode($contactos[$i]['datos_usuario']->NOMBRE)?></a>
                            <span class="users-list-date"><?=$contactos[$i]['datos_usuario']->ORIGEN?>: <?=$contactos[$i]['datos_usuario']->ID_USUARIO?></span>
                          </li>
                        </a>

                    <?php   endfor; ?>

                     </ul>

                <?php   else: ?>

                      <div class="callout callout-danger">
                          Aun no se han importado/cargado consultas de personas.
                      </div>

                <?php   endif; ?>

                  <?php /* foreach ($contactos->result() as $row):?>

                    <a href="<?=base_url()?>index.php/contacto/ver_contacto/<?=$row->ID_CRM_PERSONA?>">
                    <li>
                      <i style="padding-left:5px" class="fa fa-user"></i>
                      <a class="users-list-name" href="<?=base_url()?>index.php/contacto/ver_contacto/<?=$row->ID_CRM_PERSONA?>"><?=$row->APELLIDO.", ".$row->NOMBRE?></a>
                      <span class="users-list-date"><?=$row->FECHA_ALTA?></span>
                    </li>
                    </a>

                  <?php  endforeach; */?>


              </div>
            </div>

          </div>

    </div>
</div>


<aside class="control-sidebar control-sidebar-dark"  >
    <div class="callout callout-informativo">
      <h4>Gestiona los datos de las personas!</h4>
      <p>La seccioón "Personas" le permitirá buscar personas por apellido, nombre o email tanto en CRM como en SIGEU. <br>
       La busqueda le permitira <strong>FUSIONAR, VINCULAR, ELIMINAR y MODIFICAR<strong> los datos de las personas.</p>
    </div>
</aside>

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

            jq_va('#profesores_form').validate({

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
                            required : "Debe ingresar el alumno."
                        },
                        id_usuario: {
                            required : "Debe seleccionar un alumno de la lista."
                        }
                },
                submitHandler: function(form) {


                    jq("#div_loadding_aceptar_busqueda").show();

                    if ( jq('input[name="id_usuario"]').val() != "" ){ // si eligio al usuario del listado
                        form.submit();
                    }
                    else // si tipio y no eligio al usuario
                    {
                        alert( "El alumno debe ser seleccionado del listado" );
                    }


                }

            });
    });

 jq_va(function(){

            jq_va('#form_buscar_persona_simple').validate({

                rules :{

                        dato_buscado : {
                            required : true
                        }
                },
                messages : {

                        dato_buscado : {
                            required : "Debe ingresar el nombre, apellido o email a buscar"
                        }
                },
                invalidHandler: function(form, validator)
                {

                    jq_va('#form_buscar_persona_simple').find(":submit").removeAttr('disabled');
                }
            });
    });
</script>