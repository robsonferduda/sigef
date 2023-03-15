@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Locais Selecionados
                    <span class="d-block text-muted pt-2 font-size-sm">Listagem de Locais Selecionados para o Evento Atual</span></h3>
                </div>
                <div class="card-toolbar">                   
                    <a href="{{ url('local/novo') }}" class="btn btn-primary font-weight-bolder"><i class="fa fa-plus"></i> Cadastrar Local</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('layouts.mensagens')
                    </div>
                    <div class="col-md-6">
                        <ul class="navi navi-hover navi-success navi-accent">
                            <li class="navi-item">
                                <a class="navi-link active" href="">
                                    <span class="navi-icon"><i class="fas fa-map-marker"></i></span>
                                    <span class="navi-text">Locais Disponíveis</span>
                                </a>
                            </li>
                            @foreach ($locais_disponiveis as $local)
                                <li class="navi-item">
                                    <a class="navi-link" href="{{ url('evento/local/'.$local->cd_local_prova_lop.'/adicionar') }}">
                                        <span class="navi-icon"><i class="fas fa-plus-circle"></i></span>
                                        <span class="navi-text">{{ $local->nm_local_prova_lop }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="navi navi-hover navi-danger navi-accent">
                            <li class="navi-item">
                                <a class="navi-link active" href="">
                                    <span class="navi-icon"><i class="fas fa-map-marker"></i></span>
                                    <span class="navi-text">Locais Selecionados</span>
                                </a>
                            </li>
                            @foreach ($locais_selecionados as $local)
                                <li class="navi-item">
                                    <a class="navi-link btn-confirmar" href="{{ url('evento/local/'.$local->cd_local_prova_lop.'/remover') }}">
                                        <span class="navi-icon"><i class="fas fa-trash"></i></span>
                                        <span class="navi-text">{{ $local->nm_local_prova_lop }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
         
        });
    </script>
@endsection