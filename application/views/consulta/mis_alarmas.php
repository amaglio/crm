 
<div class="content-wrapper">
    <section class="content-header">
      <h4>
         <i class="fa fa-address-card" aria-hidden="true"></i>  <a href="<?=base_url()?>index.php/home/"> Consultas / Mis alarmas </a>
         <span class="pull-right" data-toggle="tooltip" data-placement="bottom" data-original-title="Ver ayuda">
            <a href="#" data-toggle="control-sidebar" ><i class="fa fa-question-circle"></i> Ayuda </a>
          </span>
      </h4>
    </section>
    <div class="panel-body">
  

        <!-- Filtros de busquedas -->
        <div class="col-md-3 p-5px">

            <div class="box box-primary">
              <div class="box-header with-border">
                <i class="fa fa-search"></i> <h3 class="box-title"> Filtrar Alarmas</h3>

              </div>
              <div class="box-body ">

                    <?php if(isset($filtros)): ?>

                      <div class="jumbotron" style="padding:20px"><?=$filtros?></div>

                    <?php endif; ?>

                    <form class="form-horizontal" name="form_buscar_alarmas" id="form_buscar_alarmas" method="post" action="<?=base_url()?>index.php/consulta/buscar_alarmas/">

                        <input type="hidden" name="donde_buscar" id="donde_buscar" value="todos">
                        
                        <div>
                            <label for="exampleInputEmail1">Tipo de alarma</label>
                            
                            <?php   $tipos_alarmas_array = array(); ?>

                            <?php   $tipos_alarmas_array['-1'] = 'Elegir un tipo...' ?>

                            <?php   foreach ($tipos_alarmas as $row):

                                        $tipos_alarmas_array[$row['ID_TIPO_ALARMA']] = $row['DESCRIPCION'];

                                endforeach;

                                echo form_dropdown('id_tipo_alarma', $tipos_alarmas_array, -1 ,'class="form-control select_estado" id="id_tipo_alarma" name="id_tipo_alarma"' );

                            ?>
                            

                        </div>

                        <div>
                          <label for="exampleInputEmail1">Fecha de la alarma</label>

                           <input type="text" class="form-control calendario" placeholder="Desde esta fecha" id="fecha_desde" name="fecha_desde">

                           <input type="text" class="form-control calendario" placeholder="Hasta esta fecha" id="fecha_hasta" name="fecha_hasta">

                        </div>

                        <div>
                          <button  type="submit" id="boton_buscar" class="btn btn-primary btn-block"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                        </div>

                    </form>
              </div>
           </div>
        </div>

        <!-- Ultimos consultas -->
        <div class="col-md-9 p-5px">

            <div class="box box-primary">
              <div class="box-header with-border">
                <i class="fa fa-clock-o" aria-hidden="true"></i> <h3 class="box-title">Alarmas</h3>
              </div>
              <div class="box-body ">
              
                  <table class="table table-striped" id="mis_alarmas">
                      <thead>
                        <tr>
                          <th>Fecha</th>
                          <th>Persona</th>
                          <th>Descripcion</th>
                          <th>Consulta</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($mis_alarmas as $row): ?>
                                  
                                  <tr>
                                    <td><?=$row['FECHA']?></td>
                                    <td><?=$row['NOMBRE_APELLIDO']?></td>
                                    <td><?=$row['DESCRIPCION']?></td>
                                    <td><?=$row['ID_CRM_CONSULTA']?></td>
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
      <h4>Filtrá tus alarmas!</h4>
      <p>La presente sección le permitirá ver todas las alarmas que tiene activas y poder filtrarlas.</p>
  </div>
</p>
 

<!-- jQuery 2.1.4 -->
<script src="<?=base_url()?>assets/js/jQuery-2.1.4.min.js"></script>

<!-- bootstrap datepicker -->
<script src="<?=base_url()?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>

<script type="text/javascript">

$('.calendario').datepicker({
  autoclose: true,
  format: 'dd/mm/yyyy'
});

</script>


<link href="<?=base_url()?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<script>
     var q = jQuery.noConflict();
</script>

 <!-- DATA TABES SCRIPT -->
<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>

<script type="text/javascript">

q(document).ready(function() {
    q('#mis_alarmas').dataTable({
                "paging":   true,
                "ordering": true,
                "info":     true,
                "bFilter": true,
                "language": {
                    "lengthMenu": "Mostrando _MENU_ postulaciones por pagina.",
                    "zeroRecords": "Ninguna postulacion fue encontrada.",
                    "info": "<b> Mostrando pagina _PAGE_ de _PAGES_ </b>",
                    "infoEmpty": "Ninguna postulacion disponible",
                    "infoFiltered": "(Filtrado de _MAX_ postulaciones totales)",
                    "sSearch": " Buscar    ",
                    "oPaginate": {
                                    "sNext": "Proxima pagina",
                                    "sPrevious": "<i class='fa fa-fw fa-arrow-left'></i>"
                                  }
                }

            });
} );

</script>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.10.custom.min.js"></script>

<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js" ></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js" ></script>

<script>
var jq = jQuery.noConflict();
</script>

<script type="text/javascript">

     jq.validator.addMethod("seleccionar_algo",
      function(value, element)
        {

            if( jq( "#fecha_desde" ).val() ||
                jq( "#fecha_hasta" ).val() ||
                jq( "#id_tipo_alarma" ).val() != -1  
              )
            {
              return true;
            }
            else
            {
               jq('#form_buscar_alarmas').find(":submit").removeAttr('disabled');
              return false;
            }

        },
       "Debe seleccionar algun criterio de busqueda."
    );


    jq(function(){

            jq('#form_buscar_alarmas').validate({

                submitHandler: function(form) {
 
                   jq('#form_buscar_alarmas').find(":submit").removeAttr('disabled');
                   form.submit();
                },
                rules :{
 
                     
                        fecha_hasta : {
                            seleccionar_algo : true
                        }
                },
                messages : {

                        fecha_hasta : {
                            seleccionar_algo : "Debe seleccionar algun criterio de busqueda"
                        }
                }

            });
    });
</script>