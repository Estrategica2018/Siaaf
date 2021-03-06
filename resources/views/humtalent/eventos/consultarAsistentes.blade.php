    <div class="col-md-12">
        @component('themes.bootstrap.elements.portlets.portlet', ['icon' => 'fa fa-tasks', 'title' => 'Asistentes al evento:'])
            @slot('actions', [
                   'link_cancel' => [
                   'link' => '',
                   'icon' => 'fa fa-arrow-left',
                  ],
           ])
        <br><br>
            <div class="row">
                <div class="col-md-12"><br>
                    @component('themes.bootstrap.elements.tables.datatables', ['id' => 'lista-empleados'])
                        @slot('columns', [
                            '#',
                            'Nombres',
                            'Apellidos',
                            'Cédula',
                            'Teléfono',
                            'Email',
                            'Rol ',
                            'Acciones'
                        ])
                    @endcomponent
                </div>
            </div>

            {!! Field::hidden('FK_TBL_Eventos_IdEvento',$id,['id'=>'idEvent']) !!}
            ><div class="col-md-6">
                <div class="btn-group">
                    <a href="javascript:;" class="btn btn-simple btn-success btn-icon asistents">
                        <i class="fa fa-user"></i>Registrar Asistentes
                    </a>
                </div>
            </div>


        @endcomponent
    </div>
<!-- Datatables y Toastr Scripts -->
<script src="{{ asset('assets/main/scripts/ui-toastr.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/main/scripts/table-datatable.js') }}" type="text/javascript"></script>
<script type="text/javascript">

jQuery(document).ready(function () {

    var table, url, columns;
    table = $('#lista-empleados');
    url = "{{ route('talento.humano.tablaAsistentes',$id)}}";
    columns = [
        {data: 'DT_Row_Index'},
        {data: 'PRSN_Nombres', name: 'Nombres'},
        {data: 'PRSN_Apellidos', name: 'Apellidos'},
        {data: 'PK_PRSN_Cedula', name: 'Cédula'},
        {data: 'PRSN_Telefono', name: 'Teléfono'},
        {data: 'PRSN_Correo', name: 'Correo Electronico'},
        {data: 'PRSN_Rol', name: 'Rol'},
        {
            defaultContent: '<a href="javascript:;" class="btn btn-simple btn-danger btn-icon remove"><i class="icon-trash"></i></a>',
            data: 'action',
            name: 'action',
            title: 'Acciones',
            orderable: false,
            searchable: false,
            exportable: false,
            printable: false,
            className: 'text-center',
            render: null,
            serverSide: false,
            responsivePriority: 2
        }
    ];

    dataTableServer.init(table, url, columns);
    table = table.DataTable();
    table.on('click', '.remove', function (e) {
        e.preventDefault();
        $tr = $(this).closest('tr');
        var dataTable = table.row($tr).data();
        var id = document.getElementById("idEvent").value;
        var route = '{{ route('talento.humano.evento.asistentes.deleteAsist') }}' + '/' + id + '/' + dataTable.PK_PRSN_Cedula;
        var type = 'GET';
        var async = async || false;
        swal({
                title: "¿Esta seguro?",
                text: "¿Esta seguro de eliminar el asistente seleccionado?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "De acuerdo",
                cancelButtonText: "Cancelar",
                closeOnConfirm: true,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        url: route,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        cache: false,
                        type: type,
                        contentType: false,
                        processData: false,
                        async: async,
                        success: function (response, xhr, request) {
                            if (request.status === 200 && xhr === 'success') {
                                table.ajax.reload();
                                UIToastr.init(xhr, response.title, response.message);
                            }
                        },
                        error: function (response, xhr, request) {
                            if (request.status === 422 &&  xhr === 'error') {
                                UIToastr.init(xhr, response.title, response.message);
                            }
                        }

                    })
                } else {
                    swal("Cancelado", "No se eliminó ningun asistente", "error");
                }
            });

    });

    $( ".asistents" ).on('click', function (e) {
        e.preventDefault();
        var idEvento = $('input[id="idEvent"]').val();
        var route = '{{ route('talento.humano.evento.regAsist') }}'+'/'+idEvento;
        $(".content-ajax").load(route);
    });

    $( "#link_cancel" ).on('click', function () {
        var route = '{{ route('talento.humano.evento.index.ajax') }}';
        $(".content-ajax").load(route);
    });
});

</script>