@extends('material.layouts.dashboard')

@section('page-title', 'Registro de solicitud:')

@section('content')
    <div class="col-md-12">
        @component('themes.bootstrap.elements.portlets.portlet', ['icon' => 'icon-book-open', 'title' => 'Formulario registro de solicitud'])



        <div class="row">
            <div class="col-md-7 col-md-offset-2">
            {!! Field::date(
            'articulo',
            ['label' => 'Seleccione las fechas en las que usara el espacio', 'required', 'auto' => 'off', 'data-date-format' => "yyyy-mm-dd", 'data-date-start-date' => "+0d"],
            ['help' => 'Seleccione las fechas.', 'icon' => 'fa fa-calendar']) !!}

           <!-- <ul id="lista"></ul> -->

            <button onclick="copiar()" id="agregar" class="btn blue"><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></button>
        </div>
            </div>
                <div class="row">
                <div class="col-md-7 col-md-offset-2">
                    {!! Form::open (['method'=>'POST', 'route'=> ['espacios.academicos.espacad.store']]) !!}
                    <div class="form-body">
                        {!! Field:: text('fechas_Solicitadas',null,['label'=>'Fechas seleccionadas:', 'class'=> 'form-control', 'autofocus', 'autocomplete'=>'off'],
                                                         ['help' => 'Fecchas seleccionadas desde el calendario','icon'=>'fa fa-calendar'] ) !!}


                        {!! Field::radios('SOL_ReqGuia',['Si'=>'Si', 'No'=>'No'], ['list', 'label'=>'Requiere guia de practica', 'icon'=>'fa fa-user']) !!}

                        {!! Field::text('SOL_nucleo_tematico',null,['label'=>'Nucleo tematico:', 'class'=> 'form-control', 'autofocus', 'maxlength'=>'40','autocomplete'=>'off'],
                        ['help' => 'Digite el nucleo tematico.','icon'=>'fa fa-building-o'] ) !!}


                        {!! Field::radios('SOL_ReqSoft',['Si'=>'Si', 'No'=>'No'], ['list', 'label'=>'Requiere software', 'icon'=>'fa fa-user']) !!}


                        {!! Field::text('SOL_NombSoft',null,['label'=>'Nombre Software','class'=> 'form-control', 'autofocus', 'maxlength'=>'40','autocomplete'=>'off'],
                                                         ['help' => 'Digite el nombre del software.','icon'=>'fa fa-desktop']) !!}

                        {!! Field::text('SOL_VersSoft',null,['label'=>'Version Software:', 'class'=> 'form-control', 'autofocus', 'maxlength'=>'40','autocomplete'=>'off'],
                                                         ['help' => 'Digite la version del software','icon'=>'fa fa-user'] ) !!}

                        {!! Field::text('SOL_grupo',null,['label'=>'Grupo:', 'class'=> 'form-control', 'autofocus', 'maxlength'=>'40','autocomplete'=>'off'],
                                                         ['icon'=>'fa fa-group'] ) !!}

                        {!! Field::text('SOL_cant_estudiantes',null,['label'=>'Cantidad de estudiantes:', 'class'=> 'form-control', 'autofocus', 'maxlength'=>'40','autocomplete'=>'off'],
                                                         ['icon'=>'fa fa-group'] ) !!}

                        {!! Field::checkboxes('SOL_dias',
                        ['lun' => 'Lunes', 'mar' => 'Martes', 'mie' => 'Miercoles', 'jue' => 'Jueves', 'vie' => 'Viernes','sab' => 'Sabado'],
                        ['label' => 'Dias de la semana', 'inline', 'label' => 'Seleccione los dias', 'icon'=>'fa fa-user']) !!}

                        {!! Field::text(
                        'SOL_hora_inicio',
                        ['label' => 'Hora de inicio', 'class' => 'timepicker timepicker-no-seconds', 'data-date-format' => "yyyy-mm-dd", 'data-date-start-date' => "+0d", 'required', 'auto' => 'off'],
                        ['help' => 'Selecciona la hora.', 'icon' => 'fa fa-clock-o']) !!}

                        {!! Field::text(
                        'SOL_hora_fin',
                        ['label' => 'Hora de fin', 'class' => 'timepicker timepicker-no-seconds', 'data-date-format' => "yyyy-mm-dd", 'data-date-start-date' => "+0d", 'required', 'auto' => 'off'],
                        ['help' => 'Selecciona la hora.', 'icon' => 'fa fa-clock-o']) !!}
                            </div>
                        </div>
                    </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12 col-md-offset-0">
                                    {{ Form::submit('Registrar', ['class' => 'btn blue']) }}
                                    {{ Form::reset('Cancelar', ['class' => 'btn btn-danger']) }}

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
@push('styles')
<link href="{{ asset('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('plugins')
<script src="{{ asset('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></scripts>
<script src="{{ asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-validation/js/localization/messages_es.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}" type="text/javascript"></script>
@endpush
@push('functions')
<script type="text/javascript">
var prueba="a";
/*function agregarArticulo()
{
    var textarea=document.getElementById("articulo").value;
    copiar();
    if(textarea.length>0)
    {
        if(find_li(textarea))
        {
            var li=document.createElement('li');
            var text=document.createTextNode(textarea);
            li.innerHTML="<button onclick='eliminar(this)' class='btn btn-danger' '><span class='glyphicon glyphicon-trash'></span></button> ";
            prueba = li.appendChild(text);
            document.getElementById("lista").appendChild(li);
        }
    }
    return false;
}

function find_li(contenido)
{
    var el = document.getElementById("lista").getElementsByTagName("li");
    for (var i=0; i<el.length; i++)
    {
        if(el[i].innerHTML==contenido)
            return false;
    }
    copiar();
    return true;
}

function eliminar(elemento)
{
    cadena = document.getElementById("cedula").value+",";
    valorEliminado = document.getElementById("articulo").value;
    nuevoValor = "";
    document.getElementById("cedula").value = cadena.replace(valorEliminado, nuevoValor);
    elemento.parentNode.remove();

}*/
function copiarFechasATxt()
{
    if(fechas_Solicitadas.value==""){
        document.getElementById("fechas_Solicitadas").value=document.getElementById("articulo").value;
    }else{
        document.getElementById("fechas_Solicitadas").value=document.getElementById("fechas_Solicitadas").value+","+document.getElementById("articulo").value;
    }
}
</script>
@endpush