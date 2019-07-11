<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<label for="apellidos"  class="col-sm-12 control-label">Asunto</label>
<input type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto" >

<br>
<textarea name="mensaje_email" class="email_blank_textarea" rows="100" cols="80">

</textarea>

<div class="col-xs-12 send-mail">
	<button type="submit" class="btn btn-primary btn-block btn-flat"> Enviar Email    </button>
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