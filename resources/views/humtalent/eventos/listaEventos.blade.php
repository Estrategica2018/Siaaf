@extends('material.layouts.dashboard')

@push('styles')
    <!-- Datatables Styles -->
<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<!-- toastr Styles -->
<link href="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/select2material/css/pmd-select2.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('title', '| Información de los Eventos')

@section('page-title', 'Listado de eventos registrados :')

@section('content')
    <div class="col-md-12">
        @component('themes.bootstrap.elements.portlets.portlet', ['icon' => 'fa fa-tasks', 'title' => 'Eventos registrados:'])
            <br>
            <div class="row">
                @permission('TAL_CREATE_EVENT')
                <div class="col-md-12">
                    <div class="actions">
                        <a href="javascript:;" class="btn btn-simple btn-success btn-icon create">
                            <i class="fa fa-plus">
                            </i>Nuevo
                        </a>
                    </div>
                </div>
                @endpermission
            </div>
            <br>
            @permission('TAL_READ_EVENT')
                <div class="row">
                    <div class="col-md-12">

                        @component('themes.bootstrap.elements.tables.datatables', ['id' => 'lista-eventos'])
                            @slot('columns', [
                                '#',
                                'llave',
                                'Evento',
                                'Fecha Inicio',
                                'Fecha Fin',
                                'Hora',
                                'Acciones'
                            ])
                        @endcomponent

                    </div>
                </div>
            @endpermission
        @endcomponent
    </div>
@endsection

@push('plugins')
    <!-- Datatables Scripts -->
<script src="{{ asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-validation/js/localization/messages_es.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.quicksearch.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/global/plugins/stewartlord-identicon/identicon.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/stewartlord-identicon/pnglib.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
@endpush
@push('functions')
    <script src="{{ asset('assets/main/scripts/ui-toastr.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/main/scripts/table-datatable.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {

            var table, url,columns;
            table = $('#lista-eventos');
            url = "{{ route('talento.humano.tablaEventos')}}";
            columns = [
                {data: 'DT_Row_Index'},
                {data: 'PK_EVNT_IdEvento', "visible": false },
                {data: 'EVNT_Descripcion', name: 'Evento'},
                {data: 'EVNT_Fecha_Inicio', name: 'Fecha Inicio'},
                {data: 'EVNT_Fecha_Fin', name: 'Fecha Fin'},
                {data: 'EVNT_Hora', name: 'Hora'},
                {
                    defaultContent: '@permission("TAL_UPDATE_EVENT")<a href="javascript:;" class="btn btn-primary edit" ><i class="icon-pencil"></i></a>@endpermission @permission("TAL_DELETE_EVENT")<a href="javascript:;" class="btn btn-simple btn-danger btn-icon remove"><i class="icon-trash"></i></a>@endpermission @permission("TAL_UPDATE_EVENT")<a href="javascript:;" class="btn btn-simple btn-success btn-icon asistent"><i class="icon-users"></i></a>@endpermission',
                    data:'action',
                    name:'action',
                    title:'Acciones',
                    orderable: false,
                    searchable: false,
                    exportable: false,
                    printable: false,
                    className: 'text-center',
                    render: null,
                    serverSide: false,
                    responsivePriority:2
                }
            ];
            dataTableServer.init(table, url, columns);
            table = table.DataTable();
            table.on('click', '.remove', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data();
                var route = '{{ route('talento.humano.evento.destroy') }}'+'/'+dataTable.PK_EVNT_IdEvento;
                var type = 'DELETE';
                var async = async || false;
                swal({
                        title: "¿Esta seguro?",
                        text: "¿Esta seguro de eliminar el evento seleccionado?",
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
                        } else {
                            swal("Cancelado", "No se eliminó ningun evento", "error");
                        }
                    });

            });
            table.on('click', '.edit', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data(),
                    routeEdit='{{ route('talento.humano.evento.edit') }}'+'/'+dataTable.PK_EVNT_IdEvento;
                $(".content-ajax").load(routeEdit);
            });

            table.on('click', '.asistent', function (e) {
                e.preventDefault();
                $tr = $(this).closest('tr');
                var dataTable = table.row($tr).data(),
                    route = '{{ route('talento.humano.evento.asistentes') }}'+'/'+dataTable.PK_EVNT_IdEvento;
                $(".content-ajax").load(route);
            });

            $( ".create" ).on('click', function (e) {
                e.preventDefault();
                var route = '{{ route('talento.humano.evento.create') }}';
                $(".content-ajax").load(route);
            });
        });
    </script>
@endpush