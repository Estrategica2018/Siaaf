@extends('material.layouts.dashboard')
@push('styles')
    <!-- STYLES SELECT -->
    <link href="{{ asset('assets/global/plugins/select2material/css/select2.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/global/plugins/select2material/css/select2-bootstrap.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/global/plugins/select2material/css/pmd-select2.css') }}" rel="stylesheet"
          type="text/css"/>
    {{--MODAL--}}
    <link href="{{ asset('assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css') }}" rel="stylesheet"
          type="text/css"/>
    {{--DATEPICKER--}}
    <link href="{{ asset('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
          rel="stylesheet" type="text/css"/>
    {{--TOAST--}}
    <link href="{{asset('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Styles SREETALERT  -->
    <link href="{{asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.css')}}" rel="stylesheet"
          type="text/css"/>
    <!-- Styles SWITCH  -->
    <link href="{{asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('title', '|Solicitud Prestamo')
@section('page-title', 'Solicitud Prestamo')
@section('content')
    <div class="col-md-12">
        @component('themes.bootstrap.elements.portlets.portlet', ['icon' => 'icon-frame', 'title' => 'Realizar Prestamo'])
        <br>
        <br>
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(['id' => 'form_identificacion', 'class' => '', 'url' => '/forms']) !!}
                    <div class="col-md-5">
                        {!! Field::text('id_funcionario',

                            ['label' => 'Ingrese Identificación:', 'auto' => 'off', 'max' => '10'],
                            ['help' => 'Digite Numero de identificación valido', 'icon' => 'fa fa-credit-card'])
                        !!}
                    </div>
                    <br>
                    <div class="col-md-3">
                        @permission('AUDI_REQUESTS_ENTER')
                        {!! Form::submit('Ingresar', ['class' => 'btn blue' ,'id'=>'btn_ingresar_identificacion']) !!}
                        @endpermission
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="modal fade" data-width="760" id="modal-info-funcionario" tabindex="-1">
                        <div class="modal-header modal-header-success">
                            <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                            </button>
                            <h2 class="modal-title">
                                <i class="glyphicon glyphicon-user">
                                </i>
                                Informacion Funcionario
                            </h2>
                        </div>
                        <div class="modal-body">
                            {!! Form::open(['id' => 'from_info_funcionario', 'class' => '', 'url' => '/forms']) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <p>
                                        {!! Field::text('FUCNIONARIO_Nombres',
                                        ['disabled','label' => 'Nombres:', 'max' => '40', 'min' => '2', 'required', 'auto' => 'off','tabindex'=>'2'],
                                        ['help' => 'Ingrese Nombres', 'icon' => 'fa fa-user'])
                                        !!}
                                    </p>
                                    <p>
                                        {!! Field::email('FUCNIONARIO_Correo',
                                        ['disabled','label' => 'Correo Electronico:', 'max' => '40', 'min' => '10', 'required', 'auto' => 'off','tabindex'=>'5'],
                                        ['help' => 'Ingrese Email', 'icon' => ' fa fa-envelope-open'])
                                        !!}
                                    </p>
                                    <p>
                                        {!! Field::tel('FUCNIONARIO_Telefono',
                                        ['disabled','label' => 'Telefono:','required', 'auto' => 'off', 'max' => '10','tabindex'=>'6'],
                                        ['help' => 'Digita un número de teléfono.', 'icon' => 'fa fa-phone'])
                                        !!}
                                    </p>

                                </div>
                                <div class="col-md-6">
                                    <p>
                                        {!! Field::text('FUCNIONARIO_Apellidos',
                                        ['disabled','label' => 'Apellidos:', 'max' => '40', 'min' => '2', 'required', 'auto' => 'off','tabindex'=>'3'],
                                        ['help' => 'Ingrese Apellidos', 'icon' => 'fa fa-user'])
                                        !!}
                                    </p>
                                    <p>
                                        {!! Field::select('FK_FUNCIONARIO_Programa',
                                            null,
                                           ['label' => 'seleccione un programa'])
                                       !!}
                                    </p>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            @permission('AUDI_REQUESTS_ENTER')
                            {!! Form::submit('INGRESAR PRESTAMO', ['class' => 'btn blue']) !!}
                            {!! Form::button('CANCELAR', ['class' => 'btn red', 'data-dismiss' => 'modal' ]) !!}
                            @endpermission
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        @endcomponent
        <div class="clearfix"></div>
    </div>
@endsection
@push('plugins')
    <!-- SCRIPT MODAL -->
    <script src="{{ asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') }}"
            type="text/javascript">
    </script>
    <script src="{{ asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js') }}" type="text/javascript">
    </script>
    <!-- SCRIPT SELECT -->
    <script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript">
    </script>
    <!-- SCRIPT REPEATER -->
    {{--<script src="{{ asset('assets/pages/scripts/form-repeater.min.js') }} " type="text/javascript"></script>--}}
    <script src="{{ asset('assets/global/plugins/jquery-repeater/jquery.repeater.js') }} "
            type="text/javascript"></script>
    <!-- SCRIPT DATEPICKER -->
    <script src="{{ asset('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"
            type="text/javascript"></script>
    <!-- SCRIPT Validacion Personalizadas -->
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"
            type="text/javascript">
    </script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"
            type="text/javascript">
    </script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/localization/messages_es.js') }}"
            type="text/javascript">
    </script>
    <!-- SCRIPT MENSAJES TOAST-->
    <script src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript">
    </script>
    <!-- SCRIPT Validacion Maxlength -->
    <script src="{{ asset('assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"
            type="text/javascript">
    </script>
@endpush
@push('functions')
    <!-- Estandar Validacion -->
    <script src="{{ asset('assets/main/scripts/form-validation-md.js') }}" type="text/javascript">
    </script>
    <!-- Estandar Mensajes -->
    <script src="{{ asset('assets/main/scripts/ui-toastr.js') }}" type="text/javascript">
    </script>
    <!-- SCRIPT Confirmacion Sweetalert -->
    <script src="{{ asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript">
    </script>
    <!-- Estandar Datatable -->
    <script src="{{ asset('assets/main/scripts/table-datatable.js') }}" type="text/javascript">
    </script>
    <!-- SWITCH-->
    <script type="text/javascript">
        var handleBootstrapSwitch = function() {
            if (!$().bootstrapSwitch) {
                return;
            }
            $('.make-switch').bootstrapSwitch();
        };
        var ComponentsSelect2 = function () {
            return {
                init: function () {
                    $.fn.select2.defaults.set("theme", "bootstrap");
                    $(".pmd-select2").select2({
                        placeholder: "Selecccionar",
                        allowClear: true,
                        width: 'auto',
                        escapeMarkup: function (m) {
                            return m;
                        }
                    });
                }
            }
        }();
        var ComponentsBootstrapMaxlength = function () {
            var handleBootstrapMaxlength = function () {
                $("input[maxlength], textarea[maxlength]").maxlength({
                    alwaysShow: true,
                    appendToParent: true
                });
            }
            return {
                init: function () {
                    handleBootstrapMaxlength();
                }
            };
        }();
        var guardarPrograma = false,idFuncionarioD = null;
        jQuery(document).ready(function () {
            App.unblockUI('.portlet-form');
            ComponentsSelect2.init();
            var createPrograma = function () {
                return{
                    init: function () {
                        if( guardarPrograma == true ){
                            var route = '{{route('crearFuncionarioAdmin.storePrograma')}}';
                            var type = 'POST';
                            var async = async || false;
                            var formData = new FormData();
                            formData.append('FK_FUNCIONARIO_Programa', $('select[name="FK_FUNCIONARIO_Programa"]').val());
                            formData.append('idFuncionario', idFuncionarioD);
                            $.ajax({
                                url: route,
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
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
                                        $('#modal-info-funcionario').modal('hide');
                                        $('#from_info_funcionario')[0].reset(); //Limpia formulario
                                        UIToastr.init(xhr , response.title , response.message  );
                                        var routeAjax = '{{route('opcionPrestamoAjax')}}';
                                        $(".content-ajax").load(routeAjax);
                                        App.unblockUI('.portlet-form');
                                    }
                                },
                                error: function (response, xhr, request) {
                                    if (request.status === 422 &&  xhr === 'error') {
                                        UIToastr.init(xhr, response.title, response.message);
                                        App.unblockUI('.portlet-form');
                                    }
                                }
                            });
                        }
                        else{
                            $('#modal-info-funcionario').modal('hide');
                            var routeAjax = '{{route('opcionPrestamoAjax')}}';
                            $(".content-ajax").load(routeAjax);
                        }
                    }
                }
            };
            var form_create = $('#from_info_funcionario');
            var rules_create = {
                FK_FUNCIONARIO_Programa:{required: true}
            };
            FormValidationMd.init(form_create,rules_create,false,createPrograma());
            var createIngreso = function () {
                return{
                    init: function () {
                        guardarPrograma=false;
                        var route = '{{ route('opcionPrestamoAjax') }}';
                        idFuncionarioD = $('#id_funcionario').val();
                        var  route_edit = '{{route('validarInformacionFuncionario')}}'+ '/'+ idFuncionarioD;
                        $.get( route_edit, function( info ) {
                            var datas = info.data;
                            idFuncionarioD=datas.id;
                            if(datas.audiovisual!=null){
                                if(datas.numeroPrestamos){
                                    swal(
                                        'Oops...',
                                        'Lo sentimos el usuario solo puede realizar un maximo de '+datas.numeroPrestamosMaximos+' prestamos!',
                                        'error'
                                    )
                                }else{
                                    $('#FK_FUNCIONARIO_Programa').empty();
                                    $('#FK_FUNCIONARIO_Programa').attr('disabled',true);
                                    $('#FK_FUNCIONARIO_Programa').append(new Option(datas.programa,datas.id_programa));
                                    $('input:text[name="FUCNIONARIO_Nombres"]').val(datas.name);
                                    $('#FUCNIONARIO_Correo').val(datas.email);
                                    $('input:text[name="FUCNIONARIO_Apellidos"]').val(datas.lastname);
                                    $('#FUCNIONARIO_Telefono').val(datas.phone);
                                    $('#modal-info-funcionario').modal('toggle');
                                }
                            }
                            else{
                                $('#FK_FUNCIONARIO_Programa').empty();
                                $('#FK_FUNCIONARIO_Programa').attr('disabled',false);
                                var listarProgramas= '{{ route('listarProgramas') }}';
                                $.ajax({
                                    url: listarProgramas,
                                    type: 'GET',
                                    beforeSend: function () {
                                        App.blockUI({target: '.portlet-form', animate: true});
                                    },
                                    success: function (response, xhr, request) {
                                        if (request.status === 200 && xhr === 'success') {
                                            App.unblockUI('.portlet-form');
                                            $(response.data).each(function (key,value) {
                                                $('#FK_FUNCIONARIO_Programa').append(new Option(value.PRO_Nombre,value.id));
                                            });
                                            $('#FK_FUNCIONARIO_Programa').val([])
                                        }
                                    },
                                    error: function (response, xhr, request) {
                                        if (request.status === 422 &&  xhr === 'error') {
                                            UIToastr.init(xhr, response.title, response.message);
                                            App.unblockUI('.portlet-form');
                                        }
                                    }
                                });
                                guardarPrograma=true;//funcionario no tiene asignado un programa
                                $('input:text[name="FUCNIONARIO_Nombres"]').val(datas.name);
                                $('#FUCNIONARIO_Correo').val(datas.email);
                                $('input:text[name="FUCNIONARIO_Apellidos"]').val(datas.lastname);
                                $('#FUCNIONARIO_Telefono').val(datas.phone);
                                $('#modal-info-funcionario').modal('toggle');
                            }
                        });
                    }
                }
            };
            $.ajaxSetup({
                headers:
                    {
                        'X-CSRF-Token': $('input[name="_token"]').val()
                    }
            });
            var from_identificacion = $('#form_identificacion');
            var rules_identificacion = {
                //name_edit: {minlength: 5, required: true},
                id_funcionario: {
                    minlength: 3,
                    required: true,
                    remote: {
                        url: "{{ route('identificacion.validar') }}",
                        type: "post"
                    }

                }
            };
            var messages= {
                id_funcionario: {
                    remote: 'El funcionario no existe'
                },
            };
            FormValidationMd.init(from_identificacion,rules_identificacion,messages,createIngreso());
            $("#form_identificacion").validate({
                onkeyup: false //turn off auto validate while typing-pausa  validacion despues de escribir
            });
        });
    </script>
@endpush