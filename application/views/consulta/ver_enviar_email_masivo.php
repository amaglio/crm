<link   type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" /> <link   type="text/css" href="<?php echo base_url(); ?>assets/css/consulta/consulta.css" rel="stylesheet" />
<link   type="text/css" href="<?php echo base_url(); ?>assets/css/consulta/ver_enviar_email_masivo.css" rel="stylesheet" />

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <section class="content-header">
      <h4>
         <i class="fa fa-address-card" aria-hidden="true"></i>  <a href="<?=base_url()?>index.php/home/"> Consultas  / Enviar Email </a>
      </h4>
    </section>
    <div class="panel-body">

          <form name="form_mis_consultas" id="form_mis_consultas" method="post" action="<?=base_url()?>index.php/consulta/enviar_email_masivo/" >
            <input type="hidden" id="url_referer" name="url_referer" value="<?=$url_referer?>">
            <div class="box-body">


                <?php   for ($i=0; $i < count($personas_consulta) ; $i++): ?>

                    <div id="<?=$i?>" class="callout callout-success">

                      <a target="_blank" href="<?=base_url()?>index.php/contacto/ver_contacto/<?=$personas_consulta[$i]['informacion_persona']['datos_usuario']->ID_CRM_PERSONA?>">

                      <?php   echo $personas_consulta[$i]['informacion_persona']['datos_usuario']->NOMBRE.", ". $personas_consulta[$i]['informacion_persona']['datos_usuario']->NOMBRE; ?>

                      <?php   foreach ( $personas_consulta[$i]['informacion_persona']['datos_emails'] as $row) : ?>

                          < <?=$row['EMAIL']?> >

                          <?php   $value =  $row['EMAIL']."[|]".$personas_consulta[$i]['id_consulta']; ?>

                          <?php   if(isset($personas_consulta[$i]['id_consulta_prg']))
                                $value .= "[|]".$personas_consulta[$i]['id_consulta_prg'];


                           ?>

                          <input type="hidden" name="email[]" id="email[]" value="<?=$value?>" >


                      <?php   endforeach; ?>

                      </a>

                        <a onclick="eliminar_email_envio(<?=$i?>)"> <i class="fa fa-window-close " aria-hidden="true"></i> </a>

                    </div>

                <?php   endfor; ?>

            </div>

            <div class="box-body email-select">
                <label for="apellidos"  class="col-sm-12 control-label">Seleccionar Email</label>
                <div class="col-sm-9">
                    <?php   $options = array(); ?>

                    <?php   $options[''] = 'Seleccionar email'; ?>

                    <?php   $options['-1'] = ' &#9658; En blanco '; ?>

                    <?php   foreach ($emails_plantillas->result() as $row):

                        $options[$row->ID_CRM_EMAIL_PLANTILLA] = "&#8226; ".utf8_encode($row->TITULO);

                        endforeach; ?>


                    <?=form_dropdown('id_crm_email_plantilla', $options, 0 , 'readonly="readonly" class="form-control" id="id_crm_email_plantilla"' )?>
                </div>
                <?=form_error('id_crm_email_plantilla'); ?>
                <br>
            </div>


            <div class="load-mail-wrapper clearfix">

              <div id="div_loadding_cargar_email">
                <img src="<?=base_url()?>assets/images/loading_azul.gif" >
              </div>

              <div id="texto_email" >
              </div>

            </div>

          </form>

    </div>
</div>

<!-- jQuery 2.1.4 -->
<script src="<?=base_url()?>assets/js/jQuery-2.1.4.min.js"></script>

<!-- CK Editor -->
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?=base_url()?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script>

  $(function () {
    $('select').change(function(){

      if( $(this).val() != "" )
      {
        $("#div_loadding_cargar_email").show();
        $('#texto_email').load('<?php echo site_url("consulta/ver_texto_email/")?>'+'/'+$(this).val(), function() {
          $("#div_loadding_cargar_email").hide();
        });
      }
      else
      {
        $('#texto_email').empty();
      }

    });

  });


  function eliminar_email_envio(id_div){
    $( "#"+id_div ).remove();
  }

</script>
