<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/consulta/consulta.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/base.css" rel="stylesheet" />

<!-- Datatables -->
 
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
      
      <div class="col-md-9">

        <form name="form_consultas_sin_asignar" id="form_consultas_sin_asignar" method="post" action="<?=base_url()?>index.php/consulta/procesa_asignar_consulta/" >

            <div id="div_asignar_operador" class="col-sm-12" style="padding-botton:15px">
                
                <div class="col-md-1">
                    <label class="form-check-label" for="inlineCheckbox1" id="operador_asignado">Operador</label>
                </div>

                <div class="col-md-2">
                          
                  <?php   $operadores_array = array(); ?>

                  <?php    $operadores_array[''] = "Seleccionar operador..."; ?>

                  <?php   foreach ($operadores as $row):

                          //echo $row['ID_PERSONA'];
                              $operadores_array[$row['N_ID_PERSONA']] = $row['GRANTEE'];

                          endforeach;
                    ?>

   
                     <?php
                       echo form_dropdown('id_persona', $operadores_array, '' ,'class="select_estado form-control" id="id_persona" name="id_persona" ' );
                    ?>
            
                </div>

                <div class="col-md-1">
                    <button data-toggle="tooltip" data-placement="bottom" data-original-title="Asignar consultas al operador"
                          id="btn_asignar_consulta" type="submit" class="btn btn-s  btn-primary btn-l mb-10px">
                          <i class="fa fa-at" aria-hidden="true"></i> Asignar consultas
                    </button>
                </div>
                
            </div>
            
         
            <div class="col-md-12" style="padding:10px 0px">
                  <a href="<?=base_url()?>index.php/consulta/asignar_consultas/1"  name="submit" class="btn btn-s btn-warning" style="margin:5px" > Filtrar un solo programa </a> 
                  <a href="<?=base_url()?>index.php/consulta/asignar_consultas/n"  name="submit" class="btn btn-s btn-warning" style="margin:5px" > Filtrar mas de un programa </a>
            </div>

            <table  class="table search-result table-striped table-bordered" id="mis_consultas" cellspacing="0" width="100%">
              <thead>
                  <tr>
                      <th class="th-checkbox"><input type="checkbox" name="todos" id="todos"></th>
                      <th class="th-date"> Fecha </th> 
                      <th class="th-surname">Apellido</th>
                      <th class="th-name">Nombre</th>
                      <th class="th-email">Email</th>
                      <th class="th-phone">Telefono</th>
                      <th class="th-entry-date">Ingreso</th> 
                      <th class="th-entry-date">Programa</th> 
                  </tr>
              </thead>
              <tbody>
                 <?php  for ($i= 0; $i < count($consultas); $i++ ): ?>

                      <tr>
                        <td>
                          <input class="clase_consulta" value="<?=$consultas[$i]['consultas']->ID_CRM_CONSULTA?>" type="checkbox" id="id_consulta" name="id_consulta[]">
                        </td>

                        <td class="td-date">
                          <?=$consultas[$i]['consultas']->FECHA_CONSULTA?>
                        </td>


                        <td>
                          <?=utf8_encode($consultas[$i]['persona']['datos_usuario']->APELLIDO)?>
                        </td>

                        <td>
                          <?=utf8_encode($consultas[$i]['persona']['datos_usuario']->NOMBRE)?>
                        </td>

                        <td>
                            <?php   foreach ($consultas[$i]['persona']['datos_emails'] as $email): ?>
                                    <?=$email['EMAIL']."</br>"?>
                            <?php   endforeach; ?>
                        </td>

                        <td>
                            <?php   foreach ($consultas[$i]['persona']['datos_telefonos']as $telefono): ?>
                                    <?=$telefono['TELEFONO']."</br>"?>
                            <?php   endforeach; ?>

                        </td>
                        <td>
                          <small class="entry-info"><?=$consultas[$i]['consultas']->ANIO."-".$consultas[$i]['consultas']->DESCRIPCION?></small>
                        </td>
                        <td>
                          <?php foreach ($consultas[$i]['programas']->result() as $row): ?>
                                          
                                         <span class="label label-success"><?=$row->D_DESCRED?></span>

                          <?php endforeach; ?>
                             
                        </td>
                       

                      </tr>

                <?php    endfor; ?>

              </tbody>
            </table>

        </form>

      </div>

      <div class="col-md-3">
           <div class="box box-warning pipeline">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-clock-o" aria-hidden="true"></i>Consultas activas asignadas</h3>
              </div>
              <div class="box-body " style="padding:20px">
                    
                    <table class="table table-responsive table-striped">
                      <thead>
                        <tr>
                          <th>Operador</th>
                          <th>Cantidad</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($opeadores_cantidad as $row) : ?>
                            <tr>
                              <td> <?=$row['GRANTEE']?> </td>
                              <td> <?=$row['CANTIDAD']?> </td>
                            </tr>

                        <?php endforeach; ?>
                          
                      </tbody>
                      
                    </table>
                                
              </div>

            </div>

      </div>

    </div>
</div>


<aside class="control-sidebar control-sidebar-dark"  >
   <div class="callout callout-informativo pb-10px pt-10px">
      <h4>¡Asigne las consultas!</h4>
      <p>La sección "Asignar consultas" le permitirá a usted asignar aquellas consultas que aún no tengan un operador a cargo.</p>
      <p>Debe seleccionar las consultas, seleccionar al usuario y presionar en asignar</p>

    </div>
</aside>
 
 

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
                  { 'bSortable': false, 'aTargets': [0, 3] },
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
 

<script type="text/javascript">


q(document).ready(function() {

    q('#todos').change(function(){


        var checkboxes = $(this).closest('form').find('.clase_consulta');


        if($(this).prop('checked'))
        {
          checkboxes.prop('checked', true);
          q("#div_asignar_operador").show();
        }
        else
        {
          checkboxes.prop('checked', false);
          q("#div_asignar_operador").hide();
        }

    });
});


q(document).ready(function() {

    q('.clase_consulta').change(function(){

        if( q('.clase_consulta:checkbox:checked').length == 0) // No hay nada seleccionado
        {
            q("#div_asignar_operador").hide();

        }
        else
        {
            q("#div_asignar_operador").show();

        }

    });
});

</script>


<!-- Validar -->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.10.custom.min.js"></script>

<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js" ></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js" ></script>

<script>
var jq_va = jQuery.noConflict();
</script>

<script type="text/javascript">

    jq_va(function(){

            jq_va('#form_consultas_sin_asignar').validate({

                rules :{

                        'id_consulta[]' : {
                            required : true
                        },
                        id_persona: {
                          required : true
                        } 
                },
                messages : {

                        'id_consulta[]' : {
                            required : "Debe elegir alguna consulta"
                        },
                        id_persona: {
                          required :  "Debe elegir algún usuario"
                        } 
                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_consultas_sin_asignar').find(":submit").removeAttr('disabled');
                }

            });
    });
 

</script>