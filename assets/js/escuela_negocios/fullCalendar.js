var jq = jQuery.noConflict();

jq(function() {      

  
        /*var eventos = jq('#eventos_calendario').val();
        eventos = eventos.split("\'").join("\"");  
        console.log(eventos);

        //var dates = '[{"title": "event1", "start": "2019-02-10"},{"title": "event2","start": "2019-02-18"}]';
        var dates;
        console.log(dates);
        dates = JSON.parse(eventos);*/


        var id_crm_persona_empresa = jq('#id_crm_persona_empresa').val();
        var id_crm_persona = jq('#id_crm_persona').val();
        var id_empresa = jq('#id_empresa').val();

 
        jq('#eventos_calendario_referente').fullCalendar({

            // Size
            aspectRatio: 4,
            height: 'auto',

            
            dayClick: function(date, jsEvent, view) {
                
                jq('#fecha_accion').val(date.format()); 
                jq('#descripcion').val('');
                jq('#alarma').attr('checked',false);
                jq('#descripcion').attr('disabled',false);
                jq('#alarma').attr('disabled',false);
                jq('#modal_alta_accion_empresa').modal('show');
              
                                

                /*jq('#modal_alta_accion_empresa').on('show.bs.modal', function (event) {


                });*/

            },
            

            //events: dates,
            events: function(start, end, timezone, callback) {
              jq.ajax({
                url: CI_ROOT+'index.php/escuela_negocios/get_acciones_referente_empresa',
                dataType: 'JSON', 
                type: "POST",
                data: { id_crm_persona_empresa: id_crm_persona_empresa,  id_crm_persona: id_crm_persona,  id_empresa: id_empresa  },
                success: function(doc) 
                {
                  console.log(doc);

                  var events = [];

                  jq(doc).each(function(index, element) {
                                
                    events.push({
                      
                      id: element.id,
                      title: element.title,
                      start: element.start,
                      constraint: element.constraint,  
                      respuesta: element.respuesta

                    }); 
                    
                  });
                  
                  callback(events);

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) 
                {
                   alert("Alert");
                }
              });
            },

           
            eventRender: function(event, element) {

                var alarma;
                var respuesta_clase = ' ';

                if( event.constraint == 1)
                  alarma = '<i class="fa fa-bell fa-2x alarma_accion" ></i>';
                else
                  alarma = ' ';
                
                if(event.respuesta )
                  respuesta_clase = 'accion_finalizada';
                else
                  respuesta_clase = '';
                    

                return jq('<div><a class="fc-day-grid-event '+respuesta_clase+' fc-h-event fc-event fc-start fc-end"><div class="fc-content"><span class="fc-title"> '+ alarma + event.title + '</span> <br> </div></a></div>');

            },
            
            header: { center: 'month,agendaWeek,agendaDay' },

            eventClick: function(calEvent, jsEvent, view) {

              jq('#modal_modifica_accion_empresa #descripcion').val(calEvent.title);
              jq('#id_crm_accion').val(calEvent.id);
              jq('#modal_modifica_accion_empresa #eliminar_accion').val(calEvent.id);
              
              if( calEvent.constraint == 1)
                  jq('#modal_modifica_accion_empresa #alarma').prop( "checked", true );
              else
                  jq('#modal_modifica_accion_empresa #alarma').prop( "checked", false );

              if( calEvent.respuesta)
              {
                  jq('#footer-acciones').hide();
                  jq('#div_ver_resultado_alarma').show();
                  jq('#div_ver_resultado_alarma').append(  calEvent.respuesta );
                  jq('#btn_finalizar_alarma').hide();
              }
              else
              {
                  jq('#footer-acciones').show();
                  jq('#div_ver_resultado_alarma').hide();
                  jq('#div_ver_resultado_alarma').html('');
              }

              jq('#modal_modifica_accion_empresa').modal('show');

            } 

        }); 
       

   
}); 