<link type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url(); ?>assets/css/contacto/contacto.css" rel="stylesheet" />

<div class="content-wrapper">

    <section class="content-header">
        <h4>
          <i class="fa fa-code-fork" aria-hidden="true"></i> Prefusionar contactos
        </h4>
    </section>
    <div class="panel-body">

        <div class="col-md-12">

          <div class="callout callout-informativo">
            <h4>Fusiona las personas duplicadas!</h4>
            <p>
                Para fusionar contactos, debe seleccionar el ID, nombre, apellido, emails y teléfonos que deben permanecer. Al fusionar contactos, la información no seleccionada, será eliminada.
                Por otro lado, las consultas realizadas por ambas personas, seran reasignadas a la persona resultante. <br>
                <span class="warn-operation"> La operación no puede deshacerse. </span>
            <p>
          </div>

          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Elegí los datos de la persona resultante</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body ">

              <form name="form_fusionar_contactos" id="form_fusionar_contactos" method="post" action="<?=base_url()?>index.php/contacto/fusionar_contactos">

                <input type="hidden" name="id_usuario_1"  value="<?=$contactos[0]['informacion_personal']->ID_USUARIO?>">
                <input type="hidden" name="id_usuario_2"  value="<?=$contactos[1]['informacion_personal']->ID_USUARIO?>">

                <div class="form-group col-md-1"  >
                  <label for="exampleInputEmail1">ID</label>
                  <div >
                    <input type="radio" name="id_usuario" value="<?=$contactos[0]['informacion_personal']->ID_USUARIO?>" checked="checked"> <?=$contactos[0]['informacion_personal']->ID_USUARIO?>
                  </div>
                  <div>
                    <input type="radio" name="id_usuario" value="<?=$contactos[1]['informacion_personal']->ID_USUARIO?>"> <?=$contactos[1]['informacion_personal']->ID_USUARIO?>
                  </div>
                </div>

                <div class="form-group col-md-2">
                  <label >Apellido</label>
                  <div>
                    <input type="radio" name="apellido" id="apellido" value="<?=utf8_encode($contactos[0]['informacion_personal']->APELLIDO)?>"> <?=utf8_encode($contactos[0]['informacion_personal']->APELLIDO)?>
                  </div>
                  <div >
                    <input type="radio" name="apellido" id="apellido" value="<?=utf8_encode($contactos[1]['informacion_personal']->APELLIDO)?>"> <?=utf8_encode($contactos[1]['informacion_personal']->APELLIDO)?>
                  </div>
                </div>

                <div class="form-group col-md-2">
                  <label for="exampleInputEmail1">Nombre</label>
                  <div>
                    <input type="radio" name="nombre" id="nombre" value="<?=utf8_encode($contactos[0]['informacion_personal']->NOMBRE)?>"> <?=utf8_encode($contactos[0]['informacion_personal']->NOMBRE)?>
                  </div>
                  <div  >
                    <input type="radio" name="nombre" id="nombre" value="<?=utf8_encode($contactos[1]['informacion_personal']->NOMBRE)?>"> <?=utf8_encode($contactos[1]['informacion_personal']->NOMBRE)?>
                  </div>
                </div>

                <div class="form-group col-md-2">
                  <label for="exampleInputEmail1">Documentos</label>
                  <div  >

                    <?php   foreach( $contactos[0]['documentos']  as $row ): ?>

                            <input type="checkbox" id="documento[]" name="documento[]" value="<?=$row['ID_TIPO_DOCUMENTO']."-".$row['NUMERO']?>" > <?="(".$row->TIPO.") ".$row->NUMERO?><br>

                    <?php   endforeach; ?>

                  </div>

                  <div >

                    <?php   foreach( $contactos[1]['documentos'] as $row ): ?>

                            <input type="checkbox" id="documento[]" name="documento[]" value="<?=$row['ID_TIPO_DOCUMENTO']."-".$row['NUMERO']?>" > <?="(".$row->TIPO.") ".$row->NUMERO?><br>

                    <?php   endforeach; ?>

                  </div>

                </div>



                <div class="form-group col-md-3">
                  <label for="exampleInputEmail1">Emails</label>
                  <div  >

                    <?php   foreach( $contactos[0]['emails'] as $row ): ?>

                            <input type="checkbox" id="email[]" name="email[]" value="<?=utf8_encode($row['EMAIL'])?>" > <?=utf8_encode($row['EMAIL'])?><br>

                    <?php   endforeach; ?>

                  </div>

                  <div >

                    <?php   foreach( $contactos[1]['emails']  as $row ): ?>

                            <input type="checkbox" id="email[]" name="email[]" value="<?=utf8_encode($row['EMAIL'])?>" > <?=utf8_encode($row['EMAIL'])?><br>

                    <?php   endforeach; ?>

                  </div>

                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Telefonos</label>
                  <div  >

                    <?php   foreach( $contactos[0]['telefonos']  as $row ): ?>

                            <input type="checkbox" id="telefono[]" name="telefono[]" value="<?=$row['TELEFONO']?>" > <?=$row['TELEFONO']?><br>

                    <?php   endforeach; ?>

                  </div>

                  <div  >

                    <?php   foreach( $contactos[1]['telefonos']  as $row ): ?>

                            <input type="checkbox" id="telefono[]" name="telefono[]" value="<?=$row['TELEFONO']?>" > <?=$row['TELEFONO']?> <br>

                    <?php   endforeach; ?>

                  </div>

                </div>

                <div class="form-group">
                    <button class="btn btn-block btn-primary" type="submit"> <i class="fa fa-code-fork" aria-hidden="true"></i> Fusionar</button>
                </div>
              </form>
            </div>

          </div>
        </div>



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

   jqv('#form_fusionar_contactos').validate({

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
          if (confirm('Seguro desea fusionar los contacto ?'))
          {
              form.submit();
          }
        },
        invalidHandler: function(form, validator) {

            jqv('#form_fusionar_contactos').find(":submit").removeAttr('disabled');
        }

    });
  });

</script>
