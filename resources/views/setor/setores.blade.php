@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Setores
                        <span class="d-block text-muted pt-2 font-size-sm">Listagem de Setores</span></h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ url('setor/novo') }}" class="btn btn-primary font-weight-bolder"><i class="fa fa-plus"></i> Novo</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-separate table-head-custom table-checkable dataTable no-footer" id="kt_datatable">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th>Setor Abreviado</th>
                        <th>Setor</th>
                        <th>Local</th>
                        <th>Rede de Ensino</th>
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

            $('#kt_datatable').on("click", '[data-toggle="popover"]', function (){ $(this).popover({}) });

            //$('[data-toggle="popover"]').on('popover', function (){ });
            var table = $('#kt_datatable').DataTable({
                "processing": true,
                "paginate": false,
                "serverSide": true,
                "order": [[ 1, "asc" ]],
                "bFilter": false,
                "ajax":{
                    "url": "{{ url('setores') }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": function (d) {

                    }
                },
                "columns": [
                    { data: "codigo" },
                    { data: "setor_abrev" },
                    { data: "setor" },
                    { data: "local" },
                    { data: "rede_ensino" },
                    { data: "acoes" },
                ]
            });
        });
    </script>
@endsection
