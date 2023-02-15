@extends('layouts.app')
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Usuário > Perfil
                    <div class="text-muted pt-2 font-size-sm">Dados do Usuário</div>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ url('/') }}" class="btn btn-primary font-weight-bolder"><i class="fa fa-laptop-house"></i> Dashboard</a>
            </div>
        </div>
        <div class="card-body">
            @include('layouts.mensagens')
            <h6 class="mb-3"><i class="fa fa-user mb-1"></i> 
                {{ $user->name }}
            </h6><hr/>
            <p class="mb-3">
                <strong>CPF</strong>: {{ $user->cpf }}
            </p>   
            <p class="mb-3">
                <strong>Email</strong>: {{ $user->email }}
            </p>
            <p class="mb-3">
                <strong>Situação</strong>: {{ ($user->fl_active == 'S') ? 'Ativo' : 'Inativo' }}
            </p>
            <p class="mb-3">
                <strong>Perfil</strong>: 
                @forelse($user->roles as $role)
                    <span class="badge badge-primary" style="background: ">{{ $role->display_name }}</span>
                @empty
                    Nenhum perfil associado
                @endforelse
            </p>      
            <p class="mt-3">Perfis podem ser atribuídos somente por usuários com privilégios de administrador;</p>
            <p>Para maiores detalhes sobre seu uusário, acesso o sistema Perfil, disponível em <a href="https://app.coperve.ufsc.br/perfil" target="_blank">https://app.coperve.ufsc.br/perfil</a>.</p>
        </div>
    </div>
@endsection