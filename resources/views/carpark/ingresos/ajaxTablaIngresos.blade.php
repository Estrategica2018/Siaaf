@permission('FUNC_CARPARK')
<div class="col-md-12">
    @component('themes.bootstrap.elements.portlets.portlet', ['icon' => 'fa fa-tasks', 'title' => 'Motocicletas dentro de la Universidad:'])
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="actions">
                    @permission('PARK_CREATE_INGRESO')<a href="javascript:;"
                                                            class="btn btn-simple btn-success btn-icon create">
                        <i class="fa fa-plus">
                        </i>Acción
                    </a>@endpermission
                    @permission('PARK_REPORT_INGRESO')<a href="javascript:;"
                                                            class="btn btn-simple btn-success btn-icon reports"
                                                            title="Reporte"><i class="glyphicon glyphicon-list-alt"></i>Reporte
                        de Ingresos</a><br>@endpermission
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                @component('themes.bootstrap.elements.tables.datatables', ['id' => 'listaMotosDentro'])
                    @slot('columns', [
                        '#',
                        'Nombre Usuario',
                        'Documento Usuario',
                        'Placa',                            
                        'Código Motocicleta'
                    ])
                @endcomponent
            </div>
        </div>
    @endcomponent
</div>
@endpermission
<script src="{{ asset('assets/main/scripts/ui-toastr.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/main/scripts/table-datatable.js') }}" type="text/javascript"></script>
<script type="text/javascript">

    jQuery(document).ready(function () {

        var table, url, columns;
        table = $('#listaMotosDentro');
        url = "{{ route('parqueadero.ingresosCarpark.tablaMotosDentro')}}";
        columns = [
            {data: 'DT_Row_Index'},
            {data: 'CI_NombresUser', name: 'CI_NombresUser'},
            {data: 'CI_CodigoUser', name: 'CI_CodigoUser'},
            {data: 'CI_Placa', name: 'CI_Placa'},
            {data: 'CI_CodigoMoto', name: 'PK_CI_IdIngreso'}
        ];
        dataTableServer.init(table, url, columns);

        $(".create").on('click', function (e) {
            e.preventDefault();
            var route = '{{ route('parqueadero.ingresosCarpark.create') }}';
            $(".content-ajax").load(route);
        });

        $(".reports").on('click', function (e) {
            e.preventDefault();
            $tr = $(this).closest('tr');
            $.ajax({}).done(function () {
                window.open('{{ route('parqueadero.reportesCarpark.ReporteMotosDentro') }}', '_blank');
            });
        });

    });
</script>