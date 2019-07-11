<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" />

<link   type="text/css" href="<?php echo base_url(); ?>assets/css/consulta/alta_consulta.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/base.css" rel="stylesheet" />


<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <section class="content-header">
      <h4>
         <i class="fa fa-address-card" aria-hidden="true"></i>  <a href="<?=base_url()?>index.php/home/"> Consultas / 1º Cargar informacion de la persona  </a>
      </h4>
    </section>
    <div class="panel-body" >

      <div class="callout callout-informativo">
            <h4>1er PASO</h4>
            <p>Ingrese la información de la persona que realizó la consulta.<p>
            <div class="nota"> <strong>Nota:</strong> también se puede cargar una consulta desde
                <a href="<?php echo base_url(); ?>index.php/contacto/index">
                    <i class="fa fa-users"></i>
                    <span>Personas</span>
                </a>, aunque solamente para personas que ya estén en CRM o SIGEU. </div>
      </div>

      <?php  mensaje_resultado($mensaje); ?>

      <div class="col-md-12 msg-pane">

          <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#home">1º Cargar persona</a></li>
            <li><a data-toggle="tab"  class="disabled" href="#menu1">2º Verificar persona</a></li>
            <li><a data-toggle="tab"  class="disabled " href="#menu2">3º Cargar consulta</a></li>
          </ul>

          <div class="tab-content">

            <form class="form-horizontal" name="form_alta_consulta" id="form_alta_consulta"  method="POST"  action="<?=base_url()?>index.php/consulta/ver_alta_consulta_2/"   >

                  <div class="row">
                    <div class="form-group col-sm-6 ">
                      <label for="apellido" class="col-sm-2 control-label">Apellido</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido">
                      </div>
                    </div>
                    <div class="form-group col-sm-6 ">
                      <label for="nombre" class="col-sm-2 control-label">Nombre</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="nombre"  name="nombre" placeholder="Nombre">
                      </div>
                    </div>
                  </div>

                  <div class="row">

                      <div class="form-group col-sm-6 ">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group col-sm-6 ">
                        <label for="telefono" class="col-sm-2 control-label">Telefono</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono">
                        </div>
                      </div>
                  </div>

                  <div class="row">

                      <div class="form-group col-sm-6">
                        <label for="educacion" class="col-sm-2 control-label">Educacion</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="educacion" name="educacion" placeholder="Tipee el nombre de la educacion..">
                        </div>
                        <div class="col-sm-10" id="sin_resultado">
                              No hay resultado <a  onclick="mostrar_educacion_manual()"  class="btn btn-xs btn-primary">Cargar manualmente</a>
                        </div>

                      </div>

                      <div class="form-group col-sm-12 " id="div_educacion_sigeu">
                          <label  class="col-sm-2 control-label">Educacion SIGEU</label>
                          <label  class="col-sm-1 control-label"> <a onclick="ocultar_educacion_sigeu()"> <i class="fa fa-times" aria-hidden="true"></i></a></label>
                          <div class="col-sm-8">
                               <input readonly="readonly" type="text" class="form-control" id="id_educacion" name="id_educacion" placeholder="Educacion Manual"> <br>
                               <input readonly="readonly" type="text" class="form-control" id="educacion_sigeu" name="educacion_sigeu" placeholder="Educacion Manual"> <br>
                          </div>
                          <div class="form-group">
                              <label for="carrera" class="col-sm-2 control-label">Nivel</label>
                              <div class="col-sm-9">

                                  <?php   $niveles = array(); ?>

                                  <?php   $niveles[''] = 'Seleccionar Nivel'; ?>

                                  <?php   foreach ($niveles_educacion->result() as $row):

                                          $niveles[$row->ID_NIVEL_EDUCACION] = $row->DESCRIPCION;

                                      endforeach;

                                    echo form_dropdown('id_nivel_sigeu', $niveles, '' ,'class="form-control" id="id_nivel"   ' );

                                  ?>

                              </div>
                            </div>
                      </div>

                      <div class="form-group col-sm-12 " id="div_educacion_manual">
                          <label  class="col-sm-2 control-label">Educacion Manual</label>
                          <label  class="col-sm-1 control-label"> <a onclick="ocultar_educacion_manual()"> <i class="fa fa-times" aria-hidden="true"></i></a></label>
                          <div class="col-sm-8 wrapper_ed_man">
                             <input type="text" class="form-control" id="educacion_manual" name="educacion_manual" placeholder="Educacion Manual">
                          </div>

                          <label  class="col-sm-2 control-label">Nivel</label>
                          <div class="col-sm-9">

                              <?php   $niveles = array(); ?>

                              <?php   $niveles[''] = 'Seleccionar Nivel'; ?>

                              <?php   foreach ($niveles_educacion->result() as $row):

                                      $niveles[$row->ID_NIVEL_EDUCACION] = $row->DESCRIPCION;

                                  endforeach;

                                echo form_dropdown('id_nivel_manual', $niveles, '' ,'class="form-control" id="id_nivel"  ' );

                              ?>

                          </div>

                      </div>

                  </div>


                  <div class="row">

                      <div class="form-group col-sm-6 ">
                        <label for="empresa" class="col-sm-2 control-label">Empresa</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="empresa" name="empresa" placeholder="Tipee el nombre de la empresa..">
                        </div>
                        <div class="col-sm-10" id="sin_resultado_empresa">
                              No hay resultado <a  onclick="mostrar_empresa_manual()"  class="btn btn-xs btn-success">Cargar manualmente</a>
                        </div>
                      </div>


                       <div class="form-group col-sm-12 " id="div_empresa_sigeu">
                          <label  class="col-sm-2 control-label">Empresa SIGEU</label>
                          <label  class="col-sm-1 control-label"> <a onclick="ocultar_empresa_sigeu()"> <i class="fa fa-times" aria-hidden="true"></i></a></label>
                          <div class="col-sm-8">
                               <input readonly="readonly" type="text" class="form-control" id="id_empresa" name="id_empresa" placeholder="Empresa Manual"> <br>
                               <input readonly="readonly" type="text" class="form-control" id="empresa_sigeu" name="empresa_sigeu" placeholder="Empresa Manual"> <br>
                          </div>
                          <label for="cargo" class="col-sm-2 control-label">Cargo</label>
                          <div class="col-sm-10 cs-wrapper">
                            <input type="text" class="form-control" id="cargo_sigeu" name="cargo_sigeu" placeholder="Cargo en la empresa">
                          </div>
                        </div>

                        <div class="form-group col-sm-12 " id="div_empresa_manual">
                          <label  class="col-sm-2 control-label">Empresa Manual</label>
                          <label  class="col-sm-1 control-label" > <a onclick="ocultar_empresa_manual()"> <i class="fa fa-times" aria-hidden="true"></i> </a></label>
                          <div class="col-sm-8">
                             <input type="text" class="form-control" id="empresa_manual" name="empresa_manual" placeholder="Empresa Manual">
                          </div>
                          <label for="cargo" class="col-sm-2 control-label">Cargo</label>
                          <div class="col-sm-10 cm-wrapper">
                            <input type="text" class="form-control" id="cargo_manual" name="cargo_manual" placeholder="Cargo en la empresa">
                          </div>
                        </div>

                  </div>

                  <button disabled="disabled" type="submit" class="btn btn-block btn-primary">Siguiente <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
            </form>

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

q(document).ready(function() {

    q('#form_alta_consulta')[0].reset();

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

     q('.check_contactenme').change(function(){

        if(this.value == 2) // Telefono
        {
            if( this.checked )
            {
              q('#horario_telefono').show();
            }
            else
            {
              q('#horario_telefono').hide();
            }
        }

        if(this.value == 3)
        {
            if( this.checked )
            {
              q('#horario_what').show();
            }
            else
            {
              q('#horario_what').hide();
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



<!-- Multiselect  -->


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

  $(document).on("click", ".eliminar_programa", function() {
          q('#'+$(this).attr("id")).remove();
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


    jq_va.validator.addMethod("ingreso_empresa_manual",
      function(value, element)
        {
            var empresa_manual = jq_va( "#empresa_manual" ).val().length;
            var cargo_manual = jq_va( "#cargo_manual" ).val().length;


            if( ( empresa_manual<= 0 )  &&
                ( cargo_manual > 0 )
              )
            {
              console.log("Falta empresa");
              return false;
            }
            else
            {

              console.log("Perfecto");
              return true;
            }

        },
       "Debe ingresar el nombre de la empresa"
    );

    jq_va(function(){

            jq_va('#form_alta_consulta').validate({

                rules :{

                        apellido : {
                            required : true
                        },
                        nombre : {
                            required : true
                        },
                        email : {
                            required : true,
                            email: true,
                            remote: { url: CI_ROOT+"index.php/contacto/existe_email/", type: 'POST', async: false }
                        },
                        anio : {
                            digits : true,
                            minlength: 4,
                            maxlength: 4
                        },
                        id_nivel_sigeu: {
                            required : true
                        },
                        id_nivel_manual: {
                            required : true
                        },
                        educacion_manual: {
                            required : true
                        },
                        empresa_manual: {
                            required : true
                        },
                        cargo_manual: {
                            ingreso_empresa_manual : true
                        }

                },
                messages : {

                        apellido : {
                            required : "Debe ingresar el apellido del contacto."
                        },
                        nombre : {
                            required : "Debe ingresar el nombre del contacto."
                        },
                        email : {
                            required : "Debe ingresar el email del contacto.",
                            email: "Debe tener formato de email",
                            remote: "El email esta registrado para otra persona, ingrese otro."
                        },
                        anio : {
                            digits : "Debe ingresar solo numeros.",
                            minlength: "Debe ser formato 4 digitos. Ej: 2016",
                            maxlength: "Debe ser formato 4 digitos. Ej: 2016"
                        },
                        id_nivel_sigeu: {
                          required : "Debe seleccionar un nivel de educacion"
                        },
                        id_nivel_manual: {
                          required : "Debe seleccionar un nivel de educacion"
                        },
                        educacion_manual: {
                            required : "Debe cargar la educacion manual o apretar en la X roja para eliminarla"
                        },
                        empresa_manual: {
                            required : "Debe escribir el nombre de la empresa"
                        },
                        cargo_manual: {
                            ingreso_empresa_manual : "Debe ingresar el nombre de la empresa"
                        }
                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_alta_consulta').find(":submit").removeAttr('disabled');
                }

            });
    });

</script>

<!--
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.10.custom.min.js"></script>--

<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.4.4.min.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.ui/1.12.1/jquery-ui.js"></script>

<script>
  var jq_ui = jQuery.noConflict();
</script>



<script type="text/javascript">

    jq_ui('#programa_buscado').autocomplete({
          source:'<?php echo site_url('consulta/ajax_programa'); ?>',
          select: function(event, ui)
          {
              $(ui.item.mensaje).appendTo("#programas_elegidos");
              $("#programa_buscado").val("");
          }

    });


    //-- EDUCACION

    jq_ui('#educacion').autocomplete({

          minLength: 3,
          change: function( event, ui ) {
             //jq_ui('#div_educacion_manual').hide();
          },
          source:'<?php echo site_url('consulta/ajax_educacion'); ?>',
          select: function(event, ui)
          {
              jq_ui("#div_educacion_sigeu").show();
              jq_ui("#id_educacion").val(ui.item.id_empresa);
              jq_ui("#educacion_sigeu").val(ui.item.value);
              jq_ui('#educacion').attr('readonly', true);
              jq_ui('#educacion').val("");


              jq_ui(this).val("");
              return false; // Importante, si esto no borra el input

          },
          response: function(event, ui) {

            //alert(ui.content.length);

            if (ui.content.length === 0)
            {
                 jq_ui('#sin_resultado').show();
                 //jq_ui('#educacion').attr('readonly', true);

            }
            else
            {
                 jq_ui('#sin_resultado').hide();
            }

          }

    });

    function ocultar_educacion_manual()
    {
        jq_ui('#educacion').val("");
        jq_ui('#educacion_manual').val("");
        jq_ui('#div_educacion_manual').hide();
        jq_ui('#educacion').attr('readonly', false);
    }

    function mostrar_educacion_manual()
    {
        jq_ui('#sin_resultado').hide();
        jq_ui('#educacion').val("");
        jq_ui('#educacion').attr('readonly', true);
        jq_ui('#div_educacion_manual').show();
    }

    function ocultar_educacion_sigeu()
    {
        jq_ui('#sin_resultado').hide();
        jq_ui('#div_educacion_sigeu').hide();
        jq_ui('#id_educacion').val("");
        jq_ui('#educacion_sigeu').val("");
        jq_ui('#educacion').val("");
        jq_ui('#educacion').attr('readonly', false);
    }

    //--  EMPRESA

    jq_ui('#empresa').autocomplete({

          minLength: 3,
          change: function( event, ui ) {
             //jq_ui('#empresa_manual').hide();
          },
          source:'<?php echo site_url('consulta/ajax_empresa'); ?>',
          select: function(event, ui)
          {
              jq_ui("#div_empresa_sigeu").show();
              jq_ui("#id_empresa").val(ui.item.id_empresa);
              jq_ui("#empresa_sigeu").val(ui.item.value);
              jq_ui('#empresa').attr('readonly', true);
              jq_ui('#empresa').val("");


              jq_ui(this).val("");
              return false; // Importante, si esto no borra el input

          },
          response: function(event, ui) {

            //alert(ui.content.length);

            if (ui.content.length === 0)
            {
                 jq_ui('#sin_resultado_empresa').show();
                 //jq_ui('#educacion').attr('readonly', true);

            }
            else
            {
                 jq_ui('#sin_resultado_empresa').hide();
            }

          }

    });

    function ocultar_empresa_manual()
    {
        jq_ui('#empresa').val("");
        jq_ui('#empresa_manual').val("");
        jq_ui('#div_empresa_manual').hide();
        jq_ui('#empresa').attr('readonly', false);
    }

    function mostrar_empresa_manual()
    {

        $("label.error").hide();

        jq_ui('#sin_resultado_empresa').hide();

        jq_ui('#empresa').val("");

        jq_ui('#empresa').attr('readonly', true);
        jq_ui('#div_empresa_manual').show();

        return false;
    }

    function ocultar_empresa_sigeu()
    {
        jq_ui('#sin_resultado_empresa').hide();
        jq_ui('#div_empresa_sigeu').hide();

        jq_ui('#id_empresa').val("");
        jq_ui('#empresa_sigeu').val("");

        jq_ui('#empresa').val("");
        jq_ui('#empresa').attr('readonly', false);
    }

</script>