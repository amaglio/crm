jq(function(){

            jq('#form_crear_experiencia').validate({

                rules :{

                        id_tipo_experiencia : {
                            required : true
                        },
                        c_identificacion: {
                            required : true
                        }, 
                        duracion: {
                            digits: true
                        }
                },
                messages : {

                        id_tipo_experiencia : {
                            required : "Debe seleccionar el tipo de experiencia."
                        },
                        c_identificacion: {
                           digits: "Debe seleccionar de que tipo es la EI"
                        },
                        duracion: {
                           digits: "Debe ser un numero entero."
                        }
                } 
            });    
    });     

jq(function(){

        jq('#form_editar_experiencia').validate({

            rules :{

                    id_tipo_experiencia : {
                        required : true
                    },
                    duracion: {
                        digits: true
                    }
            },
            messages : {

                    id_tipo_experiencia : {
                        required : "Debe seleccionar el tipo de experiencia."
                    },
                    duracion: {
                       digits: "Debe ser un numero entero."
                    }
            } 
        });    
});    