@extends('material.layouts.dashboard')

@push('styles')
<!-- Datatables Styles -->
<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('title', '| Gestion Funcionarios')

@section('page-title', 'Gestion Funcionarios')

@section('page-description', 'ver, modificar, eliminar y crear nuevos funcionarios.')

@section('content')
	<div class="col-md-12">
		@component('themes.bootstrap.elements.portlets.portlet', ['icon' => 'icon-users', 'title' => 'Gestion Funcionarios'])
			<div class="clearfix"> </div><br><br><br>
			<div class="row">
				<div class="col-md-12">
					@component('themes.bootstrap.elements.tables.datatables', ['id' => 'gestionar-funcionarios-ajax'])
						@slot('columns', [
                                '#' => ['style' => 'width:20px;'],
                                'Cedula',
                                'Nombres',
                                'Correo',
                                'Programa',
                                'Acciones' => ['style' => 'width:90px;']
                            ])
					@endcomponent
				</div>
			</div>
		@endcomponent
	</div>
@endsection

@push('plugins')
<!-- Datatables Scripts -->
<script src="{{ asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
@endpush

@push('functions')
<script src="{{ asset('assets/main/scripts/table-datatable.js') }}" type="text/javascript"></script>
<script>
jQuery(document).ready(function () {
	var table, url, columns;
	table = $('#gestionar-funcionarios-ajax');
	url = "{{ route('funcionario.index') }}";

	columns = [
        {data: 'DT_Row_Index'},
        {data: 'id', "visible": false },
        {data: 'PK_FNS_Cedula', name: 'Nombre'},
        {data: 'FNS_Nombres', name: 'Correo Electronico'},
        {data: 'FNS_Correo', name: 'Correo Electronico'},
        {data: 'FK_FNS_Programa', name: 'Correo Electronico'},
        {
            defaultContent: '<a href="javascript:;" class="btn btn-simple btn-warning btn-icon edit"><i class="icon-pencil"></i></a><a href="javascript:;" class="btn btn-simple btn-danger btn-icon remove"><i class="icon-trash"></i></a>',
            data:'action',
            name:'action',
            title:'Acciones',
            orderable: false,
            searchable: false,
            exportable: false,
            printable: false,
            className: 'text-right',
            render: null,
            responsivePriority:2
        }
    ];
    dataTableServer.init(table, url, columns);

    table = table.DataTable();
    table.on('click', '.remove', function (e) {
        e.preventDefault();
        $tr = $(this).closest('tr');
        var dataTable = table.row($tr).data();
        alert(dataTable.id);
    });
    table.on('click', '.edit', function (e) {
        e.preventDefault();
        $tr = $(this).closest('tr');
        var dataTable = table.row($tr).data();
        alert(dataTable.id);
    });
});
</script>
@endpush