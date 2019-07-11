var jq = jQuery.noConflict();

jq(function() { 

    jq(document).ready(function(){
        

        jq('#eventos_calendario_global').fullCalendar({

            // Size
            aspectRatio: 2,
            height: 'auto',

            dayClick: function(date, jsEvent, view) {
        
               jq('#fecha_accion').val(date.format()); 
               jq('#modal_alta_accion_empresa').modal('show');
            },
 

            events: function(start, end, timezone, callback) {
              jq.ajax({
                url: CI_ROOT+'index.php/escuela_negocios/get_todas_acciones',
                dataType: 'JSON', 
                success: function(doc) 
                {
                  var events = [];

                  jq(doc).each(function(index, element) {
                                     
                    events.push({
                      
                      id: element.id,
                      title: element.title,
                      start: element.start,
                      constraint: element.constraint    

                    }); 
                    
                  });
                  
                  callback(events);

                }
              });
            },
            
            header: { center: 'month,agendaWeek,agendaDay' },

            eventClick: function(calEvent, jsEvent, view) {

              //alert('Event: ' + calEvent.title);
              /*
              jq('#modal_ver_accion #descripcion').val(calEvent.title);
              jq('#modal_ver_accion #id_crm_accion').val(calEvent.id);
              jq('#modal_ver_accion #eliminar_accion').val(calEvent.id);
              
              if( calEvent.constraint == 1)
                  jq('#modal_ver_accion #alarma').prop( "checked", true );
              else
                  jq('#modal_ver_accion #alarma').prop( "checked", false );*/
              
              jq('#modal_ver_accion #nombre').val(calEvent.title);
              jq('#modal_ver_accion #descripcion').val(calEvent.constraint);
              jq('#modal_ver_accion #ir_referente_accion').attr('href', CI_ROOT+'index.php/escuela_negocios/ver_referente/'+calEvent.id );
              jq('#modal_ver_accion').modal('show');

            }

        });

       
    });
});