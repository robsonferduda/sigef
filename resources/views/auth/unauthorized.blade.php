@extends('layouts.app')
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Controle de Permissões
                    <div class="text-muted pt-2 font-size-sm">Gerenciamento de permissões de usuários</div>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ url('/') }}" class="btn btn-success font-weight-bolder"><i class="fa fa-home"></i> Início</a>
            </div>
        </div>
            <div class="card-body">
                <h4 class="text-danger"><i class="fa fa-ban fa-lg text-danger"></i> Permissão Negada - Permissões Insuficientes</h4>
                <div class="border-bottom border-white opacity-20 mb-5"></div>
                <p><span class="label label-inline label-pill label-danger label-rounded mr-2">ALERTA</span> Você não tem permissão para realizar para acessar esse recurso.</p>
					
                <h5>O que eu faço agora? </h5>
                <p class="mb-0">Caso precise de permissão, entre em contato com o responsável do seu departamento.</p>
                <span>Requisite permissão para essa funcionalidade ou <a href="{{ url('/') }}">clique aqui</a> para voltar ao início </span>
            </div>
    </div>
@endsection