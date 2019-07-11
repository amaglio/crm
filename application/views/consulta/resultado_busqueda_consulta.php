<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" type="text/css"/>

<link href="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/plugins/datatables/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url(); ?>assets/css/consulta/consulta.css" rel="stylesheet" type="text/css"/>

<div class="content-wrapper">
    <section class="content-header">
      <h4>
         <i class="fa fa-address-card" aria-hidden="true"></i>  <a href="<?=base_url()?>index.php/home/"> Consultas / Resultado de la busqueda </a>
      </h4>
    </section>
    <div class="panel-body">

        <?php  //echo count($consultas); ?>

          <?php  mensaje_resultado($mensaje); ?>

          <div class="info-box bg-green search-result">
            <span class="search-icon"><i class="fa fa-4x fa-search" aria-hidden="true"></i></span>
            <div class="info-box-content">
              <span><strong>CRITERIOS DE BUSQUEDA</strong></span><br>

              <?php   if( isset($condiciones_programas['programas'])  ): ?>


                 <span class="info-box-text"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> Programas buscados:

                <?php  $i = 0; ?>
                <?php   foreach ($condiciones_programas['programas'] as $key => $value): ?>

                    <?php  if($i > 0) echo ", "; ?>

                        <strong><?=$value?></strong>

                <?php   $i++ ; ?>
                <?php   endforeach; ?>

                  .

                   </span>

              <?php   endif; ?>

              <?php   if( isset($condiciones_programas['fecha_desde'])  ): ?>


                  <span class="info-box-text"> <i class="fa fa-angle-double-right" aria-hidden="true"></i>  Fecha desde:

                      <strong><?=$condiciones_programas['fecha_desde']."."?></strong>

                  </span>

              <?php   endif; ?>

              <?php   if( isset($condiciones_programas['fecha_hasta'])  ): ?>


                  <span class="info-box-text"> <i class="fa fa-angle-double-right" aria-hidden="true"></i>  Fecha hasta:

                      <strong><?=$condiciones_programas['fecha_hasta']."."?></strong>

                  </span>

              <?php   endif; ?>


            </div>
          </div>

          <div class="info-box bg-blue queries-found">
              <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> Cantidad de consultas encontradas: <strong><?php  echo ( count($consultas) == 100)? "> a 100 (solo se muestran las últimas)" : count($consultas) ; ?></strong>
          </div>


          <form name="form_mis_consultas" id="form_mis_consultas" method="post" action="<?=base_url()?>index.php/consulta/ver_enviar_email_masivo/">

            <button data-toggle="tooltip" data-placement="bottom" data-original-title="Enviar email a consultas seleccionadas"
                    id="enviar_email" type="submit" class="btn btn-primary btn-sm send-email">
                    <i class="fa fa-at" aria-hidden="true"></i> Enviar Email
            </button>

            <table  class="table search-result table-striped table-bordered" id="mis_consultas" cellspacing="0" width="100%">
              <thead>
                  <tr>
                      <th class="th-checkbox"> <input type="checkbox" name="todos" id="todos"></th>
                      <th class="th-status"> Estado </th>
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
                 <?php  for ($i= 0; $i < count($consultas); $i++ ): ?>

                      <tr <?php if ($consultas[$i]['consultas']['ESTADO_CONSULTA'] == 'Inactiva') echo "class='tr-inactiva bg-red'"; ?>>
                        <td> <input class="clase_consulta" value="<?=$consultas[$i]['consultas']['ID_CRM_CONSULTA']?>" type="checkbox" id="id_consulta" name="id_consulta[]"></td>
                        <td class="td-status"><?=$consultas[$i]['consultas']['ESTADO_CONSULTA']?></td>
                        <td class="td-date"><?=$consultas[$i]['consultas']['FECHA_CONSULTA']?></td>
                        <!-- La columna td-date-sort no es visible, la datatable oculta esta columna y la usa como criterio de orden de la columna td-date -->
                        <!-- Esta columna parsea la FECHA_CONSULTA en formato ISO8601 para que la datatable pueda ordenar bien la fecha -->
                        <td class="td-date-sort"><?= date_format(date_create(str_replace("/", "-", $consultas[$i]['consultas']['FECHA_CONSULTA'])), 'c'); ?></td>
                        <td class="td-id"> <a data-toggle="tooltip" data-placement="bottom" data-original-title="Ir a la consulta" target="_blank" href="<?=base_url()?>index.php/consulta/ver_consulta/<?=$consultas[$i]['consultas']['ID_CRM_CONSULTA']?>"> <?=$consultas[$i]['consultas']['ID_CRM_CONSULTA']?> </a> </td>
                        <td>
                            <a data-toggle="tooltip" data-placement="bottom" data-original-title="Ir a la persona" target="_blank" href="<?=base_url()?>index.php/contacto/ver_contacto/<?=$consultas[$i]['persona']['datos_usuario']->ID_CRM_PERSONA?>">
                                <?=buscar_foto_persona($consultas[$i]['persona']['datos_usuario']->ID_PERSONA);?>
                            </a>
                        </td>
                        <td>
                            <?=utf8_encode($consultas[$i]['persona']['datos_usuario']->APELLIDO)?> <br>
                        </td>
                        <td><?=utf8_encode($consultas[$i]['persona']['datos_usuario']->NOMBRE)?></td>

                        <td>
                            <?php   foreach ($consultas[$i]['persona']['datos_emails']  as $email): ?>
                                    <?=$email['EMAIL']."</br>"?>
                            <?php   endforeach; ?>

                        </td>
                        <td>
                            <?php   foreach ($consultas[$i]['persona']['datos_telefonos'] as $telefono): ?>
                                    <?=$telefono['TELEFONO']."</br>"?>
                            <?php   endforeach; ?>

                        </td>
                        <td>
                          <small class="entry-info"><?=$consultas[$i]['consultas']['ANIO']."-".$consultas[$i]['consultas']['DESCRIPCION']?></small>
                        </td>
                        <td>
                            <table class="table table-responsive sub-table">

                                <?php for($j=0; $j < count(($consultas[$i]['programas'])); $j++):
                                     // var_dump($consultas[$i]['programas'][$j]['programa']);
                                ?>
                                <?php   $estados = array(); ?>
                                <?php   foreach ($estado_consulta->result() as $row):
                                            $estados[$row->ID_ESTADO] = $row->DESCRIPCION;
                                        endforeach;
                                ?>

                                <tr>
                                    <td>
                                        <strong><?=$consultas[$i]['programas'][$j]['programa']['D_DESCRED'].": ".$estados[$consultas[$i]['programas'][$j]['programa']['ID_ESTADO']];?></strong>
                                    </td>

                                    <td>
                                        <a  data-toggle="modal" data-target="#modal_cambiar_estado_consulta_programa"  data-whatever="<?=$consultas[$i]['programas'][$j]['programa']['ID_CRM_CONSULTA_PROGRAMA']?>"  >
                                            <button data-toggle="tooltip" data-placement="bottom" data-original-title="Cambiar estado" type="button" class="btn  btn-primary btn-sm" >
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            </button>
                                        </a>

                                        <?php
                                            if( count($consultas[$i]['programas'][$j]['programas_comen']) > 0 ): // Hay comentarios

                                                $comentario = "<table class='table'>";

                                                foreach ( $consultas[$i]['programas'][$j]['programas_comen']  as $row ):

                                                $comentario .= "<tr>";
                                                $comentario .=    "<td style='width:80px; text-align:center;' > ".$row['FECHA']." </td> ";
                                                $comentario .=    "<td style='width:100px; text-align:left;'> ".$row['USUARIO_ORACLE']."</td> ";
                                                $comentario .=    "<td style='text-align:left;'> ".$row['COMENTARIO']."</td> ";
                                                $comentario .= "</tr>";
                                                endforeach;

                                                $comentario .= "</table>";

                                            else:

                                                $comentario = NULL;

                                            endif;
                                        ?>
                                        <a  data-toggle="modal" data-target="#modal_agregar_comentario"  data-whatever="<?=$consultas[$i]['programas'][$j]['programa']['ID_CRM_CONSULTA_PROGRAMA']?>"  >
                                            <button data-toggle="tooltip" data-placement="bottom" data-original-title="<?=$comentario?>" type="button" class="btn  btn-purple btn-sm" >
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


<!-- MODAL  -->
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
              <input type="hidden" name="variable_post" id="variable_post" value="<?=$variable_post?>">

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

        <div class="modal-body">

              <input type="hidden" name="id_crm_consulta_prg" id="id_crm_consulta_programa">


              <div class="form-group prog-wrapper">
                <label for="anio" class="col-sm-2 control-label">Programa</label>
                <div class="col-sm-9">
                   <input class="form-control"  type="text" name="programa" id="programa" readonly="readonly">
                </div>
              </div>


              <div class="form-group comment-wrapper">
                <label for="anio" class="col-sm-2 control-label">Estado nuevo</label>


              <?php  $estados = array(); ?>

              <?php   foreach ($estado_consulta->result() as $row):


                      $estados[$row->ID_ESTADO] = $row->DESCRIPCION;

                  endforeach;


              ?>
               <div class="col-sm-9">
                   <?php
                     echo form_dropdown('id_estado_cons_prg', $estados,  ''  ,'class="form-control select_estado" id="id_estado_cons_prg" name="id_estado_cons_prg" style=" padding:0px" ' );
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


$('#modal_agregar_comentario').on('show.bs.modal', function (event) {


    console.log("modal_agregar_comentario");


    var button = $(event.relatedTarget);
    var id_consulta_programa = button.data('whatever');
    var modal = $(this);

     $.ajax({
                url: CI_ROOT+'index.php/consulta/buscar_info_consulta_programa',
                data: { id_consulta_programa: id_consulta_programa },
                async: true,
                type: 'POST',
                dataType: 'JSON',
                success: function(data)
                {
                  //modal.find('#id_crm_consulta_programa').empty();
                  console.log("SI");
                  modal.find('#id_crm_consulta_programa').val(id_consulta_programa);
                  modal.find('#programa').val(data.programa);


                },
                error: function(x, status, error){
                  alert(error);
                }
      });

});

$('#modal_cambiar_estado_consulta_programa').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget);
    var id_consulta_programa = button.data('whatever');
    var modal = $(this);
    // alert(id_consulta_programa);
    //modal.find('#id_crm_consulta').val(id_consulta_programa);
     $.ajax({
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


$('.cambiar_estado').submit(function( e ) {

      e.preventDefault();
      var values = $(this).serialize();


      $.ajax({
              url: CI_ROOT+'index.php/consulta/procesa_cambiar_estado_cons_prg',
              async: true,
              data: values,
              type: 'POST' ,
              dataType: 'JSON',
              success: function(data)
              {

                  if(data.error == false)
                  {
                      alert("Se cambio el estado exitosamente");
                      location.reload();
                  }
                  else
                  {
                      alert("No se cambio el estado exitosamente");
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
<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>

<link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />-->

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
            {   'bSortable': false, 'aTargets': [0, 5, 11] },
            {
                "targets": [ 3 ],
                "visible": false,
                "searchable": false
            },
            { "orderData":[ 3 ],   "targets": [ 2 ] }
        ],
        "order": [[1, "asc"], [2, "asc"]]
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

});

</script>


 <!-- Jquery -->

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



</script>

