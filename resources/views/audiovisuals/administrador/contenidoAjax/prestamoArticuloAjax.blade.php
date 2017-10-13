

    {{-- BEGIN HTML SAMPLE --}}
    <div class="col-md-12">
        @component('themes.bootstrap.elements.portlets.portlet', ['icon' => 'icon-frame', 'title' => 'Gestion Reservas'])
            @slot('actions', [

                        'link_upload' => [
                            'link' => '',
                            'icon' => 'icon-cloud-upload',
                        ],
                        'link_wrench' => [
                            'link' => '',
                            'icon' => 'icon-wrench',
                        ],
                        'link_trash' => [
                            'link' => '',
                            'icon' => 'icon-trash',
                        ],

                    ])
        <br>
        <br>
        <div class="row">
            <div class="col-md-12">

                <div class="col-md-5">
                    {!! Field::text('id_funcionario',
                    ['label' => 'Ingrese Identificacion:'],
                    ['help' => 'Ingrese Estado "Activo","Inactivo"', 'icon' => 'fa fa-credit-card'])
                    !!}
                </div>
                <br>
                <div class="col-md-3">
                    {!! Form::button('Ingresar', ['class' => 'btn blue' ,'id'=>'btn_ingresar_identificacion']) !!}
                </div>

            </div>
        </div>
            <div class="row">
                <div class="col-md-12">
                {{-- BEGIN HTML MODAL CREATE --}}
                <!-- responsive -->
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
                                        ['label' => 'Nombres:', 'max' => '40', 'min' => '2', 'required', 'auto' => 'off','tabindex'=>'2'],
                                        ['help' => 'Ingrese Nombres', 'icon' => 'fa fa-user'])
                                        !!}
                                    </p>
                                    <p>
                                        {!! Field::email('FUCNIONARIO_Correo',
                                        ['label' => 'Correo Electronico:', 'max' => '40', 'min' => '10', 'required', 'auto' => 'off','tabindex'=>'5'],
                                        ['help' => 'Ingrese Email', 'icon' => ' fa fa-envelope-open'])
                                        !!}
                                    </p>
                                    <p>
                                        {!! Field::tel('FUCNIONARIO_Telefono',
                                        ['label' => 'Telefono:','required', 'auto' => 'off', 'max' => '10','tabindex'=>'6'],
                                        ['help' => 'Digita un número de teléfono.', 'icon' => 'fa fa-phone'])
                                        !!}
                                    </p>

                                </div>
                                <div class="col-md-6">
                                    <p>
                                        {!! Field::text('FUCNIONARIO_Apellidos',
                                        ['label' => 'Apellidos:', 'max' => '40', 'min' => '2', 'required', 'auto' => 'off','tabindex'=>'3'],
                                        ['help' => 'Ingrese Apellidos', 'icon' => 'fa fa-user'])
                                        !!}
                                    </p>

                                    <p>
                                        {!! Field::select('FK_FUNCIONARIO_Programa',
                                            $carrerasUdec,
                                           ['label' => 'seleccione un programa'])
                                       !!}
                                    </p>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            {!! Form::submit('INGRESAR PRESTAMO', ['class' => 'btn blue']) !!}
                            {!! Form::button('CANCELAR', ['class' => 'btn red', 'data-dismiss' => 'modal' ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                    {{-- END HTML MODAL CREATE--}}
                </div>

            </div>
        @endcomponent
        <div class="clearfix"></div>
    </div>
    {{-- END HTML SAMPLE --}}
    <script type="text/javascript">
        var FormSelect2 = function () {
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
        var guardarPrograma=false,idFuncionarioD=null;
        jQuery(document).ready(function () {
            FormSelect2.init();
            $( "#btn_ingresar_identificacion" ).on('click', function (e) {
                e.preventDefault();
                guardarPrograma=false;
                var route = '{{ route('opcionPrestamoAjax') }}';
                idfuncionarioD =$('#id_funcionario').val();
                var  route_edit = '{{route('validarInformacionFuncionario')}}'+ '/'+ idfuncionarioD;
                $.get( route_edit, function( info ) {
                    var datas=info.data;
                    idFuncionarioD=datas.id;
                    if(datas.audiovisual!=null){
                        $('#FK_FUNCIONARIO_Programa').empty();
                        $('#FK_FUNCIONARIO_Programa').attr('disabled',true);
                        $('#FK_FUNCIONARIO_Programa').append(new Option(datas.programa,datas.id_programa));
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
                                    console.log(response.data);
                                    $(response.data).each(function (key,value) {
                                        $('#FK_FUNCIONARIO_Programa').append(new Option(value.PRO_Nombre,value.id));
                                    });
                                    $('#FK_FUNCIONARIO_Programa').val([])
                                }
                            }
                        });
                        guardarPrograma=true;//funcionario no tiene asignado un programa
                    }
                    $('input:text[name="FUCNIONARIO_Nombres"]').val(datas.name);
                    $('#FUCNIONARIO_Correo').val(datas.email);
                    $('input:text[name="FUCNIONARIO_Apellidos"]').val(datas.lastname);
                    $('#FUCNIONARIO_Telefono').val(datas.phone);
                    $('#modal-info-funcionario').modal('toggle');
                });
            });
            var createPrograma = function () {
                return{
                    init: function () {
                        if(guardarPrograma==true){
                            //console.log('crear programa');
                            var route = '{{route('crearFuncionarioAdmin.storePrograma')}}';
                            var type = 'POST';
                            var async = async || false;
                            var formData = new FormData();
                            formData.append('FK_FUNCIONARIO_Programa', $('select[name="FK_FUNCIONARIO_Programa"]').val());
                            formData.append('idFuncionario', idFuncionarioD);
                            //console.log( $('select[name="FK_FUNCIONARIO_Programa"]').val());
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
                                },
                                success: function (response, xhr, request) {
                                    if (request.status === 200 && xhr === 'success') {
                                        $('#modal-info-funcionario').modal('hide');
                                        $('#from_info_funcionario')[0].reset(); //Limpia formulario
                                        //UIToastr.init(xhr , response.title , response.message  );
                                        var routeAjax = '{{route('opcionPrestamoAjax')}}';
                                        $(".content-ajax").load(routeAjax);
                                    }
                                },
                                error: function (response, xhr, request) {
                                    if (request.status === 422 &&  xhr === 'success') {
                                        UIToastr.init(xhr, response.title, response.message);
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
        });
    </script>


