{{-- MENÚ DE EJEMPLO --}}
@role(['Admin_uni','Funcionario_uni','Empresario_uni','Coordinador_uni','Pasante_uni'])
            <li class="nav-item {{ active(['alerta.alerta'], 'start active open') }}">
                <a href="{{ route('alerta.alerta') }}" class="nav-link nav-toggle">
                        <i class="fa fa-bell"></i>
                        <span class="title">BANDEJA DE ENTRADA</span>
                    </a>
                </li>
@endrole
@role(['Admin_uni','Funcionario_uni'])
            <li class="nav-item {{ active(['convenios.convenios'], 'start active open') }}">
                <a href="{{ route('convenios.convenios') }}" class="nav-link nav-toggle">
                        <i class="fa fa-calendar-plus-o"></i>
                        <span class="title">CONVENI0S</span>
                    </a>
                </li>
@endrole
@role(['Admin_uni','Funcionario_uni','Empresario_uni','Coordinador_uni','Pasante_uni'])
            <li class="nav-item {{ active(['misConvenios.misConvenios'], 'start active open') }}">
                <a href="{{ route('misConvenios.misConvenios') }}" class="nav-link nav-toggle">
                        <i class="fa fa-archive"></i>
                        <span class="title">MIS CONVENIOS</span>
                    </a>
                </li>


@endrole
@role(['Admin_uni','Funcionario_uni'])
            <li class="nav-item {{ active(['empresas.empresas'], 'start active open') }}">
                <a href="{{ route('empresas.empresas') }}" class="nav-link nav-toggle">
                        <i class="fa fa-industry"></i>
                        <span class="title">EMPRESAS</span>
                    </a>
                </li>

@endrole
@role(['Admin_uni'])
            <li class="nav-item {{ active(['sedes.sedes'], 'start active open') }}">
                <a href="{{ route('sedes.sedes') }}" class="nav-link nav-toggle">
                        <i class="fa fa-building"></i>
                        <span class="title">SEDES</span>
                    </a>
                </li>
@endrole
@role(['Admin_uni'])
            <li class="nav-item {{ active(['estados.estados'], 'start active open') }}">
                <a href="{{ route('estados.estados') }}" class="nav-link nav-toggle">
                        <i class="fa fa-paper-plane"></i>
                        <span class="title">ESTADOS</span>
                    </a>
                </li>
@endrole
@role(['Empresario_uni','Coordinador_uni','Pasante_uni'])
            <li class="nav-item {{ active(['misDocumentos.misDocumentos'], 'start active open') }}">
                <a href="{{ route('misDocumentos.misDocumentos') }}" class="nav-link nav-toggle">
                        <i class="fa fa-folder"></i>
                        <span class="title">MIS DOCUMENTOS</span>
                    </a>
                </li>
@endrole
@role(['Admin_uni','Funcionario_uni'])
            <li class="nav-item {{ active(['evaluaciones.evaluaciones'], 'start active open') }}">
                <a href="{{ route('evaluaciones.evaluaciones') }}" class="nav-link nav-toggle">
                        <i class="fa fa-check-square-o"></i>
                        <span class="title">EVALUACIONES</span>
                    </a>
                </li>
@endrole
@role(['Admin_uni'])
            <li class="nav-item {{ active(['tipoPregunta.tipoPregunta'], 'start active open') }}">
                <a href="{{ route('tipoPregunta.tipoPregunta') }}" class="nav-link nav-toggle">
                        <i class="fa fa-list-alt"></i>
                        <span class="title">TIPO DE PREGUNTAS</span>
                    </a>
                </li>
@endrole
@role(['Admin_uni'])
            <li class="nav-item {{ active(['pregunta.pregunta'], 'start active open') }}">
                <a href="{{ route('pregunta.pregunta') }}" class="nav-link nav-toggle">
                        <i class="fa fa-question"></i>
                        <span class="title">PREGUNTAS</span>
                    </a>
                </li>

<li class="nav-item {{ active(['interacion.universitaria.*'], 'start active open') }}">
    <a href="{{ route('interaccion.universitaria.index') }}" class="nav-link">
        <i class="icon-feed"></i>
        <span class="title">Interacción Universitaria</span>
    </a>
</li>
@endrole
