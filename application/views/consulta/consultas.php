<link rel="stylesheet" href="<?=base_url()?>assets/plugins/select2/select2.min.css">

<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />

<link   type="text/css" href="<?php echo base_url(); ?>assets/css/consulta/consulta.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/base.css" rel="stylesheet" />

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <section class="content-header">
      <h4>
         <i class="fa fa-address-card" aria-hidden="true"></i>  <a href="<?=base_url()?>index.php/home/"> Consultas / Todas </a>
         <span class="pull-right" data-toggle="tooltip" data-placement="bottom" data-original-title="Ver ayuda">
            <a href="#" data-toggle="control-sidebar" ><i class="fa fa-question-circle"></i> Ayuda </a>
          </span>
      </h4>
    </section>
    <div class="panel-body">
  

        <!-- Filtros de busquedas -->
        <div class="col-md-4 p-5px">

            <div class="box box-primary">
              <div class="box-header with-border">
                <i class="fa fa-search"></i> <h3 class="box-title"> Buscar consultas</h3>

              </div>
              <div class="box-body ">
                    <form class="form-horizontal" name="form_buscar_consulta" id="form_buscar_consulta" method="post" action="<?=base_url()?>index.php/consulta/buscar_consulta/">

                        <input type="hidden" name="donde_buscar" id="donde_buscar" value="todos">

                        <div >
                          <label for="exampleInputEmail1">Programas buscados</label>

                          <select id="programas_grado" name="programas_elegidos[]" multiple="multiple" >

                                   <option value="1,1,0" >Dirección de Empresas</option>
                                   <option value="1,2,0">Economía</option>
                                   <option value="1,10,0">Marketing</option>
                                   <option value="1,6,0">Contador Público</option>
                                   <option value="1,7,0">Ingeniería en Informática</option>
                                   <option value="1,3,0">Ciencias Políticas</option>
                                   <option value="1,9,0">Relaciones Internacionales</option>
                                   <option value="1,11,0">Recursos Humanos</option>
                                   <option value="1,12,0">Abogacía</option>

                          </select>

                          <select id="programas_posgrado" name="programas_elegidos[]" multiple="multiple">

                                <optgroup label="Maestrías">

                                          <option value="2,1,0" >Dirección de Empresas</option>
                                          <option value="2,3,0" >Finanzas</option>
                                          <option value="2,2,0" >Economía</option>
                                          <option value="2,5,0" >Agronegocios</option>
                                          <option value="4,3,0" >Evaluación de Proyectos</option>
                                          <option value="2,9,0" >Ciencias del Estado</option>
                                          <option value="2,20,0" >Estudios Internacionales</option>

                                </optgroup>

                                <optgroup label="Especializaciones">

                                          <option value="2,30,1" >Finanzas</option>
                                          <option value="2,31,1" >Gestión de Proyectos</option>
                                          <option value="2,140,1" >Posgrado en Management</option>
                                </optgroup>

                                <optgroup label="Doctorados">

                                          <option value="2,10,0" >Dirección de Empresas</option>
                                          <option value="2,16,0" >Finanzas</option>
                                          <option value="2,7,0" >Economía</option>

                                </optgroup>

                          </select>

                          <select id="programas_ejecutivos" name="programas_elegidos[]" multiple="multiple">

                              <optgroup label="AGRONEGOCIOS">

                                  <option value="3,115,1" >La Diplomatura en Agronegocios </option>

                              </optgroup>

                              <optgroup label="MARKETING">

                                  <option value="3,119,1" >Diplomatura en Investigación de Mercado</option>
                                  <option value="3,96,1" >Diplomatura en Marketing Estratégico</option>

                              </optgroup>

                              <optgroup label="FINANZAS">

                                  <option value="3,2,0" >Diplomatura en Mercado de Capitales</option>
                                  <option value="3,1,0" >Programa Ejecutivo en Finanzas Corporativas</option>
                                  <option value="3,30,1" >Curso Preparatorio para el Nivel I del Examen CFA</option>
                                  <option value="3,22,0" >Programa en Gestión Personal de Inversiones Financieras</option>
                                  <option value="3,131,1" >El negocio PYME en la banca - Enfoque estratégico y gestión de riesgo crediticio</option>
                                  <option value="3,16,1" >Valuación de Empresas y Creación de Valor</option>
                                  <option value="3,79,1" >Fideicomisos y Fondos de Inversión Directa</option>

                              </optgroup>

                              <optgroup label="MANAGEMENT">

                                  <option value="3,5,0" >Programa Ejecutivo en Administración de Empresas</option>
                                  <option value="3,45,1" >Negociación Organizacional</option>
                                  <option value="3,37,0" >Diseño de un Business Plan</option>
                                  <option value="3,53,2" >Tablero de Comando</option>
                                  <option value="3,90,1" >Persuasión</option>
                                  <option value="3,128,0" >Hotel Business Management - Claves de Desarrollo Gerencial para Empresas Hoteleras</option>
                                  <option value="3,56,1" >Project Management: Entrenamiento para certificación como PMP®</option>
                                  <option value="3,47,1" >Liderando e Implementando el Cambio: Change Management</option>
                                  <option value="3,136,1" >Comunicación Efectiva</option>
                                  <option value="3,81,1" >Diplomatura en Competencias Organizacionales (DCO)</option>
                                  <option value="3,81,1" >Diplomatura en Competencias Organizacionales (DCO)</option>
                                  <option value="3,77,1" >Inteligencia Emocional en la empresa</option>

                              </optgroup>

                              <optgroup label="RECURSOS HUMANOS">

                                  <option value="3,31,0" >Gestión de Recursos Humanos</option>
                                  <option value="3,84,2" >Nuevas herramientas para el desarrollo de personas</option>


                              </optgroup>

                               <optgroup label="DERECHO">

                                <option value="3,130,1" >Nuevo Código Civil y Comercial</option>
                                <option value="3,125,1" >Prevención de Lavado de Activos, lavado de dinero proveniente del narcotráfico y financiamiento del crimen organizado</option>
                                <option value="3,100,1" >Programa Ejecutivo de Certificación en Etica y Compliance</option>
                                <option value="3,6,0" >Finanzas para Abogados</option>


                              </optgroup>

                          </select>

                        </div>

                        <div >
                          <label for="exampleInputEmail1">Fecha de la consulta</label>

                           <input type="text" class="form-control pull-right calendario" placeholder="Desde esta fecha" id="fecha_desde" name="fecha_desde">

                           <input type="text" class="form-control pull-right calendario" placeholder="Hasta esta fecha" id="fecha_hasta" name="fecha_hasta">

                        </div>

                        <div>
                          <button  readonly="disabled" type="submit" class="btn btn-primary btn-block"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                        </div>

                    </form>
              </div>
           </div>
        </div>

        <!-- Ultimos consultas -->
        <div class="col-md-8 p-5px">

            <div class="box box-primary">
              <div class="box-header with-border">
                <i class="fa fa-clock-o" aria-hidden="true"></i> <h3 class="box-title">Ultimas consultas</h3>
              </div>
              <div class="box-body ">
                <ul class="users-list clearfix">


                <?php   if(count($consultas) > 0 ): ?>

                      <?php  for ($i=0; $i < count($consultas); $i++): ?>

                           <div class="col-md-6">
                              <div class="info-box">
                                  <a href="<?=base_url()?>index.php/consulta/ver_consulta/<?=$consultas[$i]['consultas']->ID_CRM_CONSULTA?>">
                                    <span data-toggle="tooltip" data-placement="bottom" data-original-title="Ir a la consulta"  class="info-box-icon bg-blue">
                                       <i class="fa fa-address-card pt-10px" aria-hidden="true">
                                        <span class="info-box-number">
                                              nº:<small><?=$consultas[$i]['consultas']->ID_CRM_CONSULTA?></small><br>

                                          </span>

                                      </i>

                                    </span>
                                  </a>
                                  <div class="info-box-content">

                                    <span data-toggle="tooltip" data-placement="bottom" data-original-title="Ir a la persona"  class="info-box-text"><a class="users-list-name fs-14px" href="<?=base_url()?>index.php/contacto/ver_contacto/<?=$consultas[$i]['consultas']->ID_CRM_PERSONA?>"><?=utf8_encode($consultas[$i]['persona']['datos_usuario']->APELLIDO.", ".$consultas[$i]['persona']['datos_usuario']->NOMBRE)?></a></span>
                                    <span class="info-box-number h-20px fs-12px">
                                          <small class="h-20px fs-12px"><?=$consultas[$i]['consultas']->FECHA_CONSULTA?></small>


                                        <?php  if(isset($consultas[$i]['consultas']->ID_PERIODO_INGRESO)):?>
                                              <small class="id-entry-period"><?=$consultas[$i]['consultas']->ANIO."-".$consultas[$i]['consultas']->DESCRIPCION?></small>
                                        <?php  endif;?>


                                    </span>

                                    <span class="info-box-number fs-12px h-20px">

                                    <?php   $k = 0; ?>

                                    <?php   foreach ($consultas[$i]['programas']->result() as $row): ?>

                                        <?php   if($k < 7):  ?>

                                              <span class="label label-success"><?=$row->D_DESCRED?></span>

                                        <?php   endif; ?>

                                        <?php   $k++; ?>

                                    <?php   endforeach;?>

                                    <?php   if( $k > 7): ?>
                                          <a href="<?=base_url()?>index.php/consulta/ver_consulta/<?=$consultas[$i]['consultas']->ID_CRM_CONSULTA?>">
                                              ...
                                          </a>
                                    <?php   endif; ?>

                                    </span>

                                  </div>
                                </div>
                            </div>

                        <?php  endfor; ?>

                  <?php   else: ?>

                      <div class="callout callout-danger">
                          Todavia no hay consultas cargadas.
                      </div>

                  <?php   endif; ?>

                </ul>
              </div>
           </div>
        </div>

    </div>
</div>

<aside class="control-sidebar control-sidebar-dark"  >
  <div class="callout callout-informativo pb-10px pt-10px">
      <h4>Encuentre las consultas!</h4>
      <p>La presente sección le permitirá buscar consultas por el/los <strong>programas</strong>  marcados como interesados y por la <strong>fecha</strong> de la misma.
  </div>
</p>


<!-- DATA TABES SCRIPT -->

<link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript" ></script>

<script>
     var q = jQuery.noConflict();
</script>

<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>

<!-- bootstrap datepicker -->
<script src="<?=base_url()?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>

<!-- Multiselect -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" type="text/css"/>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<script>
     var f = jQuery.noConflict();
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.10.custom.min.js"></script>

<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js" ></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js" ></script>

<script>
var jq_va = jQuery.noConflict();
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css
  " type="text/css"/>


<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>

<script>
var jq_sel = jQuery.noConflict();
</script>

<!-- bootstrap datepicker -->
<script src="<?=base_url()?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?=base_url()?>assets/js/consulta.js" type="text/javascript"></script>

<script type="text/javascript">

    jq_va.validator.addMethod("seleccionar_algo",
      function(value, element)
        {

            if( jq_va( "#programas_grado" ).val() ||
                jq_va( "#programas_posgrado" ).val() ||
                jq_va( "#programas_ejecutivos" ).val()  ||
                jq_va( "#fecha_desde" ).val()  ||
                jq_va( "#fecha_hasta" ).val()
              )
            {
              return true;
            }
            else
            {
              return false;
            }

        },
       "Debe seleccionar algun criterio de busqueda."
    );

    jq_va(function(){

            jq_va('#form_buscar_consulta').validate({

                rules :{

                        fecha_hasta : {
                            seleccionar_algo : true
                        }
                },
                messages : {

                        fecha_hasta : {
                            seleccionar_algo : "Debe seleccionar algun criterio de busqueda"
                        }
                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_buscar_consulta').find(":submit").removeAttr('disabled');
                }

            });
    });

</script>