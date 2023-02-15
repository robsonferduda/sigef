<div class="card card-custom {{ @$class }}">
   
    <div class="card-header align-items-center border-0 mt-4">
        <h3 class="card-title align-items-start flex-column">
            <span class="font-weight-bolder text-dark">Atividades Recentes - Todos</span>
            <span class="text-muted mt-3 font-weight-bold font-size-sm">Últimos 5 Registros <a href="{{ url('auditoria') }}">Ver todos</a></span>
        </h3>
        <div class="card-toolbar">
            <div class="dropdown dropdown-inline">
               
            </div>
        </div>
    </div>

    <div class="card-body pt-1">
        <div class="timeline timeline-6 mt-3">
            @foreach($auditorias as $a)
                <div class="timeline-item align-items-start">
                    <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg">{{ date('H:i', strtotime($a->created_at)) }}</div>
                    <div class="timeline-badge">
                        <i class="fa fa-genderless text-{{ $a->evento->ds_color_eva }} icon-xl"></i>
                    </div>
                    <div class="timeline-content d-flex">
                        <span class="text-dark-75 pl-3 font-size-lg">
                            <a href="{{ url('auditoria/'.$a->id) }}">{{ ($a->sistema) ? $a->sistema->ds_sistema_sis : 'Nenhum sistema relacionado' }} - {{ ($a->evento) ? $a->evento->ds_evento_eva : 'Não definido' }}</a> - {{ ($a->user) ? $a->user->name : 'Usuário não idetificado' }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>