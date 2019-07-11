<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/importador/importar.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/consulta/consulta.css" rel="stylesheet" />

<link href="<?php echo base_url(); ?>assets/css/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/datatable/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<div class="content-wrapper">

    <section class="content-header">
        <h4>
          <i class="fa fa-globe" aria-hidden="true"></i> Importador de consultas web
          <span class="pull-right" data-toggle="tooltip" data-placement="bottom" data-original-title="Ver ayuda">
            <a href="#" data-toggle="control-sidebar" ><i class="fa fa-question-circle"></i> Ayuda </a>
          </span>
        </h4>
    </section>


    <div class="panel-body">

        <?php  mensaje_resultado($mensaje); ?>

        <div class="col-md-12">

          <div class="box box-primary">
            <div class="box-header">
              <i class="fa fa-users" aria-hidden="true"></i> <h3 class="box-title">Contactos a Importar </h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body ">

              <?php  if( count($contactos_web) > 0 ): ?>

                  <form id="tabla_contactos_importar" name="tabla_contactos_importar" method="post" action="<?=base_url()?>index.php/importador/pre_importar"  >
                  <div class="col-md-12 import-buttons">
                      <input type="submit" name="submit" class="btn btn-s btn-primary" value="Importar">
                      <input type="submit" name="submit" class="btn btn-s btn-danger" value="Eliminar">


                      <a href="<?=base_url()?>index.php/importador/index_web/1"  name="submit" class="btn btn-s btn-warning pull-right" > Filtrar un solo programa </a>
                      <a href="<?=base_url()?>index.php/importador/index_web/n"  name="submit" class="btn btn-s btn-warning pull-right" > Filtrar mas de un programa </a>
                  </div>
                  <table class="table table-striped table-bordered entrevistas" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th><i class="fa fa-calendar" aria-hidden="true"></i></th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Telefono</th>
                        <th>Prg</th>
                        <th>Ingreso</th>
                        <th>Contactarlo</th>
                        <th>Interes</th>
                        <th>Evento</th>
                        <th><input type="checkbox" id="chequear_todos"> <i class="fa fa-check-square-o check-all"></i></th>
                      </tr>
                    </thead>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>

                    <tbody>

                        <?php  for ($i=0; $i < count($contactos_web); $i++): ?>

                            <tr>
                              <td><?=$contactos_web[$i]['contacto']->FECHA_ALTA;?></td>
                              <td><?=utf8_encode($contactos_web[$i]['contacto']->NOMBRE);?></td>
                              <td><?=utf8_encode($contactos_web[$i]['contacto']->APELLIDO);?></td>
                              <td><?=utf8_encode($contactos_web[$i]['contacto']->EMAIL);?></td>
                              <td><?php  if(isset($contactos_web[$i]['contacto']->TELEFONO)) echo $contactos_web[$i]['contacto']->TELEFONO;?></td>
                              <td>
                                  <?php  foreach ($contactos_web[$i]['programas_interes']->result() as $row2): ?>

                                      <?php  echo  utf8_encode($row2->D_DESCRED)."<br>"; ?>

                                  <?php  endforeach;?>
                              </td>
                              <td><?php  if(isset($contactos_web[$i]['periodo_ingreso']->ANIO)) echo $contactos_web[$i]['periodo_ingreso']->ANIO."<br>".$contactos_web[$i]['periodo_ingreso']->DESCRIPCION; ?></td>
                              <td>
                                  <?php   if(isset($contactos_web[$i]['como_contactarlo'])): ?>

                                        <?php  foreach ($contactos_web[$i]['como_contactarlo']->result() as $row4): ?>

                                            <?php  echo  $row4->DESCRIPCION.": ".$row4->HORARIO."<br>"; ?>

                                        <?php  endforeach;?>

                                  <?php   endif; ?>
                              </td>
                              <td>
                                  <?php   if(isset($contactos_web[$i]['info_interes'])): ?>

                                    <?php  foreach ($contactos_web[$i]['info_interes']->result() as $row3): ?>

                                        <?php  echo  utf8_encode($row3->DESCRIPCION)."<br>"; ?>

                                    <?php  endforeach;?>

                                  <?php   endif; ?>
                              </td>
                              <td>
                                  <?php   if($contactos_web[$i]['contacto']->ID_EVENTO): ?>

                                    <?php  echo  utf8_encode($contactos_web[$i]['contacto']->ID_EVENTO); ?>

                                  <?php   endif; ?>
                              </td>
                              <td>
                                <input type="checkbox" class="contactos_chequeados" id="contactos_chequeados" name="contactos_chequeados[]" value="<?=$contactos_web[$i]['contacto']->ID_CONTACTO_WEB;?>">
                              </td>
                            </tr>

                        <?php  endfor; ?>

                    </tbody>
                  </table>
                  </form>

              <?php   else: ?>

                        <div class="danger">
                          No se encontraron consultas web.
                        </div>

              <?php   endif; ?>

            </div>

          </div>
        </div>


    </div>
</div>

<aside class="control-sidebar control-sidebar-dark"  >
    <div class="callout callout-informativo">
      <h4>Importe las consultas web!</h4>
      <p>
          Las consultas recibidas por medio de formularios en www.ucema.edu.ar son recibidas aquí, donde por razones de SPAM, deben ser filtradas por un operador humano. Las consultas pueden ser <strong>Importadas</strong> o <strong>Eliminadas</strong>.
      <p>
    </div>
</p>


<script src="<?=base_url()?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js" type="text/javascript"></script>

<script>

  $(document).ready(function()
  {
        $('#chequear_todos').change(function()
        {
            var checkboxes = $(this).closest('form').find('.contactos_chequeados');

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

<!-- DATA TABLES -->

<!--
<link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<script src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript" ></script>



 <!-- DATA TABES SCRIPT
<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script> -->

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
     var q = jQuery.noConflict();
</script>

<script type="text/javascript">

q(document).ready(function() {

    //javascript:document.body.contentEditable='true'; document.designMode='on'; void 0


    q('.entrevistas tfoot td').each( function () {
        var title = q(this).text();
        q(this).html( '<input style="width:100%" type="text" placeholder="Buscar" />' );
    } );


    var table = q('.entrevistas').DataTable({
                dom: 'Bfrtip',
                 buttons: [
                      { extend: 'copyHtml5', footer: true  },
                      { extend: 'excelHtml5', footer: true },
                      { extend: 'csvHtml5', footer: true  },
                      { extend: 'pdfHtml5', footer: true }
                  ],
                "paging":   true,
                "ordering": true,
                "info":     true,
                "bFilter": true,
                "language": {
                    "lengthMenu": "Mostrando _MENU_ pedidos entrevistas por pagina.",
                    "zeroRecords": "Ningun pedido de entrevista fue encontrado.",
                    "info": "<b> Mostrando pagina _PAGE_ de _PAGES_ </b>",
                    "infoEmpty": "Ningun pedido de entrevista disponible",
                    "infoFiltered": "(Filtrado de _MAX_ pedidos de entrevistas totales)",
                    "sSearch": " Buscar    ",
                    "oPaginate": {
                                    "sNext": "Pag. sig.",
                                    "sPrevious": "Pag. ant."
                                  }
                },
                "lengthMenu": [[-1, 10, 25, 50], ["All", 10, 25, 50]]

            });

     table.columns().every( function () {
        var that = this;


        q( 'input', this.footer() ).on( 'keyup change', function () {

          if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }

        } );
    } );

} );

</script>

 <!-- VALIDAR CHECHKBOX -->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.10.custom.min.js"></script>

<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js" ></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js" ></script>

<script>
     var jqv = jQuery.noConflict();
</script>

<script>

  jqv(function(){

    jqv('#tabla_contactos_importar').validate({

        rules :{
                'contactos_chequeados[]'  : {
                    required : true
                }
        },
        messages : {
                'contactos_chequeados[]' : {
                    required :  "Debe seleccionar alguno."
                }
        },
        invalidHandler: function(form, validator) {

            jqv('#tabla_contactos_importar').find(":submit").removeAttr('disabled');
        },
        submitHandler: function(form) {

            jqv('#tabla_contactos_importar').find(":submit").removeAttr('disabled');
            form.submit();
        }


    });
  });

</script>