<div class="col-md-12">
    @component('themes.bootstrap.elements.portlets.portlet', ['icon' => 'icon-frame', 'title' => 'Registrar Novedad'])

        <div class="row">
            <div class="col-md-4 col-lg-offset-9">
                <a href="{{route('adminRegist.help.index.preguntas')}}"
                   class="btn btn-simple dark btn-icon"><i
                            class="fa fa-plus"></i>Preguntas Frecuentes</a>
            </div>
            <div class="col-md-12 col-lg-offset-1">
                <div class="col-md-4 col-lg-offset-3">
                    <div class="alert alert-block alert-info fade in">
                        <h4 class="alert-heading">Información!</h4>
                        <p>Si no se encuentra registrado por favor presione el boton Registrarse: </p>
                        <div class="col-lg-offset-3">
                            <br>
                                <a href="javascript:;" class="btn btn-simple btn-success btn-icon btn-center create"><i
                                            class="fa fa-plus"></i>Registrarse</a>
                                <br>
                            </p>
                        </div>
                    </div>
                </div>
                {!! Form::open(['id' => 'form_register', 'class' => 'form-horizontal', 'url' => '/forms']) !!}
                <div class="form-group">
                    <div class="col-md-4 col-lg-offset-3 text-left">
                        {!! Field::text('number_document', old('number_document'), ['required', 'max' => 13, 'min' => '5', 'type' => 'number','label' => 'Numero de Documento', 'autofocus', 'auto' => 'off'], ['icon' => 'fa fa-sort-numeric-asc', 'help' => 'Ingrese el Numero.']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 col-lg-offset-3 text-left">
                        {!! Field::select(
                        'novedad',null,
                        ['required', 'label' => 'Novedades' , 'autofocus', 'auto' => 'off']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 col-lg-offset-3 text-center">

                        {{ Form::submit('Registrar', ['class' => 'btn blue']) }}
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    @endcomponent
</div>
<script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/main/scripts/form-validation-md.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/main/scripts/ui-toastr.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {

        /* Configuración del Select cargado de la BD */

        var $widget_select_SelectNovedad = $('select[name="novedad"]');

        var route_Dependencia = '{{ route('adminRegist.registros.listNovedades') }}';
        $.get(route_Dependencia, function (response, status) {
            $(response.data).each(function (key, value) {
                $widget_select_SelectNovedad.append(new Option(value.NOV_NombreNovedad, value.PK_NOV_IdNovedad));
            });
            $widget_select_SelectDependencia.val([]);
            $('#PK_NOV_IdNovedad').val(1);
        });


        var $form = $('#form_register');

        var form_rules = {
            number_document: {
                minlength: 5, number: true, maxlength: 13, required: true
            },
            novedad: {required: true}

        };
        var messages = {};

        var register = function () {
            return {
                init: function () {
                    var route = '{{ route('adminRegist.registros.registro') }}';
                    var type = 'POST';
                    var async = async || false;

                    var formData = new FormData();
                    formData.append('number_document', $('input[name="number_document"]').val());
                    formData.append('novedad', $('select[name="novedad"]').val());

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
                            console.log(response);
                            if (request.status === 200 && xhr === 'success') {
                                if (response.title === 'false') {
                                    UIToastr.init('error', '¡Lo sentimos!', 'El usuario no se encuentra registrado.');
                                    App.unblockUI('.portlet-form');
                                } else {
                                    $('#form_register')[0].reset(); //Limpiar formulario
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
                                    UIToastr.init(xhr, response.title, response.message);
                                    App.unblockUI('.portlet-form');
                                    //var route = ' //route('administrative.user.index.ajax') }}';
                                    //$(".content-ajax").load(route);
                                }

                            }
                        },
                        error: function (response, xhr, request) {
                            if (request.status === 422 && xhr === 'error') {
                                UIToastr.init(xhr, response.title, response.message);
                                App.unblockUI('.portlet-form');
                            }
                        }
                    });
                }
            }
        };

        FormValidationMd.init($form, form_rules, messages, register());
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

        $(".create").on('click', function (e) {
            e.preventDefault();
            var route_create = '{{ route('adminRegist.users.create') }}';
            $(".content-ajax").load(route_create);
        });

        $('.button-cancel').on('click', function (e) {
            e.preventDefault();
            var route = '{{ route('adminRegist.users.index.ajax') }}';
            $(".content-ajax").load(route);
        });

        //Aplicar la validación en select2 cambio de valor desplegable, esto sólo es necesario para la integración de lista desplegable elegido.
        $('.pmd-select2', $form).change(function () {
            $form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });
    });

</script>