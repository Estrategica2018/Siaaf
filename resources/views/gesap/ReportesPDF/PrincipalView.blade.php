@extends('material.layouts.dashboard')

@push('styles')
    <!-- Datatables Styles -->
    <link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}"
          rel="stylesheet" type="text/css"/>
    <!-- toastr Styles -->
    <link href="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <!-- Select2 Styles -->
    <link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/global/plugins/select2material/css/pmd-select2.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{  asset('assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{  asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet"
          type="text/css"/>
@endpush

@section('title', '| Reportes PDF')

@section('content')
    <div class="col-md-12">
        @component('themes.bootstrap.elements.portlets.portlet', ['icon' => 'fa fa-tasks', 'title' => 'Reportes:'])
            <div class="row">
                <div class="col-md-9 col-md-offset-1">
                    <div class="m-heading-1 border-green m-bordered"><p><b>REPORTE DE PROYECTOS:</b></p><br>

                        <a href="{{ route('report.all.project') }}" target=”_blank” class="icon-btn"
                           data-toggle="tooltip" data-placement="bottom"
                           title="Reporte con todos los proyectos registrados." style="width:130px">
                            <i class="fa fa-group"></i>
                            <div> Todos los proyectos</div>
                        </a>&nbsp;&nbsp;&nbsp;&nbsp;

                        <a href="#" target=”_blank” class="icon-btn" data-toggle="tooltip" data-placement="bottom"
                           title="Reporte de proyectos por jurado." id="Jurado" style="width:130px">
                            <i class="fa fa-map-marker"></i>
                            <div> Por Jurado:</div>
                        </a>&nbsp;&nbsp;
                        <a href="#" target=”_blank” class="icon-btn" data-toggle="tooltip" data-placement="bottom"
                           title="Reporte de proyectos por director." id="Director" style="width:130px">
                            <i class="fa fa-dollar"></i>
                            <div> Por Director</div>
                        </a>&nbsp;&nbsp;&nbsp;&nbsp;
                    </div>
                    <br><br>
                </div>
            </div>
        @endcomponent
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12">
            <!-- Modal -->
            <div class="modal fade" id="modal-reporte-docente" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        {!! Form::open(['id' => 'reporte_docente', 'class' => '', 'url' => '/forms']) !!}
                        <div class="modal-header modal-header-success">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h1><i class="glyphicon glyphicon-thumbs-up"></i></h1>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! Field::hidden('tipo') !!}
                                    {!! Field::select('Docente',$docentes,null,[ 'auto' => 'off','autofocus']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            {!! Form::submit('Generar', ['class' => 'btn blue reporte']) !!}
                            {!! Form::button('Cancelar', ['class' => 'btn red', 'data-dismiss' => 'modal' ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12">
            <!-- Modal -->
            <div class="modal fade" id="modal-reporte-date" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        {!! Form::open(['id' => 'reporte_date', 'class' => '', 'url' => '/forms']) !!}
                        <div class="modal-header modal-header-success">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h1><i class="glyphicon glyphicon-thumbs-up"></i>Reporte por fechas</h1>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! Field::date('from',
                                    ['label' => 'Desde :','required', 'auto' => 'off', 'data-date-format' => "yyyy-mm-dd", 'data-date-start-date' => "+0d"],
                                    ['help' => '', 'icon' => 'fa fa-calendar']) !!}
                                    <hr>
                                    {!! Field::date('to',
                                    ['label' => 'Hasta:','required', 'auto' => 'off', 'data-date-format' => "yyyy-mm-dd", 'data-date-start-date' => "+0d"],
                                    ['help' => '', 'icon' => 'fa fa-calendar']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            {!! Form::submit('Generar', ['class' => 'btn blue reporte']) !!}
                            {!! Form::button('Cancelar', ['class' => 'btn red', 'data-dismiss' => 'modal' ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugins')
    <!-- Validation Plugins -->
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/localization/messages_es.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"
            type="text/javascript"></script>
    <!-- Utoastr Plugins -->
    <script src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.js') }}" type="text/javascript"></script>
    <!-- Select2 Plugins -->
    <script src="{{ asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.quicksearch.js') }}"
            type="text/javascript"></script>
    <!-- Identicon Plugins -->
    <script src="{{ asset('assets/global/plugins/stewartlord-identicon/identicon.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/stewartlord-identicon/pnglib.js') }}" type="text/javascript"></script>
@endpush
@push('functions')
    <!-- Local Scripts-->
    <script src="{{ asset('assets/main/scripts/ui-toastr.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/main/scripts/table-datatable.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        jQuery(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip()

            $('#Director').on('click', function (e) {
                e.preventDefault();
                $('.glyphicon-thumbs-up').html("Reporte por Director:");
                $('input[name="tipo"]').val('Director');
                $('#modal-reporte-docente').modal('toggle');
            });

            $('#Jurado').on('click', function (e) {
                e.preventDefault();
                $('.glyphicon-thumbs-up').html("Reporte por Jurado:");
                $('input[name="tipo"]').val('Jurado');
                $('#modal-reporte-docente').modal('toggle');

            });

            $('#Fechas').on('click', function (e) {
                e.preventDefault();
                $('#modal-reporte-date').modal('toggle');
            });

            $('#reporte_docente').submit(function (e) {
                e.preventDefault();
                if ($('input[name="tipo"]').val() == "Jurado")
                    var route = '{{route('report.jury.project')}}/' + $('select[name="Docente"]').val();
                if ($('input[name="tipo"]').val() == "Director")
                    var route = '{{route('report.director.project')}}/' + $('select[name="Docente"]').val();
                $('#reporte_docente')[0].reset();
                $(".pmd-select2").select2({
                    placeholder: "Selecccionar",
                    allowClear: true,
                    width: 'auto',
                    escapeMarkup: function (m) {
                        return m;
                    }
                });
                $('#modal-reporte-docente').modal('hide');
                window.open(route, '_blank');
            });

            $('.select2-selection--single').addClass('form-control');
            var form = $('#reporte_docente');
            /*Configuracion de Select*/
            $.fn.select2.defaults.set("theme", "bootstrap");
            $(".pmd-select2").select2({
                placeholder: "Selecccionar",
                allowClear: true,
                width: 'auto',
                escapeMarkup: function (m) {
                    return m;
                }
            });
            $('.pmd-select2', $form).change(function () {
                $form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });
        });

    </script>
@endpush