jq_sel('.calendario').datepicker({
  autoclose: true,
  format: 'dd/mm/yyyy'
});
 

jq_sel(function () {
 

    jq_sel('#fechas_evento').multiselect({
    
              nonSelectedText: 'Seleccionar fecha/s donde asistira',
              nSelectedText: 'Seleccionados',
              allSelectedText: 'Todos seleccionados',
              buttonWidth: '100%',
              numberDisplayed: 1,
              includeSelectAllOption: true,
              selectAllText: 'Seleccionar todas'
    
    });

});  

