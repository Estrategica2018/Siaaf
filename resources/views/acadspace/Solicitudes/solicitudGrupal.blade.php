@extends('material.layouts.dashboard')
@permission('ACAD_REALIZAR_SOLICITUDES')
@push('styles')
    {{--Select2--}}
    <link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/global/plugins/select2material/css/pmd-select2.css') }}" rel="stylesheet"
          type="text/css"/>
    <!-- daterange -->
    <link href="{{ asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <!-- MODAL -->
    <link href="{{ asset('assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css') }}" rel="stylesheet"
          type="text/css"/>
    <!-- DATATABLE  -->
    <link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}"
          rel="stylesheet" type="text/css"/>
    {{--Toast--}}
    <link href="{{asset('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    {{--JQuery datatable and row details--}}
    <link href="{{ asset('assets/main/acadspace/css/rowdetails.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
    {{-- BEGIN HTML SAMPLE --}}
    <div class="col-md-12">
        @component('themes.bootstrap.elements.portlets.portlet', ['icon' => 'glyphicon glyphicon-th-list', 'title' => 'Mis Solicitudes'])
            <div class="clearfix">
            </div>
            <br>
            <br>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="actions">
                        @permission('ACAD_REALIZAR_SOLICITUDES')
                        <a href="javascript:;" class="btn btn-simple btn-success btn-icon create"><i
                                    class="fa fa-plus"></i>Práctica Grupal</a> <a href="javascript:;"
                                                                                  class="btn btn-simple btn-success btn-icon createLib"><i
                                    class="fa fa-plus"></i>Práctica Libre</a></div>
                    @endpermission
                </div>
            </div>
    </div>
    <div class="clearfix">
    </div>
    <br>
    <div class="col-md-12">
        @permission('ACAD_CONSULTAR_SOLICITUDES')
        @component('themes.bootstrap.elements.tables.datatables', ['id' => 'art-table-ajax'])
            @slot('columns', [
            '#' => ['style' => 'width:20px;'],
            ' ' => ['style' => 'width:20px;'],
            'Núcleo temático',
            'Estudiantes' => ['class' => 'min-phone-l'],
            'Estado' => ['class' => 'min-phone-l'],
            'Práctica' => ['class' => 'min-phone-l']
            ])
        @endcomponent
        @endpermission
    </div>
    <div class="clearfix">
    </div>
    @endcomponent
@endsection

@push('plugins')
    {{--MOMENT--}}
    <script src="{{ asset('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <!-- SCRIPT DATATABLE -->
    <script src="{{ asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}"
            type="text/javascript"></script>
    <!-- SCRIPT MODAL -->
    <script src="{{ asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js') }}"
            type="text/javascript"></script>
    <!-- SCRIPT Validacion Maxlength -->
    <script src="{{ asset('assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"
            type="text/javascript">
    </script>
    <!-- SCRIPT Validacion Personalizadas -->
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/localization/messages_es.js') }}"
            type="text/javascript"></script>
    <!-- SCRIPT MENSAJES TOAST-->
    <script src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    {{--Selects--}}
    <script src="{{ asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.quicksearch.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
@endpush

@push('functions')
    <!--HANDLEBAR-->
    <script src="{{ asset('assets/main/acadspace/js/handlebars.js') }}"></script>
    <script src="{{ asset('assets/main/scripts/form-validation-md.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/main/scripts/form-validation-md.js') }}" type="text/javascript"></script>
    <!-- Estandar Mensajes -->
    <script src="{{ asset('assets/main/scripts/ui-toastr.js') }}" type="text/javascript"></script>
    <!-- Estandar Datatable -->
    <script src="{{ asset('assets/main/scripts/table-datatable.js') }}" type="text/javascript"></script>
    <!-- Informacion que muestra al desplegar -->
    <script id="details-template" type="text/x-handlebars-template">
        <table class="table">
            <tr>
                <td>Fecha de creación:</td>
                <td>@{{created_at}}</td>
            </tr>
            <tr>
                <td>Software:</td>
                <td>@{{software.SOF_Nombre_Soft}}</td>
            </tr>
            <tr>
                <td>Sala asignada:</td>
                <td>@{{aula.SAL_Nombre_Sala}}</td>
            </tr>
            <tr>
                <td>Observación:</td>
                <td>@{{coment.COM_Comentario}}</td>
            </tr>
        </table>
    </script>
    <script>

        /*PINTAR TABLA*/
        $(document).ready(function () {
            //capturar el template para desplegar la informacion
            var template = Handlebars.compile($("#details-template").html());

            var table, url, columns;

            table = $('#art-table-ajax');
            url = "{{ route('espacios.academicos.solacad.data') }}";
            columns = [

                {data: 'DT_Row_Index', "visible": false},
                {
                    "className": 'details-control',
                    "orderable": false,
                    "searchable": false,
                    "data": null,
                    "defaultContent": ''
                },
                {data: 'SOL_Nucleo_Tematico', name: 'Núcleo temático'},
                {data: 'SOL_Cant_Estudiantes', name: 'Estudiantes'},
                {data: 'estado', name: 'Estado'},
                {data: 'tipo_prac', name: 'Práctica'}
            ];
            dataTableServer.init(table, url, columns);
            table = table.DataTable();
            //Funcion desplegable de la tabla
            $('#art-table-ajax tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('details');
                }
                else {
                    // Open this row
                    row.child(template(row.data())).show();
                    tr.addClass('details');
                }
            });
            $(".create").on('click', function (e) {
                e.preventDefault();
                var route = '{{ route('espacios.academicos.solacad.crearGrupal') }}';
                $(".content-ajax").load(route);
            });
            $(".createLib").on('click', function (e) {
                e.preventDefault();
                var route = '{{ route('espacios.academicos.solacad.crearLibre') }}';
                $(".content-ajax").load(route);
            });
        });
    </script>
@endpush
@endpermission