<link type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url(); ?>assets/css/contacto/contacto.css" rel="stylesheet" />


<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <section class="content-header">
      <h4>
         <i class="fa fa-home"></i>  <a href="<?=base_url()?>index.php/home/"> Busqueda de Personas </a>
      </h4>
    </section>
    <div class="panel-body">

        <div class="col-xs-3" >
          <div class="info-box" >
              <span class="info-box-icon bg-green"><i class="fa fa-code-fork" aria-hidden="true"></i></span>

              <div class="info-box-content">
                <span class="info-box-text" > <strong>FUSIONAR</strong></span>
                <span > <small>Permite unificar personas en una sola. Solo se pueden fusionar contactos CRM entre ellos.</small><br>
                        <strong>1 contacto CRM + 1 contacto CRM </strong>
                </span>
              </div>
          </div>
        </div>

        <div class="col-xs-3" >
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-link" aria-hidden="true"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"> <strong>VINCULAR</strong></span>
              <span  > <small>Une un persona SIGEU con una ÚNICA persona CRM, que quizá, requirió fusiones previas.</small><br>
                        <strong>1 contacto CRM + 1 contacto SIGEU </strong>
              </span>
            </div>
          </div>
        </div>

        <div class="col-xs-3" >
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-times" aria-hidden="true"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"> <strong>Eliminar</strong></span>
              <span  > <small>Solo se pueden eliminar personas CRM que no esten vinculados con personas SIGEU.</small><br>
                       <strong>1 o mas personas CRM.</strong>
              </span>
            </div>
          </div>
        </div>

        <div class="col-xs-3" >
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-plus" aria-hidden="true"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"> <strong>Cargar Consulta</strong></span>
              <span  > <small>Se pueden cargar consultas a contactos CRM o contactos SIGEU. </small>

              </span>
            </div>
          </div>
        </div>




        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <i class="fa fa-users"></i> <h3 class="box-title">Contactos encontrados: <strong><?=count($datos_contactos)?></strong></h3>
            </div>

            <div class="box-body ">


              <form id="form_contactos_encontrados" name="form_contactos_encontrados" method="post" action="<?=base_url()?>index.php/contacto/procesar_contactos_encontrados"  >

                <div id="div_botones">
                    <input data-toggle="tooltip" data-placement="bottom" data-original-title="Fusionar las personas CRM" type="submit" name="fusionar" id="fusionar" class="btn btn-success btn-accion-usuario" value='Fusionar' >
                    <input data-toggle="tooltip" data-placement="bottom" data-original-title="Vincular las persona CRM con la persona SIGEU" type="submit" name="vincular" id="vincular" class="btn btn-info btn-accion-usuario" value='Vincular' >
                    <input data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar persona/s seleccionadas" type="submit" name="eliminar" id="eliminar" class="btn btn-danger btn-accion-usuario" value='Eliminar' >
                    <input data-toggle="tooltip" data-placement="bottom" data-original-title="Cargar una consulta a la persona seleccionada" type="submit" name="cargar_consulta" id="cargar_consulta" class="btn btn-warning btn-accion-usuario" value='Cargar Consulta' >
                </div>


                <table class="table"  id="contactos_encontrados" >

                  <thead>
                    <tr>
                      <th>Selc</th>
                      <th>ID CRM</th>
                      <th>ID SIGEU</th>
                      <th>Nombre</th>
                      <th>Apellido</th>
                      <th>Email</th>
                      <th>Origen</th>
                      <th>Ver</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php   for($i=0; $i < count($datos_contactos); $i++): ?>

                        <?php
                          $datos['id'] = $datos_contactos[$i]['informacion_personal']->ID_USUARIO;
                          $datos['origen'] = $datos_contactos[$i]['informacion_personal']->ORIGEN;
                          $valores = json_encode($datos);
                          $valores = str_replace("\"", "&", $valores);

                        ?>

                        <tr>

                          <?php  /*<td><?=utf8_encode($datos_contactos[$i]['informacion_personal']->ID_USUARIO)?></td> */ ?>
                          <td><input type="checkbox" name="id_contacto[]" id="id_contacto" value="<?=$valores?>" class="<?=$datos_contactos[$i]['informacion_personal']->ORIGEN?>" > </td>
                          <td><?php echo ( ($datos_contactos[$i]['informacion_personal']->ORIGEN == "CRM") ? $datos_contactos[$i]['informacion_personal']->ID_USUARIO : ( isset($datos_contactos[$i]['informacion_personal']->ID_CRM_PERSONA) ? $datos_contactos[$i]['informacion_personal']->ID_CRM_PERSONA : '')); ?> </td>
                          <td><?php  echo ( isset($datos_contactos[$i]['informacion_personal']->ID_PERSONA) ? $datos_contactos[$i]['informacion_personal']->ID_PERSONA : ''); ?> </td>
                          <td><?=utf8_encode($datos_contactos[$i]['informacion_personal']->NOMBRE)?></td>
                          <td><?=utf8_encode($datos_contactos[$i]['informacion_personal']->APELLIDO)?></td>
                          <td><?=utf8_encode(str_replace( ";","<br>", $datos_contactos[$i]['informacion_personal']->EMAILS ))?></td>
                          <td <?php  echo ( ($datos_contactos[$i]['informacion_personal']->ORIGEN == "CRM") ? 'style="color:blue"' : 'style="color:red"'); ?> > <?="<strong>".$datos_contactos[$i]['informacion_personal']->ORIGEN."<strong>"?></td>
                          <td>
                             <!--  <a href="<?php base_url()?>index.php/contacto/"> <i class="fa fa-binoculars" aria-hidden="true"></i>  -->
                              <?php   if(isset($datos_contactos[$i]['informacion_personal']->ID_CRM_PERSONA)): ?>

                                      <a data-toggle="tooltip" data-placement="bottom" data-original-title="Ir a la persona" target="_blank" href="<?=base_url()?>index.php/contacto/ver_contacto/<?=$datos_contactos[$i]['informacion_personal']->ID_CRM_PERSONA?>"> <i class="fa fa-binoculars" aria-hidden="true"></i> </a>

                              <?php   else:  ?>

                                      <a data-toggle="tooltip" data-placement="bottom" data-original-title="No se puede ir a la persona, no esta en CRM"  disbled="disabled"> <i class="fa fa-binoculars disabled" aria-hidden="true"></i> </a>

                              <?php   endif;  ?>

                          </td>

                        </tr>


                  <?php   endfor; ?>



                  </tbody>

                </table>

              </form>

            </div>
          </div>
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


q("input[type='checkbox']").change(function()
{
    if(q('input:checkbox:checked').length == 0) // No hay nada seleccionado
    {
      q("#eliminar").css('visibility', 'hidden');
      q("#fusionar").css('visibility', 'hidden');
      q("#vincular").css('visibility', 'hidden');
      q("#cargar_consulta").css('visibility', 'hidden');
    }

    var cantidad_crm = 0;
    var cantidad_sigeu = 0;

    q('input[type="checkbox"]').each(function()
    {
        if(this.checked)
        {
          if(q(this).attr("class") == 'CRM')
          {
              cantidad_crm++;
          }

          if(q(this).attr("class") == 'SIGEU')
          {
              cantidad_sigeu++;
          }
        }


    });

    if(q('input:checkbox:checked').length == 0)
    {
      q("#div_botones").hide();
    }


    if(q('input:checkbox:checked').length != 2)  // Si no hay dos
    {
        q("#fusionar").css('visibility', 'hidden');
        q("#vincular").css('visibility', 'hidden');

        if(q('input:checkbox:checked').length == 1)
        {
          q("#div_botones").show();
          q("#cargar_consulta").css('visibility', 'visible');;
        }

        if( cantidad_crm > 0 && cantidad_sigeu == 0)
        {
            q("#div_botones").show();
            q("#eliminar").css('visibility', 'visible');
        }
        else
        {
            //q("#div_botones").hide();
            q("#eliminar").css('visibility', 'hidden');
        }
    }
    else // Si hay 2
    {
        q("#div_botones").css('visibility', 'visible');
        q("#cargar_consulta").css('visibility', 'hidden');

        if( cantidad_crm == 1 && cantidad_sigeu == 1 )
        {
            q("#div_botones").show();
            q("#vincular").css('visibility', 'visible');
            q("#fusionar").css('visibility', 'hidden');
            q("#eliminar").css('visibility', 'hidden');

        }

        if( cantidad_crm == 2 )
        {
            q("#div_botones").show();
            q("#fusionar").css('visibility', 'visible');
            q("#eliminar").css('visibility', 'visible');
        }

        if( cantidad_sigeu == 2 )
        {
            q("#div_botones").hide();
            q("#vincular").css('visibility', 'hidden');
            q("#fusionar").css('visibility', 'hidden');
            q("#eliminar").css('visibility', 'hidden');
        }

    }

});


q(document).ready(function() {
    q('#contactos_encontrados').dataTable({
                "paging":   true,
                "ordering": true,
                "info":     true,
                "bFilter": true,
                "language": {
                    "lengthMenu": "Mostrando _MENU_ personas por pagina.",
                    "zeroRecords": "Ninguna persona fue encontrada.",
                    "info": "<b> Mostrando pagina _PAGE_ de _PAGES_ </b>",
                    "infoEmpty": "Ninguna persona disponible",
                    "infoFiltered": "(Filtrado de _MAX_ personas totales)",
                    "sSearch": " Buscar    ",
                    "oPaginate": {
                                    "sNext": "Pag. sig.",
                                    "sPrevious": "Pag. ant."
                                  }
                },
                "lengthMenu": [[-1, 10, 25, 50], ["All", 10, 25, 50]],
                "aaSorting": [[5,'asc']]


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

   jqv('#form_contactos_encontrados').validate({

        rules :{
                'id_contacto[]'  : {
                    required : true
                }
        },
        messages : {
                'id_contacto[]' : {
                    required :  "Debe seleccionar algun contacto."
                }
        },
        submitHandler: function(form)
        {
            if (confirm('¿ Seguro que desea continuar ?'))
            {
                form.submit();
            }

        }

    });
  });



</script>