<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>CRM | Customer Relationship Management </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    -->
    <link href="<?=base_url()?>assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
 
    <!-- Theme style -->
    <link href="<?=base_url()?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?=base_url()?>assets/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>assets/css/login.css" rel="stylesheet" type="text/css" />


  </head>
  <body class="login-page" style=" background-image: url('<?=base_url()?>assets/images/fondo_ucema2.png');  background-repeat: no-repeat;">
    <div class="login-box">
      <div class="login-logo">
        <img src="<?=base_url()?>assets/images/logo_crm.png" style="height:169px; widht:244px;">
      </div><!-- /.login-logo -->
      <div class="login-box-body">

        <p class="login-box-msg">Loguearse para iniciar sesion.</p>

        <form id="form_logueo" method="post">

            <div class="form-group has-feedback">

              <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuario"/>
              <span class="glyphicon glyphicon-user form-control-feedback"></span>

            </div>

            <div class="form-group has-feedback">

              <input type="password" id="clave" name="clave" class="form-control" placeholder="Password"/>
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>

            </div>

            <div class="row">

              <div class="col-xs-12">
                <button type="submit" class="btn btn-block btn-primary "> Ingresar <div id="cargando" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></div> </button>
              </div><!-- /.col -->

            </div>

        </form>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?=base_url()?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?=base_url()?>assets/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?=base_url()?>assets/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>

    <script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery-1.4.4.min.js"></script>
    <script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui-1.8.10.custom.min.js"></script>
    <script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validate.js" ></script>
    <script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/additional-methods.js" ></script>
    <script>
            var q = jQuery.noConflict();
    </script>

    <script language="javascript" type="text/javascript" >


      $(function(){

        $("#cargando").hide();
      });

      q(function(){

              q('#form_logueo').validate({

                  rules :{

                          usuario : {
                              required : true
                          },
                          clave : {
                              required : true
                          }
                  },
                  messages : {

                          usuario : {
                              required : "Debe ingresar su usuario."
                          },

                          clave : {
                              required :  "Debe ingresar su clave."
                          }
                  },
                   submitHandler: function(form) {
                      // do other things for a valid form
                      //$("#btnAddProfile").prop('value', );
                      q('#cargando').show();
                      form.submit();

                  }

              });
      });



    </script>

    <script type="text/javascript">
        /*
        var intervalID = setInterval(function() {
            document.getElementById("usuario").value = '';
            document.getElementById("clave").value = '';
        }, 20);


        setTimeout(function() {
            clearInterval(intervalID);
        }, 5000);*/

    </script>

  </body>


</html>