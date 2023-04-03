@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Locais Selecionados
                    <span class="d-block text-muted pt-2 font-size-sm">Listagem de Setores Selecionados para o Evento Atual</span></h3>
                </div>
                <div class="card-toolbar">                   
                    <a href="{{ url('setor/novo') }}" class="btn btn-primary font-weight-bolder"><i class="fa fa-plus"></i> Cadastrar Setor</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('layouts.mensagens')
                    </div>
                    <div class="col-md-12">
                        <div class="alert alert-info" role="alert">
                            <i class="fa fa-exclamation text-white mr-2"></i> São listados apenas setores dos locais habilitados para este evento. Para habilitar mais locais <a href="{{ url('evento/locais') }}" class="alert-link">Clique aqui</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <ul class="navi navi-hover navi-success navi-accent">
                            <li class="navi-item">
                                <a class="navi-link active" href="">
                                    <span class="navi-icon"><i class="fas fa-building"></i></span>
                                    <span class="navi-text">Setores Disponíveis</span>
                                </a>
                            </li>
                            @foreach ($locais_disponiveis as $local)
                                <h6 class="mt-3">{{ $local->nm_local_prova_lop }}</h6>
                                @foreach ($local->setores as $setor)
                                    <li class="navi-item">
                                        <a class="navi-link" href="{{ url('evento/setor/'.$setor->cd_setor_set.'/adicionar') }}">
                                            <span class="navi-icon"><i class="fas fa-plus-circle"></i></span>
                                            <span class="navi-text">{{ $setor->nm_setor_set }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="navi navi-hover navi-danger navi-accent">
                            <li class="navi-item">
                                <a class="navi-link active" href="">
                                    <span class="navi-icon"><i class="fas fa-map-marker"></i></span>
                                    <span class="navi-text">Setores Selecionados</span>
                                </a>
                            </li>
                            @php $ctrl = "" @endphp
                            @foreach ($setores_selecionados as $setor)
                                @if($ctrl != $setor->local->nm_local_prova_lop)
                                    <h6 class="mt-3">{{ $setor->local->nm_local_prova_lop }}</h6>
                                @endif
                                <li class="navi-item">
                                    <a class="navi-link btn-confirmar" href="{{ url('evento/setor/'.$setor->cd_setor_set.'/remover') }}">
                                        <span class="navi-icon"><i class="fas fa-trash"></i></span>
                                        <span class="navi-text">{{ $setor->nm_setor_set }}</span>
                                    </a>
                                </li>
                                @php $ctrl = $setor->local->nm_local_prova_lop @endphp
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