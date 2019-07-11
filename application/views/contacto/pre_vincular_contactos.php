<link type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url(); ?>assets/css/contacto/contacto.css" rel="stylesheet" />

<div class="content-wrapper">

    <section class="content-header">
        <h4>
          <i class="fa fa-link" aria-hidden="true"></i> Previncular personas
        </h4>
    </section>
    <div class="panel-body">

      <div class="callout callout-informativo">
        <h4>Vincula una persona de CRM y una de SIGEU</h4>
        <p>
            Al vincular personas, una persona de CRM pasa a ser la misma persona que esta en SIGUE. Esta situacion se puede dar con personas que no pasaron por el CRM (cargados directamente en SIGEU) o por error humano.
            Al vincular , la persona CRM tendra sus datos personas de <strong>SOLO LECTURA, los cambios en emails, telefonos o datos personales, se deben realizar desde SIGEU</strong>. <br>
            <span class="warn-operation"> La operación no puede deshacerse. </span>
        <p>
      </div>

      <form name="form_vincular_contactos" id="form_vincular_contactos" method="post" action="<?=base_url()?>index.php/contacto/vincular_contactos">

      <input type="hidden" id="id_usuario_1" name="id_usuario_1" value="<?=$contactos[0]['informacion_personal']->ORIGEN."-".$contactos[0]['informacion_personal']->ID_USUARIO?>">
      <input type="hidden" id="id_usuario_2" name="id_usuario_2" value="<?=$contactos[1]['informacion_personal']->ORIGEN."-".$contactos[1]['informacion_personal']->ID_USUARIO?>">

      <div class="col-md-6 left-pane">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Persona de <?=$contactos[0]['informacion_personal']->ORIGEN?> </h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body ">

                <div class="form-group">
                  <label for="id_crm" class="col-sm-3 control-label">Id <?=$contactos[0]['informacion_personal']->ORIGEN?> </label>
                  <div class="col-sm-8">
                    <input value="<?=$contactos[0]['informacion_personal']->ID_USUARIO?>" type="text" class="form-control pull-right calendario" id="nombre" readonly="readonly">
                  </div>
                </div>

                <div class="form-group">
                  <label for="id_crm" class="col-sm-3 control-label">Nombre</label>
                  <div class="col-sm-8">
                    <input value="<?=utf8_encode($contactos[0]['informacion_personal']->NOMBRE)?>" type="text" class="form-control pull-right calendario" id="nombre" readonly="readonly">
                  </div>
                </div>

                <div class="form-group">
                  <label for="id_crm" class="col-sm-3 control-label">Apellido</label>
                  <div class="col-sm-8">
                    <input value="<?=utf8_encode($contactos[0]['informacion_personal']->APELLIDO)?>" type="text" class="form-control pull-right calendario" id="nombre" readonly="readonly">
                  </div>
                </div>

                <div class="form-group">
                  <label for="id_crm" class="col-sm-3 control-label">Documento</label>
                  <div class="col-sm-8">

                    <?php   if( count($contactos[0]['documentos'])  > 0): ?>

                            <?php   foreach ($contactos[0]['documentos'] as $row): ?>

                                <input value="<?="[".$row['TIPO']."] ".$row['NUMERO']?>" type="text" class="form-control pull-right calendario" id="nombre" readonly="readonly">

                            <?php   endforeach; ?>
                    <?php   else: ?>
                        <input   type="text" class="form-control pull-right calendario" id="nombre" readonly="readonly">

                    <?php   endif; ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="id_crm" class="col-sm-3 control-label">Emails</label>
                  <div class="col-sm-8">
                    <input value="<?=utf8_encode($contactos[0]['informacion_personal']->EMAILS)?>" type="text" class="form-control pull-right calendario" id="nombre" readonly="readonly">
                  </div>
                </div>

                <div class="form-group">
                  <label for="id_crm" class="col-sm-3 control-label">Telefonos</label>
                  <div class="col-sm-8">
                    <input value="<?=$contactos[0]['informacion_personal']->TELEFONOS?>" type="text" class="form-control pull-right calendario" id="nombre" readonly="readonly">
                  </div>
                </div>

            </div>

          </div>
      </div>

      <div class="col-md-6 right-pane">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">Persona de <?=$contactos[1]['informacion_personal']->ORIGEN?> </h3>

          </div>
          <!-- /.box-header -->
          <div class="box-body ">

              <div class="form-group">
                <label for="id_crm" class="col-sm-3 control-label">Id <?=$contactos[1]['informacion_personal']->ORIGEN?> </label>
                <div class="col-sm-8">
                  <input value="<?=$contactos[1]['informacion_personal']->ID_USUARIO?>" type="text" class="form-control pull-right calendario" id="nombre" readonly="readonly">
                </div>
              </div>

              <div class="form-group">
                <label for="id_crm" class="col-sm-3 control-label">Nombre</label>
                <div class="col-sm-8">
                  <input value="<?=utf8_encode($contactos[1]['informacion_personal']->NOMBRE)?>" type="text" class="form-control pull-right calendario" id="nombre" readonly="readonly">
                </div>
              </div>

              <div class="form-group">
                <label for="id_crm" class="col-sm-3 control-label">Apellido</label>
                <div class="col-sm-8">
                  <input value="<?=utf8_encode($contactos[1]['informacion_personal']->APELLIDO)?>" type="text" class="form-control pull-right calendario" id="nombre" readonly="readonly">
                </div>
              </div>

              <div class="form-group">
                <label for="id_crm" class="col-sm-3 control-label">Documento</label>
                <div class="col-sm-8">

                    <?php   if( count($contactos[1]['documentos']) > 0): ?>

                          <?php   foreach ($contactos[1]['documentos']  as $row): ?>

                                <input value="<?="[".$row['TIPO']."] ".$row['NUMERO']?>" type="text" class="form-control pull-right calendario" id="nombre" readonly="readonly">

                          <?php   endforeach; ?>
                    <?php   else: ?>

                          <input   type="text" class="form-control pull-right calendario" id="nombre" readonly="readonly">

                    <?php   endif; ?>



                </div>
              </div>

              <div class="form-group">
                <label for="id_crm" class="col-sm-3 control-label">Emails</label>
                <div class="col-sm-8">
                  <input value="<?=utf8_encode($contactos[1]['informacion_personal']->EMAILS)?>" type="text" class="form-control pull-right calendario" id="nombre" readonly="readonly">
                </div>
              </div>

              <div class="form-group">
                <label for="id_crm" class="col-sm-3 control-label">Telefonos</label>
                <div class="col-sm-8">
                  <input value="<?=utf8_encode($contactos[1]['informacion_personal']->TELEFONOS)?>" type="text" class="form-control pull-right calendario" id="nombre" readonly="readonly">
                </div>
              </div>

          </div>

        </div>
      </div>

      <button type="submit" class="btn btn-block btn-primary" > <i class="fa fa-link" aria-hidden="true"></i> Vincular </button>

      </form>

    </div>
</div>


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

   jqv('#form_vincular_contactos').validate({

        rules :{
                apellido  : {
                    required : true
                },
                nombre  : {
                    required : true
                }
        },
        messages : {
                apellido : {
                    required :  "Debe seleccionar algun apellido."
                },
                  nombre  : {
                    required :  "Debe seleccionar algun nombre."
                }
        },
        submitHandler: function (form)
        {
          if (confirm('Seguro desea vincular los contacto ?'))
          {
              form.submit();
          }
        }

    });
  });

</script>
