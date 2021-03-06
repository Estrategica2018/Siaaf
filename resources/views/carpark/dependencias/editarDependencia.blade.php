<div class="col-md-12">
    @component('themes.bootstrap.elements.portlets.portlet', ['icon' => 'icon-book-open', 'title' => 'Formulario de actualización de datos de las dependencias'])
        @slot('actions', [
           'link_cancel' => [
               'link' => '',
               'icon' => 'fa fa-arrow-left',
                            ],
        ])

        <div class="row">
            <div class="col-md-7 col-md-offset-2">
                {!! Form::model ($dependenciaRegistrada, ['id'=>'form_dependencia_update', 'url' => '/forms'])  !!}

                <div class="form-body">

                    {!! Field:: text('PK_CD_IdDependencia',null,['label'=>'Código de la dependencia','class'=> 'form-control', 'autofocus','autocomplete'=>'off','readonly']) !!}

                    {!! Field:: text('CD_Dependencia',null,['label'=>'Nombre de la dependencia:', 'class'=> 'form-control', 'autofocus', 'maxlength'=>'50','autocomplete'=>'off'],
                                                     ['help' => 'Digite un nombre valido para la dependencia.','icon'=>'fa fa-user'] ) !!}

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 col-md-offset-0">
                                @permission('PARK_UPDATE_DEPENDENCIA')<a href="javascript:;"
                                                                            class="btn btn-outline red button-cancel"><i
                                            class="fa fa-angle-left"></i>
                                    Cancelar
                                </a>@endpermission
                                @permission('PARK_UPDATE_DEPENDENCIA'){{ Form::submit('Guardar Cambios', ['class' => 'btn blue']) }}@endpermission
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endcomponent
</div>

<script src="{{ asset('assets/main/scripts/form-validation-md.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/main/scripts/ui-toastr.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {

        var updateDependencia = function () {
            return {
                init: function () {
                    var route = '{{ route('parqueadero.dependenciasCarpark.update') }}';
                    var type = 'POST';
                    var async = async || false;

                    var formData = new FormData();
                    formData.append('PK_CD_IdDependencia', $('input:text[name="PK_CD_IdDependencia"]').val());
                    formData.append('CD_Dependencia', $('input:text[name="CD_Dependencia"]').val());

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
                                $('#form_dependencia_update')[0].reset(); //Limpia formulario
                                UIToastr.init(xhr, response.title, response.message);
                                App.unblockUI('.portlet-form');
                                var route = '{{ route('parqueadero.dependenciasCarpark.index.ajax') }}';
                                $(".content-ajax").load(route);
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
        var form = $('#form_dependencia_update');
        var formRules = {
            PK_CD_IdDependencia: {required: true},
            CD_Dependencia: {required: true, maxlength: 50, minlength: 5},
        };

        FormValidationMd.init(form, formRules, false, updateDependencia());

        $('.button-cancel').on('click', function (e) {
            e.preventDefault();
            var route = '{{ route('parqueadero.dependenciasCarpark.index.ajax') }}';
            $(".content-ajax").load(route);
        });

        $(".back").on('click', function (e) {
            e.preventDefault();
            var route = '{{ route('parqueadero.dependenciasCarpark.index.ajax') }}';
            $(".content-ajax").load(route);
        });

        $("#link_cancel").on('click', function (e) {
            var route = '{{ route('parqueadero.dependenciasCarpark.index.ajax') }}';
            $(".content-ajax").load(route);
        });


    });

</script>
