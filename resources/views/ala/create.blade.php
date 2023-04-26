@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Alas
                    <span class="d-block text-muted pt-2 font-size-sm">Listagem de Alas do Espaço Físico</span></h3>
                </div>
                <div class="card-toolbar">                   
                    <a href="{{ url('alas') }}" class="btn btn-primary font-weight-bolder"><i class="fas fa-list-alt"></i> Alas</a>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    @include('layouts.mensagens')
                </div>
                <div class="col-md-12">
               
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