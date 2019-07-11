<?php  if($inscriptos_fecha->num_rows() > 0): ?>

    <form name="form_modifica_asistencia" id="form_modifica_asistencia"  method="POST"  action="<?=base_url()?>index.php/evento/modificar_asistencia_evento/"   >

    <input type="hidden" name="id_crm_evento" id="id_crm_evento" value="<?=$id_crm_evento?>">
    <input type="hidden" name="fecha" id="fecha" value="<?=$fecha?>">

    <table  class="table table-striped table-bordered" id="mis_consultas" cellspacing="0" width="100%">
        <thead>
            <tr class="" style="background-color: rgba(60, 141, 188, 0.47);">
                <th>Nombre</th>
                <th>Asistió</th>
            </tr>
        </thead>
        <tbody>

            <?php  foreach( $inscriptos_fecha->result() as $row ):

                $data = array(
                                'name'        => 'id_asistio[]',
                                'id'          => 'id_asistio'.$row->ID_CRM_PERSONA,
                                'value'       => $row->ID_CRM_PERSONA,
                                'style'       => 'form-control' ,
                                'class'       => 'check_contactenme'
                                );

                if($row->ASISTIO == 1)
                    $data['checked'] = TRUE;

                ?>

                <tr>
                    <td><?=$row->APELLIDOS.", ".$row->NOMBRES?> </td>
                    <td><?php  echo form_checkbox($data); ?></td>
                </tr>

            <?php    endforeach; ?>

        </tbody>
    </table>

    <div class="form-group col-sm-12 ">

        <input id="modificar" name="modificar" type="submit" class="btn btn-block btn-primary" value="Modificar"  />

    </div>

  </form>

<?php  else: ?>

    <div class="callout callout-danger">
        Aun no se han inscriptos para la fecha: <?=$fecha?>
    </div>

<?php  endif; ?>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.10.custom.min.js"></script>

<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js" ></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js" ></script>

<script>
var jq_va = jQuery.noConflict();
</script>


<script type="text/javascript">

    jq_va(function(){

            jq_va('#form_modifica_asistencia').validate({

                rules :{
                        'id_asistio[]'  : {
                            required : true
                        }
                },
                messages : {
                        'id_asistio[]' : {
                            required :  "Debe seleccionar algun asistente."
                        }
                },
                invalidHandler: function(form, validator) {

                    jq_va('#form_modifica_asistencia').find(":submit").removeAttr('disabled');
                }

            });
    });

</script>
