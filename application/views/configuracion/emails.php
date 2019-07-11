<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/configuracion/emails.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/base.css" rel="stylesheet" />

<div class="content-wrapper">

    <section class="content-header">
        <h4>
          <i class="fa fa-cogs"></i> Configuracion / Emails
          <span class="pull-right" data-toggle="tooltip" data-placement="bottom" data-original-title="Ver ayuda">
            <a href="#" data-toggle="control-sidebar" ><i class="fa fa-question-circle"></i> Ayuda </a>
          </span>
        </h4>
    </section>
    <div class="panel-body">

       

         <?php  if ($mensaje): ?>

            <div class="callout callout-danger">
              <h5><?=$mensaje;?></h5>
            </div>

        <?php  endif; ?>


        <div class="col-md-8">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Crear Email</h3>

            </div>
            <div class="box-body ">

                <form name="form_alta_email" id="form_alta_email" method="post" action="<?=base_url()?>index.php/configuracion/alta_email_plantilla/" >


                  <div class="form-group col-sm-12 p-0 pt-10px">
                    <label for="nombre" class="col-sm-1 control-label">Nombre</label>
                    <div class="col-sm-11">
                      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre/Titulo del email">
                    </div>
                  </div>
                  <div class="form-group col-sm-12 p-0">
                    <label for="asunto" class="col-sm-1 control-label">Asunto</label>
                    <div class="col-sm-11">
                      <input type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto">
                    </div>
                  </div>
                  <div class="form-group col-sm-12 p-0">
                    <label for="apellido" class="col-sm-12 control-label">Texto</label>
                    <div class="col-sm-12">
                      <textarea class="form-control" name="texto" id="texto">

                        <table class="table w-100">
                            <tr>
                              <td><img class="h-40px" alt="UCEMA" src="https://www.ucema.edu.ar/sites/default/files/ucema_logo.png" /></td>
                              <td class="text-right f-12px">
                                Av. C&#243;rdoba 374, (C1054AAP) <br>
                                Ciudad de Buenos Aires, Argentina <br>
                                Tel.: (54-11) 6314-3000 | Fax: (54-11) 4314-1654 <br>
                                info@ucema.edu.ar - www.ucema.edu.ar
                              </td>
                            </tr>
                            <tr>
                              <td>Estimado/a <strong>[Nombre usuario]:</strong></td>
                              <td class="text-right"> <strong>[Fecha envio]</strong> </td>
                            </tr>
                            <tr>
                              <td colspan="2">


                                <br><br>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <strong>[Nombre y Apellido operador]</strong><br>
                                <strong>[Email Operador]</strong><br>
                                UNIVERSIDAD DEL CEMA <br>
                                Av. Córdoba 374 (C1054AAP) Buenos Aires ARGENTINA <br>
                                TEL: (54-11) 6314-3000     <br>
                              </td>
                              <td class="text-right">


                              </td>
                            </tr>
                        </table>

                      </textarea>
                    </div>
                  </div>

                   <div class="modal-footer">
                        <button  disabled="disabled" type="submit" class="btn btn-block btn-primary">Crear Email</button>
                    </div>

                </form>

            </div>

          </div>
        </div>


        <div class="col-md-4">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Emails creados</h3>

            </div>
            <div class="box-body ">
                <?php   if($emails_plantillas->num_rows() > 0):    ?>

                         <table  class="table table-striped table-bordered" id="tabla_emails" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Titulo</th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php   foreach ($emails_plantillas->result() as $row):

                                      $cadena = armar_json_email_plantilla_modal($row);
                                ?>
                                    <tr>
                                        <td><?=$row->TITULO?></td>
                                        <td>
                                              <a type="button"   data-toggle="modal" data-target="#modal_editar_email" data-whatever="<?=$cadena?>">
                                                    <i class="fa fa-edit"></i>
                                              </a>

                                              <a class="btn btn-xs"  onclick="eliminar_email_plantilla(<?=$row->ID_CRM_EMAIL_PLANTILLA?> )">
                                                <i class="fa fa-close"></i>
                                              </a>
                                        </td>
                                    </tr>
                                <?php   endforeach; ?>
                            </tbody>
                          </table>

                <?php   else: ?>

                        <div class="danger">
                          <i class="fa fa-exclamation-circle"> </i> Aún no se ha cargado ningun email.
                        </div>

                <?php   endif; ?>
            </div>

          </div>

        </div>



    </div>
</div>

<aside class="control-sidebar control-sidebar-dark"  >
   <div class="callout callout-informativo">
        <h4>Gestioná tus Emails !</h4>
        <p>La presente sección le permitirá configurar <strong>plantillas de emails</strong> que podrá utilizar para enviar en
            <a href="<?php echo base_url(); ?>index.php/consulta/mis_consultas"><i class="fa fa-angle-right" aria-hidden="true"></i>Mis consultas</a>,
            <a href="<?php echo base_url(); ?>index.php/consulta"><i class="fa  fa-search" aria-hidden="true"></i> Buscar consultas</a> y en
            <a href="<?php echo base_url(); ?>index.php/consulta/pipeline"><i class="fa fa-road" aria-hidden="true"></i>Pipeline de estados</a>.
        </p>
    </div>
</aside>  

<div class="modal fade "  id="modal_editar_email" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Editar Email</h4>
      </div>

      <!--<form  name="certificado_form_mod" id="certificado_form_mod" method="POST" action="<?=base_url()?>index.php/certificado_idioma/editar_certificado/" >-->

      <form name="form_modifica_email" id="form_modifica_email" method="post" action="<?=base_url()?>index.php/configuracion/modifica_email_plantilla/" >

        <div class="modal-body" >

                  <input type="hidden" class="form-control" id="id_crm_email_plantilla" name="id_crm_email_plantilla" >


                  <div class="form-group col-sm-12 p-0 pt-10px">
                    <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre/Titulo del email">
                    </div>
                  </div>
                  <div class="form-group col-sm-12 p-0">
                    <label for="asunto" class="col-sm-2 control-label">Asunto</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto">
                    </div>
                  </div>
                  <div class="form-group col-sm-12 p-0">
                    <label for="apellido" class="col-sm-12 control-label">Texto</label>
                    <div class="col-sm-12">
                      <textarea class="form-control" name="texto2" id="texto2"> </textarea>
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
<script>


$(function () {

  CKEDITOR.replace( 'texto',
    {
        height: 300
    }
  );

});

$(function () {

  CKEDITOR.replace( 'texto2',
    {
        height: 300
    }
  );

});

</script>


<script type="text/javascript">

//$(function () {

$(window).load(function () {
  $('#tabla_emails_length').parent().remove();
  $('#tabla_emails_info').parent().remove();
  $('#tabla_emails_paginate').parent().removeClass("col-sm-7");
  $('#tabla_emails_paginate').parent().addClass("col-sm-12");
  //$('#tabla_emails_paginate').parent().css( "background-color", "red" );
  //$('#tabla_emails_length').parent().css( "background-color", "red" );
});


$(function () {

  $('#modal_editar_email').on('show.bs.modal', function (event) {

      var cadena_json_correcta;
      var button = $(event.relatedTarget);
      var array_json;

      var cadena_json_recibida = button.data('whatever');

      console.dir(cadena_json_recibida);

      cadena_json_correcta = cadena_json_recibida.replace(/&/g, "\"");

      console.dir(cadena_json_correcta);

      array_json = JSON.parse(cadena_json_correcta);

      var titulo = array_json.titulo;
      var asunto = array_json.asunto;
      var texto = array_json.texto;
      var id_crm_email_plantilla = array_json.id_crm_email_plantilla;

      texto = texto.replace(/&/g, "\"");
      /*
      var sigla = array_json.sigla;
      var descripcion = array_json.descripcion;
      var duracion = array_json.duracion;*/

      console.log(titulo);

      var modal = $(this)

      modal.find('#nombre').val(titulo);
      modal.find('#asunto').val(asunto);
      modal.find('#texto2').val(texto);
      modal.find('#id_crm_email_plantilla').val(id_crm_email_plantilla);



      CKEDITOR.instances.texto2.setData( texto );

      /*
      modal.find('#sigla').val(sigla);
      modal.find('#descripcion').val(descripcion);
      modal.find('#duracion').val(duracion);*/

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

            jq_va('#form_alta_email').validate({

                rules :{

                        nombre : {
                            required : true
                        },
                        asunto : {
                            required : true
                        },
                        texto : {
                            required : true
                        }
                },
                messages : {

                        nombre : {
                            required : "Debe ingresa el nombre para el email"
                        },
                        asunto : {
                            required : "Debe ingresa el asunto para el email"
                        },
                        texto : {
                            required : "Debe ingresa el texto del email"
                        }
                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_alta_email').find(":submit").removeAttr('disabled');
                }

            });
    });


    jq_va(function(){

            jq_va('#form_modifica_email').validate({

                rules :{

                        nombre : {
                            required : true
                        },
                        asunto : {
                            required : true
                        },
                        texto : {
                            required : true
                        }
                },
                messages : {

                        nombre : {
                            required : "Debe ingresa el nombre para el email"
                        },
                        asunto : {
                            required : "Debe ingresa el asunto para el email"
                        },
                        texto : {
                            required : "Debe ingresa el texto del email"
                        }
                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_modifica_email').find(":submit").removeAttr('disabled');
                }

            });
    });

</script>

<script type="text/javascript">

function eliminar_email_plantilla(id_crm_email_plantilla )
{
  if (confirm('Seguro queres eliminar el email ?'))
  {
      $.ajax({
              url: CI_ROOT+'index.php/configuracion/baja_email_plantilla',
              data: { id_crm_email_plantilla: id_crm_email_plantilla },
              async: true,
              type: 'POST',
              dataType: 'JSON',
              success: function(data)
              {
                if(data.error == false)
                {
                  alert("Se ha eliminado el email exitosamente");
                  location.reload();
                }
                else
                {
                  alert("No se ha eliminado el email, intente mas tarde.");
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
    q('#tabla_emails').dataTable({
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