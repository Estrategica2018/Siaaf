@extends('material.layouts.dashboard')
@permission('ACAD_PUBLICO')
@section('page-title', 'Control Docente:')
@push('styles')
    {{--TOAST--}}
    <link href="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.css') }}" rel="stylesheet" type="text/css"/>
    {{--Select2--}}
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
@section('content')
    <div class="col-md-12">
        @component('themes.bootstrap.elements.portlets.portlet', ['icon' => 'icon-book-open', 'title' => 'Registro ingreso docentes'])

            <div class="row">
                <div class="col-md-7 col-md-offset-2">
                    {!! Form::open(['id' => 'form_sol_create', 'class' => '', 'url'=>'/forms']) !!}

                    <div class="form-body">

                        {!! Field:: text('codigo',null,['label'=>'Identificación:', 'class'=> 'form-control', 'autofocus', 'maxlength'=>'12','autocomplete'=>'off'],
                                                        ['help' => 'Digite la identificación','icon'=>'fa fa-credit-card'] ) !!}


                        {!! Field::select('SOL_carrera',
                                          ['1' => 'Ingeniería de sistemas', '2' => 'Ingeniería Ambiental',
                                          '3' => 'Ingeniería agronomica', '4' => 'Administración de empresas',
                                          '5' => 'Psicología', '6' => 'Contaduría'],
                                          null,
                                          [ 'label' => 'Programa:']) !!}

                        {!! Field:: text('materia',null,['label'=>'Materia:', 'class'=> 'form-control', 'autofocus', 'maxlength'=>'50','autocomplete'=>'off'],
                                                         ['help' => 'Digite la materia a dictar','icon'=>'fa fa-desktop'] ) !!}

                        {!! Field::select('Espacio académico:',$espacios,
                                       ['id' => 'SOL_laboratorios', 'name' => 'SOL_laboratorios'])
                                       !!}

                        {!! Field::select(
                                                          'aula', null,
                                                          ['name' => 'aula']) !!}

                        {!! Field::text('SOL_cant_estudiantes',null,['label'=>'Cantidad de estudiantes:', 'class'=> 'form-control', 'autofocus', 'maxlength'=>'2','autocomplete'=>'off'],
                        ['icon'=>'fa fa-group'] ) !!}

                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12 col-md-offset-0">
                                    @permission('ACAD_REGISTRAR_ASISTENCIA')
                                    {!! Form::submit('Guardar', ['class' => 'btn blue']) !!}
                                    @endpermission
                                </div>
                            </div>
                        </div>


                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

        @endcomponent
    </div>

@endsection

@push('plugins')
    <script src="{{ asset('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/localization/messages_es.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.js') }}" type="text/javascript"></script>
    {{--Selects--}}
    <script src="{{ asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.quicksearch.js') }}"
            type="text/javascript"></script>
@endpush

@push('functions')
    <script src="{{ asset('assets/main/scripts/form-validation-md.js') }}" type="text/javascript">
    </script>

    <script src="{{ asset('assets/main/scripts/form-validation-md.js') }}" type="text/javascript"></script>
    <!-- Estandar Mensajes -->
    <script src="{{ asset('assets/main/scripts/ui-toastr.js') }}" type="text/javascript"></script>
    <!-- Estandar Datatable -->
    <script src="{{ asset('assets/main/scripts/table-datatable.js') }}" type="text/javascript"></script>
    <script>

        jQuery(document).ready(function () {
            $.fn.select2.defaults.set("theme", "bootstrap");
            $(".pmd-select2").select2({
                allowClear: true,
                placeholder: "Seleccione",
                width: 'auto',
                escapeMarkup: function (m) {
                    return m;
                }
            });
            moment.locale('es');
            $("#SOL_laboratorios").change(function (event) {
                /*Cargar select de aulas*/
                $('#aula').empty();
                $.get("cargarSalasAsitencia/" + event.target.value + "", function (response) {
                    $(response.data).each(function (key, value) {
                        $("#aula").append(new Option(value.SAL_Nombre_Sala, value.PK_SAL_Id_Sala));
                    });
                    $("#aula").val([]);
                });
            });

            /*VALIDACIONES*/
            var wizard = $('#form_wizard_1');
            /*Crear Solicitud*/
            var createUsers = function () {
                return {
                    init: function () {
                        var route = '{{ route('espacios.academicos.asist.regisAsistDoc') }}';
                        var type = 'POST';
                        var async = async || false;

                        var formData = new FormData();
                        formData.append('ASIS_Id_Carrera', $('select[name="SOL_carrera"]').val());
                        formData.append('ASIS_Id_Identificacion', $('input:text[name="codigo"]').val());
                        formData.append('ASIS_Espacio_Academico', $('select[name="SOL_laboratorios"]').val());
                        formData.append('ASIS_Espacio', $('select[name="aula"]').val());
                        formData.append('ASIS_Nombre_Materia', $('input:text[name="materia"]').val());
                        formData.append('ASIS_Cant_Estudiantes', $('input:text[name="SOL_cant_estudiantes"]').val());

                        $.ajax({
                            url: route,
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            cache: false,
                            type: type,
                            contentType: false,
                            data: formData,
                            processData: false,
                            async: async,
                            beforeSend: function () {
                                App.blockUI({target: '.portlet-form', animate: true});
                            },
                            success: function (response, xhr, request) {
                                if (request.status === 200 && xhr === 'success') {
                                    $('#form_sol_create')[0].reset(); //Limpia formulario
                                    UIToastr.init(xhr, response.title, response.message);
                                    $('#aula').val('').trigger('change');
                                    $("#SOL_carrera").val('').trigger('change');
                                    $("#SOL_laboratorios").val('').trigger('change');
                                    App.unblockUI('.portlet-form');
                                }
                            },
                            error: function (response, xhr, request) {
                                if (request.status === 422 && xhr === 'error') {
                                    UIToastr.init(xhr, response.title, response.message);
                                }
                            }
                        });
                    }
                }
            };

            var form_edit = $('#form_sol_create');
            var rules_edit = {
                codigo: {
                    required: true, number:true, remote: {
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: '{{ route('espacios.academicos.asist.verificarDocente') }}',
                        type: "POST"
                    }
                },
                SOL_laboratorios: {required: true},
                materia: {required: true, minlength: 3},
                SOL_carrera: {required: true},
                SOL_cant_estudiantes: {required: true, number: true, maxlength: 2},
                aula: {required: true}
            };
            var messages = {
                codigo: {
                    remote: "Usuario inexistente en el sistema."
                }
            };
            FormValidationMd.init(form_edit, rules_edit, messages, createUsers());

        });

    </script>
@endpush
@endpermission