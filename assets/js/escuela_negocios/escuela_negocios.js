var jq = jQuery.noConflict();

 // Ver desplegable empresas
jq('#empresa').autocomplete({

          minLength: 3,
          change: function( event, ui ) {
             //jq('#empresa_manual').hide();
          },
          source: CI_ROOT+'index.php/consulta/ajax_empresa',
          select: function(event, ui)
          {   
              console.log(ui);
              jq("#div_empresa_sigeu").show();
 
              jq("#form_alta_referente #id_empresa").val(ui.item.id_empresa);
              jq("#form_alta_referente #empresa_sigeu").val(ui.item.value);

              jq('#form_alta_referente #empresa').attr('readonly', true);
  
              //return false; // Importante, si esto no borra el input

          },
          response: function(event, ui) {

            //alert(ui.content.length);

            if (ui.content.length === 0)
            {
                 jq('#sin_resultado_empresa').show();
                 //jq('#educacion').attr('readonly', true);

            }
            else
            {
                 jq('#sin_resultado_empresa').hide();
            }

          }

  });


  // Ocultar empresa sigeu
  function ocultar_empresa_sigeu()
  {
      jq('#form_alta_empresa_referente #sin_resultado_empresa').hide();
      jq('#form_alta_empresa_referente #div_empresa_sigeu').hide();

      jq('#form_alta_empresa_referente #id_empresa').val("");
      jq('#form_alta_empresa_referente #empresa_sigeu').val("");

      jq('#form_alta_empresa_referente #empresa').val("");
      jq('#form_alta_empresa_referente #empresa').attr('readonly', false);
  }
