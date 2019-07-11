<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/configuracion/programas.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/base.css" rel="stylesheet" />


<div class="content-wrapper">

    <section class="content-header">
        <h4>
          <i class="fa fa-cogs"></i> Configuración / Programas
          <span class="pull-right" data-toggle="tooltip" data-placement="bottom" data-original-title="Ver ayuda">
            <a href="#" data-toggle="control-sidebar" ><i class="fa fa-question-circle"></i> Ayuda </a>
          </span>
        </h4>
    </section>
    <div class="panel-body">

    
        <?php  if ($mensaje): ?>

            <div class="callout callout-success">
              <h5><?=$mensaje;?></h5>
            </div>

        <?php  endif; ?>


        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Programas del usuario</h3>
            </div>
            <div class="box-body ">

                <!-- Programas del usuario -->
                <div class="col-md-6">


                  <?php  if($programas_usuario->num_rows()> 0): ?>

                        <table class="table table-striped table-bordered col-md-12 table_programs">
                          <thead>
                            <tr>
                              <th>Programa</th>
                              <th>Eliminar</th>
                            </tr>
                          </thead>
                          <tbody>
                        <?php  foreach ($programas_usuario->result() as $row): ?>
                            <tr>
                              <td><?=$row->PROGRAMA?></td>
                              <td>
                                <a data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar de mis programas" class="btn btn-app"
                                  onclick="eliminar_programa_usuario(<?=$row->C_IDENTIFICACION?>,<?=$row->C_PROGRAMA?>,<?=$row->C_ORIENTACION?>)"
                                >
                                <i class="fa fa-times" aria-hidden="true"></i>
                                </a>
                              </td>
                            </tr>
                        <?php  endforeach; ?>
                          <tbody>
                        </table>

                  <?php  else: ?>

                        <div class=" danger no-program">
                          <i class="fa fa-exclamation-circle"></i> Todavía no tiene ningún programa cargado.
                        </div>


                  <?php  endif; ?>
                </div>

                <!-- Agregar programa -->
                <div class="col-md-6">
                  <div class="box">
                    <div class="box-header">
                      <h3 class="box-title"><i class="fa fa-plus p-5px" aria-hidden="true"></i> Agregar programa</h3>

                    </div>
                    <div class="box-body ">

                        <form  name="profesores_form" id="profesores_form" method="POST" action="<?=base_url()?>index.php/configuracion/agregar_programa/">

                          <div class="form-group">
                            <label for="profesor" class="control-label">Programa:</label>
                            <input class="form-control" name="programa_interes" type="text" id="programa_interes" placeholder="Escribir nombre del programa o sigla" />
                            <div id="sin_resultados"> Ningún resultado  </div>
                          </div>

                          <div class="info-box" id="datos_programa">

                              <span class="info-box-icon"><i class="fa fa-university" aria-hidden="true"></i></span>

                              <div class="info-box-content">
                                  <label for="nombre">Programa: </label>
                                  <input class="form-control" type="text" name="nombre_completo" id="nombre_completo" readonly="readonly"  />

                                  <label for="nombre">Nombre Corto:</label>
                                  <input class="form-control" type="text" name="nombre_corto" name="nombre_corto" readonly="readonly"  />

                                  <input class="form-control" type="hidden" name="c_identificacion" name="c_identificacion" readonly="readonly"  />

                                  <input class="form-control" type="hidden" name="c_programa" name="c_programa" readonly="readonly"  />

                                  <input class="form-control" type="hidden" name="c_orientacion" name="c_orientacion" readonly="readonly"  />

                              </div>

                              <div class="col-xs-3 col-xs-offset-4 submit-wrapper">
                                  <button type="submit" class="btn btn-primary btn-block"> Aceptar  </button>
                              </div>

                          </div>

                    </form>


                    <div class="alert alert-dismissable">
                      <table>
                          <tr>
                            <td> <i class="icon fa fa-ban"></i></td>
                            <td> <strong>Atencion: </strong> El programa debe ser seleccionado del listado emergente.   </td>
                          </tr>
                          <tr>
                            <td> <i class="icon fa fa-info pl-3px"></i></td>
                            <td>  <strong>Sugerencia: </strong> No utilizar acentos, ni mayúsculas. </td>
                          </tr>
                      </table>
                    </div>


                    </div>

                </div>
              </div>

            </div>

          </div>
        </div>


    </div>
</div>

<aside class="control-sidebar control-sidebar-dark"  >
        <div class="callout callout-informativo">
            <h4>Gestione sus programas !</h4>
            <p>La presente sección le permitirá configurar el/los programas que tiene a cargo ,y éstos,<strong> determinarán las consultas que usted podrá ver</strong>.<p>
        </div>
</aside>  

<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->

<script src="<?=base_url()?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js" type="text/javascript"></script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.12.1/jquery-ui.js"></script>

<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js"></script>

<script>
var jq = jQuery.noConflict();
</script>

<script type="text/javascript">


    jq('#programa_interes').autocomplete({

          minLength: 3,
          change: function( event, ui ) {
             jq('#sin_resultados').hide();
          },
          source:'<?php echo site_url('configuracion/ajax_programa'); ?>',
          select: function(event, ui)
          {
              jq('input[name="nombre_completo"]').val(ui.item.value);
              jq('input[name="nombre_corto"]').val(ui.item.D_DESCRED);
              jq('input[name="c_identificacion"]').val(ui.item.C_IDENTIFICACION);
              jq('input[name="c_programa"]').val(ui.item.C_PROGRAMA);
              jq('input[name="c_orientacion"]').val(ui.item.C_ORIENTACION);
              jq('#datos_programa').show();

              jq( "#datos_programa" ).animate({
                backgroundColor: "#E6E0F8",
                color: "#000",
                width: "100%"
              }, 200 );
              jq("#datos_programa").effect( "shake", {times:2, distance:5}, 200 );

          },
          response: function(event, ui) {

            if (ui.content.length === 0)
            {
                 jq('#sin_resultados').show();
            }
            else
            {
                 jq('#sin_resultados').hide();
            }

          }

    });

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

    }



</script>

