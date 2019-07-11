jq(function(){

            jq('#form_crear_periodo').validate({

                rules :{

                        id_convenio : {
                            required : true
                        },
                        vacantes_out: {
                            digits: true
                        },
                        vacantes_in: {
                            digits: true
                        },
                        periodo_1 : {
                            required : true
                        },
                        periodo_2 : {
                            required : true
                        }
                },
                messages : {

                        id_convenio : {
                            required : "Debe seleccionar el tipo de experiencia."
                        },
                        vacantes_out: {
                           digits: "Debe ser un numero entero."
                        },
                        vacantes_in: {
                           digits: "Debe ser un numero entero."
                        },
                        periodo_1 : {
                            required : "Debe elegir el primer año del periodo."
                        },
                        periodo_2 : {
                            required : "Debe elegir el segundo año del periodo."
                        }
                } 
            });    
    });     

jq(function(){

        jq('#form_editar_periodo').validate({

            rules :{

                    ID_PERIODO_INTERCAMBIO : {
                        required : true
                    },
                    vacantes_out: {
                        digits: true
                    },
                    periodo_1 : {
                        required : true
                    },
                    periodo_2 : {
                        required : true
                    }
            },
            messages : {

                    ID_PERIODO_INTERCAMBIO : {
                        required : "Debe seleccionar el tipo de experiencia."
                    },
                    vacantes_out: {
                       digits: "Debe ser un numero entero."
                    },
                    vacantes_in: {
                       digits: "Debe ser un numero entero."
                    },
                    periodo_1 : {
                        required : "Debe elegir el primer año del periodo."
                    },
                    periodo_2 : {
                        required : "Debe elegir el segundo año del periodo."
                    }
            } 
        });    
});    