<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/consulta/consulta.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/base.css" rel="stylesheet" />

<!-- Datatables -->
<!--<link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />-->
<link href="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/plugins/datatables/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" type="text/css"/>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <section class="content-header">
      <h4>
         <i class="fa fa-address-card" aria-hidden="true"></i>  <a href="<?=base_url()?>index.php/consulta/mis_consultas/"> Consultas  </a> / Mis consultas
         <span class="pull-right" data-toggle="tooltip" data-placement="bottom" data-original-title="Ver las últimas acciones">
            <a href="#" data-toggle="control-sidebar" ><i class="fa fa-question-circle"></i> Ayuda </a>
          </span>
      </h4>
    </section>

    
    <div class="panel-body">

          <?php  mensaje_resultado($mensaje); ?>

         



          <form name="form_mis_consultas" id="form_mis_consultas" method="post" action="<?=base_url()?>index.php/consulta/ver_enviar_email_masivo/" >

            <button data-toggle="tooltip" data-placement="bottom" data-original-title="Enviar email a consultas seleccionadas"
                    id="enviar_email" type="submit" class="btn  btn-primary btn-sm mb-10px">
                    <i class="fa fa-at" aria-hidden="true"></i> Enviar Email
            </button>

            <table  class="table search-result table-striped table-bordered" id="mis_consultas" cellspacing="0" width="100%">
              <thead>
                  <tr>
                      <th class="th-checkbox"> <input type="checkbox" name="todos" id="todos"></th>
                      <th class="th-date"> Fecha </th>
                      <th class="th-date-sort"></th>
                      <th class="th-id"> ID </th>
                      <th class="th-picture">Foto</th>
                      <th class="th-surname">Apellido</th>
                      <th class="th-name">Nombre</th>
                     <!--  <th class="">Prg</th> -->
                      <th class="th-email">Email</th>
                      <th class="th-phone">Telefono</th>
                      <th class="th-entry-date">Ingreso</th>
                      <th class="th-interested">Programas Interes</th>
                  </tr>
              </thead>
              <tbody>
                 <?php  for ($i= 0; $i < count($consultas_a_cargo); $i++ ): ?>

                      <tr>
                        <td>
                          <input class="clase_consulta" value="<?=$consultas_a_cargo[$i]['consultas']->ID_CRM_CONSULTA?>" type="checkbox" id="id_consulta" name="id_consulta[]">
                        </td>

                        <td class="td-date">
                          <?=$consultas_a_cargo[$i]['consultas']->FECHA_CONSULTA?>
                        </td>
                        <!-- La columna td-date-sort no es visible, la datatable oculta esta columna y la usa como criterio de orden de la columna td-date -->
                        <!-- Esta columna parsea la FECHA_CONSULTA en formato ISO8601 para que la datatable pueda ordenar bien la fecha -->
                        <td class="td-date-sort"><?= date_format(date_create(str_replace("/", "-", $consultas_a_cargo[$i]['consultas']->FECHA_CONSULTA)), 'c'); ?></td>

                        <td class="td-id">
                          <a data-toggle="tooltip" data-placement="bottom" data-original-title="Ir a la consulta" target="_blank" href="<?=base_url()?>index.php/consulta/ver_consulta/<?=$consultas_a_cargo[$i]['consultas']->ID_CRM_CONSULTA?>"> <?=$consultas_a_cargo[$i]['consultas']->ID_CRM_CONSULTA?> </a>
                        </td>

                        <td>
                          <a data-toggle="tooltip" data-placement="bottom" data-original-title="Ir a la persona" target="_blank" href="<?=base_url()?>index.php/contacto/ver_contacto/<?=$consultas_a_cargo[$i]['persona']['datos_usuario']->ID_CRM_PERSONA?>">
                            <?=buscar_foto_persona($consultas_a_cargo[$i]['persona']['datos_usuario']->ID_PERSONA);?>
                          </a>
                        </td>

                        <td>
                          <?=utf8_encode($consultas_a_cargo[$i]['persona']['datos_usuario']->APELLIDO)?>
                        </td>

                        <td>
                          <?=utf8_encode($consultas_a_cargo[$i]['persona']['datos_usuario']->NOMBRE)?>
                        </td>

                        <td>
                            <?php   foreach ($consultas_a_cargo[$i]['persona']['datos_emails'] as $email): ?>
                                    <?=$email['EMAIL']."</br>"?>
                            <?php   endforeach; ?>
                        </td>

                        <td>
                            <?php   foreach ($consultas_a_cargo[$i]['persona']['datos_telefonos']as $telefono): ?>
                                    <?=$telefono['TELEFONO']."</br>"?>
                            <?php   endforeach; ?>

                        </td>
                        <td>
                          <small class="entry-info"><?=$consultas_a_cargo[$i]['consultas']->ANIO."-".$consultas_a_cargo[$i]['consultas']->DESCRIPCION?></small>
                        </td>
                        <td>
                            <table class="table table-responsive sub-table">

                            <?php  for($j=0; $j < count(($consultas_a_cargo[$i]['programas'])); $j++):

                            ?>


                                  <tr>

                                        <?php  $estados = array(); ?>

                                        <?php   foreach ($estado_consulta->result() as $row):


                                                $estados[$row->ID_ESTADO] = $row->DESCRIPCION;

                                            endforeach;
                                        ?>

                                    <td>
                                        <?=$consultas_a_cargo[$i]['programas'][$j]['programa']->D_DESCRED.": <strong>".$estados[$consultas_a_cargo[$i]['programas'][$j]['programa']->ID_ESTADO];?></strong>
                                    </td>
                                    <td style="width:100px">

                                        <a  data-toggle="modal" data-target="#modal_cambiar_estado_consulta_programa"  data-whatever="<?=$consultas_a_cargo[$i]['programas'][$j]['programa']->ID_CRM_CONSULTA_PROGRAMA?>"  >
                                            <button data-toggle="tooltip" data-placement="bottom" data-original-title="Cambiar estado" type="button" class="btn  btn-primary btn-xs" >
                                              <i class="fas fa-pencil-alt"></i>
                                            </button>
                                        </a>

                                         <?php
                                            if( count($consultas_a_cargo[$i]['programas'][$j]['programas_comen'] ) > 0 ): // Hay comentarios

                                                $comentario = "<table class='table table-start-programs bg-none'>";

                                                foreach ( $consultas_a_cargo[$i]['programas'][$j]['programas_comen'] as $row ):

                                                  $comentario .= "<tr>";
                                                  $comentario .= "<td class='td-date'>".$row['FECHA']."</td>";
                                                  $comentario .= "<td class='td-ora-user'>".$row['USUARIO_ORACLE']."</td>";
                                                  $comentario .= "<td class='td-comment'>".$row['COMENTARIO']."</td>";
                                                  $comentario .= "</tr>";
                                                endforeach;

                                                $comentario .= "</table>";

                                            else:

                                                $comentario = NULL;

                                            endif;


                                          ?>



                                        <a  data-toggle="modal" data-target="#modal_agregar_comentario"  data-whatever="<?=$consultas_a_cargo[$i]['programas'][$j]['programa']->ID_CRM_CONSULTA_PROGRAMA?>"  >
                                            <button data-toggle="tooltip" data-placement="bottom" data-original-title="<?=$comentario?>" type="button" class="btn btn-purple btn-xs">
                                              <i class="fa fa-comment" aria-hidden="true"></i>
                                            </button>
                                        </a>
                                    </td>
                                  </tr>

                            <?php  endfor; ?>

                            </table>
                        </td>

                      </tr>

                <?php    endfor; ?>

              </tbody>
            </table>

          </form>

    </div>
</div>


<aside class="control-sidebar control-sidebar-dark"  >
   <div class="callout callout-informativo pb-10px pt-10px">
      <h4>¡Gestione mejor sus consultas!</h4>
      <p>La sección "Mis consultas" le permitirá a usted o a su grupo de trabajo, separar consultas por responsable y/o para personalizar la gestion de cada consulta.<br>
      Una consulta puede ser "TOMADA" por uno o varias personas ,y para ello, debe ir a la consulta y presionar en el botón. <button  class="btn btn-danger btn-xs" style="padding:5px" readonly="readonly"> <i class="fa fa-handshake-o"></i> Tomar consulta </button> </p>

    </div>
</aside>


<!-- MODAL COMENTARIOS -->
<div class="modal fade " id="modal_agregar_comentario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar comentario</h4>
      </div>

      <form  name="form_agregar_comentario" id="form_agregar_comentario" method="POST"  action="<?=base_url()?>index.php/consulta/agregar_comentario_programa/" >

        <div class="modal-body">

              <input type="hidden" name="id_crm_consulta_programa" id="id_crm_consulta_programa">

              <div class="form-group prog-wrapper">
                <label for="anio" class="col-sm-2 control-label">Programa</label>
                <div class="col-sm-9">
                   <input class="form-control"  type="text" name="programa" id="programa" readonly="readonly">
                </div>
              </div>

              <div class="form-group comment-wrapper">
                <label for="carrera" class="col-sm-2 control-label">Comentario</label>
                <div class="col-sm-9">

                    <textarea  class="form-control" name="comentario" id="comentario"></textarea>

                </div>
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

<!-- MODAL CAMBIAR ESTADO -->
<div class="modal fade " id="modal_cambiar_estado_consulta_programa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Modificar estado</h4>
      </div>

      <form class="cambiar_estado"  name="form_agregar_comentario" id="form_agregar_comentario" method="POST"   >

        <div class="modal-body mb-20px">

              <input type="hidden" name="id_crm_consulta_prg" id="id_crm_consulta_programa">


              <div class="form-group pb-50px">
                <label for="anio" class="col-sm-2 control-label">Programa</label>
                <div class="col-sm-9">
                   <input class="form-control"  type="text" name="programa" id="programa" readonly="readonly">
                </div>
              </div>


              <div class="form-group pb-50px">
                <label for="anio" class="col-sm-2 control-label">Estado nuevo</label>


             <?php  $estados = array(); ?>

              <?php   foreach ($estado_consulta->result() as $row):


                      $estados[$row->ID_ESTADO] = $row->DESCRIPCION;

                  endforeach;


              ?>
               <div class="col-sm-9">
                   <?php
                     echo form_dropdown('id_estado_cons_prg', $estados,  ''  ,'class="form-control select_estado p-0" id="id_estado_cons_prg" name="id_estado_cons_prg" ' );
                   ?>
                </div>
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

<!-- ;PDAÑ -->
<script src="<?=base_url()?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js" type="text/javascript"></script>

<script type="text/javascript">

  $(document).ready(function(){


      $('.btn-purple').tooltip(
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

  $('.cambiar_estado').submit(function( e ) {


      var values = $(this).serialize();

      e.preventDefault();

      $.ajax({
              url: CI_ROOT+'index.php/consulta/procesa_cambiar_estado_cons_prg',
              async: true,
              data: values,
              type: 'POST' ,
              dataType: 'JSON',
              success: function(data)
              {
                  //alert(data);

                  if(data.error == false)
                  {
                      //alert("Se cambio el estado exitosamente");
                      location.reload();
                  }
                  else
                  {
                      alert("No se cambio el estado, intente mas tarde");
                  }
                },
                error: function(x, status, error){
                  alert("No se ejecuto el cambio, intente mas tarde.");
              }

          });


  });

</script>


<!-- Datatable -->
<!--
<script src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript" ></script>
<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script> -->


<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery-1.12.4.js " type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.buttons.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.flash.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jszip.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/pdfmake.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/vfs_fonts.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.html5.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.print.min.js" type="text/javascript" ></script>

<script>
     var q = jQuery.noConflict();
</script>

<script type="text/javascript">

q(document).ready(function() {
    q('#mis_consultas').dataTable({
                dom: 'Bfrtip',
                buttons: [
                      'excel', 'pdf', 'print'
                  ],
                "paging":   true,
                "ordering": true,
                "info":     true,
                "bFilter": true,
                "language": {
                    "lengthMenu": "Mostrando _MENU_ consultas por pagina.",
                    "zeroRecords": "Ninguna consulta fue encontrada.",
                    "info": "<b> Mostrando pagina _PAGE_ de _PAGES_ </b>",
                    "infoEmpty": "Ninguna consulta disponible",
                    "infoFiltered": "(Filtrado de _MAX_ consultas totales)",
                    "sSearch": " Buscar    ",
                    "oPaginate": {
                                    "sNext": "Pag. sig.",
                                    "sPrevious": "Pag. ant."
                                  }
                },
                "aoColumnDefs": [
                  { 'bSortable': false, 'aTargets': [0, 3, 9] },
                  {
                    "targets": [ 2 ],
                    "visible": false,
                    "searchable": false
                  },
                  { "orderData":[ 2 ],   "targets": [ 1 ] }
                ],
                "order": [[1, "asc"]]

            });
} );

</script>


<!-- Validaciones -->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.10.custom.min.js"></script>

<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js" ></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js" ></script>

<script>
var jq_va = jQuery.noConflict();
</script>

<script type="text/javascript">

    jq_va(function(){

            jq_va('#form_mis_consultas').validate({

                rules :{

                        'id_consulta[]' : {
                            required : true
                        }
                },
                messages : {

                        'id_consulta[]' : {
                            required : "Debe elegir alguna consulta"
                        }
                }

            });
    });


    jq_va(function(){

            jq_va('#form_agregar_comentario').validate({

                rules :{

                        comentario : {
                            required : true
                        }
                },
                messages : {

                        comentario  : {
                            required : "Debe agregar un comentario"
                        }
                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_agregar_comentario').find(":submit").removeAttr('disabled');
                }

            });
    });

</script>


 <!-- Validaciones -->

<script src="<?=base_url()?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script>
   var jq_m = jQuery.noConflict();
</script>

<script type="text/javascript">


jq_m(document).ready(function() {

    jq_m('#todos').change(function(){


        var checkboxes = $(this).closest('form').find('.clase_consulta');


        if($(this).prop('checked'))
        {
          checkboxes.prop('checked', true);
          jq_m("#enviar_email").show();
        }
        else
        {
          checkboxes.prop('checked', false);
          jq_m("#enviar_email").hide();
        }

    });
});


jq_m(document).ready(function() {

    jq_m('.clase_consulta').change(function(){

        if( jq_m('.clase_consulta:checkbox:checked').length == 0) // No hay nada seleccionado
        {
            jq_m("#enviar_email").hide();

        }
        else
        {
            jq_m("#enviar_email").show();

        }

    });
});


jq_m('#modal_agregar_comentario').on('show.bs.modal', function (event) {

    var button = jq_m(event.relatedTarget);
    var id_consulta_programa = button.data('whatever');
    var modal = jq_m(this);
    //alert(id_consulta_programa);
    //modal.find('#id_crm_consulta').val(id_consulta_programa);
     jq_m.ajax({
                url: CI_ROOT+'index.php/consulta/buscar_info_consulta_programa',
                data: { id_consulta_programa: id_consulta_programa },
                async: true,
                type: 'POST',
                dataType: 'JSON',
                success: function(data)
                {
                  //modal.find('#id_crm_consulta_programa').empty();
                  modal.find('#id_crm_consulta_programa').val(id_consulta_programa);

                  modal.find('#programa').val(data.programa);


                },
                error: function(x, status, error){
                  alert(error);
                }
      });


});

jq_m('#modal_cambiar_estado_consulta_programa').on('show.bs.modal', function (event) {

    var button = jq_m(event.relatedTarget);
    var id_consulta_programa = button.data('whatever');
    var modal = jq_m(this);
    //alert(id_consulta_programa);
    //modal.find('#id_crm_consulta').val(id_consulta_programa);
     jq_m.ajax({
                url: CI_ROOT+'index.php/consulta/buscar_info_consulta_programa',
                data: { id_consulta_programa: id_consulta_programa },
                async: true,
                type: 'POST',
                dataType: 'JSON',
                success: function(data)
                {
                  //modal.find('#id_crm_consulta_programa').empty();
                  modal.find('#id_crm_consulta_programa').val(id_consulta_programa);
                  modal.find('#id_estado_cons_prg').val(data.id_estado_cons_prg);
                  modal.find('#programa').val(data.programa);


                },
                error: function(x, status, error){
                  alert(error);
                }
      });


});

jq_m(document).ready(function() {

    // Desahabilito para que no pueda elegir ni entrevista ni solicitud de admision

    jq_m('.select_estado option[value="5"]').attr("disabled", true);
    jq_m('.select_estado option[value="6"]').attr("disabled", true);

});



/*
jq_m('#modal_agregar_comentario').on('show.bs.modal', function (event) {

    var button = jq_m(event.relatedTarget);
    var id_consulta = button.data('whatever');
    var modal = jq_m(this)

    jq_m.ajax({
                url: CI_ROOT+'index.php/consulta/buscar_programas_consulta',
                data: { id_consulta: id_consulta },
                async: true,
                type: 'POST',
                dataType: 'JSON',
                success: function(data)
                {
                  modal.find('#id_crm_consulta_programa').empty();

                  $.each( data, function( index, value )
                  {

                    modal.find('#id_crm_consulta_programa').append('<option value="'+value.id_crm_consulta_programa+'">'+value.programa+'</option>');

                  });

                  modal.find('#id_crm_consulta').val(id_consulta);


                },
                error: function(x, status, error){
                  alert(error);
                }
      });
});
*/
</script>

