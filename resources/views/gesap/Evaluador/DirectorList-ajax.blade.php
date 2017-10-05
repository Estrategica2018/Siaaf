@component('themes.bootstrap.elements.portlets.portlet', ['icon' => 'icon-frame', 'title' => 'Director'])
        <div class="row">
        
        <div class="col-md-12">
            @component('themes.bootstrap.elements.tables.datatables', ['id' => 'lista-anteproyecto'])
            
                @slot('columns', [
                    '#' => ['style' => 'width:20px;'],
                    'id',
                    'Titulo',
                    'Palabras Clave',
                    'Duracion',
                    'Fecha Radicacion',
                    'Fecha Limite',
                    'Estado',
                    'Min',
                    'Requerimientos',
                    'Director',
                    'Estudiante 1',
                    'Estudiante 2',
                    'Jurado 1',
                    'Jurado 2',
                    'Acciones' => ['style' => 'width:160px;']
                ])
            @endcomponent
        </div>
    </div>
    
    @endcomponent

<script>
jQuery(document).ready(function () {
    var table, url;
    table = $('#lista-anteproyecto');
    url = "{{ route('anteproyecto.directorList') }}";

    table.DataTable({
       lengthMenu: [
           [5, 10, 25, 50, -1],
           [5, 10, 25, 50, "Todo"]
       ],
       responsive: true,
       colReorder: true,
       processing: true,
       serverSide: true,
       ajax: url,
       searching: true,
       language: {
           "sProcessing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i> <span class="sr-only">Procesando...</span>',
           "sLengthMenu": "Mostrar _MENU_ registros",
           "sZeroRecords": "No se encontraron resultados",
           "sEmptyTable": "Ningún dato disponible en esta tabla",
           "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
           "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
           "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
           "sInfoPostFix": "",
           "sSearch": "Buscar:",
           "sUrl": "",
           "sInfoThousands": ",",
           "sLoadingRecords": "Cargando...",
           "oPaginate": {
               "sFirst": "Primero",
               "sLast": "Último",
               "sNext": "Siguiente",
               "sPrevious": "Anterior"
           },
           "oAria": {
               "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
               "sSortDescending": ": Activar para ordenar la columna de manera descendente"
           }
       },
       columns:[
           {data: 'DT_Row_Index'},
           {data: 'PK_NPRY_idMinr008', "visible": false },
           {data: 'NPRY_Titulo', searchable: true},
           {data: 'NPRY_Keywords', searchable: true},
           {data: 'NPRY_Duracion',searchable: true},
           {data: 'NPRY_FechaR', className:'none',searchable: true},
           {data: 'NPRY_FechaL', className:'none',searchable: true},
           {data: 'NPRY_Estado',searchable: true},
           {data: 'radicacion.RDCN_Min',className:'none',
                        render: function (data, type, full, meta) 
                        {
                            return '<a href="/gesap/download/'+data+'">DESCARGAR MIN</a>';
                        }
                    },
                    {data: 'radicacion.RDCN_Requerimientos',className:'none',searchable: true,
                        render: function (data, type, full, meta) 
                        {
                            if(data=="NO FILE"){
                                return "NO FILE";    
                            }else{
                                return '<a href="/gesap/download/'+data+'">DESCARGAR REQUERIMIENTOS</a>';    
                            }  
                        }
                    }, 
           {data: 'director',render: "[, ].usuarios.name",className:'none',searchable: true},
           {data: 'estudiante1',render: "[, ].usuarios.name",className:'none',searchable: true},
           {data: 'estudiante2',render: "[, ].usuarios.name", className:'none',searchable: true},
           {data: 'jurado1',render: "[, ].usuarios.name", className:'none',searchable: true},
           {data: 'jurado2',render: "[, ].usuarios.name",className:'none',searchable: true},
            {data:'action',className:'',searchable: false,
            name:'action',
            title:'Acciones',
            orderable: false,
            exportable: false,
            printable: false,
            defaultContent: '<a href="#" class="btn btn-simple btn-warning btn-icon edit"><i class="icon-eye"></i>Ver Observaciones</a>',

            
            }
      
       ],
       buttons: [
           { extend: 'print', className: 'btn btn-circle btn-icon-only btn-default tooltips t-print', text: '<i class="fa fa-print"></i>' },
           { extend: 'copy', className: 'btn btn-circle btn-icon-only btn-default tooltips t-copy', text: '<i class="fa fa-files-o"></i>' },
           { extend: 'pdf', className: 'btn btn-circle btn-icon-only btn-default tooltips t-pdf', text: '<i class="fa fa-file-pdf-o"></i>',},
           { extend: 'excel', className: 'btn btn-circle btn-icon-only btn-default tooltips t-excel', text: '<i class="fa fa-file-excel-o"></i>',},
           { extend: 'csv', className: 'btn btn-circle btn-icon-only btn-default tooltips t-csv',  text: '<i class="fa fa-file-text-o"></i>', },
           { extend: 'colvis', className: 'btn btn-circle btn-icon-only btn-default tooltips t-colvis', text: '<i class="fa fa-bars"></i>'},
           {text: '<i class="fa fa-refresh"></i>', className: 'btn btn-circle btn-icon-only btn-default tooltips t-refresh',
               action: function ( e, dt, node, config ) {
                   dt.ajax.reload();
               }
           }

       ],
       pageLength: 10,
       dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
    });
table = table.DataTable();
    table.on('click', '.edit', function (e) {
        e.preventDefault();
        $tr = $(this).closest('tr');
        var O = table.row($tr).data();
	    $.ajax({
            type: "GET",
            url: '',
            dataType: "html",
        }).done(function (data) {
            route = '/gesap/show/'+O.PK_NPRY_idMinr008;
            $(".content-ajax").load(route);
        });
    });
    
});
</script>