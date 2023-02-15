@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Eventos
                    <span class="d-block text-muted pt-2 font-size-sm">Listagem de Eventos</span></h3>
                </div>
                <div class="card-toolbar">                   
                    <a href="{{ url('evento/create') }}" class="btn btn-primary font-weight-bolder"><i class="fa fa-plus"></i> Novo</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-separate table-head-custom table-checkable dataTable no-footer" id="kt_datatable">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Ano Ingresso</th>
                            <th>Evento</th>
                            <th>Mês/Ano</th>
                            <th>Início Inscrição</th>
                            <th>Término Inscrição</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                           
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            var table = $('#kt_datatable').DataTable({
            "processing": true,
            "paginate": false,
            "serverSide": true,
            "order": [[ 0, "desc" ]],
            "bFilter": false,
            "ajax":{
                "url": "{{ url('eventos') }}",
                "dataType": "json",
                "type": "GET",
                "data": function (d) {
                                         
                }
            },
            "columns": [
                { data: "codigo" },
                { data: "ano-ingresso" },
                { data: "evento" },
                { data: "mes-ano" },
                { data: "dt_inicio" },
                { data: "dt_termino" },
                { data: "acoes" },
            ]    
            });            
        });
    </script>
@endsection