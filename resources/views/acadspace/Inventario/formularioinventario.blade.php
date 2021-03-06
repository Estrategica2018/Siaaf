@permission('ACAD_INCIDENTES') @extends('material.layouts.dashboard') @push('styles') {{--Select2--}}
<link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css"
/>
<link href="{{ asset('assets/global/plugins/select2material/css/pmd-select2.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/dropzone/basic.min.css') }}" rel="stylesheet" type="text/css" />
<!-- MODAL -->
<link href="{{ asset('assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') }}" rel="stylesheet" type="text/css"
/>
<link href="{{ asset('assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css') }}" rel="stylesheet" type="text/css"
/>
<!-- DATATABLE  -->
<link href="{{ asset('https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet"
    type="text/css" /> {{--toast--}} {{--
<link href="{{asset('assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />--}} {{--JQuery datatable and row details--}}
<link href="{{ asset('assets/main/acadspace/css/rowdetails.css') }}" rel="stylesheet" type="text/css" /> @endpush @section('content') {{-- BEGIN HTML SAMPLE --}}
<div class="col-md-12">
    @component('themes.bootstrap.elements.portlets.portlet', ['icon' => 'icon-info', 'title' => 'Registrar Articulo'])
    <div class="clearfix">
    </div>
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="actions">
                @permission('ACAD_REGISTRAR_INCIDENTE')
                <a class="btn btn-simple btn-success btn-icon create" data-toggle="modal">
                    <i class="fa fa-plus">
                    </i>
                    Registrar Articulo
                </a>
                @endpermission
            </div>
        </div>
    </div>
    <div class="clearfix">
    </div>
    <br>
    <div class="col-md-12">
        {{--DATATABLE--}}
        <div class="portlet-body">
            @permission('ACAD_CONSULTAR_INCIDENTE') @component('themes.bootstrap.elements.tables.datatables', ['id' => 'art-table-ajax',
            'class' => 'table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-column collapsed']) @slot('columns', ['id_articulo',' ',
            'Codigo', 'Procedencia', 'Categoria', 'Hoja de vida', ' ' => ['style' => 'width:60px;'] ]) @endcomponent @endpermission
        </div>
    </div>
    <div class="clearfix">
    </div>
    <div class="col-md-12">

        {{-- BEGIN HTML MODAL CREATE --}}
        <!-- responsive -->
        <div class="modal fade" data-width="760" id="modal-create-articulo" tabindex="-1">
            <div class="modal-header modal-header-success">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                </button>
                <h2 class="modal-title">
                    <i class="glyphicon glyphicon-tv">
                    </i>
                    Registrar articulo.
                </h2>
            </div>
            <div class="modal-body">
                <div class="portlet light " id="form_wizard_1">
                    <div class="portlet-body form">
                        {!! Form::open(['id' => 'form_create_inventary', 'class' => '', 'url'=>'/forms']) !!}
                        <div class="form-wizard">
                            <div class="col-md-12">
                                {!! Field:: text('codigo',['required', 'label' => 'codigo', 'max' => '30', 'min' => '3', 'auto' => 'off', 'rows' => '1'],
                                ['help' => 'Escriba el codigo o serial asociado al articulo que pretende registrar','icon'=>'fa
                                fa-barcode'] ) !!} {!! Field::select('Categoria del articulo:',$categoria, ['id' => 'categoria',
                                'name' => 'categoria']) !!} {!! Field:: textarea('descripcion',['required', 'label' => 'descripcion',
                                'max' => '450', 'min' => '15', 'auto' => 'off', 'rows' => '3'], ['help' => 'Digite la descripción
                                del articulo','icon'=>'fa fa-desktop'] ) !!}
                                <div>
                                    <h3 class="block">Subir imagenes del articulo</h3>
                                    <h6>10 archivos maximos</h6>
                                </div>
                                <div class="form-group">
                                    <div class="dropzone dropzone-file-area data-dz-size" id="my_dropzone">
                                        <h3 class="sbold">Arrastra o da click aquí para cargar las imagenes</h3>
                                        <p> Solo se admiten formatos JPEG - JPG - PNG </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <div class="modal-footer">
                                @permission('ACAD_CONSULTAR_INCIDENTE') {!! Form::submit('Guardar', ['class' => 'btn blue button-submit']) !!} @endpermission
                                {!! Form::button('Cancelar', ['class' => 'btn red', 'data-dismiss' => 'modal' ]) !!}
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="modal-footer">
            </div>
            {{-- END HTML MODAL CREATE--}} {{-- END HTML MODAL CREATE--}}
        </div>
        @endcomponent
    </div>
    {{-- END HTML SAMPLE --}} @endsection @push('plugins')
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/jquery-validation/js/localization/messages_es.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}" type="text/javascript"></script>
    {{--Selects--}}
    <script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <!-- SCRIPT DATATABLE -->
    <script src="{{ asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/pages/scripts/table-datatables-responsive.min.js') }}" type="text/javascript"></script>
    <!-- SCRIPT MODAL -->
    <script src="{{ asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js') }}" type="text/javascript"></script>
    <!-- SCRIPT Validacion Maxlength -->
    <script src="{{ asset('assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}" type="text/javascript">
    </script>
    <!-- SCRIPT Validacion Personalizadas -->
    <!-- DROPZONE-->
    <script src="{{ asset('assets/global/plugins/dropzone/dropzone.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}" type="text/javascript"></script>

    <!-- SCRIPT MENSAJES TOAST-->
    <script src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    @endpush @push('functions')
    <!--HANDLEBAR-->
    {{-- wizard Scripts --}}
    <script src="{{ asset('assets/main/acadspace/js/form-wizard.js') }}" type="text/javascript"></script>
    <!-- Estandar Mensajes -->
    <script src="{{ asset('assets/main/acadspace/js/handlebars.js') }}"></script>
    <script src="{{ asset('assets/main/scripts/form-validation-md.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/main/scripts/form-validation-md.js') }}" type="text/javascript"></script>
    <!-- Estandar Mensajes -->
    <script src="{{ asset('assets/main/scripts/ui-toastr.js') }}" type="text/javascript"></script>
    <!-- Estandar Datatable -->
    <script src="{{ asset('assets/main/scripts/table-datatable.js') }}" type="text/javascript"></script>
    {{--Dropzone--}}
    <script src="{{ asset('assets/main/scripts/dropzone.js') }}" type="text/javascript"></script>
    {{--ROW DETAILS DESPLEGABLE--}}
    
    <script>
        function format(d) {
            // `d` is the original data object for the row
            return '<table class=table table-striped table-bordered table-hover dt-responsive dataTable no-footer collapsed">' +
                '<tr>' +
                '<td>Full name:</td>' +
                '<td>'+d.codigo_articulo + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Extension number:</td>' +
                '<td>' +d.codigo_articulo+ '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Extra info:</td>' +
                '<td>And any further details here (images etc)...</td>' +
                '</tr>' +
                '</table>';
        }
        $(document).ready(function () {
            //inicializar select

            $.fn.select2.defaults.set("theme", "bootstrap");
            $(".pmd-select2").select2({
                placeholder: "Seleccionar",
                allowClear: true,
                width: 'auto',
                escapeMarkup: function (m) {
                    return m;
                }
            });
            /*Validaciones*/
            var $form = $('#form_create_inventary'),
                $wizard = $('#form_wizard_1');
            var rules = {
                codigo: {
                    minlength: 3,
                    required: true
                },
                descripcion: {
                    required: true,
                    minlength: 15
                },
                email: {
                    email: true,
                    required: true
                }
            };
            var messages = {};
            $wizard.bootstrapWizard(FormWizard.init($wizard, $form, rules, messages, false));
            var method = function () {
                return {
                    init: function () {
                        return valores = {
                            'titulo': $('input[name="titulo"]').val(),
                            'descripcion': $('textarea[name="descripcion"]').val(),
                            'email': $('input[name="email"]').val()
                        }
                    }
                };
            };
            var type_crud = 'CREATE',
                route_store = route('espacios.academicos.formacad.store'),
                formatfile = 'image/*,.jpeg,.jpg,.png,.JPEG,.JPG,.PNG',
                numfile = 10;
            FormDropzone.init(route_store, formatfile, numfile, method(), type_crud);
            var table, url, columns;
            //Define que tabla cargara los datos
            table = $('#art-table-ajax');
            url = "{{ route('espacios.academicos.elementos.data') }}"; //url para cargar datos
            columns = [
                //Carga los datos que ha traido el control
                
                {
                    data: 'pk_id_articulo',
                    name: 'id_articulo',
                    "visible": false
                },
                {
                    "className": 'details-control',
                    "orderable": false,
                    "searchable": false,
                    "data": null,
                    "defaultContent": ''
                },
                {
                    data: 'codigo_articulo',
                    name: 'Codigo'
                },
                {
                    data: 'procedencia.tipo_procedencia',
                    name: 'Procedencia'
                },
                {
                    data: 'categoria.nombre_categoria',
                    name: 'Categoria'
                },
                {
                    data: 'hojavida',
                    name: 'Hoja de vida'
                },
                {
                    //Boton para descargar el archivo
                    defaultContent: '@permission('ACAD_DESCARGAR_FORMATO') <div class="btn-group pull-right"><button class="btn green btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">Opciones<i class="fa fa-angle-down"></i></button><ul class="dropdown-menu pull-right"><li><a href="javascript:;"><i class="fa fa-print"></i> Eliminar </a></li><li><a href="javascript:;"><i class="fa fa-file-pdf-o"></i> Ver imagenes </a></li><li><a href="javascript:;"><i class="fa fa-file-excel-o"></i> Editar </a></li></ul></div> @endpermission',
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    exportable: false,
                    printable: false,
                    //className: 'text-right',
                    render: null,
                    responsivePriority: 2
                }
            ];
            dataTableServer.init(table, url, columns);
            table = table.DataTable();
            //BOTON DETALLES
            // Array to track the ids of the details displayed rows
            // Add event listener for opening and closing details
           $('#art-table-ajax tbody').on('click','td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');

                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                    
                }
            });

            /*ABRIR MODAL*/
            $(".create").on('click', function (e) {
                e.preventDefault();
                $('#modal-create-articulo').modal('toggle');
            });


        });
    </script>
    @endpush @endpermission