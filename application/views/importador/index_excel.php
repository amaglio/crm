<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/importador/importar.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/consulta/consulta.css" rel="stylesheet" />

<div class="content-wrapper">

    <section class="content-header">
        <h4>
          <i class="fa fa-file-excel-o" aria-hidden="true"></i> Importador de consultas desde un EXCEL
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
              <h3 class="box-title"> Selccionar el Excel </h3>

            </div>

            <div class="box-body ">

              <!---<img src="<?=base_url()?>assets/images/blanka_1.gif" class="img-responsive" > -->


            <form enctype="multipart/form-data" class="form-horizontal" name="form_alta_archivo_excel" id="form_alta_archivo_excel"  method="POST"  action="<?=base_url()?>index.php/importador/pre_importar_excel"   >

                  <div class="row">
                    <div class="form-group col-sm-6 ">
                      <label for="archivo" class="col-sm-4 control-label">Archivo</label>
                      <div class="col-sm-8">
                        <input type="file" class="form-control" id="archivo" name="archivo" placeholder="Apellido">
                      </div>
                        <label for="archivo" class="col-sm-4 control-label">Son de un evento ?</label>
                      <div class="col-sm-8">
                        <?php   $array_eventos =   array(); ?>
                      <?php   $array_eventos[''] = 'Seleccionar Evento'; ?>
                      <?php   foreach ($eventos as $row):

                              $array_eventos[$row['ID_EVENTO']] = $row['ID_EVENTO']."- ".$row['NOMBRE'];

                          endforeach;

                        echo form_dropdown('id_evento', $array_eventos, '' ,'class="form-control" id="id_evento" name="id_evento" ' );

                      ?>
                      </div>
                    </div>

                    <div class="form-group col-sm-6 ">
                    <button disabled="disabled" type="submit" class="btn btn-block btn-primary">Cargar </button>
                  </div>
            </form>

            </div>

          </div>
        </div>


    </div>
</div>

<aside class="control-sidebar control-sidebar-dark"  >
     <div class="callout callout-informativo">
        <h4>Importa las consultas en excel!</h4>
        <p>
            La presente sección le permitira importar al CRM, consultas que hayan sido registradas en un archivo excel. <br>
            El archivo <strong> excel </strong> tiene que haber sido previamente <strong> formateado </strong> para ser reconocido como valido.<br>
            Formato en columnas: Apellido | Nombre | Email | Telefono |
        <p>
      </div>
</aside>

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

    jqv('#form_alta_archivo_excel').validate({

        rules :{
                archivo  : {
                    required : true,
                    extension: "xls|xlsx|csv"
                }

        },
        messages : {
                archivo : {
                    required :  "Debe elegir un archivo de hoja de calculo(xls,xlsx o csv)",
                    extension: "Debe ser un archivo xls,xlsx o csv."
                }
        },
        invalidHandler: function(form, validator)
        {

            jqv('#form_alta_archivo_excel').find(":submit").removeAttr('disabled');
        }

    });
  });

</script>