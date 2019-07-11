// Cargar modal EDITAR CONVENIO
jq('#modal_editar_convenio').on('show.bs.modal', function (event) {
        
    var cadena_json_correcta;
    var button = jq(event.relatedTarget);
    var array_json;

    var cadena_json_recibida = button.data('whatever');

    console.dir(cadena_json_recibida);

    cadena_json_correcta = cadena_json_recibida.replace(/&/g, "\"");

    console.dir(cadena_json_correcta);

    array_json = JSON.parse(cadena_json_correcta);

    var id_convenio = array_json.id_convenio;
    var id_universidad = array_json.id_universidad;
    var fecha_inicio = array_json.fecha_inicio;
    var fecha_fin = array_json.fecha_fin;
    var comentarios_replace = array_json.comentarios;
    
    console.log(id_convenio);

    var modal = $(this)

    modal.find('#id_convenio').val(id_convenio);
    modal.find('#id_universidad').val(id_universidad);

    // Fecha inicio
    var formattedDate = new Date(fecha_inicio);
    var d = ("0" + formattedDate.getDate()).slice(-2);
    var m = ('0'+(formattedDate.getMonth()+1)).slice(-2); 
    var a = formattedDate.getFullYear();
    fecha_inicio = a+"-"+m+"-"+d;
    modal.find('#fecha_inicio').val(fecha_inicio);

    // Fecha fin
    var formattedDate = new Date(fecha_fin);
    var d = ("0" + formattedDate.getDate()).slice(-2);
    var m = ('0'+(formattedDate.getMonth()+1)).slice(-2); 
    var a = formattedDate.getFullYear();
    fecha_fin = a+"-"+m+"-"+d;
    modal.find('#fecha_fin').val(fecha_fin);

    var comentario = comentarios_replace.replace("'","\"");
    modal.find('#comentario').val(comentario);
});

// Cargar modal EDITAR CONTACTO
jq('#modal_editar_contacto').on('show.bs.modal', function (event) {
        
    var cadena_json_correcta;
    var button = jq(event.relatedTarget);
    var array_json;

    var cadena_json_recibida = button.data('whatever');

    console.dir(cadena_json_recibida);

    cadena_json_correcta = cadena_json_recibida.replace(/&/g, "\"");

    console.dir(cadena_json_correcta);

    array_json = JSON.parse(cadena_json_correcta);

    var id_contacto_uni = array_json.id_contacto_uni;
    var apellido = array_json.apellido;
    var nombre = array_json.nombre;
    var email = array_json.email;
    var puesto = array_json.puesto;
    var telefono = array_json.telefono;
    var direccion_postal = array_json.direccion_postal;
    
    console.log(id_contacto_uni);

    var modal = $(this)

    modal.find('#id_contacto').val(id_contacto_uni);
    modal.find('#apellido').val(apellido);
    modal.find('#nombre').val(nombre);
    modal.find('#email').val(email);
    modal.find('#puesto').val(puesto);
    modal.find('#telefono').val(telefono);
    modal.find('#direccion_postal').val(direccion_postal);
    
    //alert(fecha_fin);
    // var comentario = comentarios_replace.replace(/&/g, " \"");
    // modal.find('#comentario').val(comentario);
});