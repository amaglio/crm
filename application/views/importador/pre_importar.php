<link type="text/css" href="<?php echo base_url(); ?>assets/css/dark-hive/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url(); ?>assets/css/importador/pre_importar.css" rel="stylesheet" />

<div class="content-wrapper">

    <section class="content-header">
        <h4>
          <i class="fa fa-globe" aria-hidden="true"></i> Importador de consultas web / Pre importador de contactos web
        </h4>
    </section>
    <div class="panel-body">

         <div class="col-xs-4">
          <div class="info-box">
              <span class="info-box-icon bg-green"><i class="fa fa-user" aria-hidden="true"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"> <strong>USUARIO NUEVO</strong></span>
                <span> <small>No se encontro personas con datos similares.</small><br>
                        <strong> Importar la persona y la consulta como nuevas.</strong>
                </span>
              </div>
          </div>
        </div>

        <div class="col-xs-4">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-user-plus" aria-hidden="true"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"> <strong>USUARIO CON COINCIDENCIAS</strong></span>
              <span> <small>Hay personas con datos similares, pero no es ninguno de ellos.</small><br>
                        <strong>Ignorar el listado e importar la persona y la consulta como nuevas.</strong>
              </span>
            </div>
          </div>
        </div>

        <div class="col-xs-4">
          <div class="info-box">
             <span class="info-box-icon bg-red"><i class="fa fa-users" aria-hidden="true"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"> <strong>USUARIO CON COINCIDENCIAS</strong></span>
               <span> <small>Hay personas con datos similares y es uno del listado.</small><br>
                        <strong>Utilizar el contacto e importar la consulta como nueva.</strong>
              </span>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Contactos a Importar</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body ">

              <form id="tabla_importar" name="tabla_importar" method="post" action="<?=base_url()?>index.php/importador/importar"  >

              <ul class="products-list product-list-in-box">

                  <?php  for( $i=0; $i < count($contactos_a_importar); $i++ ):

                      unset($datos);
                      unset($datos_json);
                  ?>
                        <li class="item">

                              <?php  if(count($contactos_a_importar[$i]['repetidos']) == 0 ):  // USUARIO SIN COINCIDENCIAS

                                  $datos['id_contacto_web'] = $contactos_a_importar[$i]['usuario_buscado']->ID_CONTACTO_WEB;
                                  $datos['tipo'] = 'sin_coincidencias';
                                  $datos_json = json_encode($datos);
                                  $datos_json = str_replace("\"", "&", $datos_json);

                                  ?>

                                  <div class="callout">

                                      <table class="table no-coincidences">
                                          <tr>
                                              <th><span class="info-box-icon bg-green tabla"><i class="fa fa-user" aria-hidden="true"></i></span></th>
                                              <th class="contact-column"><?=utf8_encode($contactos_a_importar[$i]['usuario_buscado']->APELLIDO)?></th>
                                              <th class="contact-column"><?=utf8_encode($contactos_a_importar[$i]['usuario_buscado']->NOMBRE)?></th>
                                              <th class="contact-column"><?=$contactos_a_importar[$i]['usuario_buscado']->EMAIL?></th>
                                              <th class="contact-column"><?=$contactos_a_importar[$i]['usuario_buscado']->TELEFONO?></th>

                                              <?php if( $contactos_a_importar[$i]['usuario_buscado']->ID_EVENTO ): ?>

                                                    <th class="contact-column"><?=$contactos_a_importar[$i]['usuario_buscado']->ID_EVENTO?> <i class="fa fa-ticket"></i></th>

                                              <?php endif;  ?>

                                              <th>
                                                    <input type="radio" class="datos_persona"
                                                           value="<?=$datos_json?>"
                                                           id="contacto_<?=$contactos_a_importar[$i]['usuario_buscado']->ID_CONTACTO_WEB?>"
                                                           name="contacto_<?=$contactos_a_importar[$i]['usuario_buscado']->ID_CONTACTO_WEB?>" >
                                              </th>
                                          </tr>
                                      </table>
                                  </div>

                              <?php  else: // USUARIO CON COINCIDENCIAS

                                  //array_unique($contactos_a_importar[$i]['repetidos']);

                                  $datos['id_contacto_web'] = $contactos_a_importar[$i]['usuario_buscado']->ID_CONTACTO_WEB;
                                  $datos['tipo'] = 'con_coincidencias';
                                  $datos['accion'] = 'nuevo';
                                  $datos_json = json_encode($datos);
                                  $datos_json = str_replace("\"", "&", $datos_json);

                              ?>

                                   <div class="callout">
                                    <table class="table coincidences">
                                           <tr>
                                              <th><span class="info-box-icon bg-aqua tabla"><i class="fa fa-user-plus" aria-hidden="true"></i></span></th>
                                              <th class="contact-column"><?=ucfirst(utf8_encode($contactos_a_importar[$i]['usuario_buscado']->APELLIDO))?></th>
                                              <th class="contact-column"><?=ucfirst(utf8_encode($contactos_a_importar[$i]['usuario_buscado']->NOMBRE))?></th>
                                              <th class="contact-column"><?=$contactos_a_importar[$i]['usuario_buscado']->EMAIL?></th>
                                              <th class="contact-column"><?=$contactos_a_importar[$i]['usuario_buscado']->TELEFONO?></th>
                                              <?php if( $contactos_a_importar[$i]['usuario_buscado']->ID_EVENTO ): ?>

                                              <th class="contact-column"><?=$contactos_a_importar[$i]['usuario_buscado']->ID_EVENTO?> <i class="fa fa-ticket"></i></th>

                                              <?php endif;  ?>
                                              <th class="contact-source" colspan="2"></th>
                                              <th>
                                                  <input type="radio"  value="<?=$datos_json?>"  class="datos_persona"
                                                         id="contacto_<?=$contactos_a_importar[$i]['usuario_buscado']->ID_CONTACTO_WEB?>"
                                                         name="contacto_<?=$contactos_a_importar[$i]['usuario_buscado']->ID_CONTACTO_WEB?>">
                                            </th>
                                          </tr>


                                     <?php  for ($k=0; $k < count($contactos_a_importar[$i]['repetidos']); $k++):

                                          $datos['accion'] = 'fusionar';

                                          //var_dump($contactos_a_importar[$i]['repetidos'][$k]['datos_usuario']);

                                          //var_dump($contactos_a_importar);

                                          $datos['origen'] = $contactos_a_importar[$i]['repetidos'][$k]['datos_usuario']->ORIGEN;
                                          $datos['id_usuario_coincidente'] = $contactos_a_importar[$i]['repetidos'][$k]['datos_usuario']->ID_USUARIO;
                                          $datos_json = json_encode($datos);
                                          $datos_json = str_replace("\"", "&", $datos_json);
                                     ?>
                                            <tr>
                                                <td><span class="info-box-icon bg-red tabla"><i class="fa fa-users" aria-hidden="true"></i></span></th>
                                                <td><?=$contactos_a_importar[$i]['repetidos'][$k]['imagen_usuario'].$contactos_a_importar[$i]['repetidos'][$k]['datos_usuario']->ID_USUARIO;?></td>

                                                <td <?php // if($contactos_a_importar[$i]['repetidos'][$k]['coincidencias']->MISMO_NOMBRE == 'nombre') echo "style='color:red'"; ?>>
                                                      <?=utf8_encode($contactos_a_importar[$i]['repetidos'][$k]['datos_usuario']->APELLIDO);?>
                                                </td>
                                                <td <?php // if($contactos_a_importar[$i]['repetidos'][$k]['coincidencias']->MISMO_NOMBRE == 'nombre') echo "style='color:red'"; ?>>
                                                      <?=utf8_encode($contactos_a_importar[$i]['repetidos'][$k]['datos_usuario']->NOMBRE);?>
                                                </td>
                                                <td <?php // if($contactos_a_importar[$i]['repetidos'][$k]['coincidencias']->MISMO_EMAIL == 'email') echo "style='color:red'"; ?>>
                                                    <?=utf8_encode($contactos_a_importar[$i]['repetidos'][$k]['datos_usuario']->EMAILS);?>
                                                </td>
                                                <td <?php // if($contactos_a_importar[$i]['repetidos'][$k]['coincidencias']->MISMO_TELEFONO == 'telefono') echo "style='color:red'"; ?>>
                                                      <?=$contactos_a_importar[$i]['repetidos'][$k]['datos_usuario']->TELEFONOS;?>
                                                </td>
                                                <td><?=$contactos_a_importar[$i]['repetidos'][$k]['datos_usuario']->ORIGEN;?></td>
                                                <td>
                                                    <input type="radio" class="datos_persona"
                                                           value="<?=$datos_json?>"
                                                           id="contacto_<?=$contactos_a_importar[$i]['usuario_buscado']->ID_CONTACTO_WEB?>"
                                                           name="contacto_<?=$contactos_a_importar[$i]['usuario_buscado']->ID_CONTACTO_WEB?>">
                                                </td>

                                            </tr>

                                      <?php  endfor; ?>

                                    </table>



                                   </div>

                              <?php  endif; ?>

                        </li>


                  <?php  endfor; ?>
              </ul>

              <input type="submit" class="btn btn-primary" value="Continuar">

              </form>

            </div>

          </div>
        </div>


    </div>
</div>

<script src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript" ></script>


<!-- Validaciones -->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.10.custom.min.js"></script>

<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js" ></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js" ></script>

<script>
var jq_va = jQuery.noConflict();
</script>

<script type="text/javascript">

    jq_va(function(){

        jq_va.validator.addClassRules('datos_persona', {
            required: true  
        });

        jq_va('#tabla_importar').validate({
          invalidHandler: function(form, validator) {

                    jq_va('#tabla_importar').find(":submit").removeAttr('disabled');
                }
        });
    });


</script>
