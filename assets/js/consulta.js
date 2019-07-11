q(document).ready(function() { 

    q('#universidades_convenios').dataTable({
                "paging":   true,
                "ordering": true,
                "info":     true,
                "bFilter": true,
                "language": {
                    "lengthMenu": "Mostrando _MENU_ universidades por pagina.",
                    "zeroRecords": "Ninguna postulacion fue encontrada.",
                    "info": "<b> Mostrando pagina _PAGE_ de _PAGES_ </b>",
                    "infoEmpty": "Ninguna postulacion disponible",
                    "infoFiltered": "(Filtrado de _MAX_ universidades totales)",
                    "sSearch": " Buscar    ",
                    "oPaginate": {
                                    "sNext": "Pag. sig.",
                                    "sPrevious": "Pag. ant."
                                  }
                }

            });
} );
 

f(document).ready(function(){ 

      f('#informacion_a_recibir').multiselect({
        
                  nonSelectedText: 'Selecciona la/las carreras',
                  nSelectedText: 'Seleccionados',
                  allSelectedText: 'Todos seleccionados',
                  buttonWidth: '220px',
                  numberDisplayed: 1,
                  includeSelectAllOption: true,
                  selectAllText: 'Selecciona Todas!'
        
      });

});

jq_va(function(){

        jq_va('#profesores_form').validate({

            rules :{

                    profesor : {
                        required : true
                    },
                    id_usuario: {
                        required : true
                    }
            },
            messages : {

                    profesor : {
                        required : "Debe ingresar el alumno."
                    },
                    id_usuario: {
                        required : "Debe seleccionar un alumno de la lista."
                    }
            },
            submitHandler: function(form) {


                jq("#div_loadding_aceptar_busqueda").show();

                if ( jq('input[name="id_usuario"]').val() != "" ){ // si eligio al usuario del listado
                    form.submit();
                }
                else // si tipio y no eligio al usuario
                {
                    alert( "El alumno debe ser seleccionado del listado" );
                }

                    
            }

        });    
});  


jq_sel(function () {
 

    jq_sel('#programas_grado').multiselect({
    
              nonSelectedText: 'Selecciona la/las carreras de GRADO',
              nSelectedText: 'Seleccionados',
              allSelectedText: 'Todos seleccionados',
              buttonWidth: '100%',
              numberDisplayed: 1,
              includeSelectAllOption: true,
              selectAllText: 'Seleccionar todas'
    
    });

    jq_sel('#programas_posgrado').multiselect({
    
              nonSelectedText: 'Selecciona la/las carreras de POSGRADO',
              nSelectedText: 'Seleccionados',
              allSelectedText: 'Todos seleccionados',
              buttonWidth: '100%',
              numberDisplayed: 1,
              includeSelectAllOption: true,
              selectAllText: 'Seleccionar todas'
    
    });

    jq_sel('#programas_ejecutivos').multiselect({
    
              nonSelectedText: 'Selecciona el/los programas EJECUTIVOS',
              nSelectedText: 'Seleccionados',
              allSelectedText: 'Todos seleccionados',
              buttonWidth: '100%',
              numberDisplayed: 1,
              includeSelectAllOption: true,
              selectAllText: 'Seleccionar todas'
    
    });

});  


jq_sel('.calendario').datepicker({
  autoclose: true,
  format: 'dd/mm/yyyy'
});
 