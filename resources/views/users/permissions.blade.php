@extends('layout.default')
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Usuário > Permissões
                    <div class="text-muted pt-2 font-size-sm">Detalhes das permissões atribuídas ao usuário</div>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ url('roles') }}" class="btn btn-success font-weight-bolder"><i class="fa fa-table"></i> Perfis</a>
            </div>
        </div>
        <div class="card-body">
            <h5 class="mb-3"><i class="fa fa-user mb-1"></i> 
                {{ $user->name }}
            </h5><hr/>

            @if($user->fl_active == 'S')
                <span class="label label-lg font-weight-bold label-light-primary label-inline">ATIVO</span>
            @else
                <span class="label label-lg font-weight-bold label-light-danger label-inline">INATIVO</span>
            @endif
            
            <p class="mt-4"><strong>Perfis</strong>:</p>

                @forelse($user->roles as $r)
                    <span>{{ $r->display_name }}</span><br/>
                @empty
                    <span>Nenhum perfil associado ao usuário</span>
                @endforelse

            <p class="mt-4"><strong>Permissões</strong>:</p>

                @forelse($permissions as $p)
                    <span>{{ $p->controle->ds_controle_con }} > {{ $p->display_name }} ({{ $p->name }})</span><br/>
                @empty
                    <span>Nenhuma permissão associada ao perfil</span>
                @endforelse
        </div>
    </div>
@endsection