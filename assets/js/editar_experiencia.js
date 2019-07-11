jg('#modal_editar_experiencia').on('show.bs.modal', function (event) {
        
    var cadena_json_correcta;
    var button = jg(event.relatedTarget);
    var array_json;



    var cadena_json_recibida = button.data('whatever');

    console.log("CADENA RECIBIDA: "+cadena_json_recibida);

    console.dir(cadena_json_recibida);

    cadena_json_correcta = cadena_json_recibida.replace(/&/g, "\"");

    console.dir(cadena_json_correcta);

    array_json = JSON.parse(cadena_json_correcta);

    var id_experiencia = array_json.id_experiencia;
    var id_tipo_experiencia = array_json.id_tipo_experiencia;
    var id_periodo = array_json.id_periodo;
    var titulo = array_json.titulo;
    //var vacantes_in = array_json.vacantes_in;
    //var vacantes_out = array_json.vacantes_out;
    var deadline = array_json.deadline;
    var mes_intercambio = array_json.mes_intercambio;
    var anio_intercambio = array_json.anio_intercambio;
    var duracion = array_json.duracion;
    //var periodo = array_json.periodo;
    var c_identificacion = array_json.c_identificacion;

    
    console.log("id_tipo_experiencia   "+id_tipo_experiencia);

    var modal = $(this)

    modal.find('#id_experiencia').val(id_experiencia);
    modal.find('#id_tipo_experiencia').val(id_tipo_experiencia);
    modal.find('#id_periodo').val(id_periodo);
    modal.find('#titulo').val(titulo);
    //modal.find('#vacantes_in').val(vacantes_in);
    //modal.find('#vacantes_out').val(vacantes_out);
    modal.find('#c_identificacion').val(c_identificacion);
    modal.find('#anio_intercambio').val(anio_intercambio);
    console.log("ANIO: "+array_json.anio_intercambio);
    console.log("ANIO2: "+anio_intercambio);

     // Fecha inicio
     /*
    var formattedDate = new Date(deadline);
    var d = ("0" + formattedDate.getDate()).slice(-2);
    var m = ('0'+(formattedDate.getMonth()+1)).slice(-2); 
    var a = formattedDate.getFullYear();
    deadline = a+"-"+m+"-"+d;
    modal.find('#deadline').val(deadline);*/

    // Fecha inicio
    /*
    var formattedDate = new Date(deadline);
    var d = ("0" + formattedDate.getDate()).slice(-2);
    var m = ('0'+(formattedDate.getMonth()+1)).slice(-2); 
    var a = formattedDate.getFullYear();
    //deadline = a+"-"+m+"-"+d;
    deadline = parseInt(d)+"-"+parseInt(m)+"-"+a;
    modal.find('#deadline').val(deadline);*/

    //date = new Date( '01/27/2016' );
    //var mes =formattedDate.getMonth() + 1;

    //var d = ("0" + deadline ).slice(-4);

    var d = deadline.slice(0,2);
    var m = deadline.slice(3,5);
    var a = deadline.slice(6,10);
 

    console.log("Dia: "+d);
    console.log("Mes: "+m);
    console.log("Anio: "+a);
    
    var fecha_formateada = d+"/"+m+"/"+a;

    var date = new Date( fecha_formateada )

    console.log("Fecha : "+date);

    var mes =date.getMonth();

    modal.find('#deadline').val(fecha_formateada);


    var mes_intercambio = ('0'+(mes_intercambio)).slice(-2); 
    modal.find('#mes_intercambio').val(mes_intercambio);
    
    modal.find('#duracion').val(duracion);


 
});


jg('#modal_editar_periodo').on('show.bs.modal', function (event) {
    
    console.log("modal_editar_periodo   ");

    var cadena_json_correcta;
    var button = jg(event.relatedTarget);
    var array_json;

    var cadena_json_recibida = button.data('whatever');

    console.dir(cadena_json_recibida);

    console.log("cadena_json_recibida   "+cadena_json_recibida);

    cadena_json_correcta = cadena_json_recibida.replace(/&/g, "\"");

    console.dir(cadena_json_correcta);

    array_json = JSON.parse(cadena_json_correcta);

    console.log("periodo   "+array_json.periodo);

    var ID_PERIODO_INTERCAMBIO = array_json.ID_PERIODO_INTERCAMBIO;
    var id_convenio = array_json.id_convenio;
    var vacantes_in = array_json.vacantes_in;
    var vacantes_out = array_json.vacantes_out;
    var periodo = array_json.periodo;
    var comentario = array_json.comentario;
    
 
    if( array_json.activo == 1)
    {
        //alert("aaa");
        $('#modal_editar_periodo input[type="checkbox"]').prop("checked",true);
    }


    var modal = $(this)

    modal.find('#ID_PERIODO_INTERCAMBIO').val(ID_PERIODO_INTERCAMBIO);
    modal.find('#vacantes_in').val(vacantes_in);
    modal.find('#vacantes_out').val(vacantes_out);
    modal.find('#comentario_periodo').val(comentario);
 
    var res = periodo.split("/");

    modal.find('#periodo_1').val(res[0]);
    modal.find('#periodo_2').val(res[1]);

 
});

jg('#modal_editar_periodo').on("hidden.bs.modal", function(){
    $('#modal_editar_periodo input[type="checkbox"]').prop("checked",false);
});