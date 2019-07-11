<input type="hidden" class="form-control" id="id_alumno_in" name="id_alumno_in" placeholder="id" value="<?=$info_email->ID_CRM_EMAIL_PLANTILLA?>">

<label for="apellidos"  class="col-sm-12 control-label">Asunto</label>
<input type="text" readonly="readonly"  class="form-control" id="asunto" name="asunto" placeholder="id" value="<?=$info_email->ASUNTO?>">

<br>

<input type="hidden" readonly="readonly" id="id_crm_email_plantilla_elegida" name="id_crm_email_plantilla_elegida" value="<?=$id_crm_email_plantilla_elegida?>">
<textarea name="mensaje_email" class="email_templ_textarea" rows="100" cols="150">

<?=$info_email->TEXTO?>
</textarea>

<div class="col-xs-12 send-mail">
	<button type="submit" class="btn btn-primary btn-block btn-flat"> Enviar Email </button>
</div>

<?=form_close()?>

<script>

	$(function () {

		CKEDITOR.replace( 'mensaje_email',
			{
					height: 500
			}
		);

	});

</script>
