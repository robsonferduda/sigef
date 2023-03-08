@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="card card-custom w-100">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Blocos
                        <span class="d-block text-muted pt-2 font-size-sm">Listagem de Blocos</span></h3>
                </div>
                <div class="card-toolbar">
                    <a href="{{ url('bloco/novo') }}" class="btn btn-primary font-weight-bolder"><i class="fa fa-plus"></i> Novo</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-separate table-head-custom table-checkable dataTable no-footer" id="kt_datatable">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th>Bloco</th>
                        <th>Setor</th>
                        <th>Endereço de Acesso</th>
                        <th>Muro?</th>
                        <th>Guarita?</th>
                        <th>Elevador?</th>
                        <th>Portão?</th>
                        <th>Rampa?</th>
                        <th>Vigilância?</th>
                        <th>Monitoramento?</th>
                        <th>Estacionamento?</th>
                        <th>Wifi?</th>
                        <th class="box-btn-acoes-col2">Ações</th>
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
                "order": [[ 2, "asc" ], [ 1, "asc"]],
                "bFilter": false,
                "ajax":{
                    "url": "{{ url('blocos') }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": function (d) {

                    }
                },
                "columns": [
                    { data: "codigo" },
                    { data: "bloco" },
                    { data: "setor" },
                    { data: "endereco" },
                    { data: "muro" },
                    { data: "guarita" },
                    { data: "elevador" },
                    { data: "portao" },
                    { data: "rampa" },
                    { data: "vigilancia" },
                    { data: "monitoramento" },
                    { data: "estacionamento" },
                    { data: "wifi"},
                    { data: "acoes" },
                ]
            });
        });
    </script>
@endsection
