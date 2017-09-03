@extends('material.layouts.dashboard')

@push('styles')
<!-- Datatables Styles -->
<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('title', '| Información personal contratado')

@section('page-title', 'Listado de personal asistente al evento :')

@section('content')
    <div class="col-md-12">
        @component('themes.bootstrap.elements.portlets.portlet', ['icon' => 'fa fa-tasks', 'title' => 'Asistentes al evento:'])
            <br><div class="col-md-6">
                <div class="btn-group">
                    <a href="{{ route('talento.humano.evento.index') }}">
                        <button id="volver" class="btn green" >
                            <i class="fa fa-arrow-circle-left"></i>Volver
                        </button>
                    </a>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-12"><br>
                    @component('themes.bootstrap.elements.tables.datatables', ['id' => 'lista-empleados'])
                        @slot('columns', [
                            '#',
                            'Nombres',
                            'Apellidos',
                            'Cédula',
                            'Teléfono',
                            'Email',
                            'Rol ',
                            'Acciones'
                        ])
                    @endcomponent
                </div>
            </div>
            {!! Field::hidden('FK_TBL_Eventos_IdEvento',$id,['id'=>'idEvent']) !!}
            {!! link_to_route('talento.humano.evento.regAsist','Registrar Asistentes',$id,['class' => 'btn blue']) !!}

        @endcomponent
    </div>
@endsection

@push('plugins')
<!-- Datatables Scripts -->
<script src="{{ asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
@endpush
@push('functions')
    <script src="{{ asset('assets/main/scripts/ui-toastr.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/main/scripts/table-datatable.js') }}" type="text/javascript"></script>
<script>
jQuery(document).ready(function () {
    //var id= document.getElementById("idEvent").value;
    var table, url, columns;
    table = $('#lista-empleados');
    url = "{{ route('talento.humano.tablaAsistentes',$id)}}";
    columns = [
        {data: 'DT_Row_Index'},
        {data: 'PRSN_Nombres', name: 'Nombres'},
        {data: 'PRSN_Apellidos', name: 'Apellidos'},
        {data: 'PK_PRSN_Cedula', name: 'Cédula'},
        {data: 'PRSN_Telefono', name: 'Teléfono'},
        {data: 'PRSN_Correo', name: 'Correo Electronico'},
        {data: 'PRSN_Rol', name: 'Rol'},
        {
            defaultContent: '<a href="javascript:;" class="btn btn-simple btn-danger btn-icon remove"><i class="icon-trash"></i></a>',
            data: 'action',
            name: 'action',
            title: 'Acciones',
            orderable: false,
            searchable: false,
            exportable: false,
            printable: false,
            className: 'text-center',
            render: null,
            serverSide: false,
            responsivePriority: 2
        }
    ];
    dataTableServer.init(table, url, columns);
    table = table.DataTable();
    table.on('click', '.remove', function (e) {
        e.preventDefault();
        $tr = $(this).closest('tr');
        var dataTable = table.row($tr).data();
        var id = document.getElementById("idEvent").value;
        var route = '{{ route('talento.humano.evento.asistentes.deleteAsist') }}' + '/' + id + '/' + dataTable.PK_PRSN_Cedula;
        var type = 'GET';
        var async = async || false;
        swal({
                title: "¿Esta seguro?",
                text: "¿Esta seguro de eliminar el asistente seleccionado?",
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
                            if (request.status === 422 &&  xhr === 'success') {
                                UIToastr.init(xhr, response.title, response.message);
                            }
                        }

                    })
                } else {
                    swal("Cancelado", "No se eliminó ningun asistente", "error");
                }
            });

    });
});

</script>
@endpush