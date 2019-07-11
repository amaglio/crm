var prueba;  
 

$( "#email" ).focusout(function()
{

    var email = $(this).val().trim();

    $.ajax({
            url: CI_ROOT+'index.php/escuela_negocios/existe_email_referente',
            data: { email: email },
            async: true,
            type: 'POST',
            dataType: 'JSON',
            success: function(data)
            {
              console.log(data);

              if(data.error == true)
              {
                prueba.resetForm();
                $('#modal_agregar_referente #nombre_encontrado').val(data.nombre);
                $('#modal_agregar_referente #apellido_encontrado').val(data.apellido);
                $('#modal_agregar_referente #id_crm_persona_encontrado').val(data.id_crm_persona);
                $('#modal_agregar_referente  #div_usuario_encontrado').show();

                $('#modal_agregar_referente  #nombre').prop( "disabled", true );
                $('#modal_agregar_referente  #apellido').prop( "disabled", true );
                $('#modal_agregar_referente  #email').prop( "disabled", true );
                $('#modal_agregar_referente  #telefono').prop( "disabled", true );

                //$('#form_alta_referente').find(":submit").prop( "disabled", true );

                if( data.es_referente )
                {
                    
                    $('#modal_agregar_referente  #usar_referente').attr('href', CI_ROOT+'index.php/escuela_negocios/ver_referente/'+data.id_crm_persona );
                    $('#modal_agregar_referente  #label_es_referente').show();
                    $('#modal_agregar_referente  #usar_referente').show();
                    $('#modal_agregar_referente  #agregar_referente').hide();
                    $('#modal_agregar_referente  #flag_es_referente').val("1");
                    $('#modal_agregar_referente  #flag_no_es_referente').val("0");
                }
                else
                {
                    $('#modal_agregar_referente  #usar_referente').hide();
                    $('#modal_agregar_referente  #agregar_referente').show();
                    $('#modal_agregar_referente  #flag_no_es_referente').val("1");
                    $('#modal_agregar_referente  #flag_es_referente').val("0");
                }

              }
            },
            error: function(x, status, error){
              alert(error);
            }
        });
});


// Cierra div email    

function cerrar_div_existe_email()
{ 
    $('#modal_agregar_referente #nombre').prop( "disabled", false );
    $('#modal_agregar_referente #apellido').prop( "disabled", false );
    $('#modal_agregar_referente #email').prop( "disabled", false );
    $('#modal_agregar_referente #telefono').prop( "disabled", false );

    $('#modal_agregar_referente #email').val('');
    $('#modal_agregar_referente #nombre_encontrado').val('');
    $('#modal_agregar_referente #apellido_encontrado').val('');
    $('#modal_agregar_referente #id_crm_persona_encontrado').val('');
    $('#modal_agregar_referente #div_usuario_encontrado').hide();

    $('#modal_agregar_referente #nombre').val('');
    $('#modal_agregar_referente #apellido').val('');
    $('#modal_agregar_referente #email').val('');
    $('#modal_agregar_referente #telefono').val('');

    $('#label_es_referente').hide();
    $('#form_alta_referente').find(":submit").removeAttr('disabled');

}


// Modal alta referente


$(function(){

    $('#modal_agregar_referente').on('show.bs.modal', function (event) {

        
        prueba.resetForm();
        $('#modal_agregar_referente #label_es_referente').hide();
        $('#modal_agregar_referente #nombre').prop( "disabled", false );
        $('#modal_agregar_referente #apellido').prop( "disabled", false );
        $('#modal_agregar_referente #email').prop( "disabled", false );
        $('#modal_agregar_referente #telefono').prop( "disabled", false );
     
        $('#modal_agregar_referente #empresa').prop( "disabled", false );
        $('#modal_agregar_referente #id_empresa').prop( "disabled", false );
        $('#modal_agregar_referente #empresa').prop('readonly', false);

        $('#modal_agregar_referente #nombre').val('');
        $('#modal_agregar_referente #apellido').val('');
        $('#modal_agregar_referente #email').val('');
        $('#modal_agregar_referente #telefono').val('');
        $('#modal_agregar_referente #empresa').val('');
        $('#modal_agregar_referente #cargo').val('');

        $('#modal_agregar_referente #nombre_encontrado').val('');
        $('#modal_agregar_referente #apellido_encontrado').val('');
        $('#modal_agregar_referente #id_crm_persona_encontrado').val('');
        $('#modal_agregar_referente #div_usuario_encontrado').hide();

        $('#modal_agregar_referente #div_empresa_sigeu').hide();     
        $('#modal_agregar_referente #id_empresa').val('');  
        $('#modal_agregar_referente #empresa_sigeu').val('');  

        $('#modal_agregar_referente').find(":submit").removeAttr('disabled');
             
    });

});


var jq = jQuery.noConflict();
 

// Validar alta referente 

prueba  = jq('#form_alta_referente').validate({ 
        onfocusout: false,
        rules :{

                nombre : {
                    required : true
                },
                apellido: {
                    required : true
                },
                email: { 
                    email : true
                } 

        },
        messages : {

                nombre : {
                    required : "Debe ingresar el nombre del referente."
                },
                apellido: {
                    required : "Debe ingresar el apellido del referente."
                },
                email: {

                    email : "El formato de email es incorrecto"
                } 
        },
        success: function(error){
             jq('#form_alta_referente').find(":submit").removeAttr('disabled');                          
        }

    });

