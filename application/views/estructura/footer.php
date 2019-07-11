    </div>

      <footer class="main-footer"  >
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0
        </div>
        <strong>CRM UCEMA - Customer relationship management. 2016</strong>
      </footer>


    </div> 

    <!-- jQuery 2.1.4 -->
    <script src="<?=base_url()?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script type="text/javascript">


     // Desaparece el mensaje de los reusltados de acciones
    $(function()
    {
        $( ".mensaje_resultado" ).delay(2000).fadeOut( 1000, function() {
            $( ".mensaje_resultado" ).remove();
        });

    });

    // Activa los button SUBMIT

    $(document).ready(function(){
        $(':input[type="submit"]').prop('disabled', false);
        $(':button').prop('disabled', false);
    });

    // Desactiva los SUBMIT una vez apretado

    $( "form" ).submit(function( event ) {

        $(this).find(":submit").attr('disabled','disabled');
    });

    $(document).ajaxStart(function() { Pace.restart(); });

    </script>


    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?=base_url()?>assets/js/bootstrap.min.js" type="text/javascript"></script>

    <!-- AdminLTE App -->
    <script src="<?=base_url()?>assets/dist/js/app.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/plugins/pace/pace.js"></script>
 
  </body>
</html>