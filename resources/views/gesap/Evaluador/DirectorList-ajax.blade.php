
    <div class="col-md-12">
        @component('themes.bootstrap.elements.portlets.portlet', ['icon' => 'icon-list', 'title' => 'Director'])
            <div class="row">
                <div class="col-md-12">
                    @component('themes.bootstrap.elements.tables.datatables', ['id' => 'lista-anteproyecto'])
                        @slot('columns', [
                            '#' => ['style' => 'width:20px;'],
                            'id',
                            'Tipo',        
                            'Titulo',
                            'Palabras Clave',
                            'Duracion',
                            'Fecha Radicacion',
                            'Fecha Limite',
                            'Min',
                            'Requerimientos',
                            'Director',
                            'Estudiante 1',
                            'Estudiante 2',
                            'Jurado 1',
                            'Jurado 2',
                            'Estado',
                            'Acciones' => ['style' => 'width:160px;']
                        ])
                    @endcomponent
                </div>
            </div>
        @endcomponent
    </div>    

	<!--Local Scripts-->
    <script src="{{ asset('assets/main/scripts/ui-toastr.js') }}" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function () {
            var table, url,columns;
            table = $('#lista-anteproyecto');
            url = "{{ route('anteproyecto.directorList') }}";

            columns= [
                   {data: 'DT_Row_Index'},
                   {data: 'anteproyecto.PK_NPRY_IdMinr008', "visible": false },
                   {data: function (data, type, dataToSet) {
                       if(data.anteproyecto.proyecto!=null){
                           return "PROYECTO"
                       }else{
                           return "ANTEPROYECTO"
                       }
                   },searchable: true},
                   {data: 'NPRY_Titulo', searchable: true},
                   {data: 'anteproyecto.NPRY_Keywords', className:'none', searchable: true},
                   {data: 'anteproyecto.NPRY_Duracion',searchable: true},
                   {data: 'anteproyecto.NPRY_FechaR', className:'none',searchable: true},
                   {data: 'anteproyecto.NPRY_FechaL', className:'none',searchable: true},
                   {data: 'anteproyecto.radicacion.RDCN_Min',className:'none',
                        render: function (data, type, full, meta) {
                            return '<a href="{{ route('download.documento') }}/'+data+'">DESCARGAR MIN</a>';
                        }
                   },
                   {data: 'anteproyecto.radicacion.RDCN_Requerimientos',className:'none',searchable: true,
                        render: function (data, type, full, meta) {
                            if(data=="NO FILE"){
                                return "NO APLICA";    
                            }else{
                                return '<a href="{{ route('download.documento') }}/'+data+'">DESCARGAR REQUERIMIENTOS</a>';    
                            }  
                        }
                   }, 
                   {data:  function (data, type, dataToSet) {
                       if(data.anteproyecto.director[0]!=null){
                           return data.anteproyecto.director[0].usuarios.name + " " + data.anteproyecto.director[0].usuarios.lastname;
                        }else{
                            return "SIN ASIGNAR";
                        }
                   },className:'none',searchable: true},
                   {data: function (data, type, dataToSet) {
                       if(data.anteproyecto.estudiante1[0]!=null){
                           return data.anteproyecto.estudiante1[0].usuarios.name + " " + data.anteproyecto.estudiante1[0].usuarios.lastname;
                        }else{
                           return "SIN ASIGNAR"
                        }
                   },className:'none',searchable: true},
                   {data: function (data, type, dataToSet) {
                       if(data.anteproyecto.estudiante2[0]!=null){
                            return data.anteproyecto.estudiante2[0].usuarios.name + " " + data.anteproyecto.estudiante2[0].usuarios.lastname;
                       }else{
                           return "SIN ASIGNAR"
                       }
                   }, className:'none',searchable: true},
                   {data: function (data, type, dataToSet) {
                       if(data.anteproyecto.jurado1[0]!=null){
                           return data.anteproyecto.jurado1[0].usuarios.name + " " + data.anteproyecto.jurado1[0].usuarios.lastname;
                       }else{
                           return "SIN ASIGNAR"
                       }
                   }, className:'none',searchable: true},
                   {data: function (data, type, dataToSet) {
                       if(data.anteproyecto.jurado2[0]!=null){
                           return data.anteproyecto.jurado2[0].usuarios.name + " " + data.anteproyecto.jurado2[0].usuarios.lastname;
                       }else{
                           return "SIN ASIGNAR"
                       }
                   },className:'none',searchable: true},
                    
                   {data: 'NPRY_Estado',searchable: true},
                    
                   {data:'action',
                    className:'',
                    searchable: false,
                    name:'action',
                    title:'Acciones',
                    orderable: false,
                    exportable: false,
                    printable: false,
                    responsivePriority:2,
                    render: function ( data, type, full, meta ) {
                        if(full.anteproyecto.NPRY_Estado=="APROBADO"){
                            if(full.anteproyecto.proyecto==null){
                                return '@permission("See_Observations_Gesap")<a href="#" class="btn btn-simple btn-warning btn-icon edit"><i class="icon-eye"></i></a>@endpermission @permission("Aproved_Project_Gesap")<a href="#" class="btn btn-simple btn-success btn-icon" id="proyecto"><i class="icon-check"></i></a>@endpermission';
                            }else{
                                if (full.anteproyecto.proyecto.PRYT_Estado=="TERMINADO") {
                                     return '<center>@permission("See_Observations_Gesap")<a href="#" class="btn btn-simple btn-warning btn-icon edit"><i class="icon-eye"></i></a>@endpermission @permission("See_Activity_Gesap")<a href="#" class="btn btn-simple btn-success btn-icon " id="actividades"><i class="icon-list"></i></a>@endpermission</center>';
                                 } else {
                                    return '@permission("See_Observations_Gesap")<a href="#" class="btn btn-simple btn-warning btn-icon edit"><i class="icon-eye"></i></a>@endpermission @permission("See_Activity_Gesap")<a href="#" class="btn btn-simple btn-success btn-icon " id="actividades"><i class="icon-list"></i></a>@endpermission @permission("Close_Project_Gesap")<a href="#" class="btn btn-simple btn-success btn-icon delete "  id="close"><i class="icon-lock"></i></a>@endpermission';
                                 } 
                                
                            }
                        }else{
                            return '@permission("See_Observations_Gesap")<a href="#" class="btn btn-simple btn-warning btn-icon edit"><i class="icon-eye"></i>Ver Observaciones</a>@endpermission';
                        }
                     }, 
                   }
               ];
			dataTableServer.init(table, url, columns);
            
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
                    route = '{{ route('evaluar.show') }}'+'/'+O.anteproyecto.PK_NPRY_IdMinr008;
                    $(".content-ajax").load(route);
                });
            });
    
            table.on('click', '#proyecto', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var O = table.row($tr).data();
				route = '{{ route('proyecto.aprobado') }}'+'/'+O.anteproyecto.PK_NPRY_IdMinr008;
                var type = 'GET';
                var async = async || false;
                swal({
                    title: "¿Esta seguro?",
                    text: "Esta aprobando la continuacion del anteproyecto a un proyecto",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "De acuerdo",
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: true,
                    closeOnCancel: false
                },
                     function(isConfirm){
                        if (isConfirm) {
                            $.ajax({
                                url: route,
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                cache: false,
                                type: type,
                                contentType: false,
                                processData: false,
                                async: async,
                                success: function (response, xhr, request) {
                                    if (request.status === 200 && xhr === 'success') {
                                        table.ajax.reload();
                                        UIToastr.init(xhr, response.title, response.message);
                                    }
                                },
                                error: function (response, xhr, request) {
                                    if (request.status === 422 &&  xhr === 'error') {
                                        UIToastr.init(xhr, response.title, response.message);
                                    }
                                }
                            });
                            swal.close();
                        } else {
                            swal("Cancelado", "No se eliminó ningun proyecto", "error");
                        }
                    }
                );
    });
            
            table.on('click', '#close', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var O = table.row($tr).data();
				route = '{{ route('proyecto.cerrar') }}'+'/'+O.anteproyecto.PK_NPRY_IdMinr008;
                var type = 'GET';
                var async = async || false;
                swal({
                    title: "¿Esta seguro?",
                    text: "Esta cerrando el proyecto,No se podra crear o modificar datos ni documentos",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "De acuerdo",
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: true,
                    closeOnCancel: false
                },
                     function(isConfirm){
                        if (isConfirm) {
                            $.ajax({
                                url: route,
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                cache: false,
                                type: type,
                                contentType: false,
                                processData: false,
                                async: async,
                                success: function (response, xhr, request) {
                                    if (request.status === 200 && xhr === 'success') {
                                        table.ajax.reload();
                                        UIToastr.init(xhr, response.title, response.message);
                                    }
                                },
                                error: function (response, xhr, request) {
                                    if (request.status === 422 &&  xhr === 'error') {
                                        UIToastr.init(xhr, response.title, response.message);
                                    }
                                }
                            });
                            swal.close();
                        } else {
                            swal("Cancelado", "No se cerró ningun proyecto", "error");
                        }
                    }
                );
    });
    
    table.on('click', '#actividades', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var O = table.row($tr).data();
                $.ajax({
                    type: "GET",
                    url: '',
                    dataType: "html",
                }).done(function (data) {
                    route = '{{ route('proyecto.actividades') }}'+'/'+O.anteproyecto.PK_NPRY_IdMinr008;
                    $(".content-ajax").load(route);
                });
            });
            
            
            table.on('click','.boton_mas_info',function(){
 
                if($(this).parent().find('.texto-ocultado').css('display') == 'none'){
                    $(this).parent().find('.texto-ocultado').css('display','inline');
                    $(this).parent().find('.puntos').html(' ');
                    $(this).text('Ver menos');
                } else {
                    $(this).parent().find('.texto-ocultado').css('display','none');
                    $(this).parent().find('.puntos').html('...');
                    $(this).html('Ver más');
                };
            });            
            
        });
</script>