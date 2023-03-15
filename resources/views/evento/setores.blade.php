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