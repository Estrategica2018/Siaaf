<div class="col-md-12">
    @component('themes.bootstrap.elements.portlets.portlet', ['icon' => 'fa fa-tasks', 'title' => 'Historiales del parqueadero:'])
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="actions">
                    @permission('PARK_REPORT_HISTORIAL')<a href="javascript:;"
                                                              class="btn btn-simple btn-success btn-icon reports"
                                                              title="Reporte"><i
                                class="glyphicon glyphicon-list-alt"></i>Reporte
                        Histórico</a>@endpermission
                    @permission('PARK_REPORT_HISTOFECHA')<a href="javascript:;"
                                                               class="btn btn-simple btn-success btn-icon reporteFecha"
                                                               title="Reporte"><i
                                class="glyphicon glyphicon-list-alt"></i>Reporte
                        Fechas</a>@endpermission
                    @permission('PARK_REPORT_HISTOCODIGO')<a href="javascript:;"
                                                                class="btn btn-simple btn-success btn-icon reporteCodigo"
                                                                title="Reporte"><i
                                class="glyphicon glyphicon-list-alt"></i>Reporte
                        Por Documento</a>@endpermission
                    @permission('PARK_REPORT_HISTOPLACA')<a href="javascript:;"
                                                               class="btn btn-simple btn-success btn-icon reportePlaca"
                                                               title="Reporte"><i
                                class="glyphicon glyphicon-list-alt"></i>Reporte
                        Por Placa</a>@endpermission

                    <br>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                @component('themes.bootstrap.elements.tables.datatables', ['id' => 'listaHistoriales'])
                    @slot('columns', [
                        '#',
                        'Nombre Usuario',
                        'Documento Usuario',
                        'Placa',
                        'Fecha/Hora Entrada',
                        'Fecha/Hora Salida'
                    ])
                @endcomponent
            </div>
        </div>
    @endcomponent
</div>

<script src="{{ asset('assets/main/scripts/ui-toastr.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/main/scripts/table-datatable.js') }}" type="text/javascript"></script>
<script type="text/javascript">

    jQuery(document).ready(function () {

        var table, url, columns;
        table = $('#listaHistoriales');
        url = "{{ route('parqueadero.dependenciasCarpark.tablaHistoriales')}}";
        columns = [
            {data: 'DT_Row_Index'},
            {data: 'CH_NombresUser', name: 'CH_NombresUser'},
            {data: 'CH_CodigoUser', name: 'CH_CodigoUser'},
            {data: 'CH_Placa', name: 'CH_Placa'},
            {data: 'CH_FHentrada', name: 'CH_FHentrada'},
            {data: 'CH_FHsalida', name: 'CH_FHsalida'}
        ];
        dataTableServer.init(table, url, columns);

        $(".reports").on('click', function (e) {
            e.preventDefault();
            $tr = $(this).closest('tr');
            $.ajax({}).done(function () {
                window.open('{{ route('parqueadero.reportesCarpark.ReporteHistorico') }}', '_blank');
            });
        });

        $(".reporteFecha").on('click', function (e) {
            e.preventDefault();
            $tr = $(this).closest('tr');
            $.ajax({}).done(function () {
                var route = '{{ route('parqueadero.historialesCarpark.filtrarFecha') }}';
                $(".content-ajax").load(route);
            });
        });

        $(".reporteCodigo").on('click', function (e) {
            e.preventDefault();
            $tr = $(this).closest('tr');
            $.ajax({}).done(function () {
                var route = '{{ route('parqueadero.historialesCarpark.filtrarCodigo') }}';
                $(".content-ajax").load(route);
            });
        });

        $(".reportePlaca").on('click', function (e) {
            e.preventDefault();
            $tr = $(this).closest('tr');
            $.ajax({}).done(function () {
                var route = '{{ route('parqueadero.historialesCarpark.filtrarPlaca') }}';
                $(".content-ajax").load(route);
            });
        });

    });
</script>