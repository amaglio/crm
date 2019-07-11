<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/configuracion/tipos_eventos.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/base.css" rel="stylesheet" />

<div class="content-wrapper">

    <section class="content-header">
        <h4>
          <i class="fa fa-cogs"></i> Configuracion / Tipos de eventos
          <span class="pull-right" data-toggle="tooltip" data-placement="bottom" data-original-title="Ver ayuda">
            <a href="#" data-toggle="control-sidebar" ><i class="fa fa-question-circle"></i> Ayuda </a>
          </span>
        </h4>
    </section>
    <div class="panel-body">

       

         <?php  if ($mensaje): ?>

            <div class="callout callout-danger callout-msg">
              <h5><?=$mensaje;?></h5>
            </div>

        <?php  endif; ?>


        <div class="col-md-7">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Crear tipo de evento</h3>

            </div>
            <div class="box-body ">

                <form name="form_alta_tipo_evento" id="form_alta_tipo_evento" method="post" action="<?=base_url()?>index.php/configuracion/alta_tipo_evento/" >

                  <div class="form-group col-sm-12 pt-10px p-0">
                    <label for="nombre" class="col-sm-3 control-label">Tipo de evento</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del tipo de evento">
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-block btn-primary">Crear</button>
                  </div>

                </form>

            </div>

          </div>
        </div>


        <div class="col-md-5">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Tipos de eventos creados</h3>

            </div>
            <div class="box-body ">
                <?php   if($tipos_eventos->num_rows() > 0):    ?>

                         <table  class="table table-striped table-bordered" id="tabla_eventos" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Titulo</th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php   foreach ($tipos_eventos->result() as $row):

                                      $cadena = armar_json_tipo_evento_modal($row);
                                ?>
                                    <tr>
                                        <td><?=$row->DESCRIPCION?></td>
                                        <td>
                                              <a type="button"   data-toggle="modal" data-target="#modal_editar_tipo_evento" data-whatever="<?=$cadena?>">
                                                    <i class="fa fa-edit"></i>
                                              </a>

                                              <a class="btn btn-xs"  onclick="eliminar_tipo_evento(<?=$row->ID_TIPO_EVENTO?> )">
                                                <i class="fa fa-close"></i>
                                              </a>
                                        </td>
                                    </tr>
                                <?php   endforeach; ?>
                            </tbody>
                          </table>

                <?php   else: ?>

                        <div class="callout callout-danger">
                          Aún no se ha cargado ningun tipo de evento.
                        </div>

                <?php   endif; ?>
            </div>

          </div>

        </div>



    </div>
</div>

<div class="modal fade "  id="modal_editar_tipo_evento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Editar evento</h4>
      </div>

      <form name="form_modifica_tipo_evento" id="form_modifica_tipo_evento" method="post" action="<?=base_url()?>index.php/configuracion/modifica_tipo_evento/" >

        <div class="modal-body" >

            <input type="hidden" class="form-control" id="id_tipo_evento" name="id_tipo_evento" >


            <div class="form-group col-sm-12 p-0 pt-10px">
              <label for="nombre" class="col-sm-2 control-label">Nombre</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del tipo de evento">
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


<aside class="control-sidebar control-sidebar-dark"  >
        <div class="callout callout-informativo">
            <h4>Gestioná tus tipos de eventos !</h4>
            <p>La presente sección le permitirá configurar los tipos de eventos que utilizará para para <strong>clasificar</strong> los eventos en
            <a href="<?php echo base_url(); ?>index.php/evento/index"><i class="fa fa-ticket"></i><span>Eventos</span></a>  
        </div>
</aside>


<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->

<script src="<?=base_url()?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js" type="text/javascript"></script>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.10.custom.min.js"></script>

<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js" ></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js" ></script>

<script>
var jq = jQuery.noConflict();
</script>

<script type="text/javascript">



    function eliminar_programa_usuario(c_identificacion, c_programa, c_orientacion )
    {
      if (confirm('Seguro queres eliminar el programa del usuario ?'))
      {
          $.ajax({
                  url: CI_ROOT+'index.php/configuracion/eliminar_programa_usuario',
                  data: { c_identificacion: c_identificacion, c_programa: c_programa , c_orientacion: c_orientacion },
                  async: true,
                  type: 'POST',
                  dataType: 'JSON',
                  success: function(data)
                  {
                    if(data.error == false)
                    {
                      alert("Se ha eliminado el programa exitosamente");
                      location.reload();
                    }
                    else
                    {
                      alert("No se ha podido eliminar el programa, intente mas tarde.");
                      location.reload();
                    }
                  },
                  error: function(x, status, error){
                    alert("error");
                  }
            });
      }
      //alert("eliminar");
    }



</script>

<!-- jQuery 2.1.4 -->
<script src="<?=base_url()?>assets/js/jQuery-2.1.4.min.js"></script>
<!-- CK Editor -->
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?=base_url()?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>



<script type="text/javascript">

//$(function () {

$(window).load(function () {
  $('#tabla_eventos_length').parent().remove();
  $('#tabla_eventos_info').parent().remove();
  $('#tabla_eventos_paginate').parent().removeClass("col-sm-7");
  $('#tabla_eventos_paginate').parent().addClass("col-sm-12");
  //$('#tabla_eventos_paginate').parent().css( "background-color", "red" );
  //$('#tabla_eventos_length').parent().css( "background-color", "red" );
});


$(function () {

  $('#modal_editar_tipo_evento').on('show.bs.modal', function (event) {

      console.dir("modal_editar_tipo_evento");


      var cadena_json_correcta;
      var button = $(event.relatedTarget);
      var array_json;

      var cadena_json_recibida = button.data('whatever');


      console.dir(cadena_json_recibida);

      cadena_json_correcta = cadena_json_recibida.replace(/&/g, "\"");

      console.dir(cadena_json_correcta);

      array_json = JSON.parse(cadena_json_correcta);

      var nombre = array_json.nombre;
      var id_tipo_evento = array_json.id_tipo_evento;

      nombre = nombre.replace(/&/g, "\"");


      var modal = $(this)

      modal.find('#nombre').val(nombre);
      modal.find('#id_tipo_evento').val(id_tipo_evento);

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

            jq_va('#form_alta_tipo_evento').validate({

                rules :{

                        nombre : {
                            required : true
                        }
                },
                messages : {

                        nombre : {
                            required : "Debe ingresa el nombre para el tipo de evento"
                        }
                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_alta_tipo_evento').find(":submit").removeAttr('disabled');
                }

            });
    });


    jq_va(function(){

            jq_va('#form_modifica_tipo_evento').validate({

                rules :{

                        nombre : {
                            required : true
                        }
                },
                messages : {

                        nombre : {
                            required : "Debe ingresa el nombre para el tipo de evento"
                        }
                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_modifica_tipo_evento').find(":submit").removeAttr('disabled');
                }

            });
    });

</script>

<script type="text/javascript">

function eliminar_tipo_evento(id_tipo_evento )
{
  if (confirm('Seguro queres eliminar el tipo de evento ?'))
  {
      $.ajax({
              url: CI_ROOT+'index.php/configuracion/baja_tipo_evento',
              data: { id_tipo_evento: id_tipo_evento },
              async: true,
              type: 'POST',
              dataType: 'JSON',
              success: function(data)
              {
                if(data.error == false)
                {
                  alert("Se ha eliminado el tipo de evento exitosamente");
                  location.reload();
                }
                else
                {
                  alert("No se ha eliminado el tipo de evento, intente mas tarde.");
                }
              },
              error: function(x, status, error){
                alert("error");
              }
        });

  }
}

</script>

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
    q('#tabla_eventos').dataTable({
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
                                      { 'bSortable': false, 'aTargets': [ 1 ] }
                                    ]

            });
} );



</script>