@extends('layout.default')
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Detalhes Perfil
                    <div class="text-muted pt-2 font-size-sm">Dados do perfil</div>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ url('roles') }}" class="btn btn-success font-weight-bolder"><i class="fa fa-table"></i> Perfis</a>
            </div>
        </div>
        <div class="card-body">
            <h5 class="mb-3"><i class="fa fa-user-tag mb-1"></i> {{ $role->display_name }}</h5><hr/>
            <p><strong>Chave</strong>: {{ $role->name }}</p>
            <p><strong>Descrição</strong>: {{ $role->description }}</p>

            <p><strong>Usuários</strong>:</p>
    
                @forelse($role->users as $u)
                    <span>{{ $u->name }}</span><br/>
                @empty
                    <span>Nenhum usuário associado ao perfil</span><br/>
                @endforelse

            <br/>

            <p><strong>Permissões</strong>:</p>

                @forelse($role->permissions as $p)
                    <span>{{ $p->controle->ds_controle_con }} > {{ $p->display_name }} ({{ $p->name }})</span><br/>
                @empty
                    <span>Nenhuma permissão associada ao perfil</span>
                @endforelse
        </div>
    </div>
@endsection

{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection


{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors --}}
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

    {{-- page scripts --}}
    <script src="{{ asset('js/pages/crud/datatables/basic/basic.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
@endsection