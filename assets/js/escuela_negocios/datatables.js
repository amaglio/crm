(function(){
    var jq = jQuery.noConflict();
    jq(document).ready(function() {
        jq('#tabla_ultimos_referentes').dataTable({
            "paging":   true,
            "ordering": true,
            "info":     true,
            "bFilter": true,
            "pageLength": 10,
            "language": {
                "lengthMenu": "Mostrando _MENU_",
                "zeroRecords": "No se encontraron resultados.",
                "info": "<b> Mostrando pagina _PAGE_ de _PAGES_ </b>",
                "infoEmpty": "Ningun resultado disponible",
                "infoFiltered": "(Filtrado de _MAX_ resultados totales)",
                "sSearch": " Buscar    ",
                "oPaginate": {
                    "sNext": ">",
                    "sPrevious": "<"
                }
            },
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ -1 ] }
            ]
        });
        jq('#tabla_proximas_alarmas').dataTable({
            "paging":   true,
            "ordering": true,
            "info":     true,
            "bFilter": true,
            "pageLength": 10,
            "language": {
                "lengthMenu": "Mostrando _MENU_",
                "zeroRecords": "No se encontraron resultados.",
                "info": "<b> Mostrando pagina _PAGE_ de _PAGES_ </b>",
                "infoEmpty": "Ningun resultado disponible",
                "infoFiltered": "(Filtrado de _MAX_ resultados totales)",
                "sSearch": " Buscar    ",
                "oPaginate": {
                    "sNext": ">",
                    "sPrevious": "<"
                }
            },
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ -1 ] }
            ]
        });

 

        jq('#tabla_ultimas_empresas').DataTable({
                "paging":   true,
                "ordering": true,
                "info":     true,
                "bFilter": true, 
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                            'url':CI_ROOT+'index.php/escuela_negocios/get_empresas'
                        },
                'columns': 
                    [
                        { data: 'empresa_nombre' },  { data: 'boton_empresa' }
                    ],
                 "language": {
                                "lengthMenu": "Mostrando _MENU_",
                                "zeroRecords": "No se encontraron resultados.",
                                "info": "<b> Mostrando pagina _PAGE_ de _PAGES_ </b>",
                                "infoEmpty": "Ningun resultado disponible",
                                "infoFiltered": "(Filtrado de _MAX_ resultados totales)",
                                "sSearch": " Buscar    ",
                                "oPaginate": {
                                    "sNext": ">",
                                    "sPrevious": "<"
                }
            },
        });

        
        jq('#tabla_ultimas_camaras').DataTable({
                "paging":   true,
                "ordering": true,
                "info":     true,
                "bFilter": true, 
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                            'url':CI_ROOT+'index.php/escuela_negocios/get_camaras'
                        },
                'columns': 
                    [
                        { data: 'empresa_nombre' },  { data: 'boton_empresa' }
                    ],
                 "language": {
                                "lengthMenu": "Mostrando _MENU_",
                                "zeroRecords": "No se encontraron resultados.",
                                "info": "<b> Mostrando pagina _PAGE_ de _PAGES_ </b>",
                                "infoEmpty": "Ningun resultado disponible",
                                "infoFiltered": "(Filtrado de _MAX_ resultados totales)",
                                "sSearch": " Buscar    ",
                                "oPaginate": {
                                    "sNext": ">",
                                    "sPrevious": "<"
                }
            },
        });

        /*
        jq('#tabla_ultimas_empresas').dataTable({
            "paging":   true,
            "ordering": true,
            "info":     true,
            "bFilter": true,
            "pageLength": 10,
            "language": {
                "lengthMenu": "Mostrando _MENU_ ",
                "zeroRecords": "No se encontraron resultados.",
                "info": "<b> Mostrando pag _PAGE_ de _PAGES_ </b>",
                "infoEmpty": "Ningun resultado disponible",
                "infoFiltered": "(Filtrado de _MAX_ resultados totales)",
                "sSearch": " Buscar    ",
                "oPaginate": {
                    "sNext": ">",
                    "sPrevious": "<"
                }
            },
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ -1 ] }
            ]
        });*/
        
        jq('#referentes_empresa').dataTable({
            "paging":   true,
            "ordering": true,
            "info":     true,
            "bFilter": true,
            "pageLength": 10,
            "language": {
                "lengthMenu": "Mostrando _MENU_ ",
                "zeroRecords": "No se encontraron resultados.",
                "info": "<b> Mostrando pag _PAGE_ de _PAGES_ </b>",
                "infoEmpty": "Ningun resultado disponible",
                "infoFiltered": "(Filtrado de _MAX_ resultados totales)",
                "sSearch": " Buscar    ",
                "oPaginate": {
                    "sNext": ">",
                    "sPrevious": "<"
                }
            },
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ -1 ] }
            ]
        });


        jq('#empleados_empresa').dataTable({
            "paging":   true,
            "ordering": true,
            "info":     true,
            "bFilter": true,
            "pageLength": 10,
            "language": {
                "lengthMenu": "Mostrando _MENU_ ",
                "zeroRecords": "No se encontraron resultados.",
                "info": "<b> Mostrando pag _PAGE_ de _PAGES_ </b>",
                "infoEmpty": "Ningun resultado disponible",
                "infoFiltered": "(Filtrado de _MAX_ resultados totales)",
                "sSearch": " Buscar    ",
                "oPaginate": {
                    "sNext": ">",
                    "sPrevious": "<"
                }
            },
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ -1 ] }
            ]
        });


    } );
})();
